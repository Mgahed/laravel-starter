<?php

namespace Mgahed\LaravelStarter\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Mgahed\LaravelStarter\Models\Site\Site;

class MgahedStarterSitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		// seed the sites table with 2 lang ar and en
		Site::create([
			'domain' => 'mgahed.com',
			'title' => 'Mgahed',
			'site_contents' => null,
			'configurations' => null,
			'language_id' => 1,
			'country_id' => 1,
			'default_site' => 1,
			'record_priority' => 100,
			'record_state' => 1,
			'protected' => 1,
			'deleted_at' => null,
			'lang' => 'en',
			'language' => 'English',
			'direction' => 'ltr',
			'logo' => null,
			'flag' => null,
			'translations' => null,
			'publish_at' => now(),
			'expire_at' => null,
		]);
		Site::create([
			'domain' => 'mgahed.com',
			'title' => 'مجاهد',
			'site_contents' => null,
			'configurations' => null,
			'language_id' => 2,
			'country_id' => 1,
			'default_site' => 1,
			'record_priority' => 100,
			'record_state' => 1,
			'protected' => 1,
			'deleted_at' => null,
			'lang' => 'ar',
			'language' => 'Arabic',
			'direction' => 'rtl',
			'logo' => null,
			'flag' => null,
			'translations' => null,
			'publish_at' => now(),
			'expire_at' => null,
		]);
    }
}
