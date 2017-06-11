<?php

namespace Debughub\Client\Handlers;

use Debughub\Client\Reportable;

class LogHandler implements Reportable
{

    private $logs = [];

    public function __construct()
    {

    }

    public function addLog($data, $name)
    {
        if (is_string($data) || is_numeric($data) || is_bool($data) || is_null($data)) {
            $this->push($data, $name);
        } else {
            $this->push(var_export($data, true), $name);
        }
    }

    private function push($data, $name)
    {
        return $this->logs[] = [
            'time' => microtime(),
            'payload' => $data,
            'name' => $name
        ];
    }

    public function getData()
    {
      return $this->logs;
    }
}
