<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restoran extends Model
{
    protected $table = 'tb_restoran';
    protected $primaryKey = 'id_restoran';
    public $timestamps = false;

    protected $fillable = [
        'nama_restoran',
        'jenis_makanan',
        'alamat',
        'rating',
        'harga',
        'jam_operasional',
        'kabupaten_kota',
        'jarak',
        'url_gambar'
    ];
}
