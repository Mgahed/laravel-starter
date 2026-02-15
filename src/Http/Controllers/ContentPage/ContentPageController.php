<?php

namespace Mgahed\LaravelStarter\Http\Controllers\ContentPage;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mgahed\LaravelStarter\Http\Requests\ContentPage\StoreContentPageRequest;
use Mgahed\LaravelStarter\Http\Requests\ContentPage\UpdateContentPageRequest;
use Mgahed\LaravelStarter\Models\Admin\ContentPage;
use Mgahed\LaravelStarter\Models\Admin\Settings\SystemSetting;

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
            ->with('success', __('admin.content-pages.Content page created successfully'));
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

        $message = __('admin.content-pages.Content page updated successfully');
        if ($versionChanged) {
            $message .= ' ' . __('admin.content-pages.New revision created');
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
                ->with('error', __('admin.content-pages.This page is protected and cannot be deleted'));
        }

        $page->delete();

        return redirect()
            ->route('content-pages.index')
            ->with('success', __('admin.content-pages.Content page deleted successfully'));
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
            ->with('success', __('admin.content-pages.Selected pages deleted successfully'));
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
        $page->createRevision($page->version, __('admin.content-pages.Before restoring to version') . ' ' . $revision->version);

        // Restore from revision
        $page->update([
            'version' => $revision->version . '.restored',
            'title' => $revision->title,
            'content' => $revision->content,
        ]);

        return redirect()
            ->route('content-pages.edit', $page->id)
            ->with('success', __('admin.content-pages.Page restored to version') . ' ' . $revision->version);
    }

    /**
     * Download content page as PDF with cover page
     */
    public function downloadPdf($id)
    {
        $page = ContentPage::findOrFail($id);

        // Check if dompdf is available
        if (!class_exists('Dompdf\\Dompdf')) {
            return redirect()
                ->back()
                ->with('error', __('admin.content-pages.Pdf library is not installed'));
        }

        // Get system settings for cover page
        $settings = SystemSetting::first();
        if (!$settings) {
            $settings = SystemSetting::create($this->defaultSystemSettings());
        }

        $logoUrl = $this->logoUrl($settings->logo_path);
        $logoFilePath = $this->logoFilePath($settings->logo_path);

        // Get current locale content
        $locale = app()->getLocale();
        $title = $page->getTranslation('title', $locale, true);
        $content = $page->getTranslation('content', $locale, true);

        // Render the view
        $view = view('mgahed-laravel-starter::admin.content-pages.pdf', [
            'page' => $page,
            'title' => $title,
            'content' => $content,
            'settings' => $settings,
            'logoUrl' => $logoUrl,
            'logoFilePath' => $logoFilePath,
        ]);

        // Generate PDF
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', [public_path(), storage_path('app/public')]);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'cairo');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($view->render());
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Generate filename
        $filename = Str::slug($title) . '-' . date('Y-m-d') . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Get logo URL
     */
    private function logoUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Get logo file path
     */
    private function logoFilePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return public_path('storage/' . $path);
    }

    /**
     * Default system settings
     */
    private function defaultSystemSettings(): array
    {
        return [
            'company_name' => 'Company Name',
            'general_manager' => 'General Manager',
            'health_approval_number' => 'N/A',
            'full_address' => 'Address',
            'landline' => '',
            'mobile' => '',
            'whatsapp_enabled' => false,
            'website' => '',
            'tax_id' => '',
            'vat_no' => '',
            'eori_no' => '',
        ];
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

