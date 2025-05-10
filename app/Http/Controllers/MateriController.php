<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function indexEbook()
    {
        $materi = Materi::where('tipe', 'ebook')->get();
        $tipe = 'ebook'; // tetap ada
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
            'cover' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'file' => 'required|mimes:pdf,mp3,mp4|max:100000',
            'tipe' => 'required|in:ebook,listening,video',
        ]);

        // Upload cover
        $coverPath = $request->file('cover')->store('cover', 'public');

        // Upload file materi
        $filePath = $request->file('file')->store('materi', 'public');

        // Simpan ke database
        Materi::create([
            'judul' => $request->judul,
            'author' => $request->author,
            'cover' => basename($coverPath),
            'file' => basename($filePath),
            'tipe' => $request->tipe,
            'status' => 'aktif',
        ]);

        switch ($request->tipe) {
            case 'ebook':
                return redirect()->route('materi.ebook')->with('success', 'Materi berhasil ditambahkan.');
            case 'listening':
                return redirect()->route('materi.listening')->with('success', 'Materi berhasil ditambahkan.');
            case 'video':
                return redirect()->route('materi.video')->with('success', 'Materi berhasil ditambahkan.');
            default:
                return redirect()->back()->with('error', 'Tipe materi tidak dikenali.');
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


}
