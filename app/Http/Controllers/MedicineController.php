<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('medicine.index', [
            'title' => 'Data Obat & Alkes',
            'medicines' => Medicine::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('medicine.create', [
            'title' => 'Tambah Data Obat',
        ]);
    }

    public function store(Request $request)
    {
        if ($request->has('price')) {
            $request->merge([
                'price' => str_replace('.', '', $request->price),
            ]);
        }

        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:medicines,name',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        try {
            Medicine::create($validate);
            return to_route('medicine.index')->withSuccess('Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show(Medicine $medicine)
    {
        abort(404);
    }

    public function edit(Medicine $medicine)
    {
        return view('medicine.edit', [
            'title' => 'Ubah Data Obat',
            'medicine' => $medicine,
        ]);
    }

    public function update(Request $request, Medicine $medicine)
    {
        if ($request->has('price')) {
            $request->merge([
                'price' => str_replace('.', '', $request->price),
            ]);
        }

        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:medicines,name,' . $medicine->id,
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        try {
            $medicine->update($validate);
            return to_route('medicine.index')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            return back()->withInput()->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function destroy(Medicine $medicine)
    {
        try {
            $medicine->delete();
            return to_route('medicine.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            return to_route('medicine.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
