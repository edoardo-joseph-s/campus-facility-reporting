<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriFasilitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'ikon',
        'aktif',
        'urutan'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer'
    ];
}
