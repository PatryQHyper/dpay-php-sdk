<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 20.05.2022 17:40
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Panel;

use PatryQHyper\Dpay\Exceptions\DpayPaymentException;
use PatryQHyper\Dpay\Responses\TransferBankResponse;
use PatryQHyper\Dpay\Responses\TransferBanksResponse;
use PatryQHyper\Dpay\Responses\TransferTransactionDetailsResponse;

class PaybylinkOperations extends PanelAbstract
{
    private string $serviceName;
    private string $serviceHash;

    public function __construct(string $serviceName, string $serviceHash)
    {
        $this->serviceName = $serviceName;
        $this->serviceHash = $serviceHash;
    }

    public function getTransactionDetails(string $transactionId): TransferTransactionDetailsResponse
    {
        $request = $this->dpay->httpClient->doRequest($this->baseUrl . '/api/v1/pbl/details', [
            'json' => [
                'service' => $this->serviceName,
                'transaction_id' => $transactionId,
                'checksum' => hash('sha256', $this->serviceName . '|' . $transactionId . '|' . $this->serviceHash)
            ]
        ]);

        if (json_last_error() != JSON_ERROR_NONE)
            throw new DpayPaymentException('Json decode error (' . json_last_error() . '): ' . json_last_error_msg());

        if (isset($request->message))
            throw new DpayPaymentException('Dpay error: ' . json_encode($request));

        return new TransferTransactionDetailsResponse($request->transaction);
    }

    public function refundTransaction(string $transactionId)
    {
        $this->dpay->httpClient->doRequest($this->baseUrl . '/api/v1/pbl/refund', [
            'json' => [
                'service' => $this->serviceName,
                'transaction_id' => $transactionId,
                'checksum' => hash('sha256', $this->serviceName . '|' . $transactionId . '|' . $this->serviceHash)
            ]
        ]);
    }

    public function getAllBanks(?bool $specificService = false): array
    {
        $payload = [];
        $timestamp = time();
        if ($specificService) {
            $payload['service'] = $this->serviceName;
            $payload['timestamp'] = $timestamp;
            $payload['checksum'] = hash('sha256', $this->serviceName . '|' . $timestamp . '|' . $this->serviceHash);
        }

        $request = $this->dpay->httpClient->doRequest($this->baseUrl . '/api/v1/pbl/banks', [
            'json' => $payload
        ], ($specificService ? 'POST' : 'GET'));

        $arr = [];
        foreach ($request as $bank) {
            $arr[] = new TransferBankResponse($bank);
        }
        return $arr;
    }
}