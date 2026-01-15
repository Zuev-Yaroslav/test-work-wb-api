<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenType extends Model
{
    protected $guarded = [];

    public function apiService()
    {
        return $this->belongsTo(ApiService::class);
    }
}
