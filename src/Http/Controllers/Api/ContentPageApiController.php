<?php

namespace Mgahed\LaravelStarter\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mgahed\LaravelStarter\Models\Admin\ContentPage;

class ContentPageApiController extends Controller
{
    /**
     * Get all published content pages
     */
    public function index(Request $request): JsonResponse
    {
        $query = ContentPage::published();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        $perPage = min($request->get('per_page', 15), 100);
        $pages = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $pages->map(function ($page) {
                return [
                    'id' => $page->id,
                    'slug' => $page->slug,
                    'version' => $page->version,
                    'title' => $page->getTranslation('title', app()->getLocale(), true),
                    'content' => $page->getTranslation('content', app()->getLocale(), true),
                    'available_languages' => $page->getAvailableLanguages(),
                    'published_at' => $page->published_at?->toISOString(),
                    'updated_at' => $page->updated_at->toISOString(),
                ];
            }),
            'meta' => [
                'current_page' => $pages->currentPage(),
                'last_page' => $pages->lastPage(),
                'per_page' => $pages->perPage(),
                'total' => $pages->total(),
            ],
        ]);
    }

    /**
     * Get a single content page by slug
     */
    public function show(string $slug): JsonResponse
    {
        $page = ContentPage::published()
            ->where('slug', $slug)
            ->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Content page not found.',
            ], 404);
        }

        $locale = app()->getLocale();
        $fallbackLocale = config('app.fallback_locale', 'en');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $page->id,
                'slug' => $page->slug,
                'version' => $page->version,
                'title' => $page->getTranslation('title', $locale, true),
                'content' => $page->getTranslation('content', $locale, true),
                'available_languages' => $page->getAvailableLanguages(),
                'current_locale' => $locale,
                'fallback_locale' => $fallbackLocale,
                'has_translation' => $page->hasTranslation($locale),
                'published_at' => $page->published_at?->toISOString(),
                'updated_at' => $page->updated_at->toISOString(),
            ],
        ]);
    }

    /**
     * Get a content page in a specific locale
     */
    public function showInLocale(string $slug, string $locale): JsonResponse
    {
        $page = ContentPage::published()
            ->where('slug', $slug)
            ->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Content page not found.',
            ], 404);
        }

        $fallbackLocale = config('app.fallback_locale', 'en');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $page->id,
                'slug' => $page->slug,
                'version' => $page->version,
                'title' => $page->getTranslation('title', $locale, true),
                'content' => $page->getTranslation('content', $locale, true),
                'available_languages' => $page->getAvailableLanguages(),
                'current_locale' => $locale,
                'fallback_locale' => $fallbackLocale,
                'has_translation' => $page->hasTranslation($locale),
                'published_at' => $page->published_at?->toISOString(),
                'updated_at' => $page->updated_at->toISOString(),
            ],
        ]);
    }

    /**
     * Get all translations for a page
     */
    public function translations(string $slug): JsonResponse
    {
        $page = ContentPage::published()
            ->where('slug', $slug)
            ->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Content page not found.',
            ], 404);
        }

        $translations = [];
        foreach ($page->getAvailableLanguages() as $locale) {
            $translations[$locale] = [
                'title' => $page->getTranslation('title', $locale, false),
                'content' => $page->getTranslation('content', $locale, false),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $page->id,
                'slug' => $page->slug,
                'version' => $page->version,
                'translations' => $translations,
                'available_languages' => $page->getAvailableLanguages(),
                'published_at' => $page->published_at?->toISOString(),
                'updated_at' => $page->updated_at->toISOString(),
            ],
        ]);
    }
}

