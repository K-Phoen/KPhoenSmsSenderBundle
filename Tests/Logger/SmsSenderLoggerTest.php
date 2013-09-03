<?php

namespace KPhoen\SmsSenderBundle\Tests\SmsSender;

use KPhoen\SmsSenderBundle\Logger\SmsSenderLogger;

/**
* @author Kévin Gomez <contact@kevingomez.fr>
*/
class SmsSenderLoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testLogMessage()
    {
        $logger = $this->getMock('\Psr\Log\LoggerInterface');
        $logger->expects($this->once())->method('info');
        $sms_logger = new SmsSenderLogger($logger);

        $sms_logger->logMessage(
            $sms = $this->getMock('\SmsSender\Result\ResultInterface'),
            0.002, // seconds
            'DummyProviderClass'
        );

        $this->assertSame(array(
            array(
                'sms'               => $sms,
                'duration'          => 0.002,
                'provider_class'    => 'DummyProviderClass',
            )
        ), $sms_logger->getSms());
    }

    public function testLogMessageWithNoPsrLogger()
    {
        $sms_logger = new SmsSenderLogger();

        $sms_logger->logMessage(
            $sms = $this->getMock('\SmsSender\Result\ResultInterface'),
            0.002, // seconds
            'DummyProviderClass'
        );

        $this->assertSame(array(
            array(
                'sms'               => $sms,
                'duration'          => 0.002,
                'provider_class'    => 'DummyProviderClass',
            )
        ), $sms_logger->getSms());
    }
}
