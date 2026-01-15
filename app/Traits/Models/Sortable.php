<?php

namespace App\Traits\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @mixin Builder
 */

trait Sortable
{
    public function scopeLatestDate(Builder $builder)
    {
        $builder->orderBy('date', 'desc');
    }
}
