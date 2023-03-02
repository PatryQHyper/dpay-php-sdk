<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 20.05.2022 20:18
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Panel;

use PatryQHyper\Dpay\Exceptions\DpaySmsException;

class SmsOperations extends PanelAbstract
{
    public function verifyCode(string $clientId, string $serviceId, string $code)
    {
        $request = $this->dpay->httpClient->doRequest(sprintf('%s/api/v1/sms/verify/%s/%s/%s', $this->baseUrl, $clientId, $serviceId, $code), [], 'GET', false);

        $json = json_decode($request->getBody());

        if ($request->getStatusCode() != 200)
            throw new DpaySmsException(sprintf('Error %s; %s', $json->errorcode, $json->message));

        echo $request;
    }
}