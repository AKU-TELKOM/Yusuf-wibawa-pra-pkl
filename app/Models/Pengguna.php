<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Model {
    protected $table = 'pengguna';
    protected $fillable = ['nama', 'kelas', 'jurusan', 'no_hp'];

    public function peminjaman(): HasMany {
        return $this->hasMany(Peminjaman::class, 'pengguna_id');
    }
}