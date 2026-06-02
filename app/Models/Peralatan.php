<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peralatan extends Model {
    protected $table = 'peralatan';
    protected $fillable = ['nama_peralatan', 'kategori', 'jumlah_stok', 'kondisi'];

    public function peminjaman(): HasMany {
        return $this->hasMany(Peminjaman::class, 'peralatan_id');
    }
}