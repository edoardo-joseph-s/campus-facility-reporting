<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemuaLaporan extends Model
{
    protected $table = 'laporan_kinerjas';
    
    protected $fillable = [
        'nomor_laporan',
        'judul',
        'deskripsi',
        'user_id',
        'lokasi_id',
        'kategori_id',
        'prioritas',
        'status',
        'catatan',
        'lampiran',
        'tanggal_laporan',
        'target_penyelesaian',
        'tanggal_selesai',
    ];
    
    protected $casts = [
        'lampiran' => 'array',
        'tanggal_laporan' => 'date',
        'target_penyelesaian' => 'date',
        'tanggal_selesai' => 'date',
    ];
}
