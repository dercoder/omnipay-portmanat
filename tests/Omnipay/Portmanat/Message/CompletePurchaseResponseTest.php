<?php
namespace Omnipay\Portmanat\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'partnerId' => '12345',
            'serviceId' => '67890',
            'securityKey' => 'oJ2rHLBVSbD5iGfT',
            'testMode' => true
        ));
    }

    public function testFailure()
    {
        $response = new CompletePurchaseResponse($this->request, array(
            'o_id' => '1234567890',
            'transaction' => 'TX9997888',
            'method' => 'CODE',
            'amount' => '14.65',
            'test' => '0',
            'hash' => 'CE76828063B3A2E3793A23C21B603E93'
        ));

        $this->assertFalse($response->isSuccessful());
        $this->assertNull($response->getCode());
        $this->assertSame('Invalid test mode', $response->getMessage());
        $this->assertSame('1234567890', $response->getTransactionId());
        $this->assertSame('TX9997888', $response->getTransactionReference());
        $this->assertSame('CODE', $response->getMethod());
        $this->assertSame('14.65', $response->getAmount());
        $this->assertFalse($response->getTest());
        $this->assertSame('CE76828063B3A2E3793A23C21B603E93', $response->getHash());

        $response = new CompletePurchaseResponse($this->request, array(
            'o_id' => '1234567890',
            'transaction' => 'TX9997888',
            'method' => 'CODE',
            'amount' => '14.65',
            'test' => '1',
            'hash' => 'CE76828063B3A2E3793A23C21B603E94'
        ));

        $this->assertFalse($response->isSuccessful());
        $this->assertNull($response->getCode());
        $this->assertSame('Invalid hash checksum', $response->getMessage());
        $this->assertSame('1234567890', $response->getTransactionId());
        $this->assertSame('TX9997888', $response->getTransactionReference());
        $this->assertSame('CODE', $response->getMethod());
        $this->assertSame('14.65', $response->getAmount());
        $this->assertTrue($response->getTest());
        $this->assertSame('CE76828063B3A2E3793A23C21B603E94', $response->getHash());
    }

    public function testSuccess()
    {
        $response = new CompletePurchaseResponse($this->request, array(
            'o_id' => '1234567890',
            'transaction' => 'TX9997888',
            'method' => 'CODE',
            'amount' => '14.65',
            'test' => '1',
            'hash' => 'CE76828063B3A2E3793A23C21B603E93'
        ));

        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('1234567890', $response->getTransactionId());
        $this->assertSame('TX9997888', $response->getTransactionReference());
        $this->assertSame('CODE', $response->getMethod());
        $this->assertSame('14.65', $response->getAmount());
        $this->assertTrue($response->getTest());
        $this->assertSame('CE76828063B3A2E3793A23C21B603E93', $response->getHash());
    }
}
