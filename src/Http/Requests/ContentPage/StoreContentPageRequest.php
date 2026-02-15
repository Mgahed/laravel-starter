<?php

namespace Mgahed\LaravelStarter\Http\Requests\ContentPage;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentPageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'slug' => ['nullable', 'string', 'max:255', 'unique:content_pages,slug', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'version' => ['nullable', 'string', 'max:50'],
            'is_published' => ['boolean'],
            'record_order' => ['integer', 'min:0'],
        ];

        // Get available locales from mcamara/laravel-localization or config
        $locales = $this->getAvailableLocales();
        $defaultLocale = config('app.fallback_locale', 'en');

        // Add validation rules for each locale
        foreach ($locales as $locale) {
            $isRequired = $locale === $defaultLocale ? 'required' : 'nullable';
            $rules["title.{$locale}"] = [$isRequired, 'string', 'max:500'];
            $rules["content.{$locale}"] = [$isRequired, 'string'];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'slug.regex' => 'The slug must be a valid URL slug (lowercase letters, numbers, and hyphens only).',
            'slug.unique' => 'This slug is already taken. Please choose a different one.',
            'title.*.required' => 'The title is required for the default language.',
            'content.*.required' => 'The content is required for the default language.',
        ];
    }

    /**
     * Get available locales from the application
     */
    protected function getAvailableLocales(): array
    {
        // Try to get from mcamara/laravel-localization
        if (class_exists('Mcamara\LaravelLocalization\Facades\LaravelLocalization')) {
            return array_keys(\LaravelLocalization::getSupportedLocales());
        }

        // Fallback to config or default
        return config('laravel-starter.available_locales', ['en']);
    }
}

