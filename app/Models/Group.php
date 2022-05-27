<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'name', 'faculty', 'url'];

    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class);
    }

}
