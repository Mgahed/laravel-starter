<?php

namespace Mgahed\LaravelStarter\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mgahed\LaravelStarter\Triggers\AutoUlid;
use Mgahed\LaravelStarter\Triggers\CreatedBy;
use Mgahed\LaravelStarter\Triggers\UpdatedBy;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
	use AutoUlid, CreatedBy, UpdatedBy, SoftDeletes, HasTranslations;
	protected $fillable = [
		'ulid',
		'slug',
		'parent_id',
		'title',
		'route',
		'icon',
		'record_order',
		'created_by',
		'updated_by',
	];

	public $translatable = [
		'title',
	];

	// global scope that order menus by record_order
	protected static function boot()
	{
		parent::boot();
		static::addGlobalScope('order', function ($query) {
			$query->orderBy('record_order');
		});
	}

	public function parent()
	{
		return $this->belongsTo(Menu::class, 'parent_id');
	}

	public function children()
	{
		return $this->hasMany(Menu::class, 'parent_id');
	}

	// scope that get all parent menus
	public function scopeParentsOnly($query)
	{
		return $query->whereNull('parent_id');
	}
}
