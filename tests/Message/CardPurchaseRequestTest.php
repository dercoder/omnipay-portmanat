<?php

namespace Omnipay\Portmanat\Message;

use Omnipay\Tests\TestCase;

class CardPurchaseRequestTest extends TestCase
{
    /**
     * @var CardPurchaseRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new CardPurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'serviceId'     => '123456',
            'secretKey'     => 'aV4cvKHFMfqqINI',
            'amount'        => 5.23,
            'currency'      => 'AZN',
            'transactionId' => 'TX12345',
            'clientIp'      => '127.0.0.1',
            'returnUrl'     => 'https://example.com/return',
            'cancelUrl'     => 'https://example.com/cancel'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('123456', $data['service_id']);
        $this->assertSame('TX12345', $data['client_rrn']);
        $this->assertSame('5.23', $data['amount']);
        $this->assertSame('127.0.0.1', $data['client_ip']);
        $this->assertSame('https://example.com/return', $data['return_url']);
        $this->assertSame('https://example.com/cancel', $data['cancel_url']);
        $this->assertSame('44e5739572227948cb2dad894fb580180f4304c2ce68e8cd2df30fa2d408ec1f', $data['hash']);

        $this->request->setCurrency('EUR');
        $this->setExpectedException('Omnipay\Common\Exception\InvalidRequestException', 'Invalid currency. Only AZN is supported');
        $this->request->getData();
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\Portmanat\Message\CardPurchaseResponse', $response);
    }
}
