<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 19.05.2022 23:00
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Environment;

class ProductionEnvironment extends AbstractEnvironment
{
    public function panelUrl(): string
    {
        return 'https://panel.dpay.pl';
    }

    public function secureUrl(): string
    {
        return 'https://secure.dpay.pl';
    }
}