<?php

namespace Mgahed\LaravelStarter\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mgahed\LaravelStarter\Models\Admin\Settings\Translation;

/**
 * TranslateJob - Multi-language translation job using LaravelLocalization
 *
 * This job translates translation records from a source language to multiple target languages
 * using the Google Translate API. It automatically detects supported locales from LaravelLocalization
 * package or falls back to config/default locales.
 *
 * Features:
 * - Supports multiple languages dynamically based on LaravelLocalization
 * - Translates from a source language to all or specific target languages
 * - Skips translations that already exist and are different from the source
 * - Rate limiting to avoid Google Translate API throttling
 * - Fallback support when LaravelLocalization is not installed
 *
 * Usage Examples:
 *
 * 1. Translate from English to all supported locales:
 *    TranslateJob::dispatch();
 *    // or
 *    TranslateJob::dispatch('en');
 *
 * 2. Translate from English to specific languages:
 *    TranslateJob::dispatch('en', ['ar', 'fr', 'es']);
 *
 * 3. Translate from Arabic to all supported locales:
 *    TranslateJob::dispatch('ar');
 *
 * 4. Translate from Arabic to specific languages:
 *    TranslateJob::dispatch('ar', ['en', 'fr']);
 *
 * Requirements:
 * - mcamara/laravel-localization package (optional, will use fallback if not installed)
 * - Internet connection for Google Translate API
 *
 * @package Mgahed\LaravelStarter\Jobs
 */
class TranslateJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $timeout = 600; // 10 minutes (increased for multiple languages)

	/**
	 * The source language to translate from
	 */
	private string $sourceLanguage;

	/**
	 * The target languages to translate to (null = all supported locales)
	 */
	private ?array $targetLanguages;

	/**
	 * Create a new job instance.
	 *
	 * @param string $sourceLanguage The source language to translate from (default: 'en')
	 * @param array|null $targetLanguages Array of target language codes, or null to translate to all supported locales
	 */
	public function __construct(string $sourceLanguage = 'en', ?array $targetLanguages = null)
	{
		$this->sourceLanguage = $sourceLanguage;
		$this->targetLanguages = $targetLanguages;
	}

	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		// Get supported locales from LaravelLocalization or fallback to config
		$supportedLocales = $this->getSupportedLocales();

		// Determine target languages
		$targetLanguages = $this->targetLanguages ?? array_keys($supportedLocales);

		// Remove source language from target languages
		$targetLanguages = array_diff($targetLanguages, [$this->sourceLanguage]);

		if (empty($targetLanguages)) {
			\Log::warning('TranslateJob: No target languages to translate to');
			return;
		}

		\Log::info('TranslateJob: Starting translation from ' . $this->sourceLanguage . ' to: ' . implode(', ', $targetLanguages));

		// Find translations that need to be translated
		$data = Translation::where(function ($q) {
			// Source language has a value
			$q->whereNotNull("translations->{$this->sourceLanguage}")
				->where("translations->{$this->sourceLanguage}", '!=', '');
		})
			->where(function ($q) use ($targetLanguages) {
				// At least one target language is missing or matches source
				foreach ($targetLanguages as $lang) {
					$q->orWhereNull("translations->{$lang}")
						->orWhere("translations->{$lang}", '')
						->orWhereRaw("JSON_EXTRACT(translations, '$.{$lang}') = JSON_EXTRACT(translations, '$.{$this->sourceLanguage}')");
				}
			})
			->get();

		$translatedCount = 0;
		$totalItems = $data->count();
		\Log::info("TranslateJob: Found {$totalItems} translation records to process");

		foreach ($data as $item) {
			$translations = is_string($item->translations)
				? json_decode($item->translations, true)
				: (array) $item->translations;

			// Get the source text
			$sourceText = $translations[$this->sourceLanguage] ?? $item->translation_key;

			if (empty($sourceText)) {
				continue;
			}

			// Ensure source language is set
			$translations[$this->sourceLanguage] = $sourceText;

			// Translate to each target language
			$itemTranslated = false;
			foreach ($targetLanguages as $targetLang) {
				// Skip if translation already exists and is different from source
				if (
					!empty($translations[$targetLang]) &&
					$translations[$targetLang] !== $sourceText
				) {
					continue;
				}

				try {
					$translations[$targetLang] = $this->translate($sourceText, $targetLang);
					$itemTranslated = true;

					// Small delay to avoid rate limiting
					usleep(100000); // 0.1 second
				} catch (\Exception $e) {
					\Log::error("TranslateJob: Failed to translate to {$targetLang}: " . $e->getMessage());
					$translations[$targetLang] = $sourceText; // Fallback to source text
				}
			}

			if ($itemTranslated) {
				$item->translations = json_encode($translations, JSON_UNESCAPED_UNICODE);
				$item->save();
				$translatedCount++;
			}
		}

		\Log::info("TranslateJob: Successfully translated {$translatedCount} of {$totalItems} records");
	}

	/**
	 * Get supported locales from LaravelLocalization or config
	 *
	 * @return array
	 */
	private function getSupportedLocales(): array
	{
		// Check if LaravelLocalization is available
		if (class_exists('Mcamara\LaravelLocalization\Facades\LaravelLocalization')) {
			try {
				$laravelLocalization = app('laravellocalization');
				$locales = $laravelLocalization->getSupportedLocales();
				if (!empty($locales)) {
					return $locales;
				}
			} catch (\Exception $e) {
				\Log::warning('TranslateJob: Could not get locales from LaravelLocalization: ' . $e->getMessage());
			}
		}

		// Fallback to config or default locales
		return config('laravellocalization.supportedLocales', [
			'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
			'ar' => ['name' => 'Arabic', 'script' => 'Arab', 'native' => 'العربية', 'regional' => 'ar_SA'],
		]);
	}

	/**
	 * Translate text using Google Translate API
	 *
	 * @param string $text The text to translate
	 * @param string $targetLang The target language code
	 * @return string The translated text
	 */
	private function translate(string $text, string $targetLang): string
	{
		$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl={$this->sourceLanguage}&tl={$targetLang}&dt=t&q=" . urlencode($text);

		$response = @file_get_contents($url);

		if ($response === false) {
			throw new \Exception("Failed to fetch translation from Google Translate");
		}

		$response = json_decode($response, true);

		if (!isset($response[0][0][0])) {
			throw new \Exception("Invalid response from Google Translate");
		}

		return $response[0][0][0];
	}
}
