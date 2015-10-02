<?php

namespace EngagementAgency\CDN;

use EngagementAgency\CDN\Commands\Version;
use Illuminate\Support\ServiceProvider;

class CDNServiceProvider extends ServiceProvider
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
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('engagement-cdn.php'),
            __DIR__ . '/config.json' => config_path('engagement-cdn.json')
        ]);
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CDN::class, function ($app) {
            return new CDN(config('engagement-cdn'));
        });
        $this->app->singleton(Version::class, function ($app) {
            return new Version(config('engagement-cdn'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [CDN::class, Version::class];
    }
}
