<?php

namespace Omnipay\Portmanat\Message;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Tests\TestCase;

class CardPurchaseResponseTest extends TestCase
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
            'clientIp'      => '127.0.0.1'
        ));
    }

    public function testSuccess()
    {
        /** @var RedirectResponseInterface $response */
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('POST', $response->getRedirectMethod());
        $this->assertSame('http://psp.mps.az/process', $response->getRedirectUrl());
        $this->assertSame(array(
            'service_id' => '123456',
            'client_rrn' => 'TX12345',
            'amount'     => '5.23',
            'client_ip'  => '127.0.0.1',
            'hash'       => '44e5739572227948cb2dad894fb580180f4304c2ce68e8cd2df30fa2d408ec1f'
        ), $response->getRedirectData());
    }
}
