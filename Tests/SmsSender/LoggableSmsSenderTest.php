<?php

namespace KPhoen\SmsSenderBundle\Tests\SmsSender;

use SmsSender\Provider\DummyProvider;
use SmsSender\Result\ResultInterface;

use KPhoen\SmsSenderBundle\SmsSender\LoggableSmsSender;

/**
* @author Kévin Gomez <contact@kevingomez.fr>
*/
class LoggableSmsSenderTest extends \PHPUnit_Framework_TestCase
{
    public function testSendLogsData()
    {
        // setup the logger
        $logger = $this->getMock('\KPhoen\SmsSenderBundle\Logger\SmsSenderLogger');
        $logger->expects($this->once())
            ->method('logMessage')
            ->with(
                $this->callback(function($result) {
                    return $result instanceof ResultInterface;
                }),
                $this->greaterThan(0),                  // duration
                $this->stringContains('DummyProvider')  // provider className
            );

        // setup the sender
        $sender = new LoggableSmsSender($logger);
        $sender->registerProvider(new DummyProvider());

        // and launch the test
        $result = $sender->send('0642424242', 'content', 'originator');
    }

    public function testSendWithNoLogger()
    {
        // setup the sender
        $sender = new LoggableSmsSender();
        $sender->registerProvider(new DummyProvider());

        $result = $sender->send('0642424242', 'content', 'originator');
        $this->assertTrue(true, 'No error is raised');
    }
}
