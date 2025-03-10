<?php

namespace Mgahed\LaravelStarter\Triggers;

use Illuminate\Support\Facades\Auth;

trait CreatedBy
{
	protected static function bootCreatedBy()
	{
		static::creating(function ($model) {
			$model->created_by = !Auth::guest() ? Auth::id() : null;
		});
	}
}
