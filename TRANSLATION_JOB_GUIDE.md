# TranslateJob Guide

## Overview

The `TranslateJob` is a powerful Laravel queue job that automatically translates your application's translation records from a source language to multiple target languages using the Google Translate API.

## Features

✅ **Multi-Language Support**: Automatically translates to all languages configured in LaravelLocalization  
✅ **Smart Translation**: Skips translations that already exist and are different from the source  
✅ **Flexible Configuration**: Translate from any source language to any target languages  
✅ **Rate Limiting**: Built-in delays to avoid API throttling  
✅ **Fallback Support**: Works even without LaravelLocalization installed  
✅ **Comprehensive Logging**: Tracks translation progress and errors  

## Requirements

- **mcamara/laravel-localization** package (optional, but recommended)
- Internet connection for Google Translate API
- Queue system configured in Laravel

## Installation & Configuration

### 1. Install LaravelLocalization (Optional but Recommended)

```bash
composer require mcamara/laravel-localization
```

### 2. Publish LaravelLocalization Config

```bash
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```

### 3. Configure Supported Locales

Edit `config/laravellocalization.php` and set your supported locales:

```php
'supportedLocales' => [
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English'],
    'ar' => ['name' => 'Arabic', 'script' => 'Arab', 'native' => 'العربية'],
    'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'Français'],
    'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'Español'],
    'de' => ['name' => 'German', 'script' => 'Latn', 'native' => 'Deutsch'],
    // Add more languages as needed
],
```

## Usage Examples

### Basic Usage

#### 1. Translate from English to All Supported Locales

```php
use Mgahed\LaravelStarter\Jobs\TranslateJob;

// Dispatch the job
TranslateJob::dispatch();
// or explicitly specify English as source
TranslateJob::dispatch('en');
```

This will translate all translation records from English to all languages configured in LaravelLocalization.

#### 2. Translate from Arabic to All Supported Locales

```php
TranslateJob::dispatch('ar');
```

#### 3. Translate to Specific Languages Only

```php
// Translate from English to Arabic and French only
TranslateJob::dispatch('en', ['ar', 'fr']);

// Translate from Arabic to English and Spanish only
TranslateJob::dispatch('ar', ['en', 'es']);
```

### Advanced Usage

#### Queue the Job

```php
// Dispatch to default queue
TranslateJob::dispatch('en');

// Dispatch to specific queue
TranslateJob::dispatch('en')->onQueue('translations');

// Dispatch with delay
TranslateJob::dispatch('en')->delay(now()->addMinutes(5));
```

#### Chain Multiple Translation Jobs

```php
use Illuminate\Support\Facades\Bus;

Bus::chain([
    new TranslateJob('en', ['ar']),
    new TranslateJob('ar', ['fr']),
    new TranslateJob('fr', ['es']),
])->dispatch();
```

#### Schedule Automatic Translations

Add to `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Run translation job daily at midnight
    $schedule->job(new TranslateJob('en'))
             ->daily()
             ->at('00:00');
}
```

## How It Works

1. **Fetch Supported Locales**: The job retrieves all supported locales from LaravelLocalization
2. **Identify Target Languages**: Determines which languages to translate to (all or specific)
3. **Query Records**: Finds translation records that need translation
4. **Translate**: Uses Google Translate API to translate text from source to target languages
5. **Save**: Updates the translation records with new translations
6. **Skip Logic**: Automatically skips translations that already exist and differ from source

## Translation Logic

The job will translate a record if:
- The source language has a non-empty value
- The target language is empty/null OR
- The target language value is the same as the source language value

The job will **skip** translation if:
- The target language already has a different value than the source
- The source language value is empty

## Monitoring & Debugging

The job logs important information to Laravel's log system:

```php
// Check logs
tail -f storage/logs/laravel.log

// Look for entries like:
// [info] TranslateJob: Starting translation from en to: ar, fr, es
// [info] TranslateJob: Found 150 translation records to process
// [info] TranslateJob: Successfully translated 145 of 150 records
// [error] TranslateJob: Failed to translate to fr: Connection timeout
```

## Best Practices

### 1. Use Queues
Always run translation jobs in a queue, not synchronously:

```bash
php artisan queue:work
```

### 2. Rate Limiting
The job includes automatic rate limiting (0.1s delay between translations). For large datasets, consider:

```php
// Chunk translations
Translation::chunk(100, function ($translations) {
    TranslateJob::dispatch('en')->delay(now()->addMinutes(5));
});
```

### 3. Test with Small Datasets First

```php
// Test with specific translations
Translation::where('id', '<', 10)->get();
TranslateJob::dispatch('en', ['ar']);
```

### 4. Handle Failed Jobs

Set up failed job handling in `config/queue.php`:

```php
'failed' => [
    'driver' => 'database',
    'database' => 'mysql',
    'table' => 'failed_jobs',
],
```

Retry failed jobs:

```bash
php artisan queue:retry all
```

## Fallback Configuration

If LaravelLocalization is not installed, the job falls back to config or defaults:

```php
// config/laravellocalization.php or any config file
return [
    'supportedLocales' => [
        'en' => ['name' => 'English'],
        'ar' => ['name' => 'Arabic'],
    ],
];
```

## Troubleshooting

### Issue: No translations happening
- Check that source language has values
- Verify queue is running: `php artisan queue:work`
- Check logs for errors

### Issue: Google Translate API errors
- Check internet connection
- Verify the language codes are valid
- Check for rate limiting (add delays between jobs)

### Issue: Out of memory
- Process translations in smaller batches
- Increase PHP memory limit
- Use `chunk()` method for large datasets

## Performance Optimization

### 1. Batch Processing

```php
// Process in batches
Translation::whereNull('translations->ar')
    ->chunk(50, function ($translations) {
        TranslateJob::dispatch('en', ['ar'])->delay(now()->addSeconds(30));
    });
```

### 2. Selective Translation

```php
// Only translate new records
Translation::where('created_at', '>', now()->subDay())
    ->get();
TranslateJob::dispatch('en');
```

### 3. Use Job Middleware

```php
use Illuminate\Queue\Middleware\RateLimited;

public function middleware()
{
    return [new RateLimited('translations')];
}
```

## Support & Contributing

For issues, questions, or contributions, please refer to the main package documentation.

## License

This job is part of the Mgahed Laravel Starter package.

