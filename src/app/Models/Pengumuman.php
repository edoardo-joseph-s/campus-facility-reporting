<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumen';

    protected $fillable = [
        'judul',
        'konten',
        'tipe',
        'thumbnail',
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'aktif'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'aktif' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)
            ->where('tanggal_mulai', '<=', now())
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', now());
            });
    }
}
