<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'nama_user', 'avatar', 'jenis_media', 'media_url', 'caption', 'status', 'waktu_upload'
    ];
}