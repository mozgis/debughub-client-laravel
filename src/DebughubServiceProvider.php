<?php

namespace Debughub\Client;

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
        $debugger = new Debugger($this->config);
        $debugger->logHandler = new Handlers\LogHandler();
        $debugger->queryHandler = new Handlers\LaravelQueryHandler($this->app);
        $debugger->exceptionHandler = new Handlers\LaravelExceptionHandler($this->app);
        $debugger->requestHandler = new Handlers\LaravelRequestHandler($this->config, $this->app);
        $debugger->responseHandler = new Handlers\LaravelResponseHandler($this->config, $this->app);
        $debugger->registerShutdown();

        $this->app->singleton('debughub', function () use($debugger) {
            return $debugger;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();




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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['debughub'];
    }
}
