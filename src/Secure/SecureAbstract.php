<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 19.05.2022 23:09
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Secure;

use PatryQHyper\Dpay\Dpay;

abstract class SecureAbstract
{
    public Dpay $dpay;
    public string $baseUrl;

    public function setDpay(Dpay $dpay)
    {
        $this->dpay = $dpay;
        $this->baseUrl = $dpay->environment->secureUrl();
    }
}