<?php

namespace Mgahed\LaravelStarter\Providers;

use Illuminate\Support\ServiceProvider;
use Mgahed\LaravelStarter\Commands\LaravelStarterCommand;
use Mgahed\LaravelStarter\Commands\NewMenuItem;

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

		// Publishing resources
		$this->publishes([
			__DIR__ . '/../../config/laravel-starter.php' => config_path('laravel-starter.php'),
		], 'mgahed-laravel-starter-config');

		// Publishing the views.
		$this->publishes([
			__DIR__ . '/../../resources/views' => resource_path('views/mgahed/laravel-starter'),
		], 'mgahed-laravel-starter-views');

		// Publishing assets.
		$this->publishes([
			__DIR__ . '/../../resources/assets' => public_path('assets'),
		], 'mgahed-laravel-starter-assets');

		// Publishing the migration files.
		$this->publishes([
			__DIR__ . '/../../database/migrations' => database_path('migrations/mgahed-laravel-starter'),
		], 'mgahed-laravel-starter-migrations');

		// Publishing the seeders files.
		$this->publishes([
			__DIR__ . '/../../database/seeders' => database_path('seeders'),
		], 'mgahed-laravel-starter-seeders');

		// Publishing the translation files.
		/*$this->publishes([
			__DIR__.'/../../resources/lang' => resource_path('lang/vendor/mgahed-starter'),
		], 'lang');*/

		if ($this->app->runningInConsole()) {
			// Registering package commands.
			$this->commands([
				LaravelStarterCommand::class,
				NewMenuItem::class,
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
		if (!is_dir($routesDir)) {
			return;
		}

		$routesDireFiles = scandir($routesDir);
		foreach ($routesDireFiles as $routesDireFile) {
			// Skip . and .. directories
			if ($routesDireFile === '.' || $routesDireFile === '..') {
				continue;
			}

			$fullPath = $routesDir . '/' . $routesDireFile;

			if (is_file($fullPath)) {
				$this->loadRoutesFrom($fullPath);
			} elseif (is_dir($fullPath)) {
				$routesSubDirFiles = scandir($fullPath);
				foreach ($routesSubDirFiles as $routesSubDirFile) {
					// Skip . and .. directories
					if ($routesSubDirFile === '.' || $routesSubDirFile === '..') {
						continue;
					}

					$subFilePath = $fullPath . '/' . $routesSubDirFile;
					if (is_file($subFilePath)) {
						$this->loadRoutesFrom($subFilePath);
					}
				}
			}
		}
	}
}
