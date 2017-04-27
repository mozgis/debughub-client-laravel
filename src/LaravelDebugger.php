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
        $debugger->queryHandler = new LaravelQueryHandler($this->app);
        $debugger->logHandler = new LogHandler();
        $debugger->exceptionHandler = new ExceptionHandler();
        $debugger->requestHandler = new LaravelRequestHandler($config, $this->app);
        $debugger->responseHandler = new LaravelResponseHandler($config, $this->app);
        $debugger->registerShutdown();

    }
}
