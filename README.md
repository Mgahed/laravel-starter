# Mgahed Laravel Starter
![Packagist Version](https://img.shields.io/packagist/v/mgahed/laravel-starter?style=flat&color=blue)
![Packagist Downloads](https://img.shields.io/packagist/dt/mgahed/laravel-starter?style=flat&color=blue)
![Packagist License](https://img.shields.io/packagist/l/mgahed/laravel-starter?style=flat&color=green)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/mgahed/laravel-starter?style=flat&color=purple)
![Packagist Stars](https://img.shields.io/github/stars/mgahed/laravel-starter?style=flat&color=orange)

The package `mgahed/laravel-starter` allows you to easily use starter templates for your Laravel projects.

This is a PHP Package made to serve a plain Laravel project, This
package add authentication and (view, edit, delete) profile using Saul theme. And you can easily customize and use the theme features in your project.

> [!WARNING]
> Please note that this package is still in development.

## Installation

```bash
composer require mgahed/laravel-starter
```

## Publishing

#### assets
```bash
php artisan vendor:publish --tag="mgahed-laravel-starter-assets"
```

This will add folder assets to the `public` path in your Laravel project.


#### migrations
```bash
php artisan vendor:publish --tag="mgahed-laravel-starter-migrations"
```

#### seeders
```bash
php artisan vendor:publish --tag="mgahed-laravel-starter-seeders"
```

## Running Migrations

```bash
php artisan migrate --path=database/migrations/mgahed-laravel-starter
```

## Running Seeders

```bash
php artisan db:seed --class=Mgahed\LaravelStarter\Database\Seeders\MgahedStarterSitesSeeder
```

```bash
php artisan db:seed --class=Mgahed\LaravelStarter\Database\Seeders\MgahedStarterMenusSeeder
```

## Features supported
* Authentication
* Profile (view, edit, delete)
* Easy translation system
* Saul Theme supported
* Easy to customize
* Supports `mcamara/laravel-localization` package
  * Run `composer require mcamara/laravel-localization` 
  * publish the config file `php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"`
  * See docs [here](https://github.com/mcamara/laravel-localization)

## Supported Links

- [Saul Theme](https://keenthemes.com/products/saul-html-free)

### Support me by clicking the button below
<div>
    <a href="https://ko-fi.com/mgahed" target="_blank"><img src="https://cdn.prod.website-files.com/5c14e387dab576fe667689cf/670f5a01c01ea9191809398c_support_me_on_kofi_blue.png" style="width: 250px;max-width: 100%;"></a>
</div>
