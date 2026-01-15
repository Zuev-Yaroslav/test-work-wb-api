<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $guarded = [];
    public function account()
    {
        return $this->hasOne(Account::class);
    }
    public function orders()
    {
        return $this->hasManyThrough(Order::class, Account::class);
    }
    public function sales()
    {
        return $this->hasManyThrough(Sale::class, Account::class);
    }
    public function stocks()
    {
        return $this->hasManyThrough(Stock::class, Account::class);
    }
    public function incomes()
    {
        return $this->hasManyThrough(Income::class, Account::class);
    }
}
