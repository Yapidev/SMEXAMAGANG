<?php

namespace App\Models;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prakerin extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'prakerins';

    protected $guarded = ['id'];

    /**
     * siswa
     *
     * @return BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * pembimbing
     *
     * @return BelongsTo
     */
    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(Pembimbing::class);
    }

    /**
     * tempat_prakerin
     *
     * @return BelongsTo
     */
    public function tempat_prakerin(): BelongsTo
    {
        return $this->belongsTo(TempatPrakerin::class);
    }

    public function PrakerinDetail(): BelongsTo
    {
        return $this->belongsTo(PrakerinDetail::class);
    }
}
