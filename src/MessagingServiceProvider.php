<?php
namespace Midnite81\Plivo;

use Illuminate\Support\ServiceProvider;
use Midnite81\Plivo\Services\Messaging;
use Midnite81\Plivo\Services\Plivo;


class MessagingServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    /**
     * Bootstrap the application events.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../config/plivo.php' => config_path('plivo.php')
        ]);
        $this->mergeConfigFrom(__DIR__ . '/../config/plivo.php', 'plivo');
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('midnite81.plivo', function ($app) {
            return new Messaging($app->make(Plivo::class));
        });

        $this->app->alias('midnite81.plivo', 'Midnite81\Plivo\Contracts\Services\Messaging');
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['midnite81.plivo', 'Midnite81\Plivo\Contracts\Services\Messaging'];
    }
}