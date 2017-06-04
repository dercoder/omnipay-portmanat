<?php

namespace Omnipay\Portmanat\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class CardFetchTransactionResponse
 * @package Omnipay\Portmanat\Message
 */
class CardFetchTransactionResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getStatus() === 'OK' && $this->getCode() === 0;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->getStatus() === 'OK' && $this->getCode() === 1;
    }

    /**
     * @return int|null
     */
    public function getCode()
    {
        return isset($this->data['code']) ? (int) $this->data['code'] : null;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return isset($this->data['description']) ? $this->data['description'] : null;
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return isset($this->data['status']) ? $this->data['status'] : null;
    }

    /**
     * @return array|null
     */
    public function getErrors()
    {
        return isset($this->data['errors']) ? $this->data['errors'] : null;
    }

    /**
     * @return float|null
     */
    public function getAmount()
    {
        if (!isset($this->data['body'])) {
            return null;
        }

        return (float) $this->data['body']['amount'];
    }

    /**
     * @return string|null
     */
    public function getTransactionId()
    {
        if (!isset($this->data['body'])) {
            return null;
        }

        return $this->data['body']['client_rrn'];
    }

    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        if (!isset($this->data['body'])) {
            return null;
        }

        return $this->data['body']['psp_rrn'];
    }

    /**
     * @return string|null
     */
    public function getBankTransactionReference()
    {
        if (!isset($this->data['body'])) {
            return null;
        }

        return $this->data['body']['bank_rrn'];
    }

    /**
     * @return \DateTime|null
     */
    public function getDate()
    {
        if (!isset($this->data['body']) or !isset($this->data['body']['created_at'])) {
            return null;
        }

        $date = $this->data['body']['created_at']['date'];
        $timeZone = $this->data['body']['created_at']['timezone'];

        return new \DateTime($date, new \DateTimeZone($timeZone));
    }
}
