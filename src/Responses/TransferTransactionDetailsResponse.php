<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 20.05.2022 17:47
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Responses;

class TransferTransactionDetailsResponse
{
    private object $data;

    public function __construct(object $data)
    {
        $this->data = $data;
    }

    public function getId()
    {
        return $this->data->id;
    }

    public function getValue()
    {
        return $this->data->value;
    }

    public function getRate()
    {
        return $this->data->rate;
    }

    public function getMinimalFee()
    {
        return $this->data->minimal_fee;
    }

    public function getPermanentFee()
    {
        return $this->data->permanent_fee;
    }

    public function getStatus()
    {
        return $this->data->status;
    }

    public function getPaymentMethod()
    {
        return $this->data->payment_method;
    }

    public function getSuccessUrl()
    {
        return $this->data->urls->success;
    }

    public function getFailUrl()
    {
        return $this->data->urls->fail;
    }

    public function getIpnUrl()
    {
        return $this->data->urls->ipn;
    }

    public function getCreationDate()
    {
        return $this->data->creation_date;
    }

    public function getPaymentDate()
    {
        return $this->data->payment_date;
    }

    public function getSettled()
    {
        return $this->data->settled;
    }

    public function getRefunded()
    {
        return $this->data->refunded;
    }

    public function getDirect()
    {
        return $this->data->direct;
    }
}