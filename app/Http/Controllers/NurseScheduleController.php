<?php

namespace App\Http\Controllers;

use App\Models\NurseSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NurseScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\NurseSchedule::with(['user', 'room']);
        
        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', '>=', date('Y-m-d'));
        }

        return view('nurse_schedule.index', [
            'title' => 'Jadwal Dinas Perawat',
            'schedules' => $query->orderBy('date')->orderBy('shift')->get(),
        ]);
    }

    public function create()
    {
        return view('nurse_schedule.create', [
            'title' => 'Tambah Jadwal Perawat',
            'users' => \App\Models\User::where('role', 'Perawat')->orderBy('name')->get(),
            'rooms' => \App\Models\Room::orderBy('name')->get(),
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validate = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                \Illuminate\Validation\Rule::unique('nurse_schedules')->where(function ($query) use ($request) {
                    return $query->where('date', $request->date)
                                 ->where('shift', $request->shift);
                })
            ],
            'room_id' => [
                'required',
                'exists:rooms,id',
                \Illuminate\Validation\Rule::unique('nurse_schedules')->where(function ($query) use ($request) {
                    return $query->where('date', $request->date)
                                 ->where('shift', $request->shift);
                })
            ],
            'date' => 'required|date',
            'shift' => 'required|in:Pagi,Sore,Malam',
        ], [
            'user_id.unique' => 'Perawat tersebut sudah memiliki jadwal dinas di ruangan lain pada shift dan tanggal ini.',
            'room_id.unique' => 'Kamar tersebut sudah dijadwalkan untuk perawat lain pada shift dan tanggal ini.'
        ]);

        try {
            \App\Models\NurseSchedule::create($validate);
            return to_route('nurse-schedule.index')->withSuccess('Jadwal berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()->withError('Gagal menambahkan jadwal: ' . $e->getMessage());
        }
    }

    public function show(\App\Models\NurseSchedule $nurseSchedule)
    {
        abort(404);
    }

    public function edit(\App\Models\NurseSchedule $nurseSchedule)
    {
        return view('nurse_schedule.edit', [
            'title' => 'Ubah Jadwal Perawat',
            'schedule' => $nurseSchedule,
            'users' => \App\Models\User::where('role', 'Perawat')->orderBy('name')->get(),
            'rooms' => \App\Models\Room::orderBy('name')->get(),
        ]);
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\NurseSchedule $nurseSchedule)
    {
        $validate = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                \Illuminate\Validation\Rule::unique('nurse_schedules')->where(function ($query) use ($request) {
                    return $query->where('date', $request->date)
                                 ->where('shift', $request->shift);
                })->ignore($nurseSchedule->id)
            ],
            'room_id' => [
                'required',
                'exists:rooms,id',
                \Illuminate\Validation\Rule::unique('nurse_schedules')->where(function ($query) use ($request) {
                    return $query->where('date', $request->date)
                                 ->where('shift', $request->shift);
                })->ignore($nurseSchedule->id)
            ],
            'date' => 'required|date',
            'shift' => 'required|in:Pagi,Sore,Malam',
        ], [
            'user_id.unique' => 'Perawat tersebut sudah memiliki jadwal dinas di ruangan lain pada shift dan tanggal ini.',
            'room_id.unique' => 'Kamar tersebut sudah dijadwalkan untuk perawat lain pada shift dan tanggal ini.'
        ]);

        try {
            $nurseSchedule->update($validate);
            return to_route('nurse-schedule.index')->withSuccess('Jadwal berhasil diubah');
        } catch (\Exception $e) {
            return back()->withInput()->withError('Gagal mengubah jadwal: ' . $e->getMessage());
        }
    }

    public function destroy(\App\Models\NurseSchedule $nurseSchedule)
    {
        try {
            $nurseSchedule->delete();
            return to_route('nurse-schedule.index')->withSuccess('Jadwal berhasil dihapus');
        } catch (\Exception $e) {
            return to_route('nurse-schedule.index')->withError('Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }
}
