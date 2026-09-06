<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    public $timestamps = false; 

    protected $fillable = [
        'kode_reservasi', 'user_id', 'id_paket', 'nama_paket', 'nama_pemesan', 
        'whatsapp', 'tanggal_kunjungan', 'jumlah_orang', 'harga_satuan', 
        'total_biaya', 'catatan', 'status', 'waktu_pesan'
    ];
}