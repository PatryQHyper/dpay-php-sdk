<?php

/**
 * Created with love by: Patryk Vizauer (patryqhyper.pl)
 * Date: 19.05.2022 23:32
 * Using: PhpStorm
 */

namespace PatryQHyper\Dpay\Secure;

use PatryQHyper\Dpay\Exceptions\DpayPaymentException;
use PatryQHyper\Dpay\Exceptions\DpayRequestException;
use PatryQHyper\Dpay\Responses\PaymentGeneratedResponse;
use PatryQHyper\Dpay\Secure\Styles\AbstractStyle;

class PaybylinkPayment extends SecureAbstract
{
    private string $serviceName;
    private string $serviceHash;

    private float $amount;
    private string $successUrl;
    private string $failUrl;
    private string $ipnUrl;
    private bool $installment;
    private bool $creditCard;
    private bool $paysafecard;
    private bool $paypal;
    private bool $noBanks;
    private string $channel;
    private string $email;
    private string $clientName;
    private string $clientSurname;
    private string $description;
    private string $custom;
    private AbstractStyle $style;

    public function __construct(string $serviceName, string $serviceHash)
    {
        $this->serviceName = $serviceName;
        $this->serviceHash = $serviceHash;
    }

    public function setAmount(float $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function setSuccessUrl(string $successUrl): self
    {
        $this->successUrl = $successUrl;
        return $this;
    }

    public function setFailUrl(string $failUrl): self
    {
        $this->failUrl = $failUrl;
        return $this;
    }

    public function setIpnUrl(string $ipnUrl): self
    {
        $this->ipnUrl = $ipnUrl;
        return $this;
    }

    public function setInstallment(bool $installment): self
    {
        $this->installment = $installment;
        return $this;
    }

    public function setCreditCard(bool $creditCard): self
    {
        $this->creditCard = $creditCard;
        return $this;
    }

    public function setPaysafecard(bool $paysafecard): self
    {
        $this->paysafecard = $paysafecard;
        return $this;
    }

    public function setPaypal(bool $paypal): self
    {
        $this->paypal = $paypal;
        return $this;
    }

    public function setNoBanks(bool $noBanks): self
    {
        $this->noBanks = $noBanks;
        return $this;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setClientName(string $clientName): self
    {
        $this->clientName = $clientName;
        return $this;
    }

    public function setClientSurname(string $clientSurname): self
    {
        $this->clientSurname = $clientSurname;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setCustom(string $custom): self
    {
        $this->custom = $custom;
        return $this;
    }

    public function setStyle(AbstractStyle $style): self
    {
        $this->style = $style;
        return $this;
    }

    /**
     * @throws DpayRequestException
     * @throws DpayPaymentException
     */
    public function generate(): PaymentGeneratedResponse
    {
        $array['service'] = $this->serviceName;
        $array['value'] = sprintf('%.2f', $this->amount);
        $array['url_success'] = $this->successUrl;
        $array['url_fail'] = $this->failUrl;
        $array['url_ipn'] = $this->ipnUrl;
        $array['accept_tos'] = 1;
        $array['checksum'] = hash('sha256', implode('|', [
            $this->serviceName,
            $this->serviceHash,
            sprintf('%.2f', $this->amount),
            $this->successUrl,
            $this->failUrl,
            $this->ipnUrl,
        ]));
        if (isset($this->installment)) $array['installment'] = $this->installment;
        if (isset($this->creditCard)) $array['creditcard'] = $this->creditCard;
        if (isset($this->paysafecard)) $array['paysafecard'] = $this->paysafecard;
        if (isset($this->paypal)) $array['paypal'] = $this->paypal;
        if (isset($this->noBanks)) $array['nobanks'] = $this->noBanks;
        if (isset($this->channel)) $array['channel'] = $this->channel;
        if (isset($this->email)) $array['email'] = $this->email;
        if (isset($this->clientName)) $array['client_name'] = $this->clientName;
        if (isset($this->clientSurname)) $array['client_surname'] = $this->clientSurname;
        if (isset($this->description)) $array['description'] = $this->description;
        if (isset($this->custom)) $array['custom'] = $this->custom;
        if (isset($this->style)) $array['style'] = $this->style->style();

        $request = $this->dpay->httpClient->doRequest($this->baseUrl . '/register', [
            'json' => $array
        ]);

        if (!$request->status || $request->error)
            throw new DpayPaymentException('Error: ' . $request->msg);

        return new PaymentGeneratedResponse($request->msg, $request->transactionId);
    }
}