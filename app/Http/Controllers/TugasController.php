<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\SoalKuis;
use App\Models\JawabanKuis;
use App\Models\Notifikasi;
use App\Models\TugasUser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:tugas,kuis,ujian_akhir,evaluasi_mingguan,tryout',
            'cover' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'deadline' => 'nullable|date',
            'durasi' => 'nullable|integer|min:1',
            // 'status' => 'required|in:belum_selesai,selesai',
            'deskripsi' => 'required|string',
            'bidang' => 'required|string'
        ]);

        // Validasi khusus ujian akhir
        if ($request->tipe === 'ujian_akhir') {
            $request->validate([
                'durasi' => 'required|integer|min:1'
            ]);
        }

        // Handle upload cover
        $cover = null;
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('cover_tugas', 'public');
        }

        // Hitung deadline dan durasi
        $durasiMenit = null;
        if ($request->tipe === 'ujian_akhir') {
            $durasiMenit = (int)$request->durasi;
            $deadline = now()->addMinutes($durasiMenit);
        } else {
            $deadline = $request->deadline;
            
            // Reset durasi menit jika bukan ujian akhir
            if ($request->has('durasi')) {
                $durasiMenit = null;
            }
        }

        // Buat tugas
        $tugasData = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            // 'cover' => $cover,
            'deadline' => $deadline,
            'durasi_menit' => $durasiMenit,
            // 'status' => $request->status,
            'bidang' => $request->bidang
        ];

        $tugas = Tugas::create($tugasData);

        // Notifikasi
        $notification = [
            'judul' => 'Tugas Baru!',
            'pesan' => 'Ada tugas baru yang harus kamu kerjakan.',
            'tipe' => $request->tipe
        ];

        switch ($request->tipe) {
            case 'kuis':
                $notification['judul'] = 'Kuis Baru!';
                $notification['pesan'] = 'Ada kuis baru yang tersedia. Jangan lupa kerjakan ya.';
                break;
            case 'evaluasi_mingguan':
                $notification['judul'] = 'Evaluasi Mingguan Baru!';
                $notification['pesan'] = 'Yuk cek evaluasi minggu ini.';
                break;
            case 'tryout':
                $notification['judul'] = 'Tryout Baru!';
                $notification['pesan'] = 'Persiapkan dirimu! Tryout baru sudah tersedia.';
                break;
            case 'ujian_akhir':
                $notification['judul'] = 'Ujian Akhir!';
                $notification['pesan'] = 'Ujian akhir sudah tersedia. Waktu pengerjaan: '.$durasiMenit.' menit';
                break;
        }

        // Kirim notifikasi ke siswa
        User::where('role', 'siswa')
            ->where('bidang', $request->bidang)
            ->each(function ($user) use ($notification, $request) {
                Notifikasi::create([
                    'user_id' => $user->id,
                    'judul' => $notification['judul'],
                    'pesan' => $notification['pesan'],
                    'tipe' => $notification['tipe'],
                    'bidang' => $request->bidang, // pastikan kolom ini ada di tabel
                ]);
            });


        // Simpan soal jika diperlukan
        if (in_array($request->tipe, ['kuis', 'ujian_akhir','tryout']) && $request->has('soal')) {
            collect($request->soal)->each(function ($item) use ($tugas) {
                SoalKuis::create([
                    'tugas_id' => $tugas->id,
                    'pertanyaan' => $item['pertanyaan'],
                    'opsi_a' => $item['opsi_a'],
                    'opsi_b' => $item['opsi_b'],
                    'opsi_c' => $item['opsi_c'],
                    'opsi_d' => $item['opsi_d'],
                    'jawaban' => $item['jawaban'],
                ]);
            });
        }

        return redirect()->route('tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
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
        $user = Auth::user();

        // Ambil semua tugas yang bidang-nya sesuai dengan bidang siswa
        $tugas = Tugas::with(['tugasUser' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->where('bidang', $user->bidang)
            ->orderBy('deadline', 'asc')
            ->get();

        return view('siswa.konten.tugas', compact('tugas'));
    }

    public function showSiswa($id)
    {
        $userId = Auth::id();

        $tugas = Tugas::with(['tugasUser' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }, 'soalKuis'])->findOrFail($id);

        $userStatus = $tugas->tugasUser->first();

        // Cek apakah sudah lewat deadline
        $isExpired = false;
        if ($tugas->deadline) {
            $isExpired = \Carbon\Carbon::parse($tugas->deadline)->isPast();
        }

        switch ($tugas->tipe) {
            case 'kuis':
            case 'tryout':
            // case 'ujian_akhir':
                return view('siswa.konten.detailkuis', compact('tugas', 'userStatus', 'isExpired'));
            default:
                return view('siswa.konten.detailtugas', compact('tugas', 'userStatus', 'isExpired'));
        }
    }

    public function showSoalUjian($id, $nomor)
    {
        $userId = Auth::id();
        $tugas = Tugas::with(['soalKuis.jawabanKuis' => function($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->findOrFail($id);

        // Set waktu mulai di session jika belum ada
        if (!session()->has('ujian_waktu_mulai_'.$id)) {
            session(['ujian_waktu_mulai_'.$id => now()->toISOString()]); // Format ISO
        }

        $soal = $tugas->soalKuis->sortBy('id')->values()->get($nomor - 1);

        if (!$soal) {
            return redirect()->route('siswa.tugas.ujian.selesai', $id);
        }

        $totalSoal = $tugas->soalKuis->count();
        $jawabanUser = $soal->jawabanKuis->where('user_id', $userId)->first();

        return view('siswa.konten.ujiansoal', [
            'tugas' => $tugas,
            'soal' => $soal,
            'nomor' => $nomor,
            'totalSoal' => $totalSoal,
            'jawabanUser' => $jawabanUser,
            'waktuMulai' => session('ujian_waktu_mulai_'.$id)
        ]);
    }

    public function simpanJawaban(Request $request, $id)
    {
        $userId = Auth::id();
        $soalId = $request->input('soal_id');
        $jawaban = $request->input('jawaban');

        \Log::info('Menyimpan jawaban', [
            'user_id' => $userId,
            'soal_id' => $soalId,
            'jawaban' => $jawaban
        ]);

        try {
            // Simpan jawaban
            $jawaban = JawabanKuis::updateOrCreate(
                [
                    'user_id' => $userId,
                    'soal_kuis_id' => $soalId
                ],
                [
                    'tugas_id' => $id,
                    'jawaban' => $jawaban,
                    'updated_at' => now()
                ]
            );

            \Log::info('Jawaban tersimpan', ['jawaban_id' => $jawaban->id]);

            // Hitung nilai
            $nilai = $this->hitungNilaiUjian($id, $userId);

            return response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil disimpan',
                'nilai' => $nilai // Tambahkan nilai dalam response untuk debugging
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan jawaban', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan jawaban'], 500);
        }
    }

    protected function hitungNilaiUjian($tugasId, $userId)
    {
        // Load data dengan relasi yang diperlukan
        $tugas = Tugas::with(['soalKuis' => function($query) {
            $query->select('id', 'tugas_id', 'jawaban');
        }])->find($tugasId);

        $jawabanUser = JawabanKuis::where('tugas_id', $tugasId)
                                ->where('user_id', $userId)
                                ->get(['id', 'soal_kuis_id', 'jawaban']);

        $totalSoal = $tugas->soalKuis->count();
        $jawabanBenar = 0;

        foreach ($jawabanUser as $jawaban) {
            $soal = $tugas->soalKuis->firstWhere('id', $jawaban->soal_kuis_id);
            
            // Debugging - log perbandingan jawaban
            \Log::info('Comparing answers', [
                'user_answer' => $jawaban->jawaban,
                'correct_answer' => $soal->jawaban ?? null,
                'is_correct' => $soal && strtoupper(trim($jawaban->jawaban)) === strtoupper(trim($soal->jawaban))
            ]);

            if ($soal && strtoupper(trim($jawaban->jawaban)) === strtoupper(trim($soal->jawaban))) {
                $jawabanBenar++;
            }
        }

        $nilai = $totalSoal > 0 ? round(($jawabanBenar / $totalSoal) * 100, 2) : 0;

        // Debugging - log sebelum menyimpan
        \Log::info('Saving nilai', [
            'user_id' => $userId,
            'tugas_id' => $tugasId,
            'nilai' => $nilai,
            'jawaban_benar' => $jawabanBenar,
            'total_soal' => $totalSoal
        ]);

        // Simpan nilai
        TugasUser::updateOrCreate(
            [
                'user_id' => $userId,
                'tugas_id' => $tugasId
            ],
            [
                'nilai' => $nilai,
                'status' => 'selesai',
                'updated_at' => now()
            ]
        );
        
        return $nilai;
    }

    public function selesaiUjian($id)
    {
        $tugas = Tugas::findOrFail($id);
        
        // Update status user menjadi selesai dan ambil data nilai
        $tugasUser = TugasUser::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'tugas_id' => $id
            ],
            [
                'status' => 'selesai',
                'updated_at' => now()
            ]
        );

        return view('siswa.konten.ujianselesai', compact('tugas', 'tugasUser'));
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

        $nilai = $totalSoal > 0 ? round(($benar / $totalSoal) * 100) : 0;

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

        return response()->json([
            'success' => true,
            'nilai' => $nilai
        ]);
    }

    public function kirimJawaban(Request $request, $id)
    {
        $request->validate([
            'jawaban' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $tugas = Tugas::findOrFail($id);
        $userId = Auth::id();
        $tugasUser = TugasUser::where('user_id', $userId)->where('tugas_id', $id)->first();

        if (!$tugasUser) {
            $tugasUser = new TugasUser();
            $tugasUser->user_id = $userId;
            $tugasUser->tugas_id = $id;
        }
            
        if ($tugas->deadline && \Carbon\Carbon::parse($tugas->deadline)->isPast()) {
            return back()->with('error', 'Waktu pengumpulan sudah berakhir.');
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

    public function showDetailUjian($id)
    {
        $tugas = Tugas::with([
            'tugasUser.user',
            'soalKuis',
            'tugasUser.jawabanKuis' // Tambahkan eager loading untuk jawaban
        ])->findOrFail($id);
        
        return view('admin.konten.detailujian', [
            'tugas' => $tugas
        ]);
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

    public function nilaiRaporAdmin()
    {
        $siswa = User::where('role', 'siswa')->get();

        $data = $siswa->map(function ($user) {
            $tugasUser = $user->tugasUser()->with('tugas')->get();

            // Nilai per tipe
            $nilaiTugas = $tugasUser->where('tugas.tipe', 'tugas')->pluck('nilai')->filter()->avg();
            $nilaiEvaluasi = $tugasUser->where('tugas.tipe', 'evaluasi_mingguan')->pluck('nilai')->filter()->avg();
            $nilaiTryout = $tugasUser->where('tugas.tipe', 'tryout')->pluck('nilai')->filter()->avg();

            // Bobot nilai
            $bobotTugas = 0.3;
            $bobotEvaluasi = 0.3;
            $bobotTryout = 0.4;

            $nilaiTugas = $nilaiTugas ?? 0;
            $nilaiEvaluasi = $nilaiEvaluasi ?? 0;
            $nilaiTryout = $nilaiTryout ?? 0;

            // Rata-rata keseluruhan berbobot
            $rataKeseluruhan = ($nilaiTugas * $bobotTugas) + ($nilaiEvaluasi * $bobotEvaluasi) + ($nilaiTryout * $bobotTryout);
            $rataKeseluruhan = round($rataKeseluruhan, 2);

            // Prediksi kelulusan
            if ($rataKeseluruhan > 65) {
                $prediksi = 'Lulus';
            } elseif ($rataKeseluruhan >= 60) {
                $prediksi = 'Beresiko';
            } else {
                $prediksi = 'Tidak Lulus';
            }

            return [
                'nama' => $user->nama_lengkap,
                'kelas' => $user->kelas ?? '-',
                'bidang' => $user->bidang ?? '-',
                'nilai_tugas' => $nilaiTugas ? round($nilaiTugas) : '-',
                'nilai_evaluasi' => $nilaiEvaluasi ? round($nilaiEvaluasi) : '-',
                'nilai_tryout' => $nilaiTryout ? round($nilaiTryout) : '-',
                'rata_keseluruhan' => $rataKeseluruhan,
                'prediksi' => $prediksi,
                'id' => $user->id,
            ];
        });

        return view('admin.konten.rapotsiswa', compact('data'));
    }

    public function detailNilai($id)
    {
        $user = User::with(['tugasUser.tugas'])->findOrFail($id);

        $dataTugas = $user->tugasUser->map(function ($item) {
            return [
                'tanggal' => $item->created_at->format('d M Y'),
                'pelajaran' => $item->tugas->judul ?? '-',
                'tipe' => $item->tugas->tipe ?? '-',
                'catatan' => $item->catatan ?? '-',
                'status' => $item->status ?? 'Belum dikoreksi',
                'nilai' => $item->nilai ?? '-', // Tambahkan ini
            ];
        });


        return view('admin.konten.detailnilai', [
            'user' => $user,
            'dataTugas' => $dataTugas,
        ]);
    }

    public function editNilaiTipe($id, $tipe)
    {
        $user = User::findOrFail($id);
        $nilai = $user->nilai; // pastikan relasi 'nilai' sudah ada
        return view('admin.konten.editnilai', compact('user', 'nilai', 'tipe'));
    }

    public function updateNilaiTipe(Request $request, $id, $tipe)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        // Cari tugas dengan tipe yang dimaksud
        $tugas = Tugas::where('tipe', $tipe)->first();

        if (!$tugas) {
            return back()->with('error', 'Tugas dengan tipe tersebut tidak ditemukan.');
        }

        // Cari tugas_user berdasarkan user dan tugas
        $tugasUser = TugasUser::firstOrNew([
            'user_id' => $user->id,
            'tugas_id' => $tugas->id,
        ]);

        $tugasUser->nilai = $request->nilai;
        $tugasUser->save();

        // Hitung prediksi kelulusan
        $nilaiTugas = TugasUser::where('user_id', $user->id)
            ->whereHas('tugas', fn($q) => $q->where('tipe', 'tugas'))
            ->value('nilai');

        $nilaiEvaluasi = TugasUser::where('user_id', $user->id)
            ->whereHas('tugas', fn($q) => $q->where('tipe', 'evaluasi'))
            ->value('nilai');

        $nilaiTryout = TugasUser::where('user_id', $user->id)
            ->whereHas('tugas', fn($q) => $q->where('tipe', 'tryout'))
            ->value('nilai');

        if ($nilaiTugas !== null && $nilaiEvaluasi !== null && $nilaiTryout !== null) {
            $total = 0.3 * $nilaiTugas + 0.3 * $nilaiEvaluasi + 0.4 * $nilaiTryout;
            $prediksi = $total > 65 ? 'Lulus' : ($total >= 60 ? 'Beresiko' : 'Tidak Lulus');

            // Simpan prediksi ke kolom tambahan jika kamu punya, atau tampilkan saja di view
            $user->prediksi = $prediksi;
            $user->save();
        }

        return redirect()->route('admin.nilai')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function detailNilaiSiswa(Request $request)
    {
        $tipe = $request->query('tipe');

        // Validasi tipe
        if (!in_array($tipe, ['tugas', 'evaluasi_mingguan', 'tryout'])) {
            abort(404);
        }

        $userId = auth()->id();

        $nilai = DB::table('tugas_user')
            ->join('tugas', 'tugas_user.tugas_id', '=', 'tugas.id')
            ->where('tugas_user.user_id', $userId)
            ->where('tugas.tipe', $tipe)
            ->select('tugas.judul', 'tugas_user.nilai', 'tugas_user.created_at')
            ->orderBy('tugas_user.created_at', 'desc')
            ->get();

        return view('siswa.konten.detailnilai', compact('nilai', 'tipe'));
    }




}
