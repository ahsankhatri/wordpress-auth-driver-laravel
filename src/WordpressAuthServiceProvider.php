<?php

namespace MrShan0\WordpressAuth;

use Auth;
use Hautelook\Phpass\PasswordHash;
use Illuminate\Support\ServiceProvider;
use MrShan0\WordpressAuth\Auth\EloquentWordpressUserProvider;
use MrShan0\WordpressAuth\Guard\WordpressGuard;
use MrShan0\WordpressAuth\Hashing\WordPressHasher;

class WordpressAuthServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/wordpress-auth.php' => config_path('wordpress-auth.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/wordpress-auth.php', 'wordpress-auth');

        Auth::extend('wordpress', function ($app) {
            return new WordpressGuard(
                new EloquentWordpressUserProvider($app['wordpress-auth'], $config['model'])
            );
        });

        $this->app->singleton('wordpress-auth', function ($app) {
            $iteration_count = $app['config']->get('wordpress-auth.hash.iteration_count');
            $portable_hashes = $app['config']->get('wordpress-auth.hash.portable_hashes');

            $hasher = new PasswordHash($iteration_count, $portable_hashes);

            return new WordPressHasher($hasher);
        });

        Auth::provider('eloquent.wordpress', function ($app, array $config) {
            return new EloquentWordpressUserProvider($app['wordpress-auth'], $config['model']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['wordpress-auth'];
    }
}
