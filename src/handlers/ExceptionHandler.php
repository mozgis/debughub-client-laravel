<?php

namespace Debughub\Client;



class ExceptionHandler implements Reportable
{
    private $exceptions = [];

    public function __construct()
    {
      $this->addExceptionListener();
    }

    private function addExceptionListener()
    {

    }

    public function getData()
    {
      return $this->exceptions;
    }
}
