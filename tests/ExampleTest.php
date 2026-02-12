<?php

namespace Mgahed\LaravelStarter\Tests;

class ExampleTest extends TestCase
{
	public function testLaravelStarterExample()
	{
		$this->withoutMiddleware();

		$this->get(route('system-settings.cover'))
			->assertStatus(200)
			->assertSee('HACCP Cover');
	}
}
