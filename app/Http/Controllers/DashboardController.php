<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalPatientsToday = 0;
        $dailyRevenue = 0;
        $monthlyRevenue = 0;
        $weeklyVisits = [];
        
        $today = now()->format('Y-m-d');
        $thisMonth = now()->format('m');
        $thisYear = now()->format('Y');

        if ($user->role === 'Dokter') {
            $doctorId = $user->doctor->id ?? null;
            
            if ($doctorId) {
                $totalPatientsToday = \App\Models\Appointment::where('doctor_id', $doctorId)
                                        ->whereDate('appointment_date', $today)
                                        ->count();
                                        
                $visits = \App\Models\Appointment::selectRaw('DATE(appointment_date) as date, count(*) as total')
                                        ->where('doctor_id', $doctorId)
                                        ->where('appointment_date', '>=', now()->subDays(6)->startOfDay())
                                        ->groupBy('date')
                                        ->orderBy('date')
                                        ->get()
                                        ->keyBy('date');
            } else {
                $visits = collect();
            }
        } else {
            // Admin and Superadmin
            $totalPatientsToday = \App\Models\Appointment::whereDate('appointment_date', $today)->count();
            
            $dailyRevenue = \App\Models\PaymentInvoice::whereDate('created_at', $today)
                                        ->where('status', 'Paid')
                                        ->sum('total_amount');
                                        
            $monthlyRevenue = \App\Models\PaymentInvoice::whereMonth('created_at', $thisMonth)
                                        ->whereYear('created_at', $thisYear)
                                        ->where('status', 'Paid')
                                        ->sum('total_amount');
                                        
            $visits = \App\Models\Appointment::selectRaw('DATE(appointment_date) as date, count(*) as total')
                                    ->where('appointment_date', '>=', now()->subDays(6)->startOfDay())
                                    ->groupBy('date')
                                    ->orderBy('date')
                                    ->get()
                                    ->keyBy('date');
        }
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $weeklyVisits[now()->subDays($i)->format('d M')] = $visits->has($date) ? $visits[$date]->total : 0;
        }

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'totalPatientsToday' => $totalPatientsToday,
            'dailyRevenue' => $dailyRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'weeklyVisits' => $weeklyVisits,
        ]);
    }

    public function show()
    {
        return view('dashboard.show', [
            'title' => 'My Profile',
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('dashboard.edit', [
            'title' => 'Edit Profile',
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $validate = $request->validate([
                'name' => 'required',
                'password' => 'nullable|min:8',
                'passwordconfirm' => 'nullable|same:password',
                'email' => 'required|email|lowercase|unique:users,email,' . $user->id,
                'avatar' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:512'
            ], [
                'name.required' => 'Nama wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'passwordconfirm.same' => 'Konfirmasi password tidak cocok',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'avatar.image' => 'File avatar harus berupa gambar',
                'avatar.mimes' => 'Format avatar harus png, jpg, jpeg, atau svg',
                'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 512 KB',
            ]);

            if ($request->file('avatar')) {
                $validate['avatar'] = $request->file('avatar')->store('img', 'public');
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            if ($request->password) {
                $validate['password'] = bcrypt($request->password);
            } else {
                unset($validate['password']);
            }
            $user->update($validate);

            DB::commit();
            return to_route('dashboard.show')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('dashboard.edit')->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }
}
