<?php

namespace Omnipay\Portmanat;

use Omnipay\Tests\GatewayTestCase;

class CardGatewayTest extends GatewayTestCase
{
    /**
     * @var CardGateway
     */
    public $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new CardGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setServiceId('123456');
        $this->gateway->setSecretKey('aV4cvKHFMfqqINI');
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase();
        $this->assertSame('123456', $request->getServiceId());
        $this->assertSame('aV4cvKHFMfqqINI', $request->getSecretKey());;
        $this->assertInstanceOf('Omnipay\Portmanat\Message\CardPurchaseRequest', $request);
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase();
        $this->assertSame('http://psp.mps.az/check', $request->getEndpoint());
        $this->assertInstanceOf('Omnipay\Portmanat\Message\CardCompletePurchaseRequest', $request);
    }

    public function testFetchTransaction()
    {
        $request = $this->gateway->fetchTransaction();
        $this->assertSame('http://psp.mps.az/check', $request->getEndpoint());
        $this->assertInstanceOf('Omnipay\Portmanat\Message\CardFetchTransactionRequest', $request);
    }
}
