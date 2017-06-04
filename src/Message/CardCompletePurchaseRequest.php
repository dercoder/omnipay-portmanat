<?php

namespace Omnipay\Portmanat\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Class CardCompletePurchaseRequest
 * @package Omnipay\Portmanat\Message
 */
class CardCompletePurchaseRequest extends AbstractCardRequest
{
    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        if (!$transactionReference = $this->httpRequest->get('psp_rrn')) {
            throw new InvalidRequestException('The psp_rrn parameter is required');
        }

        $data = array(
            'psp_rrn' => $transactionReference
        );

        return $data;
    }

    /**
     * @param array $data
     *
     * @return CardCompletePurchaseResponse
     */
    public function sendData($data)
    {
        $headers = array(
            'Content-Type' => 'application/json; charset=utf-8'
        );

        $httpRequest = $this->httpClient->createRequest('POST', $this->getEndpoint(), $headers, $data);
        $httpResponse = $httpRequest->send();
        $jsonResponse = $httpResponse->json();

        return new CardCompletePurchaseResponse($this, $jsonResponse);
    }
}
