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
	}
}
