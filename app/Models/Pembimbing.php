<?php

namespace App\Models;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'pembimbings';

    protected $fillable = ['name', 'image', 'jabatan', 'jurusan', 'prakerins_id'];

    protected $guarded = ['id'];

    public function prakerins() {
        return $this->belongsTo('prakerins');
    }
}
