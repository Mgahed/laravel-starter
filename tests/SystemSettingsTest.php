<?php

namespace Mgahed\LaravelStarter\Tests;

class SystemSettingsTest extends TestCase
{
    public function testSystemSettingsPageRenders(): void
    {
        $this->withoutMiddleware();

        $this->get(route('system-settings.cover'))
            ->assertStatus(200)
            ->assertSee('Cover');
    }
}
