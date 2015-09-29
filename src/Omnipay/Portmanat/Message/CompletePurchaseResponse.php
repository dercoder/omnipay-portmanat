<?php

namespace Omnipay\Portmanat\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Portmanat Complete Purchase Response.
 *
 * @author    Alexander Fedra <contact@dercoder.at>
 * @copyright 2015 DerCoder
 * @license   http://opensource.org/licenses/mit-license.php MIT
 */
class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->getHash() === $this->calculateHash() && $this->request->getTestMode() === $this->getTest();
    }

    public function getMessage()
    {
        if ($this->getHash() !== $this->calculateHash()) {
            return 'Invalid hash checksum';
        } elseif ($this->request->getTestMode() !== $this->getTest()) {
            return 'Invalid test mode';
        } else {
            return;
        }
    }

    public function getTransactionId()
    {
        return $this->data['o_id'];
    }

    public function getTransactionReference()
    {
        return $this->data['transaction'];
    }

    public function getMethod()
    {
        return $this->data['method'];
    }

    public function getAmount()
    {
        return $this->data['amount'];
    }

    public function getTest()
    {
        return (bool) $this->data['test'];
    }

    public function getHash()
    {
        return $this->data['hash'];
    }

    private function calculateHash()
    {
        return strtoupper(md5(
            $this->request->getPartnerId().
            $this->request->getServiceId().
            $this->getTransactionId().
            $this->getTransactionReference().
            $this->request->getSecurityKey()
        ));
    }
}
