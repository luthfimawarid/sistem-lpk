<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TugasUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{

    public function profilAdmin()
    {
        $user = Auth::user(); // ambil data user yang login
        return view('admin.konten.profiladmin', compact('user'));
    }
    public function edit()
    {
        $user = User::find(session('user_id'));
        return view('siswa.konten.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->status = $request->status;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('profile', 'public');
            $user->photo = $photo;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }

    public function profil()
    {
        $user = Auth::user();

        // Ambil nilai berdasarkan tipe tugas
        $tugasUser = $user->TugasUser()->with('tugas')->get();

        $nilaiTugas = $tugasUser->where('tugas.tipe', 'tugas')->pluck('nilai')->filter()->avg();
        $nilaiEvaluasi = $tugasUser->where('tugas.tipe', 'evaluasi_mingguan')->pluck('nilai')->filter()->avg();
        $nilaiKuis = $tugasUser->where('tugas.tipe', 'kuis')->pluck('nilai')->filter()->avg();
        $nilaiTryout = $tugasUser->where('tugas.tipe', 'tryout')->pluck('nilai')->filter()->avg();

        return view('siswa.konten.profil', compact('user', 'nilaiTugas', 'nilaiEvaluasi', 'nilaiKuis', 'nilaiTryout'));
    }

    public function updateProfilSiswa(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'nullable|string',
            'kelas' => 'nullable|string',
            'status' => 'nullable|string',
            'angkatan' => 'nullable|numeric|min:2000|max:' . date('Y'),
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->kelas = $request->kelas;
        $user->status = $request->status;
        $user->angkatan = $request->angkatan;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }


    public function updatePasswordSiswa(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }


}
