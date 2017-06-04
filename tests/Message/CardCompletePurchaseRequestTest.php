<?php

namespace Omnipay\Portmanat\Message;

use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CardCompletePurchaseRequestTest extends TestCase
{
    /**
     * @var CardCompletePurchaseRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $httpRequest = new HttpRequest(array(), array(
            'psp_rrn' => '1495199725-5xfasd-6CVI3o-l]Bupz'
        ));

        $this->request = new CardCompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $this->request->initialize(array(
            'serviceId' => '123456',
            'secretKey' => 'aV4cvKHFMfqqINI'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('1495199725-5xfasd-6CVI3o-l]Bupz', $data['psp_rrn']);

        $request = new CardCompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->setExpectedException('Omnipay\Common\Exception\InvalidRequestException', 'The psp_rrn parameter is required');
        $request->getData();
    }

    public function testSendData()
    {
        $this->setMockHttpResponse('CardFetchTransactionPendingResponse.txt');
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\Portmanat\Message\CardCompletePurchaseResponse', $response);
    }
}
