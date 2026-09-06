<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketWisata extends Model
{
    protected $table = 'paket_wisata'; 
    public $timestamps = false; 

    protected $fillable = [
        'nama_paket', 'harga', 'durasi', 'kapasitas', 'deskripsi', 'gambar'
    ];
}