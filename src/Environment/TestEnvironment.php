<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 19.05.2022 23:00
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Environment;

class TestEnvironment extends AbstractEnvironment
{
    public function panelUrl(): string
    {
        return 'https://panel.digitalpayments.pl';
    }

    public function secureUrl(): string
    {
        return 'https://secure-test.dpay.pl';
    }
}