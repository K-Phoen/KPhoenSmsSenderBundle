<?php

namespace KPhoen\SmsSenderBundle\SmsSender;

use SmsSender\SmsSender;

use KPhoen\SmsSenderBundle\Logger\SmsSenderLogger;

/**
 * @author Kévin Gomez <kevin_gomez@carpe-hora.com>
 */
class LoggableSmsSender extends SmsSender
{
    protected $logger;

    public function __construct(SmsSenderLogger $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function send($recipient, $body, $originator = '')
    {
        if ($this->logger === null) {
            return parent::send($recipient, $body, $originator);
        }

        $time = microtime(true);
        $result = parent::send($recipient, $body, $originator);
        $duration = microtime(true) - $time;

        $this->logger->logMessage($result, $duration, $this->getProviderClass());

        return $result;
    }

    protected function getProviderClass()
    {
        return get_class($this->getProvider());
    }
}
