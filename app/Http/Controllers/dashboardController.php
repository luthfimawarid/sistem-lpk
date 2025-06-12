<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobMatching;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Sertifikat;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TugasUser;
use Illuminate\Support\Facades\Http;
use App\Models\ChatRoom;
// use App\Models\Tugas;


class dashboardController extends Controller
{
    public function index()
    {
        $courses = Materi::latest()->take(3)->get();
        $myCourses = Materi::where('status', 'aktif')->take(2)->get();
        $siswa = User::where('role', 'siswa')->latest()->take(5)->get();
        $materi = Materi::where('tipe', 'ebook')->where('status', 'aktif')->get();
        $tipe = 'ebook'; 


        // Ambil semua room milik admin saat ini (user login)
       $rooms = Auth::user()->chatRooms()
            ->with([
                'users',
                'messages' => function ($query) {
                    $query->latest()->limit(1);
                }
            ])
            ->latest('updated_at')
            ->get();

        return view('admin.konten.dashboard', compact('courses', 'myCourses', 'siswa', 'rooms', 'tipe','materi'));
    }

    public function indexsiswa()
    {
        $userId = Auth::id();

        $kuisBelumDikerjakan = Tugas::where('tipe', 'kuis')
            ->whereDate('deadline', '>=', now()) // hanya kuis yang masih aktif
            ->whereNotIn('id', function ($query) use ($userId) {
                $query->select('tugas_id')
                    ->from('tugas_user')
                    ->where('user_id', $userId);
            })
            ->exists(); // hanya true/false

            
            // Ambil data kursus, chat, nilai, dll seperti biasa...
        $materi = Materi::where('tipe', 'ebook')->where('status', 'aktif')->get();
        $courses = Materi::latest()->take(3)->get();
        $myCourses = Materi::where('status', 'aktif')->take(5)->get();
        $tanggalTerdaftar = Auth::user()->created_at->toDateString();

        $jobMatchings = [];
        $jobApplications = [];

        $sertifikatLulus = Sertifikat::where('user_id', $userId)->count();

        if ($sertifikatLulus >= 2) {
            $jobMatchings = JobMatching::where('status', 'terbuka')->get();

            // Ambil lamaran user untuk job yang ada
            $jobApplications = JobApplication::where('user_id', $userId)->get()->keyBy('job_matching_id');
        }

        // Ambil nilai tugas, evaluasi, tryout seperti biasa...
        $nilaiTugas = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')
            ->where('tugas_user.user_id', $userId)
            ->where('tugas.tipe', 'tugas')
            ->whereNotNull('tugas_user.nilai')
            ->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')
            ->orderBy('tanggal')
            ->get();

        $nilaiEvaluasi = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')
            ->where('tugas_user.user_id', $userId)
            ->where('tugas.tipe', 'evaluasi_mingguan')
            ->whereNotNull('tugas_user.nilai')
            ->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')
            ->orderBy('tanggal')
            ->get();

        $nilaiTryout = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')
            ->where('tugas_user.user_id', $userId)
            ->where('tugas.tipe', 'tryout')
            ->whereNotNull('tugas_user.nilai')
            ->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')
            ->orderBy('tanggal')
            ->get();

        $rooms = Auth::user()->chatRooms()
            ->with([
                'users',
                'messages' => function ($query) {
                    $query->latest()->limit(1);
                }
            ])
            ->latest('updated_at')
            ->get();

        // Rata-rata nilai
        $rataTugas = $nilaiTugas->avg('nilai') ?? 0;
        $rataEvaluasi = $nilaiEvaluasi->avg('nilai') ?? 0;
        $rataTryout = $nilaiTryout->avg('nilai') ?? 0;

        $hasilPrediksi = 'Belum diprediksi';
        $nilaiPersen = 0; // <- nilai skor dari API

        try {
            $response = Http::post('http://127.0.0.1:5001/prediksi', [
                'tugas' => $rataTugas,
                'evaluasi' => $rataEvaluasi,
                'tryout' => $rataTryout,
                'bobot_tugas' => 30,
                'bobot_evaluasi' => 30,
                'bobot_tryout' => 40,
            ]);

            if ($response->successful()) {
                $json = $response->json();
                $hasilPrediksi = $json['hasil'];
                $nilaiPersen = round($json['skor'], 2); // <- ambil nilai akhir dari API
            }
        } catch (\Exception $e) {
            $hasilPrediksi = 'Gagal memanggil API';
        }

        return view('siswa.konten.dashboard', compact(
            'courses',
            'rooms',
            'myCourses',
            'nilaiTugas',
            'nilaiEvaluasi',
            'nilaiTryout',
            'tanggalTerdaftar',
            'jobMatchings',
            'jobApplications',
            'sertifikatLulus',
            'hasilPrediksi',
            'nilaiPersen',
            'kuisBelumDikerjakan',
            'materi'
        ));
    }

    public function nilaisiswa()
    {
        $userId = Auth::id();

        $courses = Materi::latest()->take(3)->get();
        $tanggalTerdaftar = Auth::user()->created_at;
        $myCourses = Materi::where('status', 'aktif')->take(5)->get();

        // 🔹 Ambil data nilai lengkap (tanggal & nilai)
        $nilaiTugas = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')
            ->where('tugas_user.user_id', $userId)
            ->where('tugas.tipe', 'tugas')
            ->whereNotNull('tugas_user.nilai')
            ->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')
            ->orderBy('tanggal')
            ->get();

        $nilaiEvaluasi = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')
            ->where('tugas_user.user_id', $userId)
            ->where('tugas.tipe', 'evaluasi_mingguan')
            ->whereNotNull('tugas_user.nilai')
            ->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')
            ->orderBy('tanggal')
            ->get();

        $nilaiTryout = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')
            ->where('tugas_user.user_id', $userId)
            ->where('tugas.tipe', 'tryout')
            ->whereNotNull('tugas_user.nilai')
            ->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')
            ->orderBy('tanggal')
            ->get();

            
        $tugas = $nilaiTugas->pluck('nilai');
        $evaluasi = $nilaiEvaluasi->pluck('nilai');
        $tryout = $nilaiTryout->pluck('nilai');
            
        $rataTugas = $tugas->count() > 0 ? round($tugas->avg()) : 0;
        $rataEvaluasi = $evaluasi->count() > 0 ? round($evaluasi->avg()) : 0;
        $rataTryout = $tryout->count() > 0 ? round($tryout->avg()) : 0;
            
        function getStatus($nilai) {
            if ($nilai >= 75) return 'Lulus';
            if ($nilai >= 60) return 'Beresiko';
            if ($nilai === 0) return '-';
            return 'Tidak Lulus';
        }

        $statusTugas = getStatus($rataTugas);
        $statusEvaluasi = getStatus($rataEvaluasi);
        $statusTryout = getStatus($rataTryout);

        // 🔹 Prediksi Kelulusan pakai ML API
        $hasilPrediksi = 'Belum diprediksi';
        $nilaiPersen = 0;

        $warna = $hasilPrediksi == 'Lulus' ? 'green' : ($hasilPrediksi == 'Beresiko' ? 'orange' : 'red');
        $statusKelulusan = $hasilPrediksi;

        try {
            $response = Http::post('http://127.0.0.1:5001/prediksi', [
                'tugas' => $rataTugas,
                'evaluasi' => $rataEvaluasi,
                'tryout' => $rataTryout,
                'bobot_tugas' => 30,
                'bobot_evaluasi' => 30,
                'bobot_tryout' => 40,
            ]);

            if ($response->successful()) {
                $json = $response->json();
                $hasilPrediksi = $json['hasil'];
                $nilaiPersen = round($json['skor'], 2);
            }
        } catch (\Exception $e) {
            $hasilPrediksi = 'Gagal memanggil API';
        }

        return view('siswa.konten.rapot', compact(
            'courses', 'myCourses', 'nilaiTugas', 'nilaiEvaluasi', 'nilaiTryout',
            'rataTugas', 'rataEvaluasi', 'rataTryout', 'tanggalTerdaftar',
            'hasilPrediksi', 'nilaiPersen', 'statusKelulusan', 'warna',
            'statusTugas', 'statusEvaluasi', 'statusTryout'
        ));
    }
}
