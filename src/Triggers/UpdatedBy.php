<?php

namespace Mgahed\LaravelStarter\Triggers;

use Illuminate\Support\Facades\Auth;

trait UpdatedBy
{
	protected static function bootUpdatedBy()
	{
		static::updating(function ($model) {
			$model->updated_by = Auth::id() ? Auth::id() : null;
		});

		static::deleting(function ($model) {
			$model->updated_by = Auth::id() ? Auth::id() : null;
		});

		static::restoring(function ($model) {
			$model->updated_by = Auth::id() ? Auth::id() : null;
		});

	}
}
