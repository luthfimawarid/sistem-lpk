<?php

namespace App\Http\Controllers;

use App\Models\BobotPenilaian; // Import model BobotPenilaian
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TugasUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil admin.
     */
    public function profilAdmin()
    {
        // Pastikan hanya admin yang bisa mengakses
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = Auth::user();
        $bobot = BobotPenilaian::all();
        
        return view('admin.konten.profiladmin', compact('user', 'bobot')); 
    }
    
    /**
     * Memperbarui data profil admin.
     */
    public function updateProfil(Request $request)
    {
        // Pastikan hanya admin yang bisa mengakses
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'status' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp; // Perbaikan: no_hp, bukan phone
        $user->status = $request->status;

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $request->file('photo')->store('profile', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Memperbarui password admin.
     */
    public function updatePassword(Request $request)
    {
        // Pastikan hanya admin yang bisa mengakses
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

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
    
    public function updateBobot(Request $request)
    {
        // Pastikan hanya admin yang bisa mengakses
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        // Validasi input
        $request->validate([
            'tugas' => 'required|integer|min:0|max:100',
            'evaluasi_mingguan' => 'required|integer|min:0|max:100',
            'tryout' => 'required|integer|min:0|max:100',
        ]);

        // Hitung total bobot
        $totalBobot = $request->tugas + $request->evaluasi_mingguan + $request->tryout;
        if ($totalBobot !== 100) {
            return redirect()->back()->with('error', 'Total bobot harus 100%.');
        }

        // Simpan perubahan ke database
        BobotPenilaian::where('jenis_penilaian', 'tugas')->update(['bobot' => $request->tugas]);
        BobotPenilaian::where('jenis_penilaian', 'evaluasi_mingguan')->update(['bobot' => $request->evaluasi_mingguan]);
        BobotPenilaian::where('jenis_penilaian', 'tryout')->update(['bobot' => $request->tryout]);

        // Ubah redirect dari back() menjadi redirect ke route profil admin
        return redirect()->route('admin.profil')->with('success', 'Bobot penilaian berhasil diperbarui.')->with('tab', 'tab-bobot');
    }
    
    public function profil()
    {
        $user = Auth::user();
        $tugasUser = $user->TugasUser()->with('tugas')->get();
        $nilaiTugas = $tugasUser->where('tugas.tipe', 'tugas')->pluck('nilai')->filter()->avg();
        $nilaiEvaluasi = $tugasUser->where('tugas.tipe', 'evaluasi_mingguan')->pluck('nilai')->filter()->avg();
        $nilaiKuis = $tugasUser->where('tugas.tipe', 'kuis')->pluck('nilai')->filter()->avg();
        $nilaiTryout = $tugasUser->where('tugas.tipe', 'tryout')->pluck('nilai')->filter()->avg();
        $dokumenSiswa = $user->dokumenSiswa()->get()->keyBy('jenis_dokumen');

        return view('siswa.konten.profil', compact(
            'user',
            'nilaiTugas',
            'nilaiEvaluasi',
            'nilaiKuis',
            'nilaiTryout',
            'dokumenSiswa'
        ));
    }
    
    public function updateProfilSiswa(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tanggal_lahir' => 'nullable|date',
            'no_hp' => 'nullable|string|max:20',
            'kelas' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'angkatan' => 'nullable|numeric|min:2000|max:' . date('Y'),
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->no_hp = $request->no_hp;
        $user->kelas = $request->kelas;
        $user->status = $request->status;
        $user->angkatan = $request->angkatan;

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
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