<?php

namespace Mgahed\LaravelStarter\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Mgahed\LaravelStarter\Models\Admin\Menu;

class MgahedStarterMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seed the menus table with the starter menus
		$menus = [
			[ // id = 1
				'slug' => 'dashboard-parent',
				'title' => [
					'en' => 'Dashboard',
					'ar' => 'لوحة التحكم',
				],
				'route' => '#',
				'icon' => 'fas fa-tachometer-alt',
				'record_order' => 1,
			],
			[ // id = 2
				'slug' => 'dashboard',
				'title' => [
					'en' => 'Dashboard',
					'ar' => 'لوحة التحكم',
				],
				'route' => 'dashboard',
				'icon' => 'fas fa-tachometer-alt',
				'parent_id' => 1,
				'record_order' => 1,
			],
			[ // id = 3
				'slug' => 'settings-parent',
				'title' => [
					'en' => 'Settings',
					'ar' => 'الاعدادات'
				],
				'route' => '#',
				'icon' => 'fas fa-cogs',
				'record_order' => 2,
			],
			[ // id = 4
				'slug' => 'translations',
				'title' => [
					'en' => 'Translations',
					'ar' => 'الترجمات',
				],
				'route' => 'translations.index',
				'icon' => 'fas fa-user-shield',
				'parent_id' => 3,
				'record_order' => 1,
			],
		];

		foreach ($menus as $menu) {
			Menu::create($menu);
		}
    }
}
