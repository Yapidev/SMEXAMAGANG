<?php

namespace App\Models;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pembimbing extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'pembimbings';

    protected $guarded = ['id'];

    /**
     * prakerins
     *
     * @return HasOne
     */
    public function prakerins(): HasOne
    {
        return $this->hasOne(Prakerin::class);
    }
}
