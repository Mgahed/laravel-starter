<?php

namespace Mgahed\LaravelStarter\Models\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Mgahed\LaravelStarter\Triggers\AutoUlid;
use Mgahed\LaravelStarter\Triggers\CreatedBy;
use Mgahed\LaravelStarter\Triggers\UpdatedBy;
use Spatie\Translatable\HasTranslations;

class ContentPage extends Model
{
    use AutoUlid, CreatedBy, UpdatedBy, SoftDeletes, HasTranslations;

    protected $fillable = [
        'ulid',
        'slug',
        'version',
        'title',
        'content',
        'is_published',
        'record_order',
        'record_state',
        'protected',
        'created_by',
        'updated_by',
        'published_at',
    ];

    public $translatable = [
        'title',
        'content',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from title if not provided
        static::creating(function ($model) {
            if (empty($model->slug) && !empty($model->title)) {
                $defaultLocale = config('app.fallback_locale', 'en');
                $title = is_array($model->title)
                    ? ($model->title[$defaultLocale] ?? reset($model->title))
                    : $model->title;
                $model->slug = Str::slug($title);

                // Ensure uniqueness
                $originalSlug = $model->slug;
                $counter = 1;
                while (static::where('slug', $model->slug)->exists()) {
                    $model->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
        });

        // Global scope for active records
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('record_state', 1)
                ->orderBy('record_order', 'asc')
                ->orderBy('id', 'desc');
        });
    }

    /**
     * Scope to get only published pages
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at');
    }

    /**
     * Scope to search by title or slug
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('slug', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%");
        });
    }

    /**
     * Get the content for the current locale with fallback
     */
    public function getLocalizedContent()
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        return [
            'title' => $this->getTranslation('title', $locale, $fallback),
            'content' => $this->getTranslation('content', $locale, $fallback),
        ];
    }

    /**
     * Get available languages for this page
     */
    public function getAvailableLanguages()
    {
        $languages = [];

        if (is_array($this->title)) {
            foreach ($this->title as $locale => $value) {
                if (!empty($value)) {
                    $languages[] = $locale;
                }
            }
        }

        return $languages;
    }

    /**
     * Check if page has translation for given locale
     */
    public function hasTranslation($locale)
    {
        return !empty($this->getTranslation('title', $locale, false))
            && !empty($this->getTranslation('content', $locale, false));
    }

    /**
     * Get all revisions for this page
     */
    public function revisions()
    {
        return $this->hasMany(ContentPageRevision::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the latest revision
     */
    public function latestRevision()
    {
        return $this->hasOne(ContentPageRevision::class)->latest('created_at');
    }

    /**
     * Create a new revision
     */
    public function createRevision($oldVersion, $changeNotes = null)
    {
        // Get the previous revision (if any)
        $previousRevision = $this->revisions()
            ->where('version', $oldVersion)
            ->first();

        // Create new revision
        return $this->revisions()->create([
            'previous_revision_id' => $previousRevision?->id,
            'version' => $this->version,
            'title' => $this->title,
            'content' => $this->content,
            'change_notes' => $changeNotes,
        ]);
    }

    /**
     * Get revision history
     */
    public function getRevisionHistory()
    {
        return $this->revisions()
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

