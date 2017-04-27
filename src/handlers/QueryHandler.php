<?php

namespace Debughub\Client;

use DB;

class QueryHandler implements Reportable
{
    public $queries = [];

    public function getData()
    {
      return $this->queries;
    }
}
