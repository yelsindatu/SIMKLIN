<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('room.index', [
            'title' => 'Manajemen Kamar / Ruangan',
            'rooms' => Room::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('room.create', [
            'title' => 'Tambah Ruangan',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name',
            'description' => 'nullable|string',
        ]);

        try {
            Room::create($validate);
            return to_route('room.index')->withSuccess('Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show(Room $room)
    {
        abort(404);
    }

    public function edit(Room $room)
    {
        return view('room.edit', [
            'title' => 'Ubah Ruangan',
            'room' => $room,
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'description' => 'nullable|string',
        ]);

        try {
            $room->update($validate);
            return to_route('room.index')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            return back()->withInput()->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function destroy(Room $room)
    {
        try {
            $room->delete();
            return to_route('room.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            return to_route('room.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
