<?php

namespace Debughub\Client;


use Illuminate\Contracts\Foundation\Application;

class LaravelQueryHandler extends QueryHandler
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;

        //listener for view events
        $app['events']->listen('Illuminate\Database\Events\QueryExecuted', function($event) {
          $data = [
            'query' => $event->sql,
            'data' => $event->bindings,
            'duration' => $event->time,
            'end_time' => microtime(),
          ];
          $this->queries[] = $data;
        });
    }

}
