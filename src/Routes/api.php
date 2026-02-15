<?php

use Illuminate\Support\Facades\Route;
use Mgahed\LaravelStarter\Http\Controllers\Api\ContentPageApiController;

Route::group(['middleware' => ['api', 'Locale', 'TransformNumbers'], 'prefix' => 'api'], function () {
    // Content Pages API
    Route::get('content-pages', [ContentPageApiController::class, 'index']);
    Route::get('content-pages/{slug}', [ContentPageApiController::class, 'show']);
    Route::get('content-pages/{slug}/locale/{locale}', [ContentPageApiController::class, 'showInLocale']);
    Route::get('content-pages/{slug}/translations', [ContentPageApiController::class, 'translations']);
});
