<?php

use Illuminate\Support\Facades\Route;
use Mgahed\LaravelStarter\Http\Controllers\Settings\SystemSettingsController;
use Mgahed\LaravelStarter\Http\Controllers\Settings\Translation\TranslationController;

/**
 * Check if middleware `localizationRedirect` exists
 * This a middleware from mcamara/laravel-localization package
 */
if (class_exists('Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect')) {
	$mcamaraMiddleWares = ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'];
	$mcameraPrefix = LaravelLocalization::setLocale();
} else {
	$mcamaraMiddleWares = [];
	$mcameraPrefix = '';
}
Route::group(
	[
		'prefix' => $mcameraPrefix,
		'middleware' => $mcamaraMiddleWares
	], function () {
	Route::group(['middleware' => ['web', 'auth', 'verified']], function () {

		Route::get('system-settings', [SystemSettingsController::class, 'index'])->name('system-settings.index');
		Route::post('system-settings', [SystemSettingsController::class, 'store'])->name('system-settings.store');
		Route::get('system-settings-cover', [SystemSettingsController::class, 'cover'])->name('system-settings.cover');

		Route::group(['prefix' => 'translation'], function () {
			Route::get('translations', [TranslationController::class, 'index'])->name('translations.index');
			Route::get('jsonTranslation', [TranslationController::class, 'jsonTranslation'])->name('jsonTranslation');
			Route::get('translations-search', [TranslationController::class, 'search'])->name('translations.search');
			Route::post('translations-add-custom-key', [TranslationController::class, 'addCustomKey'])->name('translations.addCustomKey');

			Route::get('translations-item/{id?}', [TranslationController::class, 'show'])->name('translations-item');
			Route::post('translations-update', [TranslationController::class, 'update'])->name('translations.update');
			Route::post('translations-update-global', [TranslationController::class, 'updateGlobal'])->name('translations.updateGlobal');
			Route::get('translations-scan', [TranslationController::class, 'scanTranslation'])->name('translations.scan');
			Route::get('translations-publish', [TranslationController::class, 'publishTranslation'])->name('translations.publish');
			Route::get('translations-unpublished', [TranslationController::class, 'unpublishedTranslation'])->name('translations.unpublished');
			Route::get('translations-create', [TranslationController::class, 'newTranslation'])->name('translations.create');

			Route::get('translate-all/{code?}', [TranslationController::class, 'translateAll'])->name('translate-all');
			Route::get('initiate/{code?}', [TranslationController::class, 'initiate'])->name('initiate');
		});

	});
});
