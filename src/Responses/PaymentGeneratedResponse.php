<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 19.05.2022 23:53
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Responses;

class PaymentGeneratedResponse
{
    private ?string $transactionUrl = null;
    private ?string $transactionId = null;

    public function __construct(?string $transactionUrl = null, ?string $transactionId = null)
    {
        $this->transactionUrl = $transactionUrl;
        $this->transactionId = $transactionId;
    }

    public function getTransactionUrl(): ?string
    {
        return $this->transactionUrl;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }
}