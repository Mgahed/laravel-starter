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

Ensure that your database is configured to use PostgreSQL with the vector extension. The package will enable the extension
via a migration if it is not already enabled.

## Publishing

#### assets
```bash
php artisan vendor:publish --tag="mgahed-laravel-starter-assets"
```
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

This will add folder assets to the `public` path in your laravel project.


## Supported Links

- [Saul Theme](https://keenthemes.com/products/saul-html-free)
