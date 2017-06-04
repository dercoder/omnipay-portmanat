<?php

namespace Omnipay\Portmanat\Message;

/**
 * Class CardAbstractRequest
 * @package Omnipay\Portmanat\Message
 */
abstract class AbstractCardRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @var string
     */
    protected $endpoint = 'http://psp.mps.az/check';

    /**
     * Get API endpoint URL
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Get Portmanat service ID.
     *
     * @return string serviceId
     */
    public function getServiceId()
    {
        return $this->getParameter('serviceId');
    }

    /**
     * Set Portmanat service ID.
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
     * Get Portmanat secret key.
     *
     * @return string secretKey
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set Portmanat secret key.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }
}
