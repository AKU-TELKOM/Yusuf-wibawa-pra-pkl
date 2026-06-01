<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sesuaikan dengan gate/auth jika diperlukan
    }

    public function rules(): array
    {
        return [
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'required|string|max:50|unique:equipments,kode_alat',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}