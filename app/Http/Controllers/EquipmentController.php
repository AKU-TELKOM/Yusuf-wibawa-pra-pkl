<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::latest()->paginate(10);
        return view('equipments.index', compact('equipments'));
    }

    public function store(StoreEquipmentRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('equipments', 'public');
        }

        Equipment::create($data);

        return redirect()->route('equipments.index')->with('success', 'Peralatan lab berhasil ditambahkan.');
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($equipment->gambar && Storage::disk('public')->exists($equipment->gambar)) {
                Storage::disk('public')->delete($equipment->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('equipments', 'public');
        }

        $equipment->update($data);

        return redirect()->route('equipments.index')->with('success', 'Data peralatan berhasil diperbarui.');
    }

    public function destroy(Equipment $equipment)
    {
        if ($equipment->gambar && Storage::disk('public')->exists($equipment->gambar)) {
            Storage::disk('public')->delete($equipment->gambar);
        }

        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Peralatan berhasil didelete dari sistem.');
    }
}