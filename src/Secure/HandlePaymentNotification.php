<?php

/**
 * Created with love by: Patryk Vizauer (wizjoner.dev)
 * Date: 02.03.2023 14:35
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Secure;

use PatryQHyper\Dpay\Exceptions\DpayNotificationException;

class HandlePaymentNotification extends SecureAbstract
{
    private object $payload;

    public function __construct(private readonly string $hash)
    {
        $this->payload = @json_decode(file_get_contents('php://input'));
    }

    /**
     * @throws DpayNotificationException
     */
    public function verify(): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            throw new DpayNotificationException('method not allowed');
        }

        foreach ($this->parameters as $parameter) {
            if (!isset($this->payload->$parameter) || empty($this->payload->parameter)) {
                throw new DpayNotificationException(sprintf('Parameter %s not found in payload', $parameter));
            }
        }

        if ($this->payload->signature != $this->generateSignature()) {
            throw new DpayNotificationException('invalid signature');
        }
    }

    public function generateSignature(): string
    {
        $payload = [
            $this->payload->id,
            $this->hash,
            sprintf('%.2f', $this->payload->amount),
            $this->payload->email,
            $this->payload->type,
            $this->payload->attempt,
            $this->payload->version,
            $this->payload->custom,
        ];

        return hash('sha256', implode('', $payload));
    }

    private array $parameters = [
        'id',
        'amount',
        'email',
        'type',
        'attempt',
        'version',
        'custom',
        'signature',
    ];
}