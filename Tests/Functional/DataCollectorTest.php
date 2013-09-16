<?php

namespace KPhoen\SmsSenderBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DataCollectorTest extends WebTestCase
{
    public function testMessagesAreCollected()
    {
        $client = static::createClient();

        // only exists in symfony >2.1
        if (method_exists($client, 'enableProfiler')) {
            $client->enableProfiler();
        }

        $crawler = $client->request('GET', '/', array(
            'recipient' => '0652525252',
            'body'      => 'test body',
        ));

        $this->assertTrue($client->getResponse()->isSuccessful());

        // check the profiler content
        $profile = $client->getProfile();
        $sms_collector = $profile->getCollector('sms_sender');
        $sms_data = $sms_collector->getSmsData();

        $this->assertEquals(1, $sms_collector->getSmsCount());
        $this->assertCount(1, $sms_data);

        $this->assertArrayHasKey('sms', $sms_data[0]);
        $this->assertArrayHasKey('duration', $sms_data[0]);
        $sms = $sms_data[0]['sms'];

        $this->assertInternalType('float', $sms_data[0]['duration']);
        $this->assertInternalType('float', $sms_collector->getTime());
        $this->assertSame('SmsSender\Provider\DummyProvider', $sms_data[0]['provider_class']);
        $this->assertInstanceOf('\SmsSender\Result\ResultInterface', $sms);
        $this->assertSame('0652525252', $sms->getRecipient());
        $this->assertSame('test body', $sms->getBody());
    }
}
