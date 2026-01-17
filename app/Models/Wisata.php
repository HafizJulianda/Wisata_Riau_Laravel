<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    protected $table = 'tb_wisata';
    protected $primaryKey = 'id_wisata';
    public $timestamps = false;

    protected $fillable = [
        'nama_wisata',
        'jenis_wisata',
        'deskripsi',
        'alamat',
        'rating',
        'jam_buka',
        'kabupaten_kota',
        'url_alamat',
        'url_gambar'
    ];
}
