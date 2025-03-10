<?php

namespace Mgahed\LaravelStarter\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mgahed\LaravelStarter\Models\Admin\Settings\Translation;

class TranslateJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $timeout = 180; // 3 minutes

	/**
	 * Create a new job instance.
	 */
	private $langCode = 'ar';

	public function __construct($langCode)
	{
		$this->langCode = $langCode ?? 'ar';
	}

	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		$data = Translation::Where(function ($q) {
			$q->whereRaw("JSON_EXTRACT(translations, '$.en') = ''")
				->orWhereJsonContains('translations->en', '');
		})
			->orWhere(function ($q) {
				$q->whereRaw("JSON_EXTRACT(translations, '$.ar') = JSON_EXTRACT(translations, '$.en')");
					})
			->get();

		foreach ($data as $item) {
			// check if translations is not empty and value of ar has english characters
			if (!empty($item->translations)) {
				$translatedData = [
					'en' => $item->translation_key,
					'ar' => $this->translate($item->translation_key, $this->langCode),
				];
				$item->translations = json_encode($translatedData);
				$item->save();
			}
		}
	}

	private function translate(mixed $translation_key, string $lang = 'ar')
	{
		$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=$lang&dt=t&q=" . urlencode($translation_key);
		$response = file_get_contents($url);
		$response = json_decode($response, true);
		return $response[0][0][0];
	}
}
