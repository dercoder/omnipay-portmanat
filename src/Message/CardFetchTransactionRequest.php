<?php

namespace Omnipay\Portmanat\Message;

/**
 * Class CardFetchTransactionRequest
 * @package Omnipay\Portmanat\Message
 */
class CardFetchTransactionRequest extends AbstractCardRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $this->validate(
            'transactionReference'
        );

        $data = array(
            'psp_rrn' => $this->getTransactionReference()
        );

        return $data;
    }

    /**
     * @param array $data
     *
     * @return CardFetchTransactionResponse
     */
    public function sendData($data)
    {
        $headers = array(
            'Content-Type' => 'application/json; charset=utf-8'
        );

        $httpRequest = $this->httpClient->createRequest('POST', $this->getEndpoint(), $headers, $data);
        $httpResponse = $httpRequest->send();
        $jsonResponse = $httpResponse->json();

        return new CardFetchTransactionResponse($this, $jsonResponse);
    }
}
