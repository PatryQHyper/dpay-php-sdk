<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 20.05.2022 17:39
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Panel;

use PatryQHyper\Dpay\Dpay;

abstract class PanelAbstract
{
    public Dpay $dpay;
    public string $baseUrl;

    public function setDpay(Dpay $dpay)
    {
        $this->dpay = $dpay;
        $this->baseUrl = $dpay->environment->panelUrl();
    }
}