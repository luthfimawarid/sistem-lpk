<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function indexEbook()
    {
        $materi = Materi::where('tipe', 'ebook')->get();
        $tipe = 'ebook'; 
        return view('admin.konten.ebook', compact('materi', 'tipe')); // <<< PERBAIKI INI
    }

    public function indexListening()
    {
        $materi = Materi::where('tipe', 'listening')->get();
        $tipe = 'listening';
        return view('admin.konten.listening', compact('materi', 'tipe'));
    }

    public function indexVideo()
    {
        $materi = Materi::where('tipe', 'video')->get();
        $tipe = 'video';
        return view('admin.konten.video', compact('materi', 'tipe'));
    }

    public function create($tipe)
    {
        return view('admin.konten.tambahmateri', compact('tipe'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'bidang' => 'required|string|in:Perawatan (Kaigo/Caregiver),Pembersihan Gedung,Konstruksi,Manufaktur Mesin Industri,Elektronik dan Listrik,Perhotelan,Pertanian,Perikanan,Pengolahan Makanan dan Minuman,Restoran/Cafe',
            'file' => 'required|mimetypes:application/pdf,audio/mpeg,video/mp4|max:200000',
            'tipe' => 'required|in:ebook,listening,video',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        try {
            // Upload file
            $filePath = $request->file('file')->store('materi', 'public');

            // Simpan ke database
            Materi::create([
                'judul' => $request->judul,
                'author' => $request->author,
                'bidang' => $request->bidang,
                'file' => basename($filePath),
                'tipe' => $request->tipe,
                'status' => $request->status,
            ]);

            // Redirect sesuai tipe
            switch ($request->tipe) {
                case 'ebook':
                    return redirect()->route('materi.ebook')->with('success', 'Materi berhasil ditambahkan.');
                case 'listening':
                    return redirect()->route('materi.listening')->with('success', 'Materi berhasil ditambahkan.');
                case 'video':
                    return redirect()->route('materi.video')->with('success', 'Materi berhasil ditambahkan.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan materi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        return view('admin.konten.editmateri', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'tipe' => 'required|in:ebook,listening,video',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $materi->judul = $request->judul;
        $materi->author = $request->author;
        $materi->tipe = $request->tipe;
        $materi->status = $request->status;

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('cover', 'public');
            $materi->cover = basename($coverPath);
        }

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materi', 'public');
            $materi->file = basename($filePath);
        }

        $materi->save();

        switch ($materi->tipe) {
            case 'ebook':
                return redirect()->route('materi.ebook')->with('success', 'Materi berhasil diupdate.');
            case 'listening':
                return redirect()->route('materi.listening')->with('success', 'Materi berhasil diupdate.');
            case 'video':
                return redirect()->route('materi.video')->with('success', 'Materi berhasil diupdate.');
            default:
                return redirect()->back()->with('error', 'Tipe materi tidak dikenali.');
        }
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        // Hapus file cover dan file materi
        \Storage::disk('public')->delete('cover/'.$materi->cover);
        \Storage::disk('public')->delete('materi/'.$materi->file);

        $materi->delete();

        return redirect()->back()->with('success', 'Materi berhasil dihapus.');
    }

    public function siswaEbook()
    {
        $user = auth()->user();
        $materi = Materi::where('tipe', 'ebook')
            ->where('status', 'aktif')
            ->where('bidang', $user->bidang)
            ->get();

        $tipe = 'ebook'; 

        return view('siswa.konten.ebook', compact('materi', 'tipe'));
    }

    public function siswaListening()
    {
        $user = auth()->user();
        $materi = Materi::where('tipe', 'listening')
            ->where('status', 'aktif')
            ->where('bidang', $user->bidang)
            ->get();

        $tipe = 'listening'; 

        return view('siswa.konten.listening', compact('materi', 'tipe'));
    }

    public function siswaVideo()
    {
        $user = auth()->user();
        $materi = Materi::where('tipe', 'video')
            ->where('status', 'aktif')
            ->where('bidang', $user->bidang)
            ->get();

        $tipe = 'video'; 

        return view('siswa.konten.video', compact('materi', 'tipe'));
    }



}
