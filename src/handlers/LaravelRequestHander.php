<?php

namespace Debughub\Client;


use Illuminate\Contracts\Foundation\Application;

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
            $this->route = $event->route->uri;
        });
    }
}
