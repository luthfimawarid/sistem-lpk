<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\SoalKuis;
use App\Models\JawabanKuis;
use App\Models\TugasUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function index()
    {
        $tugas = Tugas::all();
        return view('admin.konten.tugas', compact('tugas'));

    }

    public function create()
    {
        return view('admin.konten.tambahtugas');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tipe' => 'required|in:tugas,kuis,ujian_akhir,evaluasi_mingguan,tryout',
            'cover' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'deadline' => 'nullable|date',
            'status' => 'required|in:belum_selesai,selesai',
            'deskripsi' => 'required',
        ]);
        
    
        $cover = null;
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('cover_tugas', 'public');
        }
    
        // Simpan data tugas
        $tugas = Tugas::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi, // Tambahkan ini
            'tipe' => $request->tipe,
            'cover' => $cover,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);
        
    
        // Simpan soal jika tipe kuis atau ujian_akhir
        if (in_array($request->tipe, ['kuis', 'ujian_akhir']) && $request->has('soal')) {
            foreach ($request->soal as $item) {
                SoalKuis::create([
                    'tugas_id' => $tugas->id,
                    'pertanyaan' => $item['pertanyaan'],
                    'opsi_a' => $item['opsi_a'],
                    'opsi_b' => $item['opsi_b'],
                    'opsi_c' => $item['opsi_c'],
                    'opsi_d' => $item['opsi_d'],
                    'jawaban' => $item['jawaban'],
                ]);
            }
        }
    
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan.');
    }
    

    public function edit($id)
    {
        $tugas = Tugas::findOrFail($id);
        return view('admin.konten.edittugas', compact('tugas'));
    }

    public function update(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'tipe' => 'required|in:tugas,kuis,ujian_akhir,evaluasi_mingguan,tryout',
            'cover' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'deadline' => 'nullable|date',
            'status' => 'required|in:belum_selesai,selesai',
        ]);
        

        if ($request->hasFile('cover')) {
            if ($tugas->cover) {
                Storage::delete('public/cover_tugas/'.$tugas->cover);
            }
            $cover = $request->file('cover')->store('cover_tugas', 'public');
            $tugas->cover = basename($cover);
        }

        $tugas->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        if ($tugas->cover) {
            Storage::delete('public/cover_tugas/'.$tugas->cover);
        }
        $tugas->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }
    public function indexSiswa()
    {
        $userId = Auth::id();
    
        $tugas = Tugas::with(['tugasUser' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])
        ->orderBy('deadline', 'asc')
        ->get();
    
        return view('siswa.konten.tugas', compact('tugas'));
    }
    

    public function showSiswa($id)
    {
        $tugas = Tugas::with('soalKuis')->findOrFail($id);
    
        switch ($tugas->tipe) {
            case 'kuis':
            case 'ujian_akhir':
                return view('siswa.konten.detailkuis', compact('tugas'));
            default:
                return view('siswa.konten.detailtugas', compact('tugas'));
        }
    }
    
    public function submitKuis(Request $request, $id)
    {
        $tugas = Tugas::with('soalKuis')->findOrFail($id);
        $userId = Auth::id();
    
        $benar = 0;
        $totalSoal = $tugas->soalKuis->count();
    
        foreach ($request->jawaban as $soalId => $jawaban) {
            $soal = $tugas->soalKuis->firstWhere('id', $soalId);
    
            if ($soal && strtoupper($soal->jawaban) === strtoupper($jawaban)) {
                $benar++;
            }
    
            // Simpan jawaban
            JawabanKuis::updateOrCreate(
                [
                    'tugas_id' => $tugas->id,
                    'soal_kuis_id' => $soalId,
                    'user_id' => $userId
                ],
                [
                    'jawaban' => $jawaban
                ]
            );
        }
    
        // Hitung nilai
        $nilai = $totalSoal > 0 ? round(($benar / $totalSoal) * 100) : 0;
    
        // Simpan nilai dan status ke tugas_user
        TugasUser::updateOrCreate(
            [
                'tugas_id' => $tugas->id,
                'user_id' => $userId
            ],
            [
                'status' => 'selesai',
                'nilai' => $nilai,
                'catatan' => 'Nilai dihitung otomatis oleh sistem kuis'
            ]
        );
    
        return redirect()->route('siswa.tugas')->with('success', 'Kuis selesai. Nilai Anda: ' . $nilai);
    }
    

    public function kirimJawaban(Request $request, $id)
    {
        $request->validate([
            'jawaban' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $userId = Auth::id();
        $tugasUser = TugasUser::where('user_id', $userId)->where('tugas_id', $id)->first();

        if (!$tugasUser) {
            $tugasUser = new TugasUser();
            $tugasUser->user_id = $userId;
            $tugasUser->tugas_id = $id;
        }

        // Simpan file
        $path = $request->file('jawaban')->store('jawaban_siswa', 'public');

        $tugasUser->jawaban = basename($path);
        $tugasUser->status = 'selesai';
        $tugasUser->save();

        return redirect()->route('siswa.tugas')->with('success', 'Jawaban berhasil dikirim.');
    }

    public function showDetailKuis($id)
    {
        $tugas = Tugas::findOrFail($id);

        // Ambil semua siswa yang mengerjakan tugas ini (status selesai/belum)
        $pengumpulan = TugasUser::with('user')
            ->where('tugas_id', $id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.konten.detailkuis', compact('tugas', 'pengumpulan'));
    }


    public function showPengumpulan($id)
    {
        $tugas = Tugas::findOrFail($id);

        // Ambil data siswa yang sudah mengumpulkan tugas tersebut
        $pengumpulan = TugasUser::with('user')->where('tugas_id', $id)->get();


        return view('admin.konten.detailtugas', compact('tugas', 'pengumpulan'));
    }

    public function formInputNilai($id)
    {
        $tugasUser = TugasUser::with('user', 'tugas')->findOrFail($id);
        return view('admin.konten.inputnilai', compact('tugasUser'));
    }

    public function simpanNilai(Request $request)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string',
            'tugas_user_id' => 'required|exists:tugas_user,id',
        ]);

        $tugasUser = TugasUser::findOrFail($request->tugas_user_id);
        $tugasUser->nilai = $request->nilai;
        $tugasUser->catatan = $request->catatan;
        $tugasUser->save();

        return redirect()->route('tugas.index')->with('success', 'Nilai berhasil disimpan.');
    }

}
