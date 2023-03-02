<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 19.05.2022 22:46
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Environment;

abstract class AbstractEnvironment
{
    abstract public function panelUrl(): string;

    abstract public function secureUrl(): string;
}