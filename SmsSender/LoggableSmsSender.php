<?php

namespace KPhoen\SmsSenderBundle\SmsSender;

use SmsSender\DelayedSenderInterface;
use SmsSender\SmsSenderInterface;

use KPhoen\SmsSenderBundle\Logger\SmsSenderLogger;

/**
 * @author Kévin Gomez <kevin_gomez@carpe-hora.com>
 */
class LoggableSmsSender implements DelayedSenderInterface
{
    protected $sender;
    protected $logger;

    public function __construct(SmsSenderInterface $sender, SmsSenderLogger $logger = null)
    {
        $this->sender = $sender;
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function send($recipient, $body, $originator = '')
    {
        if ($this->logger === null) {
            return $this->sender->send($recipient, $body, $originator);
        }

        $time = microtime(true);
        $result = $this->sender->send($recipient, $body, $originator);
        $duration = microtime(true) - $time;

        $this->logger->logMessage($result, $duration, $this->getProviderClass());

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        if ($this->sender instanceof DelayedSenderInterface) {
            $this->sender->flush();
        }
    }

    /**
     * Allows to proxy method calls to the real SMS sender.
     */
    public function __call($name, $arguments)
    {
        if (is_callable(array($this->sender, $name))) {
            $result = call_user_func_array(array($this->sender, $name), $arguments);

            // don't break fluid interfaces
            return $result instanceof SmsSenderInterface ? $this : $result;
        }
    }

    protected function getProviderClass()
    {
        return ($provider = $this->sender->getProvider()) ? get_class($provider) : null;
    }
}
