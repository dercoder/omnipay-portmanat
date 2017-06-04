<?php

namespace Omnipay\Portmanat\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class CardPurchaseRequest
 * @package Omnipay\Portmanat\Message
 */
class CardPurchaseRequest extends AbstractCardRequest
{
    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'serviceId',
            'secretKey',
            'transactionId',
            'clientIp',
            'currency',
            'amount'
        );

        if ($this->getCurrency() !== 'AZN') {
            throw new InvalidRequestException('Invalid currency. Only AZN is supported');
        }

        $hash = hash_hmac(
            'sha256',
            $this->getServiceId() . $this->getTransactionId() . $this->getAmount(),
            $this->getSecretKey()
        );

        $data = array(
            'service_id' => $this->getServiceId(),
            'client_rrn' => $this->getTransactionId(),
            'amount'     => $this->getAmount(),
            'client_ip'  => $this->getClientIp(),
            'hash'       => $hash
        );

        if ($returnUrl = $this->getReturnUrl()) {
            $data['return_url'] = $returnUrl;
        }

        if ($cancelUrl = $this->getCancelUrl()) {
            $data['cancel_url'] = $cancelUrl;
        }

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @return CardPurchaseResponse
     */
    public function sendData($data)
    {
        return new CardPurchaseResponse($this, $data);
    }
}
