<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lokasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'lantai',
        'gedung',
        'blok',
        'koordinat',
        'parent_id',
        'aktif',
        'urutan'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Lokasi::class, 'parent_id');
    }

    public function getLokasiLengkapAttribute(): string
    {
        $parts = [];
        
        if ($this->blok) $parts[] = "Blok {$this->blok}";
        if ($this->gedung) $parts[] = "Gedung {$this->gedung}";
        if ($this->lantai) $parts[] = "Lantai {$this->lantai}";
        $parts[] = $this->nama;
        
        return implode(', ', $parts);
    }
}
