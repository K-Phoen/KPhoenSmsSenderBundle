<?php

namespace KPhoen\SmsSenderBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

use KPhoen\SmsSenderBundle\Logger\SmsSenderLogger;

class SmsSenderDataCollector extends DataCollector
{
    protected $logger;

    public function __construct(SmsSenderLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'smsData'   => $list = $this->retrieveSmsList(),
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

    public function getSmsData()
    {
        return $this->data['smsData'];
    }

    public function getSmsCount()
    {
        return $this->data['smsCount'];
    }

    protected function computeTime()
    {
        $total = 0;
        foreach ($this->logger->getSms() as $data) {
            $total += $data['duration'];
        }

        return $total;
    }

    protected function retrieveSmsList()
    {
        return $this->logger->getSms();
    }
}
