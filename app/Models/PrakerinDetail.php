<?php

namespace App\Models;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrakerinDetail extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'prakerin_details';    

    protected $guarded = ['id'];

    public function prakerins(): HasMany
    {
        return $this->hasMany(Prakerin::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
