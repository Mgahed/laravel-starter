<?php

namespace Mgahed\LaravelStarter\Http\Requests\ContentPage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContentPageRequest extends FormRequest
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
            'version' => ['nullable', 'string', 'max:50'],
            'is_published' => ['boolean'],
            'record_order' => ['integer', 'min:0'],
            'change_notes' => ['nullable', 'string', 'max:1000'],
        ];

        // Get available locales
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
            'title.*.required' => __('admin.content-pages.The title is required for the default language'),
            'content.*.required' => __('admin.content-pages.The content is required for the default language'),
            'change_notes.max' => __('admin.content-pages.Change notes cannot exceed 1000 characters'),
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

