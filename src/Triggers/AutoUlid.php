<?php

namespace Mgahed\LaravelStarter\Triggers;

trait AutoUlid
{
	protected static function bootAutoUlid()
	{
		static::creating(function ($model) {
			$model->keyType = 'string';
			$model->ulid = (string) \Str::orderedUuid();
		});
	}
}
