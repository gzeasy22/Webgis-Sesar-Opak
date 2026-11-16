<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gempa extends Model
{
    protected $table = 'tb_gempa'; // wajib, karena nama tabel gak ikut konvensi Laravel
    protected $primaryKey = 'id_gempa';
    public $incrementing = false; // karena id_gempa berupa string, bukan angka auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_gempa',
        'waktu',
        'skala_mmi',
        'magnitudo',
        'geom_area',
    ];
}