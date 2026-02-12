<?php

namespace Mgahed\LaravelStarter\Database\Seeders;

use Illuminate\Database\Seeder;
use Mgahed\LaravelStarter\Models\Admin\Menu;

class SystemSettingsMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parent = Menu::where('slug', 'settings-parent')->first();

        if (!$parent) {
            $parent = Menu::create([
                'slug' => 'settings-parent',
                'title' => [
                    'en' => 'Settings',
                    'ar' => 'الاعدادات',
                ],
                'route' => '#',
                'icon' => 'fas fa-cogs',
                'record_order' => 2,
            ]);
        }

        Menu::updateOrCreate(
            ['slug' => 'system-settings'],
            [
                'title' => [
                    'en' => 'System Settings',
                    'ar' => 'اعدادات النظام',
                ],
                'route' => 'system-settings.index',
                'icon' => 'fas fa-sliders-h',
                'parent_id' => $parent->id,
                'record_order' => 2,
            ]
        );
    }
}

