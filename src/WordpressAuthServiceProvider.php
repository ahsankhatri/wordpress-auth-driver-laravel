<?php

namespace MrShan0\WordpressAuth;

use Auth;
use Hautelook\Phpass\PasswordHash;
use Illuminate\Support\ServiceProvider;
use MrShan0\WordpressAuth\Hashing\WordPressHasher;
use MrShan0\WordpressAuth\Auth\EloquentWordpressUserProvider;
use MrShan0\WordpressAuth\Guard\WordpressGuard;

class WordpressAuthServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/hash.php', 'wordpress-hash.hash');

        Auth::extend('wordpress', function($app) {
            return new WordpressGuard(
                new EloquentWordpressUserProvider($app['wordpress-hash'], $config['model'])
            );
        });

        $this->app->singleton('wordpress-hash', function ($app)
        {
            $iteration_count = $app['config']->get('wordpress-hash.hash.iteration_count');
            $portable_hashes = $app['config']->get('wordpress-hash.hash.portable_hashes');

            $hasher = new PasswordHash($iteration_count, $portable_hashes);

            return new WordPressHasher($hasher);
        });

        Auth::provider('eloquent.wordpress', function($app, array $config) {
            return new EloquentWordpressUserProvider($app['wordpress-hash'], $config['model']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['wordpress-hash'];
    }
}
