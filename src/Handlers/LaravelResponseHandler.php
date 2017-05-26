<?php
namespace Debughub\Client\Handlers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Debughub\Client\Config;

class LaravelResponseHandler extends ResponseHandler
{

    private $app;

    public function __construct(Config $config, Application $app)
    {
        parent::__construct($config);
        $this->app = $app;


        //listener for view events
        $app['events']->listen('composing:*', function ($view, $data) {
            $this->parseView($data);
        });

        $this->response = '';
        $app['events']->listen('*', function ($event = null, $data = null) {
          if ($event == 'Illuminate\Foundation\Http\Events\RequestHandled' && $data) {
            $request = $data[0];
            $maxLength = 1000;
            if (strlen($request->response->getContent()) > $maxLength) {
              $data = substr($request->response->getContent(), 0, $maxLength);
            } else {
              $data = $request->response->getContent();
            }
            $this->response = $data;
          }

        });
    }


    private function parseView($data)
    {
        if (is_object($data[0])){
          $this->views[] = [
            'name' => $data[0]->getName(),
            'path' => $data[0]->getPath()
          ];

        }

    }
}
