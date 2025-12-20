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
* Easy translation system with multi-language support
* Automated translation job (see [Translation Job Guide](TRANSLATION_JOB_GUIDE.md))
* Menu management system with multi-language support
* Saul Theme supported
* Easy to customize
* Supports `mcamara/laravel-localization` package
  * Run `composer require mcamara/laravel-localization` 
  * publish the config file `php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"`
  * See docs [here](https://github.com/mcamara/laravel-localization)

## Menu Management System

The package includes a powerful menu management system that supports multi-language menu titles. Menu titles are stored as JSON in the database and automatically integrate with `mcamara/laravel-localization` package.

### Creating a New Menu Item

Use the `mgahed:menu` command to create menu items with multi-language support:

```bash
php artisan mgahed:menu {slug} {route?} {parent?}
```

**Parameters:**
- `slug` (required): The unique slug for the menu item
- `route` (optional): The route name or URL (defaults to "#")
- `parent` (optional): The parent menu slug (for creating sub-menus)

**Interactive Multi-Language Input:**

The command automatically detects available languages from your `mcamara/laravel-localization` configuration and prompts you to enter the menu title for each language:

```bash
# Create a simple menu item
php artisan mgahed:menu products products.index

# Create a parent menu
php artisan mgahed:menu settings-parent

# Create a child menu with parent
php artisan mgahed:menu site-settings settings.index settings-parent
```

**Example Output:**

```
Please enter the menu title for each language:
Title for English (en): Products
Title for Arabic (ar): المنتجات
Title for German (de): Produkte

Successfully created menu with id: 5
+----------+------------+
| Language | Title      |
+----------+------------+
| en       | Products   |
| ar       | المنتجات  |
| de       | Produkte   |
+----------+------------+
```

**How it works:**

1. The command reads available languages from `config/laravellocalization.php`
2. Prompts you to enter a title for each configured language
3. Stores the titles as JSON in the database using `spatie/laravel-translatable`
4. If no localization config is found, defaults to English and Arabic

**Database Structure:**

Menu titles are stored as JSON in the `title` column:
```json
{
  "en": "Dashboard",
  "ar": "لوحة التحكم",
  "de": "Armaturenbrett"
}
```

This allows seamless integration with all Mgahed packages that support multi-language features like `mgahed/ai`, `mgahed/core`, `mgahed/one`, etc.

## Translation System

The package includes a powerful translation job that can automatically translate your content to multiple languages using Google Translate API. The job integrates seamlessly with `mcamara/laravel-localization` to support all configured locales.

### Translation Scanning

The translation scanner automatically discovers translation keys from your code and vendor packages.
for example if you have alot of packages under `mgahed` By default, it scans:
- Application views and controllers
- All vendor packages under the `mgahed` namespace (configurable)

#### Scanning Multiple Vendor Packages

You can configure the package prefix to scan all packages under a specific vendor namespace. This is useful when you have multiple packages like `mgahed/ai`, `mgahed/core`, `mgahed/one`, etc.

**Configuration:**

Add to your `.env` file:
```env
PACKAGES_PREFIX=mgahed
```

**How it works:**

The scanner will automatically discover and scan all packages under `vendor/{PACKAGES_PREFIX}/`:
- Scans `resources/views` directory in each package
- Scans `src` directory in each package
- No need to manually configure each package

**Example:**

If you have the following packages:
- `vendor/mgahed/ai`
- `vendor/mgahed/core`
- `vendor/mgahed/one`
- `vendor/mgahed/laravel-starter`

All of them will be automatically scanned for translation keys without additional configuration.

**Running the Scan:**

```php
use Mgahed\LaravelStarter\Jobs\ScanTranslationJob;

// Dispatch the job to scan for translation keys
ScanTranslationJob::dispatch();
```

### Quick Start

```php
use Mgahed\LaravelStarter\Jobs\TranslateJob;

// Translate from English to all supported languages
TranslateJob::dispatch('en');

// Translate from English to specific languages
TranslateJob::dispatch('en', ['ar', 'fr', 'es']);
```

For detailed usage instructions, see the [Translation Job Guide](TRANSLATION_JOB_GUIDE.md).

## Supported Links

- [Saul Theme](https://keenthemes.com/products/saul-html-free)

### Support me by clicking the button below
<div>
    <a href="https://ko-fi.com/mgahed" target="_blank"><img src="https://cdn.prod.website-files.com/5c14e387dab576fe667689cf/670f5a01c01ea9191809398c_support_me_on_kofi_blue.png" style="width: 250px;max-width: 100%;"></a>
</div>
