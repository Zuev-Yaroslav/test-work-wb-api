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
class Order extends Model
{
    use Filterable;
    use Sortable;
    use HasOwner;
    protected $guarded = [];
    public const UNIQUE_ATTRIBUTES = [
        'g_number',
        'nm_id',
        'barcode',
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
