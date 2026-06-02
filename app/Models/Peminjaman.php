<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model {
    protected $table = 'peminjaman';
    protected $fillable = ['pengguna_id', 'peralatan_id', 'tanggal_pinjam', 'tanggal_kembali', 'jumlah_pinjam'];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function pengguna(): BelongsTo {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function peralatan(): BelongsTo {
        return $this->belongsTo(Peralatan::class, 'peralatan_id');
    }
}