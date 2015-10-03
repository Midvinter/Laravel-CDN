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
     * @return array
     */
    private function getConfig()
    {
        $config = config('engagement-cdn');
        if (!$config) {
            return [];
        }

        if (isset($config['CDN_URL'])) {
            $config['CDN_URL'] = rtrim($config['CDN_URL'], '/');
        }

        if (isset($config['BYPASS']) && $config['BYPASS'] === null) {
            $config['BYPASS'] = env('APP_DEBUG', false);
        }

        return $config;
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CDN::class, function ($app) {
            return new CDN($this->getConfig());
        });
        $this->app->singleton(Version::class, function ($app) {
            return new Version($this->getConfig());
        });
        $this->commands([Version::class]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [CDN::class];
    }
}
