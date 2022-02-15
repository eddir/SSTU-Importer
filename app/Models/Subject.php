<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{

    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class);
    }
}