<?php

namespace Debughub\Client\Handlers;

use Debughub\Client\Reportable;

class ExceptionHandler implements Reportable
{
    public $exceptions = [];

    public function getData()
    {
      return $this->exceptions;
    }
}
