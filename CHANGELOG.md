# CHANGELOG

## 2.2.2
 - Added support till Laravel 7.8.x

## 2.2.1
 - README.md and CHANGELOG.md Updated.

## 2.2.0
 - Added Laravel 6.x support.

## 2.1.2
 - Updated laravel required version in `composer.json` file.

## 2.1.1
 - Added Laravel 5.8 support.
 - Extend config `wordpress-hash.php` with option to map email and password column if you've changed and default connection set to `wp-mysql`
 - Few spelling glitches.
 - Added Password accessor in WordpressUser Model
 - README.md and CHANGELOG.md Updated

## 2.1.0
 - Support added for seperate connection in `config/database.php`
 - Default `wp_` prefix removed from `Models\WordpressUser.php`. It'll be handled by connection in `config/database.php`
 - Added `user_registered` date mutators.
 - Config file renamed to `wordpress-auth`
 - README.md and CHANGELOG.md Updated

## 2.0.0
 - Added support for Laravel 5.6 & 5.7

## 1.1.0
 - Laravel 5.5 Support added

## 1.0.1 - 1.0.2
 - Package type changed to library
 - Added scrutinizer badges in README.md
 - Added README.md & CHANGELOG.md

## 1.0.0
 - Initial release.
