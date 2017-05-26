<?php

namespace Debughub\Client\Handlers;


class QueryHandler implements Reportable
{
    public $queries = [];

    public function getData()
    {
      return $this->queries;
    }
}
