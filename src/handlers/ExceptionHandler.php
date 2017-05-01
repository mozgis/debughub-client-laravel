<?php

namespace Debughub\Client;


class ExceptionHandler implements Reportable
{
    public $exceptions = [];

    public function getData()
    {
      return $this->exceptions;
    }
}
