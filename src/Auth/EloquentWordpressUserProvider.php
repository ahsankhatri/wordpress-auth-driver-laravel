<?php

namespace MrShan0\WordpressAuth\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class EloquentWordpressUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) ||
           (count($credentials) === 1 &&
            array_key_exists('password', $credentials))) {
            return;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();

        $credentials = $this->transformPayloadForWP($credentials);
        $password_column = config('wordpress-auth.options.password_column', 'user_pass');
        foreach ($credentials as $key => $value) {
            if (Str::contains($key, 'password') || $key == $password_column) {
                continue;
            }

            $query->where($key, $value);
        }

        return $query->first();
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $credentials = $this->transformPayloadForWP($credentials);
        $plain = $credentials[config('wordpress-auth.options.password_column', 'user_pass')];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }

    private function transformPayloadForWP(array $credentials)
    {
        // Get password column name
        $password_column = config('wordpress-auth.options.password_column', 'user_pass');
        $email_column = config('wordpress-auth.options.email_column', 'user_email');

        // This is required when used laravel auth scaffolding since wp follows
        // `user_email` and laravel follows `email` only
        // Same goes for `password` as `user_pass` by wordpress
        if (
            config('wordpress-auth.options.force_wp_email', false) &&
            array_key_exists('email', $credentials)
        ) {
            $credentials[$email_column] = $credentials['email'];
            unset($credentials['email']);
        }

        if (
            config('wordpress-auth.options.force_wp_password', false) &&
            array_key_exists('password', $credentials)
        ) {
            $credentials[$password_column] = $credentials['password'];
            unset($credentials['password']);
        }

        return $credentials;
    }
}
