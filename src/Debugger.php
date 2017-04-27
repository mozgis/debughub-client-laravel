<?php

namespace Debughub\Client;


use DB;
use App;

class Debugger
{
    public $queryHandler;
    public $exceptionHandler;
    public $logHandler;
    public $requestHandler;
    public $responseHandler;
    public $startTime;
    public $endTime;
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->startTime = microtime();

    }


    public function registerShutdown()
    {
       register_shutdown_function([$this, 'sendData']);
    }

    private function createPayload()
    {

        $endTime = microtime();
        $timeStartFloat = $this->microtimeFloat($this->startTime);
        $timeEndFloat = $this->microtimeFloat($endTime);
        $duration = $timeEndFloat - $_SERVER['REQUEST_TIME_FLOAT'];

        return [
          'data' =>[
              'start_time' => $this->startTime,
              'end_time' => $endTime,
              'queries' => $this->queryHandler->getData(),
              'exceptions' => $this->exceptionHandler->getData(),
              'logs' => $this->logHandler->getData(),
              'request' => $this->requestHandler->getData(),
              'response' => $this->responseHandler->getData(),
              'duration' => $duration,
          ],
          'api_key' => $this->config->getApiKey(),
          'project_key' => $this->config->getProjectKey(),
        ];
    }

    public function sendData()
    {
        $payload = $this->createPayload();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config->getEndpoint());
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec ($ch);
        curl_close ($ch);
    }

    private function microtimeFloat($time)
    {
      list($usec, $sec) = explode(" ", $time);
      return ((float)$usec + (float)$sec);
    }
}
