<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaKerusakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'lokasi',
        'deskripsi',
        'tingkat_kerusakan',
        'gambar',
        'tanggal_inspeksi',
        'semua_laporan_id',
    ];

    protected $casts = [
        'tanggal_inspeksi' => 'date',
    ];

    public function semuaLaporan()
    {
        return $this->belongsTo(\App\Models\SemuaLaporan::class);
    }
}