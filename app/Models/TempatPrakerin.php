<?php

namespace App\Models;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatPrakerin extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $table = 'tempat_prakerins';

    protected $guarded = ['id'];
}
