<?php

namespace Mgahed\LaravelStarter\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mgahed\LaravelStarter\Models\Admin\Menu;
use Symfony\Component\Console\Command\Command as CommandAlias;

class NewMenuItem extends Command
{
	protected $signature = 'mgahed:menu {slug} {route?} {parent?}';

	protected $description = 'Create a new menu item with multi-language support';

	public function handle()
	{
		$menuSlug = $this->argument('slug');
		$route = $this->argument('route');
		$parent = $this->argument('parent');

		if(is_null($route)){
			$route = "#";
		}

		// Get available languages from mcamara/laravel-localization config
		$supportedLocales = $this->getSupportedLocales();

		if (empty($supportedLocales)) {
			$this->error('No supported locales found. Please configure mcamara/laravel-localization or add languages to config/laravellocalization.php');
			return CommandAlias::FAILURE;
		}

		// Collect title translations for each language
		$this->info('Please enter the menu title for each language:');
		$titles = [];

		foreach ($supportedLocales as $locale => $localeData) {
			$localeName = is_array($localeData) ? ($localeData['name'] ?? $locale) : $locale;
			$title = $this->ask("Title for {$localeName} ({$locale})");

			if (!empty($title)) {
				$titles[$locale] = $title;
			}
		}

		if (empty($titles)) {
			$this->error('At least one title must be provided');
			return CommandAlias::FAILURE;
		}

		// Get parent menu if specified
		$parentMenuId = null;
		if(!is_null($parent)){
			$parentMenu = Menu::where("slug",$parent)->first();

			if (!$parentMenu) {
				$this->error("Parent menu with slug '{$parent}' not found");
				return CommandAlias::FAILURE;
			}

			$parentMenuId = $parentMenu->id;
		}

		// Create the menu item
		$menu = Menu::create([
			'ulid' => Str::ulid(),
			'slug' => $menuSlug,
			'parent_id' => $parentMenuId,
			'title' => $titles,
			'route' => $route,
		]);

		$this->info('Successfully created menu with id: ' . $menu->id);
		$this->table(
			['Language', 'Title'],
			collect($titles)->map(fn($title, $locale) => [$locale, $title])->toArray()
		);

		return CommandAlias::SUCCESS;
	}

	/**
	 * Get supported locales from mcamara/laravel-localization config
	 */
	protected function getSupportedLocales(): array
	{
		// Try to get from mcamara/laravel-localization config
		if (config()->has('laravellocalization.supportedLocales')) {
			return config('laravellocalization.supportedLocales', []);
		}

		// Fallback to common languages if config not found
		$this->warn('mcamara/laravel-localization config not found. Using default languages (en, ar)');
		return [
			'en' => ['name' => 'English'],
			'ar' => ['name' => 'Arabic'],
		];
	}
}
