<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->attributes['created_at'] = Carbon::now();
            $model->attributes['updated_at'] = Carbon::now();
        });

        static::updating(function ($model) {
            $model->attributes['updated_at'] = Carbon::now();
        });
    }
}
