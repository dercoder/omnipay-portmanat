<?php

namespace Omnipay\Portmanat;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractCardRequest;
use Omnipay\Portmanat\Message\CardCompletePurchaseRequest;
use Omnipay\Portmanat\Message\CardFetchTransactionRequest;
use Omnipay\Portmanat\Message\CardPurchaseRequest;

/**
 * Class CardGateway
 * @package Omnipay\Portmanat
 */
class CardGateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Portmanat Card';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'serviceId' => '',
            'secretKey' => '',
            'testMode'  => false
        );
    }

    /**
     * Get MPS service ID.
     *
     * @return string serviceId
     */
    public function getServiceId()
    {
        return $this->getParameter('serviceId');
    }

    /**
     * Set MPS service ID.
     *
     * @param string $value serviceId
     *
     * @return $this
     */
    public function setServiceId($value)
    {
        return $this->setParameter('serviceId', $value);
    }

    /**
     * Get MPS secret key.
     *
     * @return string secretKey
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set MPS secret key.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractCardRequest|CardPurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Portmanat\Message\CardPurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractCardRequest|CardCompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Portmanat\Message\CardCompletePurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractCardRequest|CardFetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Portmanat\Message\CardFetchTransactionRequest', $parameters);
    }
}
