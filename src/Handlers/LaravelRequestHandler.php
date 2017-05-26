<?php

namespace Debughub\Client\Handlers;

use Illuminate\Contracts\Foundation\Application;
use Debughub\Client\Config;


class LaravelRequestHandler extends RequestHandler
{

    public function __construct(Config $config, Application $app)
    {
        parent::__construct($config);
        //set up laravel request variables
        $this->params = $app['request']->all();
        $this->headers = $app['request']->header();
        $this->method = strtolower($app['request']->server('REQUEST_METHOD'));
        $this->url = $app['request']->url();
        $app['events']->listen('Illuminate\Routing\Events\RouteMatched', function($event) {
          if (method_exists('Illuminate\Routing\Route', 'getUri')) {
            $this->route = $event->route->getUri();
          } else {
            $this->route = $event->route->uri;
          }
        });
    }
}
