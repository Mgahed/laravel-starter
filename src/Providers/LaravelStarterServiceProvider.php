<?php

namespace Mgahed\LaravelStarter\Providers;

use Illuminate\Support\ServiceProvider;
use Mgahed\LaravelStarter\Commands\LaravelStarterCommand;

class LaravelStarterServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 */
	public function boot()
	{
		$this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'mgahed-laravel-starter');
		$this->loadViewsFrom(__DIR__ . '/../../resources/views', 'mgahed-laravel-starter');
		$this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

		$routesDir = __DIR__ . '/../Routes';
		$this->loadRoutesFromRoutesModules($routesDir);


		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__ . '/../../config/laravel-starter.php' => config_path('laravel-starter.php'),
			], 'mgahed-laravel-starter-config');

			// Publishing the views.
			$this->publishes([
				__DIR__ . '/../../resources/views' => resource_path('views/vendor/mgahed/laravel-starter'),
			], 'mgahed-laravel-starter-views');

			// Publishing assets.
			$this->publishes([
				__DIR__ . '/../../resources/assets' => public_path('assets'),
			], 'mgahed-laravel-starter-assets');

			// Publishing the translation files.
			/*$this->publishes([
				__DIR__.'/../../resources/lang' => resource_path('lang/vendor/mgahed-starter'),
			], 'lang');*/

			// Registering package commands.
			$this->commands([
				LaravelStarterCommand::class,
			]);
		}
	}

	/**
	 * Register the application services.
	 */
	public function register()
	{
		// Automatically apply the package configuration
		$this->mergeConfigFrom(__DIR__ . '/../../config/laravel-starter.php', 'mgahed.mgahed-starter');
	}

	public function loadRoutesFromRoutesModules($routesDir)
	{
		$routesDireFiles = scandir($routesDir);
		foreach ($routesDireFiles as $routesDireFile) {
			if (is_file($routesDir . '/' . $routesDireFile)) {
				$this->loadRoutesFrom($routesDir . '/' . $routesDireFile);
			}else{
				$routesSubDirFiles = scandir($routesDir . '/' . $routesDireFile);
				foreach ($routesSubDirFiles as $routesSubDirFile) {
					if (is_file($routesDir . '/' . $routesDireFile . '/' . $routesSubDirFile)) {
						$this->loadRoutesFrom($routesDir . '/' . $routesDireFile . '/' . $routesSubDirFile);
					}
				}
			}
		}
	}
}
