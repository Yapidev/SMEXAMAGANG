<?php

namespace App\Models;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function prakerins(): HasMany
    {
        return $this->hasMany(Prakerin::class);
    }

    /**
     * Relasi ke tabel tempat prakerin
     *
     * @return BelongsTo
     */
    public function tempatPrakerin(): BelongsTo
    {
        return $this->belongsTo(TempatPrakerin::class, 'tempat_prakerins_id');
    }
}
