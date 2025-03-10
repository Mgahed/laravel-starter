<?php
use Illuminate\Support\Facades\Route;
use Mgahed\LaravelStarter\Http\Controllers\Settings\Translation\TranslationController;

Route::group(['middleware' => ['web', 'auth', 'verified']], function () {

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
