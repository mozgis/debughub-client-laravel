<?php

namespace Debughub\Client\Handlers;

use Debughub\Client\Reportable;

class LogHandler implements Reportable
{

    private $logs = [];

    public function __construct()
    {

    }

    public function addLog($data, $name, $type = 'log')
    {
        if (is_string($data) || is_numeric($data) || is_bool($data) || is_null($data)) {
            $this->push($data, $name, $type);
        } else {
            $this->push(var_export($data, true), $name, $type);
        }
    }

    private function push($data, $name, $type)
    {
        $trace = debug_backtrace();
        $file = '';
        $line = '';
        if ($trace && isset($trace[3]) && isset($trace[3]['file'])) {
            $file = $trace[3]['file'];
            $line = $trace[3]['line'];
        }
        return $this->logs[] = [
            'time' => microtime(),
            'payload' => $data,
            'name' => $name,
            'type' => $type,
            'file' => $file,
            'line' => $line,
        ];
    }

    public function getData()
    {
      return $this->logs;
    }
}
