<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;


class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil bidang siswa
        $bidangSiswa = $user->bidang;

        // Update notifikasi yang dibaca oleh user berdasarkan bidang mereka (jika ingin tandai dibaca semua dari bidangnya)
        Notifikasi::where('bidang', $bidangSiswa)
                ->where('user_id', $user->id)
                ->update(['dibaca' => true]);

        // Ambil notifikasi yang sesuai bidang siswa
        $notifikasi = Notifikasi::where('bidang', $bidangSiswa)
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('siswa.konten.notifikasi', compact('notifikasi'));
    }
    public function indexadmin()
    {
        $user = Auth::user();

        // Ambil bidang siswa
        $bidangSiswa = $user->bidang;

        // Update notifikasi yang dibaca oleh user berdasarkan bidang mereka (jika ingin tandai dibaca semua dari bidangnya)
        Notifikasi::where('bidang', $bidangSiswa)
                ->where('user_id', $user->id)
                ->update(['dibaca' => true]);

        // Ambil notifikasi yang sesuai bidang siswa
        $notifikasi = Notifikasi::where('bidang', $bidangSiswa)
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('admin.konten.notifikasi', compact('notifikasi'));
    }

    public function markAsReadAdmin($id)
    {
        $user = Auth::user();

        $notif = Notifikasi::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // Tandai sebagai dibaca
        $notif->update(['dibaca' => true]);

        // Redirect ke halaman job-matching admin
        return redirect()->route('admin.job-matching.index');
    }


    public function markAsRead(Request $request)
    {
        $user = Auth::user();

        $notif = Notifikasi::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $notif->dibaca = true;
        $notif->save();

        return response()->json(['message' => 'Notifikasi sudah ditandai terbaca']);
    }

}

