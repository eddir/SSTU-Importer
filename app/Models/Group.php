<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'faculty', 'url'];

    public $timestamps = false;

    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class);
    }
}