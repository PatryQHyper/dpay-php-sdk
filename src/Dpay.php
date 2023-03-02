<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 19.05.2022 22:42
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay;

use PatryQHyper\Dpay\Environment\AbstractEnvironment;
use PatryQHyper\Dpay\Environment\ProductionEnvironment;
use PatryQHyper\Dpay\Panel\PanelAbstract;
use PatryQHyper\Dpay\Secure\SecureAbstract;

class Dpay
{
    public AbstractEnvironment $environment;
    public HttpClient $httpClient;

    public function __construct(AbstractEnvironment $environment = new ProductionEnvironment())
    {
        $this->environment = $environment;
        $this->httpClient = new HttpClient($this);
    }

    public function secure(SecureAbstract $secureAbstract): SecureAbstract
    {
        $secureAbstract->setDpay($this);
        return $secureAbstract;
    }

    public function panel(PanelAbstract $panelAbstract): PanelAbstract
    {
        $panelAbstract->setDpay($this);
        return $panelAbstract;
    }
}