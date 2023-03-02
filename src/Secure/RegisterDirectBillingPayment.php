<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 20.05.2022 17:22
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Secure;

use PatryQHyper\Dpay\Exceptions\DpayPaymentException;
use PatryQHyper\Dpay\Exceptions\DpayRequestException;
use PatryQHyper\Dpay\Responses\PaymentGeneratedResponse;

class RegisterDirectBillingPayment extends SecureAbstract
{
    private string $guid;
    private string $secretKey;

    private float $amount;
    private string $successUrl;
    private string $failUrl;
    private string $custom;

    public function __construct(string $guid, string $secretKey)
    {
        $this->guid = $guid;
        $this->secretKey = $secretKey;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function setSuccessUrl(string $successUrl): self
    {
        $this->successUrl = $successUrl;
        return $this;
    }

    public function setFailUrl(string $failUrl): self
    {
        $this->failUrl = $failUrl;
        return $this;
    }

    public function setCustom(string $custom): self
    {
        $this->custom = $custom;
        return $this;
    }

    /**
     * @throws DpayRequestException
     * @throws DpayPaymentException
     */
    public function generate(): PaymentGeneratedResponse
    {
        $array['guid'] = $this->guid;
        $array['value'] = $this->amount * 100;
        $array['url_success'] = $this->successUrl;
        $array['url_fail'] = $this->failUrl;
        if (isset($this->custom)) $array['custom'] = $this->custom;
        $array['checksum'] = hash('sha256', implode('|', [
            $this->guid,
            $this->secretKey,
            sprintf('%.2f', $this->amount),
            $this->successUrl,
            $this->failUrl
        ]));

        $request = $this->dpay->httpClient->doRequest('https://secure.dpay.pl/dcb/register', [
            'json' => $array
        ]);

        if (!$request->status || $request->error)
            throw new DpayPaymentException('Error: ' . $request->error);

        return new PaymentGeneratedResponse(
            $request->msg,
        );
    }
}