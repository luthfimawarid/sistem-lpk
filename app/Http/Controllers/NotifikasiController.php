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
        $notifikasi = Notifikasi::where('user_id', $user->id)
                        ->latest()
                        ->get();
        // Notifikasi::where('user_id', $user->id)->update(['dibaca' => true]);

        return view('siswa.konten.notifikasi', compact('notifikasi'));
    }
    public function markAsRead(Request $request)
    {
        $user = Auth::user();

        // Update semua yang belum dibaca
        $user->notifikasi()->where('dibaca', false)->update(['dibaca' => true]);

        return response()->json(['message' => 'Notifikasi sudah ditandai terbaca']);
    }

}

