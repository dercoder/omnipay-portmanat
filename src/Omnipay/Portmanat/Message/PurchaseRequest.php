<?php

namespace Omnipay\Portmanat\Message;

/**
 * Portmanat Purchase Request.
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Get the method.
     *
     * For Portmanat Account: method=account
     * For Portmanat Code: method=code
     *
     * @return string username
     */
    public function getMethod()
    {
        return strtoupper($this->getParameter('method'));
    }

    /**
     * Set the method.
     *
     * For Portmanat Account: method=account
     * For Portmanat Code: method=code
     *
     * @param string $value method
     *
     * @return self
     */
    public function setMethod($value)
    {
        return $this->setParameter('method', $value);
    }

    /**
     * Get the data for this request.
     *
     * @return array request data
     */
    public function getData()
    {
        $this->validate(
            'serviceId',
            'method',
            'transactionId',
            'amount'
        );

        return array(
            's_id' => $this->getServiceId(),
            'o_id' => $this->getTransactionId(),
            'method' => $this->getMethod(),
            'amount' => $this->getAmount(),
        );
    }

    /**
     * Send the request with specified data.
     *
     * @param mixed $data The data to send
     *
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        return new PurchaseResponse($this, $data);
    }
}
