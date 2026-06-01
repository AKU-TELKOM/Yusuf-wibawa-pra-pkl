<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $equipmentId = $this->route('equipment')->id ?? $this->route('equipment');

        return [
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'required|string|max:50|unique:equipments,kode_alat,' . $equipmentId,
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}