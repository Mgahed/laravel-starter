<?php

namespace Mgahed\LaravelStarter\Http\Controllers\ContentPage;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Mgahed\LaravelStarter\Http\Requests\ContentPage\StoreContentPageRequest;
use Mgahed\LaravelStarter\Http\Requests\ContentPage\UpdateContentPageRequest;
use Mgahed\LaravelStarter\Models\Admin\ContentPage;

class ContentPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the content pages.
     */
    public function index(Request $request)
    {
        $query = ContentPage::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Filter by published status
        if ($request->has('published') && $request->published !== '') {
            $query->where('is_published', (bool) $request->published);
        }

        $pages = $query->paginate(15)->withQueryString();

        return view('mgahed-laravel-starter::admin.content-pages.index', [
            'pages' => $pages,
            'search' => $request->search,
            'published' => $request->published,
        ]);
    }

    /**
     * Show the form for creating a new content page.
     */
    public function create()
    {
        $locales = $this->getAvailableLocales();
        $defaultLocale = config('app.fallback_locale', 'en');

        return view('mgahed-laravel-starter::admin.content-pages.create', [
            'locales' => $locales,
            'defaultLocale' => $defaultLocale,
        ]);
    }

    /**
     * Store a newly created content page in storage.
     */
    public function store(StoreContentPageRequest $request)
    {
        $data = $request->validated();

        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $defaultLocale = config('app.fallback_locale', 'en');
            $title = $data['title'][$defaultLocale] ?? '';
            $data['slug'] = Str::slug($title);
        }

        // Set published_at if is_published is true
        if (!empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $page = ContentPage::create($data);

        return redirect()
            ->route('content-pages.edit', $page->id)
            ->with('success', 'Content page created successfully.');
    }

    /**
     * Display the specified content page.
     */
    public function show($id)
    {
        $page = ContentPage::findOrFail($id);
        $locales = $this->getAvailableLocales();

        return view('mgahed-laravel-starter::admin.content-pages.show', [
            'page' => $page,
            'locales' => $locales,
            'availableLanguages' => $page->getAvailableLanguages(),
        ]);
    }

    /**
     * Show the form for editing the specified content page.
     */
    public function edit($id)
    {
        $page = ContentPage::findOrFail($id);
        $locales = $this->getAvailableLocales();
        $defaultLocale = config('app.fallback_locale', 'en');

        return view('mgahed-laravel-starter::admin.content-pages.edit', [
            'page' => $page,
            'locales' => $locales,
            'defaultLocale' => $defaultLocale,
            'availableLanguages' => $page->getAvailableLanguages(),
        ]);
    }

    /**
     * Update the specified content page in storage.
     */
    public function update(UpdateContentPageRequest $request, $id)
    {
        $page = ContentPage::findOrFail($id);
        $data = $request->validated();

        // Store old version for comparison
        $oldVersion = $page->version;
        $newVersion = $data['version'] ?? $page->version;

        // Set or update published_at
        if (!empty($data['is_published'])) {
            if (empty($page->published_at)) {
                $data['published_at'] = now();
            }
        } else {
            $data['published_at'] = null;
        }

        // Check if version has changed
        $versionChanged = $oldVersion !== $newVersion;

        // If version changed, create a revision before updating
        if ($versionChanged && $oldVersion) {
            $page->createRevision($oldVersion, $request->input('change_notes'));
        }

        $page->update($data);

        $message = 'Content page updated successfully.';
        if ($versionChanged) {
            $message .= ' New revision created.';
        }

        return redirect()
            ->route('content-pages.edit', $page->id)
            ->with('success', $message);
    }

    /**
     * Remove the specified content page from storage.
     */
    public function destroy($id)
    {
        $page = ContentPage::findOrFail($id);

        if ($page->protected) {
            return redirect()
                ->route('content-pages.index')
                ->with('error', 'This page is protected and cannot be deleted.');
        }

        $page->delete();

        return redirect()
            ->route('content-pages.index')
            ->with('success', 'Content page deleted successfully.');
    }

    /**
     * Bulk delete content pages.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:content_pages,id'],
        ]);

        ContentPage::whereIn('id', $request->ids)
            ->where('protected', '!=', 1)
            ->delete();

        return redirect()
            ->route('content-pages.index')
            ->with('success', 'Selected pages deleted successfully.');
    }

    /**
     * Show revision history for a content page.
     */
    public function revisions($id)
    {
        $page = ContentPage::findOrFail($id);
        $revisions = $page->getRevisionHistory();

        return view('mgahed-laravel-starter::admin.content-pages.revisions', [
            'page' => $page,
            'revisions' => $revisions,
        ]);
    }

    /**
     * Restore a specific revision.
     */
    public function restoreRevision($id, $revisionId)
    {
        $page = ContentPage::findOrFail($id);
        $revision = $page->revisions()->findOrFail($revisionId);

        // Create a new revision with current data before restoring
        $page->createRevision($page->version, 'Before restoring to version ' . $revision->version);

        // Restore from revision
        $page->update([
            'version' => $revision->version . '.restored',
            'title' => $revision->title,
            'content' => $revision->content,
        ]);

        return redirect()
            ->route('content-pages.edit', $page->id)
            ->with('success', 'Page restored to version ' . $revision->version);
    }

    /**
     * Get available locales from the application
     */
    protected function getAvailableLocales(): array
    {
        // Try to get from mcamara/laravel-localization
        if (class_exists('Mcamara\LaravelLocalization\Facades\LaravelLocalization')) {
            $supportedLocales = \LaravelLocalization::getSupportedLocales();
            $locales = [];
            foreach ($supportedLocales as $code => $locale) {
                $locales[$code] = $locale['native'] ?? $locale['name'] ?? $code;
            }
            return $locales;
        }

        // Fallback to config or default
        return config('laravel-starter.available_locales', ['en' => 'English']);
    }
}

