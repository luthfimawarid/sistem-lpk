<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TugasUser;
// use App\Models\Tugas;


class dashboardController extends Controller
{
    public function index()
    {
        $courses = Materi::latest()->take(3)->get(); // Ongoing Courses
        $myCourses = Materi::where('status', 'aktif')->take(2)->get(); // Kursus Saya (contoh)
        $siswa = User::where('role', 'siswa')->latest()->take(5)->get();

        return view('admin.konten.dashboard', compact('courses', 'myCourses', 'siswa'));
    }

    public function indexsiswa()
    {
        $userId = Auth::id();

        $courses = Materi::latest()->take(3)->get();
        $myCourses = Materi::where('status', 'aktif')->take(5)->get();

        // Ambil nilai lengkap dengan tanggal
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

        return view('siswa.konten.dashboard', compact(
            'courses',
            'myCourses',
            'nilaiTugas',
            'nilaiEvaluasi',
            'nilaiTryout'
        ));
    }
    public function nilaisiswa()
    {
        $userId = Auth::id();

        $courses = Materi::latest()->take(3)->get();
        $myCourses = Materi::where('status', 'aktif')->take(5)->get();

        // 🔹 Ambil data nilai lengkap (tanggal & nilai) untuk grafik
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

        // 🔹 Ambil nilai saja untuk rata-rata
        $tugas = $nilaiTugas->pluck('nilai');
        $evaluasi = $nilaiEvaluasi->pluck('nilai');
        $tryout = $nilaiTryout->pluck('nilai');

        // 🔹 Hitung rata-rata
        $rataTugas = $tugas->count() > 0 ? round($tugas->avg()) : null;
        $rataEvaluasi = $evaluasi->count() > 0 ? round($evaluasi->avg()) : null;
        $rataTryout = $tryout->count() > 0 ? round($tryout->avg()) : null;

        // 🔹 Fungsi status lulus / belum
        $status = function ($nilai) {
            return $nilai >= 75 ? 'Lulus' : 'Belum Lulus';
        };

        return view('siswa.konten.rapot', compact(
            'courses',
            'myCourses',
            'nilaiTugas',
            'nilaiEvaluasi',
            'nilaiTryout',
            'rataTugas',
            'rataEvaluasi',
            'rataTryout',
            'status'
        ));
    }


}
