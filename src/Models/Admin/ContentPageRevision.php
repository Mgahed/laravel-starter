<?php

namespace Mgahed\LaravelStarter\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Mgahed\LaravelStarter\Triggers\CreatedBy;
use Spatie\Translatable\HasTranslations;

class ContentPageRevision extends Model
{
    use CreatedBy, HasTranslations;

    protected $fillable = [
        'content_page_id',
        'previous_revision_id',
        'version',
        'title',
        'content',
        'change_notes',
        'created_by',
    ];

    public $translatable = [
        'title',
        'content',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Disable updated_at since revisions are immutable
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = now();
        });
    }

    /**
     * Get the content page that owns this revision
     */
    public function contentPage()
    {
        return $this->belongsTo(ContentPage::class);
    }

    /**
     * Get the previous revision
     */
    public function previousRevision()
    {
        return $this->belongsTo(ContentPageRevision::class, 'previous_revision_id');
    }

    /**
     * Get the next revision (if any)
     */
    public function nextRevision()
    {
        return $this->hasOne(ContentPageRevision::class, 'previous_revision_id');
    }

    /**
     * Get the creator user
     */
    public function creator()
    {
        return $this->belongsTo(\Mgahed\LaravelStarter\Models\User::class, 'created_by');
    }

    /**
     * Check if this is the latest revision
     */
    public function isLatest()
    {
        return !$this->nextRevision()->exists();
    }

    /**
     * Get localized content for current locale
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
}


