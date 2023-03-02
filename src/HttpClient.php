<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 19.05.2022 22:55
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay;

use GuzzleHttp\Client;
use PatryQHyper\Dpay\Exceptions\DpayRequestException;

class HttpClient
{
    /**
     * Dpay client.
     *
     * @var Dpay
     */
    protected Dpay $dpay;

    /**
     * GuzzleHTTP client.
     *
     * @var Client
     */
    protected Client $client;

    public function __construct(Dpay $dpay)
    {
        $this->dpay = $dpay;

        $this->client = new Client([
//            'base_uri' => $this->dpay->getEnvironment()->url(),
            'http_errors' => false,
            'headers' => [
                'Accept' => 'Application/json',
                'Content-type' => 'Application/json',
            ],
            'debug' => false
        ]);

        return $this;
    }

    public function doRequest(string $uri, array $payload = [], string $method = 'POST', bool $returnBody = true)
    {
        $request = $this->client->request(strtoupper($method), $uri, $payload);

        if ($returnBody && !in_array($request->getStatusCode(), [200, 201, 202, 204]))
            throw new DpayRequestException(sprintf('Invalid status code: %d, request body: %s', $request->getStatusCode(), $request->getBody()));

        if ($returnBody)
            return @json_decode($request->getBody()) ?? $request->getBody();

        return $request;
    }
}