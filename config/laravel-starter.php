<?php

// config for Mgahed/LaravelStarter
return [
    /*
    |--------------------------------------------------------------------------
    | Available Locales
    |--------------------------------------------------------------------------
    |
    | List of available locales for multilingual content.
    | This will be used as a fallback if mcamara/laravel-localization is not installed.
    |
    */
    'available_locales' => [
        'en' => 'English',
        'ar' => 'العربية',
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Pages Settings
    |--------------------------------------------------------------------------
    |
    | Configuration options for the content pages management feature.
    |
    */
    'content_pages' => [
        'auto_publish' => false, // Automatically publish pages upon creation
        'enable_versioning' => true, // Enable version tracking
        'items_per_page' => 15, // Number of items per page in admin listing
    ],
];
