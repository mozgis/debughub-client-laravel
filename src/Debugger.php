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
        register_shutdown_function(function () {
            $payload = $this->createPayload();


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config->getEndpoint());
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        });
    }

    private function createPayload()
    {

        $endTime = microtime();
        $timeStartFloat = $this->microtimeFloat($this->startTime);
        $timeEndFloat = $this->microtimeFloat($endTime);
        $duration = $timeEndFloat - $_SERVER['REQUEST_TIME_FLOAT'];

        $startTime = $_SERVER['REQUEST_TIME_FLOAT'];
        $bootTime =  $timeStartFloat - $startTime;
        $timeline = [];
        $timeline[] = [
            'start' => 0,
            'end' => $bootTime,
            'duration' => $bootTime,
            'name' => 'Laravel application boot',
            'type' => 'app_boot_time',
            'display_type' => '',
        ];
        $queries = $this->queryHandler->getData();
        foreach ($queries as $query) {
            $queryEndTime = $this->microtimeFloat($query['end_time']);
            $timeline[] = [
                'start' => $queryEndTime - ($query['duration'] / 1000) - $startTime,
                'end' => $queryEndTime - $startTime,
                'duration' => $query['duration'],
                'name' => $query['query'],
                'type' => 'query',
                'display_type' => 'query',
            ];
        }
        $logs = $this->logHandler->getData();
        foreach ($logs as $log) {
            $time = $this->microtimeFloat($log['time']);
            $duration = 0.01;
            $timeline[] = [
                'start' => $time - $startTime,
                'end' => $time + $duration - $startTime,
                'duration' => $duration,
                'name' => $log['payload'],
                'type' => 'log',
                'display_type' => $log['name'],

            ];
        }
        usort($timeline, function($a, $b) {
            if ($a['start'] == $b['start']) {
                return 0;
            }
            return ($a['start'] < $b['start']) ? -1 : 1;
        });


        return [
            'data' => [
                'boot_time' => $this->startTime,
                'start_time' => $_SERVER['REQUEST_TIME_FLOAT'],
                'end_time' => $endTime,
                'queries' => $queries,
                'exceptions' => $this->exceptionHandler->getData(),
                'logs' => $logs,
                'request' => $this->requestHandler->getData(),
                'response' => $this->responseHandler->getData(),
                'duration' => $duration,
                'timeline' => $timeline,
            ],
            'api_key' => $this->config->getApiKey(),
            'project_key' => $this->config->getProjectKey(),
        ];
    }

    private function microtimeFloat($time)
    {
        list($usec, $sec) = explode(" ", $time);
        return ((float)$usec + (float)$sec);
    }

    public function log($data = '', $name = 'info')
    {
        $this->logHandler->addLog($data, $name);
    }

    public function startBlock($name = null)
    {
        $this->logHandler->addLog([], $name, 'start_block');
    }

    public function stopBlock()
    {
        $this->logHandler->addLog([], null, 'end_block');

    }
}
