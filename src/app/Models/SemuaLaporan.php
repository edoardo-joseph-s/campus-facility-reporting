<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemuaLaporan extends Model
{
    protected $table = 'laporan_kinerjas';

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ditugaskanKepada()
    {
        return $this->belongsTo(User::class, 'ditugaskan_kepada_id');
    }
    
    protected $fillable = [
        'nomor_laporan',
        'judul',
        'deskripsi',
        'user_id',
        'lokasi_id',
        'kategori_id',
        'ditugaskan_kepada_id',
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
