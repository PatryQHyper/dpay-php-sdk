<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 20.05.2022 19:56
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Responses;

class TransferBankResponse
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

    public function getName()
    {
        return $this->data->name;
    }

    public function getOnFrom()
    {
        return $this->data->on_from;
    }

    public function getOnTo()
    {
        return $this->data->on_to;
    }

    public function getImage(bool $fullUrl = false)
    {
        if (!$fullUrl)
            return $this->data->image;

        return 'https://panel.dpay.pl/api/v1/pbl/image/' . $this->data->image;
    }

    public function getIterator()
    {
        return $this->data->iterator;
    }

    public function getTest()
    {
        return $this->data->test;
    }
}