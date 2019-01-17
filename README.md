# Wordpress Auth Driver for Laravel

[![Latest Stable Version](https://poser.pugx.org/ahsankhatri/wordpress-auth-provider/v/stable)](https://packagist.org/packages/ahsankhatri/wordpress-auth-provider) [![Total Downloads](https://poser.pugx.org/ahsankhatri/wordpress-auth-provider/downloads)](https://packagist.org/packages/ahsankhatri/wordpress-auth-provider) [![Build Status](https://scrutinizer-ci.com/g/ahsankhatri/wordpress-auth-driver-laravel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ahsankhatri/wordpress-auth-driver-laravel/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ahsankhatri/wordpress-auth-driver-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ahsankhatri/wordpress-auth-driver-laravel/?branch=master) [![Code Intelligence Status](https://scrutinizer-ci.com/g/ahsankhatri/wordpress-auth-driver-laravel/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence) [![License](https://poser.pugx.org/ahsankhatri/wordpress-auth-provider/license)](https://packagist.org/packages/ahsankhatri/wordpress-auth-provider)

## Installation

To install this package you will need
  - Laravel 5.6|5.7 ([for older versions of laravel](https://github.com/ahsankhatri/wordpress-auth-driver-laravel/tree/v1))
  - PHP 7.1

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

// logout
Auth::guard('wordpress')->logout();
```

You may also change default guard in `config/auth.php` then your code will look like
```php
Auth::loginUsingId(5);
```

## Changelog

[CHANGELOG](CHANGELOG.md)

## Credits

Thanks to the community of [Laravel](https://www.laravel.com/).

## Copyright and License

Copyright (c) 2016 [Ahsaan Muhammad Yousuf](http://ahsaan.me/), [MIT](LICENSE) License
