<?php

namespace Debughub\Client\Handlers;


class ExceptionHandler implements Reportable
{
    public $exceptions = [];

    public function getData()
    {
      return $this->exceptions;
    }
}
