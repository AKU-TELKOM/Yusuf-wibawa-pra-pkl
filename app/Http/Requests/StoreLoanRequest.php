<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Equipment;

class StoreLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'equipment_id' => [
                'required',
                'exists:equipments,id',
                function ($attribute, $value, $fail) {
                    $equipment = Equipment::find($value);
                    if ($equipment && $equipment->stok < 1) {
                        $fail('Stok alat "' . $equipment->nama_alat . '" saat ini sedang habis.');
                    }
                },
            ],
            'tanggal_pinjam' => 'required|date|date_format:Y-m-d|after_or_equal:today',
        ];
    }
}