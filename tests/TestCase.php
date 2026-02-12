<?php

namespace Mgahed\LaravelStarter\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Mgahed\LaravelStarter\Providers\LaravelStarterServiceProvider;

class TestCase extends Orchestra
{
	protected function setUp(): void
	{
		parent::setUp();
		$this->loadLaravelMigrations();
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
	}

	protected function getPackageProviders($app)
	{
		return [
			LaravelStarterServiceProvider::class,
		];
	}

	public function getEnvironmentSetUp($app)
	{
		config()->set('database.default', 'testing');
		config()->set('database.connections.testing', [
			'driver' => 'sqlite',
			'database' => ':memory:',
			'prefix' => '',
		]);
	}
}
