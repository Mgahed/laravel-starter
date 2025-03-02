# Mgahed Laravel Starter
![Packagist Version](https://img.shields.io/packagist/v/mgahed/laravel-starter)

The package `mgahed/laravel-starter` allows you to easily use starter templates for your Laravel projects.

> [!WARNING]
> Please note that this package is still in development.

## Installation

```bash
composer require mgahed/laravel-starter
```

Ensure that your database is configured to use PostgreSQL with the vector extension. The package will enable the extension
via a migration if it is not already enabled.

You can publish the assets:

```bash
php artisan vendor:publish --tag="mgahed-laravel-starter-assets
```

This will add folder assets to the `public` path in your laravel project.
