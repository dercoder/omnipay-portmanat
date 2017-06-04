<?php

namespace Omnipay\Portmanat\Message;

use Omnipay\Tests\TestCase;

class FetchTransactionRequestTest extends TestCase
{
    /**
     * @var CardFetchTransactionRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new CardFetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'serviceId'            => '123456',
            'secretKey'            => 'aV4cvKHFMfqqINI',
            'transactionReference' => '1495199725-5xfasd-6CVI3o-l]Bupz'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('1495199725-5xfasd-6CVI3o-l]Bupz', $data['psp_rrn']);

        $request = new CardFetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->setExpectedException('Omnipay\Common\Exception\InvalidRequestException', 'The transactionReference parameter is required');
        $request->getData();
    }

    public function testSendData()
    {
        $this->setMockHttpResponse('CardFetchTransactionPendingResponse.txt');
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\Portmanat\Message\CardFetchTransactionResponse', $response);
    }
}
