<?php

namespace Omnipay\Portmanat\Message;

use Omnipay\Tests\TestCase;

class CardCompletePurchaseResponseTest extends TestCase
{
    public function testPending()
    {
        $this->setMockHttpResponse('CardFetchTransactionPendingResponse.txt');
        $request = new CardCompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $response = $request->sendData(array(
            'psp_rrn' => '1495199725-5xfasd-6CVI3o-l]Bupz'
        ));

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isPending());
        $this->assertSame(1, $response->getCode());
        $this->assertSame('Request is pending', $response->getMessage());
        $this->assertSame('OK', $response->getStatus());
        $this->assertSame(5.23, $response->getAmount());
        $this->assertSame('591eefd77c028', $response->getTransactionId());
        $this->assertSame('1495199725-5xfasd-6CVI3o-l]Bupz', $response->getTransactionReference());
        $this->assertSame('O/yn+szmjVxYVMmst0T7Z02zxM0=', $response->getBankTransactionReference());
        $this->assertInstanceOf('DateTime', $response->getDate());
        $this->assertNull($response->getErrors());
    }

    public function testSuccess()
    {
        $this->setMockHttpResponse('CardFetchTransactionSuccessResponse.txt');
        $request = new CardCompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $response = $request->sendData(array(
            'psp_rrn' => '1495199725-5xfasd-6CVI3o-l]Bupz'
        ));

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertSame(0, $response->getCode());
        $this->assertSame('Success', $response->getMessage());
        $this->assertSame('OK', $response->getStatus());
        $this->assertSame('OK', $response->getStatus());
        $this->assertSame(5.23, $response->getAmount());
        $this->assertSame('591eefd77c028', $response->getTransactionId());
        $this->assertSame('1495199725-5xfasd-6CVI3o-l]Bupz', $response->getTransactionReference());
        $this->assertSame('O/yn+szmjVxYVMmst0T7Z02zxM0=', $response->getBankTransactionReference());
        $this->assertInstanceOf('DateTime', $response->getDate());
        $this->assertNull($response->getErrors());
    }

    public function testFailed()
    {
        $this->setMockHttpResponse('CardFetchTransactionFailedResponse.txt');
        $request = new CardCompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $response = $request->sendData(array(
            'psp_rrn' => '1495199725-5xfasd-6CVI3o-l]Bupz'
        ));

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertSame(10, $response->getCode());
        $this->assertSame('Validation error', $response->getMessage());
        $this->assertSame('BAD', $response->getStatus());
        $this->assertNull($response->getAmount());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getBankTransactionReference());
        $this->assertNull($response->getDate());
        $this->assertSame(array(
            'psp_rrn' => array(
                'The psp rrn field is required.'
            )
        ), $response->getErrors());
    }
}