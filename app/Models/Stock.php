<?php

namespace App\Models;

use App\Traits\Models\HasOwner;
use App\Traits\Models\Filterable;
use App\Traits\Models\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Stock extends Model
{
    use Filterable;
    use Sortable;
    use HasOwner;
    protected $guarded = [];
    public const UNIQUE_ATTRIBUTES = [
        'date',
        'nm_id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function apiToken()
    {
        return $this->account->apiToken();
    }
}
