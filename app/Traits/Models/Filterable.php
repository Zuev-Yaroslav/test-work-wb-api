<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @mixin Builder
 */

trait Filterable
{
    use Sortable;
    public static function scopeFreshFilter(Builder $builder)
    {
        $now = Carbon::now()->format('Y-m-d');
        $todayDataExists = static::where('date', '>=', $now)->exists();
        if (!$todayDataExists) {
            $model = static::latestDate()->first();
            $formattedDate = Carbon::parse($model->date)->format('Y-m-d');
            $builder->where('date', '>=', $formattedDate);
        } else {
            $builder->where('date', '>=', $now);
        }
    }
}
