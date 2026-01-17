<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penginapan extends Model
{
    protected $table = 'tb_penginapan';
    protected $primaryKey = 'id_penginapan';
    public $timestamps = false;

    protected $fillable = [
        'lokasi_wisata', 'nama_penginapan', 'deskripsi_singkat', 'tipe',
        'fasilitas', 'harga_per_malam', 'alamat', 'rating',
        'kota_kabupaten', 'jarak_ke_wisata', 'url_gambar'
    ];
}