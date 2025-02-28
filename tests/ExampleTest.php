<?php

namespace Mgahed\LaravelStarter\Tests;

class ExampleTest extends TestCase
{
	public function testLaravelStarterExample()
	{
		$this->get(route('mgahed-starter.index'))
			->assertStatus(200)
			->assertViewIs('mgahed-starter::index');
	}
}
