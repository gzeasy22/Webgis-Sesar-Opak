<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Segmen extends Model
{
    protected $table = 'tb_segmen';
    protected $primaryKey = 'id_segmen';

    protected $fillable = [
        'nama_segmen',
        'deskripsi',
        'geom_line',
    ];
}