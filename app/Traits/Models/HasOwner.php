<?php

namespace App\Traits\Models;

trait HasOwner
{
    public function isOwner(string $token) : bool
    {
        return $this->apiToken()->where('token', $token)->exists();
    }
}
