<?php

namespace App\Models;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prakerin extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'prakerins';

    protected $fillable = ['name', 'description', 'address', 'image'];

    protected $guarded = ['id'];

    public function siswa() {
        return $this->hasMany('siswas');
    }

    public function pembimbing() {
        return $this->hasMany('pembimbing');
    }
}
