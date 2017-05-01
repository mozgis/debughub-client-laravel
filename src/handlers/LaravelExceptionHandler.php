<?php

namespace Debughub\Client;


use Illuminate\Contracts\Foundation\Application;

class LaravelExceptionHandler extends ExceptionHandler
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;

        //listener for error events
        $app['events']->listen('*', function($event, $data = null) {
          //for laravel 5.2
          if ($event == 'error') {
            $this->exceptions[] = $this->parseError($data);
          }
          //for laravel 5.4+
          if ($event == 'Illuminate\Foundation\Http\Events\RequestHandled') {
            //if exception is found, add it to the stack
            if ($data[0]->response->exception) {
              $this->exceptions[] = $this->parseError($data[0]->response->exception);
            }
          }
        });
    }

    public function parseError($data) {
      $errorTrace = [];
      foreach ($data->getTrace() as $trace) {
        $errorTrace[] = [
          'file' => isset($trace['file']) ? $trace['file'] : '',
          'line' => isset($trace['line']) ? $trace['line'] : '',
          'function' => isset($trace['function']) ? $trace['function'] : '',
          'class' => isset($trace['class']) ? $trace['class'] : '',
          'type' => isset($trace['type']) ? $trace['type'] : '',
        ];
      }
      return [
        'message' => $data->getMessage(),
        'file' => $data->getFile(),
        'code' => $data->getCode(),
        'line' => $data->getLine(),
        'severity' => $data->getSeverity(),
        'trace' => $errorTrace,
        'end_time' => microtime()
      ];
    }
}
