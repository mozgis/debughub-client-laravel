<?php

namespace Debughub\Client\Handlers;

use Debughub\Client\Reportable;

class QueryHandler implements Reportable
{
    public $queries = [];

    public function getData()
    {
      return $this->queries;
    }
}
