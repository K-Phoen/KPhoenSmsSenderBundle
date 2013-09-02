<?php

namespace KPhoen\SmsSenderBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

use SmsSender\LoggableSmsSender;

class SmsSenderDataCollector extends DataCollector
{
    protected $sms_sender;

    public function __construct(LoggableSmsSender $sender)
    {
        $this->sms_sender = $sender;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'sms'       => $list = $this->retrieveSmsList(),
            'smsCount'  => count($list),
            'time'      => $this->computeTime(),
        );
    }

    /**
     * Returns the collector name.
     *
     * @return string The collector name.
     */
    public function getName()
    {
        return 'sms_sender';
    }

    public function getTime()
    {
        return $this->data['time'];
    }

    public function getSms()
    {
        return $this->data['sms'];
    }

    public function getSmsCount()
    {
        return $this->data['smsCount'];
    }

    protected function computeTime()
    {
        $total = 0;
        foreach ($this->sms_sender->getLoggedData() as $data) {
            $total += $data['time'];
        }

        return $total;
    }

    protected function retrieveSmsList()
    {
        $list = array();
        foreach ($this->sms_sender->getLoggedData() as $data) {
            $list[] = $data['sms'];
        }

        return $list;
    }
}
