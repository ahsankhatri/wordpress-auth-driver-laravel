# Wordpress Auth Driver for Laravel

[![Latest Stable Version](https://poser.pugx.org/ahsankhatri/wordpress-auth-provider/v/stable)](https://packagist.org/packages/ahsankhatri/wordpress-auth-provider) [![Total Downloads](https://poser.pugx.org/ahsankhatri/wordpress-auth-provider/downloads)](https://packagist.org/packages/ahsankhatri/wordpress-auth-provider) [![Build Status](https://scrutinizer-ci.com/g/ahsankhatri/wordpress-auth-driver-laravel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ahsankhatri/wordpress-auth-driver-laravel/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ahsankhatri/wordpress-auth-driver-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ahsankhatri/wordpress-auth-driver-laravel/?branch=master) [![Code Intelligence Status](https://scrutinizer-ci.com/g/ahsankhatri/wordpress-auth-driver-laravel/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence) [![License](https://poser.pugx.org/ahsankhatri/wordpress-auth-provider/license)](https://packagist.org/packages/ahsankhatri/wordpress-auth-provider)

| **Laravel**  |  **wordpress-auth-driver-laravel** |
|---|---|
| 5.2 to 5.5    | ^1.0  |
| 5.6 to 8.x  | ^2.0  |

## Installation

To install this package you will need
  - At least Laravel 5.6 ([for older versions of laravel](https://github.com/ahsankhatri/wordpress-auth-driver-laravel/tree/v1))
  - PHP 7.1 (or depending on your Laravel version)

The best way to install this package is with the help of composer. Run
```
composer require ahsankhatri/wordpress-auth-provider
```

or install it by adding it to `composer.json` then run `composer update`
```
"require": {
    "ahsankhatri/wordpress-auth-provider": "^2.0",
}
```

## Setup

Once you have installed this package from the [composer](https://packagist.org/packages/ahsankhatri/wordpress-auth-provider), make sure to follow the below steps to configure.

To register authentication guard.

##### config/auth.php
```php
'guards' => [
    ...,
    'wordpress' => [
        'driver' => 'session',
        'provider' => 'wordpress',
    ],
```

```php
'providers' => [
    ...,
    'wordpress' => [
        'driver' => 'eloquent.wordpress',
        'model' => MrShan0\WordpressAuth\Models\WordpressUser::class,
    ],
```

```php
'passwords' => [
    ...,
    'wordpress' => [
        'provider' => 'wordpress',
        'table' => 'password_resets',
        'expire' => 60,
    ],
```

#### Publish config file (optional)
```bash
php artisan vendor:publish --provider="MrShan0\WordpressAuth\WordpressAuthServiceProvider"
```

It will publish config file (`config/wordpress-auth.php`) where you can define your own connection type e.g `wp-mysql`. Make sure to fill `prefix` in `config/database.php` for `wp_` prefix in your tables if you're using prefix in wordpress tabels.

For example:
```php
'wp-mysql' => [
    'driver' => 'mysql',
    'host' => env('WP_DB_HOST', '127.0.0.1'),
    'port' => env('WP_DB_PORT', '3306'),
    'database' => env('WP_DB_DATABASE', 'forge'),
    'username' => env('WP_DB_USERNAME', 'forge'),
    'password' => env('WP_DB_PASSWORD', ''),
    'unix_socket' => env('WP_DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => 'wp_',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
],
```

Add following option along if using Laravel v7 (optional)
```php
    // ...
    'url' => env('DATABASE_URL'),
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
```

## Configuration

`password_resets` table (from Laravel default auth mechanism) is required to hold reset password token. If you do not have `password_resets` table then use this migration instead
```
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
```

## Extension
Alternatively, if you want to use a custom user model, you should have it extend `MrShan0\WordpressAuth\Models\WordpressUser` and specify the name of your model in `config/auth.php` under `providers` -> `wordpress` -> `model`.

## Customization
If you've renamed your `user_email` column of wordpress database, you need to first publish configurations of this package if you've not already, extend the model as mentioned above and make sure you've override your changes in your `$fillable` property and `config/wordpress-auth.php` config file which is being used for authentication scaffolding and sending notifications.

## Usage
You need to define `wordpress` **guard** explicitly to load the driver.
### Examples
```php
Auth::guard('wordpress')->loginUsingId(5);

// or login using email and password
Auth::guard('wordpress')->attempt([
    'user_email' => 'demo@example.com',
    'user_pass' => 'quickbrownfox'
]);

// get user object
Auth::guard('wordpress')->user();

// Update wordpress compatible password
$user->user_pass = app('wordpress-auth')->make('new_password');
$user->save();

// logout
Auth::guard('wordpress')->logout();
```

You may also change default guard in `config/auth.php` then your code will look like
```php
Auth::loginUsingId(5);
```

If you haven't set default guard and wanted to take advantage of **Password Resets** (Auth Scaffolding) in laravel. You may need to define `guard` and `broker` explicitly in `Auth/ForgotPasswordController.php` and `Auth/ResetPasswordController.php` as

```php
/**
 * Get the broker to be used during password reset.
 *
 * @return \Illuminate\Contracts\Auth\PasswordBroker
 */
public function broker()
{
    return \Password::broker('wordpress');
}

/**
 * Get the guard to be used during password reset.
 *
 * @return \Illuminate\Contracts\Auth\StatefulGuard
 */
protected function guard()
{
    return \Auth::guard('wordpress');
}
```

## Changelog

[CHANGELOG](CHANGELOG.md)

## Credits

Thanks to the community of [Laravel](https://www.laravel.com/).

## Copyright and License

Copyright (c) 2016 [Ahsaan Muhammad Yousuf](http://ahsaan.me/), [MIT](LICENSE) License
