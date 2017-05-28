<?php

namespace Debughub\Client;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;


class DebughubServiceProvider extends ServiceProvider
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
        if ($this->config->enabled) {
          new LaravelDebugger($this->app, $this->config);
        }



    }

    private function configure()
    {
        $config = realpath(__DIR__.'/../config/debughub.php');
        $this->mergeConfigFrom($config, 'debughub');

        $this->config = new Config();
        $this->config->setApiKey($this->app->config->get('debughub.api_key'));
        $this->config->setProjectKey($this->app->config->get('debughub.project_key'));
        $this->config->setEndpoint($this->app->config->get('debughub.endpoint'));
        $this->config->setGitRoot($this->app->config->get('debughub.git_root'));
        $this->config->setBlacklistParams($this->app->config->get('debughub.blacklist_params'));
        $this->config->setEnabled($this->app->config->get('debughub.enabled'));

    }


}
