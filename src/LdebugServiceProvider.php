<?php

namespace Debughub\Client;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\TerminableMiddleware;
use Debughub\Client\Middleware\SendData;


class LdebugServiceProvider extends ServiceProvider
{

    private $config;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();

        new LaravelDebugger($this->app, $this->config);


    }

    private function configure()
    {
        $config = realpath(__DIR__.'/../config/ldebugger.php');
        $this->mergeConfigFrom($config, 'ldebugger');

        $this->config = new Config();
        $this->config->setApiKey($this->app->config->get('ldebugger.api_key'));
        $this->config->setProjectKey($this->app->config->get('ldebugger.project_key'));
        $this->config->setEndpoint($this->app->config->get('ldebugger.endpoint'));
        $this->config->setGitRoot($this->app->config->get('ldebugger.git_root'));
        $this->config->setBlacklistParams($this->app->config->get('ldebugger.blacklist_params'));

    }


}
