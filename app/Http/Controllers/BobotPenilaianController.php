<?php

namespace App\Http\Controllers;

use App\Models\BobotPenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class BobotPenilaianController extends Controller
{
    /**
     * Pastikan hanya admin yang bisa mengakses controller ini.
     */
    public function __construct()
    {
        // Pilihan 1: Menggunakan middleware built-in Laravel
        // Ini akan memastikan hanya pengguna yang terautentikasi (login) yang bisa mengakses
        $this->middleware('auth');

        // Pilihan 2: Menggunakan middleware kustom untuk role 'admin'
        // Jika Anda memiliki kolom 'role' di tabel users, Anda bisa buat middleware kustom
        // Middleware ini perlu dibuat terlebih dahulu.
        // $this->middleware('auth')->middleware('role:admin'); 

        // Pilihan 3: Menggunakan 'can' untuk mengizinkan pengguna dengan role tertentu
        // Ini membutuhkan Gate atau Policy
        $this->middleware('can:update-bobot'); // Sesuaikan dengan nama 'ability' yang Anda buat
    }

    /**
     * Menampilkan halaman pengaturan bobot.
     */
    public function index()
    {
        $bobot = BobotPenilaian::all();
        // Pastikan nama view-nya sudah benar
        return view('admin.konten.profiladmin', compact('bobot'));
    }

    /**
     * Memperbarui bobot penilaian.
     */
    public function update(Request $request)
    {
        // Periksa apakah pengguna memiliki role admin sebelum melanjutkan
        if (Auth::user()->role !== 'admin') {
            abort(403); // Tampilkan error 403 jika bukan admin
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

        return redirect()->back()->with('success', 'Bobot penilaian berhasil diperbarui.');
    }
}