<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'nama_alat',
        'kode_alat',
        'stok',
        'deskripsi',
        'gambar',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}