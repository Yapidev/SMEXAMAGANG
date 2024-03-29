<?php

namespace App\Models;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TempatPrakerin extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'tempat_prakerins';

    protected $guarded = ['id'];

    public function prakerins(): HasMany
    {
        return $this->hasMany(Prakerin::class, 'tempat_prakerin_id');
    }
}
