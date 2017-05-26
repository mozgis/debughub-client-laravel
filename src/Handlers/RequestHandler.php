<?php

namespace Debughub\Client\Handlers;

use Debughub\Client\Reportable;
use Debughub\Client\Config;


class RequestHandler implements Reportable
{
    public $params;
    public $headers;
    public $method;
    public $route;
    public $url;
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    private function filterParams()
    {
        if (is_array($this->params)) {
            foreach ($this->params as $name => $param) {
                if (in_array($name, $this->config->getBlacklistParams())) {
                    $this->params[$name] = 'blacklisted param';
                }
            }
        }
    }

    public function getData()
    {
        $this->filterParams();
        return [
            'params' => $this->params,
            'headers' => $this->headers,
            'method' => $this->method,
            'route' => $this->route,
            'url' => $this->url,
        ];
    }
}
