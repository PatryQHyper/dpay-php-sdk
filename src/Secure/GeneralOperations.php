<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 19.05.2022 23:08
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Secure;

class GeneralOperations extends SecureAbstract
{
    public function getLicenseNumber()
    {
        return $this->dpay->httpClient->doRequest($this->baseUrl . '/license.number');
    }

    public function getPrivacyPolicyUrl(): string
    {
        return $this->baseUrl . '/privacy';
    }

    public function getTermsUrl(): string
    {
        return $this->baseUrl . '/rules';
    }

    public function getRegulations(): string
    {
        return $this->dpay->httpClient->doRequest($this->baseUrl . '/regulations');
    }
}