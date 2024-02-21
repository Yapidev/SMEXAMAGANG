<?php

namespace App\Models;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'siswas';

    protected $guarded = ['id'];

    /**
     * prakerin
     *
     * @return HasMany
     */
    public function prakerins(): HasMany
    {
        return $this->hasMany(Prakerin::class);
    }

    public function prakerinDetail(): HasMany
    {
        return $this->hasMany(PrakerinDetail::class);
    }
}
