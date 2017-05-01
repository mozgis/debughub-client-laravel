<?php

namespace Debughub\Client;


class QueryHandler implements Reportable
{
    public $queries = [];

    public function getData()
    {
      return $this->queries;
    }
}
