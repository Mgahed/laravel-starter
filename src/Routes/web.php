<?php

use Illuminate\Support\Facades\Auth;
use Mgahed\LaravelStarter\Http\Controllers\Auth\AuthenticatedSessionController;
use Mgahed\LaravelStarter\Http\Controllers\Auth\ConfirmablePasswordController;
use Mgahed\LaravelStarter\Http\Controllers\Auth\EmailVerificationNotificationController;
use Mgahed\LaravelStarter\Http\Controllers\Auth\EmailVerificationPromptController;
use Mgahed\LaravelStarter\Http\Controllers\Auth\NewPasswordController;
use Mgahed\LaravelStarter\Http\Controllers\Auth\PasswordController;
use Mgahed\LaravelStarter\Http\Controllers\Auth\PasswordResetLinkController;
use Mgahed\LaravelStarter\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Mgahed\LaravelStarter\Http\Controllers\Auth\VerifyEmailController;
use Mgahed\LaravelStarter\Http\Controllers\ProfileController;

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
	Route::middleware(['web'])->group(function () {
		Route::middleware(['guest'])->group(function () {
			Route::get('register', [RegisteredUserController::class, 'create'])
				->name('register');

			Route::post('register', [RegisteredUserController::class, 'store']);

			Route::get('login', [AuthenticatedSessionController::class, 'create'])
				->name('login');

			Route::post('login', [AuthenticatedSessionController::class, 'store']);

			Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
				->name('password.request');

			Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
				->name('password.email');

			Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
				->name('password.reset');

			Route::post('reset-password', [NewPasswordController::class, 'store'])
				->name('password.store');
		});

		Route::middleware('auth')->group(function () {
			Route::get('verify-email', EmailVerificationPromptController::class)
				->name('verification.notice');

			Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
				->middleware(['signed', 'throttle:6,1'])
				->name('verification.verify');

			Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
				->middleware('throttle:6,1')
				->name('verification.send');

			Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
				->name('password.confirm');

			Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

			Route::put('password', [PasswordController::class, 'update'])->name('password.update');

			Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
				->name('logout');
		});

		Route::group(['middleware' => ['auth', 'verified']], function () {
			Route::get('/dashboard', function () {
				return view('mgahed-laravel-starter::layouts.admin.dashboard');
			})->name('dashboard');

			Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
			Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
			Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
		});
	});
});
