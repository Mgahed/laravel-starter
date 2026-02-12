<?php

namespace Mgahed\LaravelStarter\Models\Admin\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mgahed\LaravelStarter\Triggers\AutoUlid;
use Mgahed\LaravelStarter\Triggers\CreatedBy;
use Mgahed\LaravelStarter\Triggers\UpdatedBy;

class SystemSetting extends Model
{
    use AutoUlid, CreatedBy, UpdatedBy, SoftDeletes;

    protected $guarded = [];
}

