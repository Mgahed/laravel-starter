<?php

namespace Mgahed\LaravelStarter\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Mgahed\LaravelStarter\Enums\RecordState;
use Mgahed\LaravelStarter\Models\Admin\Settings\Translation;
use Mgahed\LaravelStarter\Models\Site\Site;
use Symfony\Component\Finder\Finder;

class ScanTranslationJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	public $timeout = 300; // 5 minutes


	/**
	 * Create a new job instance.
	 */
	public function __construct()
	{

	}

	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		$this->findTranslation(resource_path('views'));
		$this->findTranslation(app_path('Http/Controllers'));
		if (File::exists(app_path('Resources'))) {
			$this->findTranslation(app_path('Resources'));
		}
		if (File::exists(app_path('Rules'))) {
			$this->findTranslation(app_path('Rules'));
		}
		if (File::exists(app_path('Jobs'))) {
			$this->findTranslation(app_path('Jobs'));
		}

		//vendor
		if (File::exists(base_path('vendor/mgahed/laravel-starter'))) {
			$this->findTranslation(base_path('vendor/mgahed/laravel-starter/resources/views'));
			$this->findTranslation(base_path('vendor/mgahed/laravel-starter/src'));
		}

		//vendor - scan all prefixed packages
		$prefixedPackages = env('PACKAGES_PREFIX', 'mgahed');
		if (File::exists(base_path("vendor/$prefixedPackages"))) {
			$mgahedPackages = File::directories(base_path("vendor/$prefixedPackages"));

			foreach ($mgahedPackages as $packagePath) {
				// Scan resources/views if exists
				if (File::exists($packagePath . '/resources/views')) {
					$this->findTranslation($packagePath . '/resources/views');
				}

				// Scan src if exists
				if (File::exists($packagePath . '/src')) {
					$this->findTranslation($packagePath . '/src');
				}
			}
		}

		// check if path exist
		if (File::exists(base_path('app/Mail'))) {
			$this->findTranslation(base_path('app/Mail'));
		}

		//for user custom keys
		if (!File::exists(storage_path('app/customKey'))) {
			File::makeDirectory(storage_path('app/customKey'));
		}
		$this->findTranslation(storage_path('app/customKey'));

		$data = Translation::whereNotNull('full_path')
			->where(function (Builder $query) {
				$query->whereNull('translation_published')
					->orWhere('translation_published', 0)
					->orWhereNull('translations');
			})
			->get();
		$sites = Site::where('record_state', RecordState::TRUE)->get();

		$dataArray = $data->toArray(); // Convert the collection to an array if it's a collection
		$dataChunkSize = 500; // Adjust the chunk size as needed
		$chunkedDataArray = array_chunk($dataArray, $dataChunkSize);

		foreach ($chunkedDataArray as $chunk) {
			foreach ($chunk as $item) {
				foreach ($sites as $site) {
					if ($item['translations_changed'] != 1) {
						if (__($item['full_path'], [], $site->lang) == $item['full_path']) {
							$translations[$site->lang] = str_replace('$', '', $item['translation_key']);
						} else {
							$translations[$site->lang] = __($item['full_path'], [], $site->lang);
						}

						$item['translations'] = json_encode($translations);
						$item['translations_raw'] = serialize($translations);

						// Rehydrate the item back to a model if necessary, or use a custom save logic
						$model = $data->find($item['id']); // Assuming $data is a collection of models
						$model->translations = $item['translations'];
						$model->translations_raw = $item['translations_raw'];
						$model->save();
					}
				}
			}
		}

	}

	private function findTranslation($path = null)
	{

		$path = $path ?? resource_path('views'); //if null just parse views
		$groupKeys = array();
		$functions = array(
			'trans',
			'trans_choice',
			'Lang::get',
			'Lang::choice',
			'Lang::trans',
			'Lang::transChoice',
			'@lang',
			'@choice',
			'__',
		);

		$groupPattern = "[^\w|>]" . "(" . implode('|', $functions) . ")" . "\(" . "[\'\"]" . "(" . "[a-zA-Z0-9_-]+" . "([.|\/][^\1)]+)+" . ")" . "[\'\"]" . "[\),]"; // Close parentheses or new parameter
		$finder = new Finder();
		$finder->in($path)->exclude('storage')->name('*.php')
			//			->name('*.twig')
			//			->name('*.vue')
			->files();

		foreach ($finder as $file) {
			if (preg_match_all("/$groupPattern/siU", $file->getContents(), $matches)) {
				foreach ($matches[2] as $key) {
					$groupKeys[] = trim($key);
				}
			}
		}

		$groupKeys = $this->array_iunique($groupKeys);

		$groupKeys = array_combine(array_values($groupKeys), array_values($groupKeys));


		$groupKeys = ($this->explodeTree($groupKeys, '.'));

		$this->buildTreeFromArray($groupKeys);
	}

	private function array_iunique($array)
	{
		return array_intersect_key(
			$array,
			array_unique(array_map("strtolower", $array))
		);
	}

	private function explodeTree($array, $delimiter = '_', $baseval = false)
	{
		if (!is_array($array)) return false;
		$splitRE = '/' . preg_quote($delimiter, '/') . '/';
		$returnArr = array();
		foreach ($array as $key => $val) {
			// Get parent parts and the current leaf
			$parts = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
			$leafPart = array_pop($parts);

			// Build parent structure
			// Might be slow for really deep and large structures
			$parentArr = &$returnArr;
			// @codeCoverageIgnoreStart
			foreach ($parts as $part) {
				if (!isset($parentArr[$part])) {
					$parentArr[$part] = array();
				} elseif (!is_array($parentArr[$part])) {
					if ($baseval) {
						$parentArr[$part] = array('__base_val' => $parentArr[$part]);
					} else {
						$parentArr[$part] = array();
					}
				}
				$parentArr = &$parentArr[$part];
			}

			// Add the final part to the structure
			if (empty($parentArr[$leafPart])) {
				$parentArr[$leafPart] = $val;
			} elseif ($baseval && is_array($parentArr[$leafPart])) {
				$parentArr[$leafPart]['__base_val'] = $val;
			}
			// @codeCoverageIgnoreEnd
		}
		return $returnArr;
	}

	private function buildTreeFromArray($items, $parent = 0)
	{

		foreach ($items as $i => &$item) {

			if (is_array($item)) {
				$data = Translation::firstOrCreate([
					'parent_id' => $parent,
					'translation_key' => $i,
				]);

				$this->buildTreeFromArray($item, $data->id);
			} else {
				$data = Translation::firstOrCreate([
					'full_path' => $item,
					'parent_id' => $parent,
					'translation_key' => $i,
				]);
			}
		}
	}
}
