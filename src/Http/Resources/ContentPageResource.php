<?php

namespace Mgahed\LaravelStarter\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        $fallbackLocale = config('app.fallback_locale', 'en');

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'version' => $this->version,
            'title' => $this->getTranslation('title', $locale, true),
            'content' => $this->getTranslation('content', $locale, true),
            'available_languages' => $this->getAvailableLanguages(),
            'current_locale' => $locale,
            'fallback_locale' => $fallbackLocale,
            'has_translation' => $this->hasTranslation($locale),
            'is_published' => $this->is_published,
            'published_at' => $this->published_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}

