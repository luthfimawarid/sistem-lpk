<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function index()
    {
        $sertifikatBahasa = Sertifikat::where('tipe', 'bahasa')->with('user')->latest()->get();
        $sertifikatSkill = Sertifikat::where('tipe', 'skill')->with('user')->latest()->get();
    
        return view('admin.konten.sertifikat', compact('sertifikatBahasa', 'sertifikatSkill'));
    }
    

    public function create()
    {
        $siswa = User::where('role', 'siswa')->get();
        return view('admin.konten.tambahsertifikat', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:bahasa,skill',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('sertifikat', 'public');
        }

        Sertifikat::create([
            'user_id' => $request->user_id,
            'judul' => $request->judul,
            'tipe' => $request->tipe,
            'deskripsi' => $request->deskripsi,
            'file' => $gambarPath,
        ]);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $siswa = User::where('role', 'siswa')->get();
        return view('admin.konten.editsertifikat', compact('sertifikat', 'siswa'));
    }

    public function update(Request $request, $id)
    {
        $sertifikat = Sertifikat::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:bahasa,skill',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($sertifikat->file) {
                Storage::delete('public/' . $sertifikat->file);
            }
            $sertifikat->file = $request->file('gambar')->store('sertifikat', 'public');
        }

        $sertifikat->update([
            'user_id' => $request->user_id,
            'judul' => $request->judul,
            'tipe' => $request->tipe,
            'deskripsi' => $request->deskripsi,
            'file' => $sertifikat->file,
        ]);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        if ($sertifikat->file) {
            Storage::delete('public/' . $sertifikat->file);
        }
        $sertifikat->delete();

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function siswaIndex()
    {
        $userId = Auth::id();

        // Ambil semua sertifikat milik siswa ini
        $sertifikatBahasa = Sertifikat::where('user_id', $userId)->where('tipe', 'bahasa')->get();
        $sertifikatSkill = Sertifikat::where('user_id', $userId)->where('tipe', 'skill')->get();

        return view('siswa.konten.sertifikat', compact('sertifikatBahasa', 'sertifikatSkill'));
    }

}
