<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class LaporanKinerja extends Model
{
    use HasFactory;

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

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (!$model->nomor_laporan) {
                $model->nomor_laporan = static::generateNomorLaporan();
            }
        });
    }

    public static function generateNomorLaporan(): string
    {
        $prefix = 'LK';
        $tahun = date('Y');
        $bulan = date('m');
        $counter = static::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->count() + 1;
        
        return sprintf('%s/%s/%s/%04d', $prefix, $tahun, $bulan, $counter);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriFasilitas::class, 'kategori_id');
    }
}