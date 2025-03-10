<?php

namespace Mgahed\LaravelStarter\Models\Admin\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mgahed\LaravelStarter\Triggers\CreatedBy;
use Mgahed\LaravelStarter\Triggers\UpdatedBy;

class Translation extends Model
{
	use SoftDeletes, CreatedBy, UpdatedBy;
	protected $guarded = [];
}
