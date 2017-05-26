<?php

namespace Debughub\Client;


use Illuminate\Contracts\Foundation\Application;

class LaravelDebugger
{
    private $queryHandler;
    protected $app;

    public function __construct(Application $app, Config $config)
    {
        $this->app = $app;
        $debugger = new Debugger($config);
        $debugger->queryHandler = new Handlers\LaravelQueryHandler($this->app);
        $debugger->logHandler = new Handlers\LogHandler();
        $debugger->exceptionHandler = new Handlers\LaravelExceptionHandler($this->app);
        // $debugger->requestHandler = '';
        $debugger->requestHandler = new Handlers\LaravelRequestHandler($config, $this->app);
        $debugger->responseHandler = new Handlers\LaravelResponseHandler($config, $this->app);
        $debugger->registerShutdown();

    }
}
