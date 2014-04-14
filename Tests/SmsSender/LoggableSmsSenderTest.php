<?php

namespace KPhoen\SmsSenderBundle\Tests\SmsSender;

use SmsSender\Provider\DummyProvider;

use KPhoen\SmsSenderBundle\SmsSender\LoggableSmsSender;

/**
* @author Kévin Gomez <contact@kevingomez.fr>
*/
class LoggableSmsSenderTest extends \PHPUnit_Framework_TestCase
{
    public function testSendLogsData()
    {
        $provider = $this->getMock('\SmsSender\Provider\DummyProvider');
        $result = $this->getMock('\SmsSender\Result\ResultInterface');

        // setup the sender
        $sender = $this->getMock('\SmsSender\SmsSenderInterface', array('getProvider', 'send'));
        $sender->expects($this->once())
            ->method('getProvider')
            ->will($this->returnValue($provider));
        $sender->expects($this->once())
            ->method('send')
            ->with(
                $this->equalTo('0642424242'),
                $this->equalTo('content'),
                $this->equalTo('originator')
            )
            ->will($this->returnValue($result));

        // setup the logger
        $logger = $this->getMock('\KPhoen\SmsSenderBundle\Logger\SmsSenderLogger', array('logMessage'));
        $logger->expects($this->once())
            ->method('logMessage')
            ->with(
                $this->equalTo($result),                // the exact result returned by the sender
                $this->greaterThan(0),                  // duration
                $this->stringContains('DummyProvider')  // provider className
            );

        // setup the sender
        $sender = new LoggableSmsSender($sender, $logger);

        // and launch the test
        $senderResult = $sender->send('0642424242', 'content', 'originator');
        $this->assertSame($result, $senderResult);
    }

    public function testSendWithNoLogger()
    {
        $result = $this->getMock('\SmsSender\Result\ResultInterface');

        // setup the sender
        $sender = $this->getMock('\SmsSender\SmsSender');
        $sender->expects($this->once())
            ->method('send')
            ->with(
                $this->equalTo('0642424242'),
                $this->equalTo('content'),
                $this->equalTo('originator')
            )
            ->will($this->returnValue($result));

        // setup the sender
        $sender = new LoggableSmsSender($sender);

        // and launch the test
        $senderResult = $sender->send('0642424242', 'content', 'originator');
        $this->assertSame($result, $senderResult);
    }
}
