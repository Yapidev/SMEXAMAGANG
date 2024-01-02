<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'name', 'image', 'phone_number', 'nik', 'kelas', 'jurusan', 'image', 'prakerins_id'
    ];

    protected $guarded = ['id'];

    public function prakerin() {
        return $this->belongsTo('prakerins');
    }
}
