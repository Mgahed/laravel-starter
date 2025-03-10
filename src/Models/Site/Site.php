<?php

namespace Mgahed\LaravelStarter\Models\Site;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mgahed\LaravelStarter\Triggers\AutoUlid;
use Mgahed\LaravelStarter\Triggers\CreatedBy;
use Mgahed\LaravelStarter\Triggers\UpdatedBy;

class Site extends Model
{
	use AutoUlid, CreatedBy, SoftDeletes, UpdatedBy;

	protected static function boot()
	{

		parent::boot();

		static::addGlobalScope('module', function (Builder $builder) {
			$builder->where('record_state', 1)
				->orderBy('record_priority', 'asc')
				->orderBy('id', 'asc');
		});

	}

	public function getLabelAttribute()
	{
		return json_decode($this->translations, true)['title'][app()->getLocale()] ?? $this->title;
	}

	public static function labelArray($jsonEncode=true)
	{
		$result = array();

		foreach (Site::select(['language'])->get() as $item) {
			array_push($result, $item->language);
		}

		if($jsonEncode==false) {
			return $result;
		}

		return json_encode($result,JSON_UNESCAPED_UNICODE);
	}
}
