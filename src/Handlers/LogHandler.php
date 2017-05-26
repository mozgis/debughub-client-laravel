<?php

namespace Debughub\Client\Handlers;

use Debughub\Client\Reportable;

class LogHandler implements Reportable
{

    private $logs = [];

    public function __construct()
    {

    }

    public function addLog($data)
    {
        if (is_string($data) || is_numeric($data) || is_bool($data) || is_null($data)) {
            $this->push($data);
        } else {
            $this->push(var_export($data, true));
        }
    }

    private function push($data)
    {
        return $this->logs[] = [
          'time' => microtime(),
          'payload' => $data
        ];
    }

    public function getData()
    {
      return $this->logs;
    }
}
