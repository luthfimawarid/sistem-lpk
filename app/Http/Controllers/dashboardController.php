<?php

namespace App\Http\Controllers;

use App\Models\BobotPenilaian;
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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use App\Models\ChatRoom;
// use App\Models\Tugas;


class dashboardController extends Controller
{
    public function index()
    {
        $courses = Materi::latest()->take(5)->get();
        $myCourses = Materi::where('status', 'aktif')->take(2)->get();
        $siswa = User::where('role', 'siswa')->latest()->take(5)->get();
        $materi = Materi::where('tipe', 'ebook')->where('status', 'aktif')->get();
        $tipe = 'ebook'; 


        // Ambil semua room milik admin saat ini (user login)
        $rooms = Auth::user()->chatRooms()
            ->with([
                'users' => function ($q) {
                    $q->where('role', 'siswa'); // ambil hanya siswa
                },
                'messages' => function ($query) {
                    $query->latest()->limit(1);
                }
            ])
            ->latest('updated_at')
            ->get()
            ->filter(function ($room) {
                // hanya tampilkan room jika siswa masih terdaftar
                return $room->users->isNotEmpty();
            });


        return view('admin.konten.dashboard', compact('courses', 'myCourses', 'siswa', 'rooms', 'tipe','materi'));
    }

    public function indexsiswa()
    {
        $userId = Auth::id();
        $user = Auth::user();
        $bidangUser = $user->bidang;

        // ... (Data non-prediksi lainnya)
        $kuisBelumDikerjakan = Tugas::where('tipe', 'kuis')->whereDate('deadline', '>=', now())->whereNotIn('id', function ($query) use ($userId) { $query->select('tugas_id')->from('tugas_user')->where('user_id', $userId); })->exists();
        $materi = Materi::where('tipe', 'ebook')->where('status', 'aktif')->where('bidang', $bidangUser)->get();
        $courses = Materi::where('status', 'aktif')->where('bidang', $bidangUser)->latest()->take(3)->get();
        $myCourses = Materi::where('status', 'aktif')->where('bidang', $bidangUser)->take(5)->get();
        $tanggalTerdaftar = $user->created_at->toDateString();
        $sertifikatLulus = Sertifikat::where('user_id', $userId)->count();
        $jobTanpaSertifikat = JobMatching::where('status', 'terbuka')->where('butuh_sertifikat', false)->where('bidang', $bidangUser)->get();
        $jobButuhSertifikat = $sertifikatLulus >= 2 ? JobMatching::where('status', 'terbuka')->where('butuh_sertifikat', true)->where('bidang', $bidangUser)->get() : collect();
        $jobApplications = JobApplication::where('user_id', $userId)->get()->keyBy('job_matching_id');
        $rooms = $user->chatRooms()->with(['users', 'messages' => fn ($query) => $query->latest()->limit(1)])->latest('updated_at')->get();

        // Panggil fungsi pembantu untuk mendapatkan data prediksi
        $prediksiData = $this->getPrediksiData();

        // Data untuk chart
        $nilaiTugas = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')->where('tugas_user.user_id', $userId)->where('tugas.tipe', 'tugas')->whereNotNull('tugas_user.nilai')->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')->orderBy('tanggal')->get();
        $nilaiEvaluasi = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')->where('tugas_user.user_id', $userId)->where('tugas.tipe', 'evaluasi_mingguan')->whereNotNull('tugas_user.nilai')->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')->orderBy('tanggal')->get();
        $nilaiTryout = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')->where('tugas_user.user_id', $userId)->where('tugas.tipe', 'tryout')->whereNotNull('tugas_user.nilai')->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')->orderBy('tanggal')->get();
        
        // Perbaikan: Cek jika jumlah nilai lengkap kurang dari 3
        $jumlahNilaiAktif = ($prediksiData['rataTugas'] !== null ? 1 : 0) + ($prediksiData['rataEvaluasi'] !== null ? 1 : 0) + ($prediksiData['rataTryout'] !== null ? 1 : 0);

        if ($jumlahNilaiAktif < 3) {
            $prediksiData['saran'] = 'Saat ini prediksi hanya dihitung berdasarkan nilai yang tersedia. Untuk hasil prediksi yang lebih akurat, lengkapi nilai dari Tugas, Evaluasi, dan Tryout.';
        }

        // Gunakan array asosiatif untuk mengoper data
        return view('siswa.konten.dashboard', [
            'courses' => $courses,
            'rooms' => $rooms,
            'myCourses' => $myCourses,
            'nilaiTugas' => $nilaiTugas,
            'nilaiEvaluasi' => $nilaiEvaluasi,
            'nilaiTryout' => $nilaiTryout,
            'tanggalTerdaftar' => $tanggalTerdaftar,
            'jobTanpaSertifikat' => $jobTanpaSertifikat,
            'jobButuhSertifikat' => $jobButuhSertifikat,
            'jobApplications' => $jobApplications,
            'sertifikatLulus' => $sertifikatLulus,
            'hasilPrediksi' => $prediksiData['hasilPrediksi'],
            'nilaiPersen' => $prediksiData['nilaiAkhir'],
            'kuisBelumDikerjakan' => $kuisBelumDikerjakan,
            'materi' => $materi,
            'saran' => $prediksiData['saran'],
            'rataTugas' => $prediksiData['rataTugas'],
            'rataEvaluasi' => $prediksiData['rataEvaluasi'],
            'rataTryout' => $prediksiData['rataTryout'],
        ]);
    }

    public function nilaisiswa()
    {
        $userId = Auth::id();

        // ... (Data non-prediksi lainnya)
        $courses = Materi::latest()->take(3)->get();
        $tanggalTerdaftar = Auth::user()->created_at;
        $myCourses = Materi::where('status', 'aktif')->take(5)->get();

        // Panggil fungsi pembantu untuk mendapatkan data prediksi
        $prediksiData = $this->getPrediksiData();

        // Data untuk chart
        $nilaiTugas = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')->where('tugas_user.user_id', $userId)->where('tugas.tipe', 'tugas')->whereNotNull('tugas_user.nilai')->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')->orderBy('tanggal')->get();
        $nilaiEvaluasi = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')->where('tugas_user.user_id', $userId)->where('tugas.tipe', 'evaluasi_mingguan')->whereNotNull('tugas_user.nilai')->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')->orderBy('tanggal')->get();
        $nilaiTryout = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')->where('tugas_user.user_id', $userId)->where('tugas.tipe', 'tryout')->whereNotNull('tugas_user.nilai')->selectRaw('DATE(tugas_user.created_at) as tanggal, tugas_user.nilai')->orderBy('tanggal')->get();

        // Status rapot
        $statusTugas = ($prediksiData['rataTugas'] !== null && $prediksiData['rataTugas'] >= 65) ? 'Baik' : 'Perlu Perbaikan';
        $statusEvaluasi = ($prediksiData['rataEvaluasi'] !== null && $prediksiData['rataEvaluasi'] >= 65) ? 'Baik' : 'Perlu Perbaikan';
        $statusTryout = ($prediksiData['rataTryout'] !== null && $prediksiData['rataTryout'] >= 65) ? 'Baik' : 'Perlu Perbaikan';
        $statusKelulusan = $prediksiData['hasilPrediksi'];
        $warnaKelulusan = 'text-gray-900';
        $warnaBox = 'bg-gray-200';
        $persenTampil = $prediksiData['nilaiAkhir'];
        $jumlahNilaiAktif = ($prediksiData['rataTugas'] !== null ? 1 : 0) + ($prediksiData['rataEvaluasi'] !== null ? 1 : 0) + ($prediksiData['rataTryout'] !== null ? 1 : 0);
        $hanyaSatuNilai = $jumlahNilaiAktif === 1;

        if ($statusKelulusan === 'Lulus') {
            $warnaKelulusan = 'text-green-600';
            $warnaBox = 'bg-green-600';
        } elseif ($statusKelulusan === 'Beresiko') {
            $warnaKelulusan = 'text-yellow-500';
            $warnaBox = 'bg-yellow-500';
        } elseif ($statusKelulusan === 'Tidak Lulus') {
            $warnaKelulusan = 'text-red-600';
            $warnaBox = 'bg-red-600';
        }

        $jumlahNilaiAktif = ($prediksiData['rataTugas'] !== null ? 1 : 0) + ($prediksiData['rataEvaluasi'] !== null ? 1 : 0) + ($prediksiData['rataTryout'] !== null ? 1 : 0);

        if ($jumlahNilaiAktif < 3) {
            $prediksiData['saran'] = 'Saat ini prediksi hanya dihitung berdasarkan nilai yang tersedia. Untuk hasil prediksi yang lebih akurat, lengkapi nilai dari Tugas, Evaluasi, dan Tryout.';
        }

        // Gunakan array asosiatif untuk mengoper data
        return view('siswa.konten.rapot', [
            'courses' => $courses,
            'myCourses' => $myCourses,
            'nilaiTugas' => $nilaiTugas,
            'nilaiEvaluasi' => $nilaiEvaluasi,
            'nilaiTryout' => $nilaiTryout,
            'rataTugas' => $prediksiData['rataTugas'],
            'rataEvaluasi' => $prediksiData['rataEvaluasi'],
            'rataTryout' => $prediksiData['rataTryout'],
            'tanggalTerdaftar' => $tanggalTerdaftar,
            'hasilPrediksi' => $prediksiData['hasilPrediksi'],
            'persenTampil' => $persenTampil,
            'statusKelulusan' => $statusKelulusan,
            'warnaBox' => $warnaBox,
            'warnaKelulusan' => $warnaKelulusan,
            'saran' => $prediksiData['saran'],
            'statusTugas' => $statusTugas,
            'statusEvaluasi' => $statusEvaluasi,
            'statusTryout' => $statusTryout,
            'hanyaSatuNilai' => $hanyaSatuNilai,
        ]);
    }

    private function getPrediksiData()
    {
        $userId = Auth::id();

        // Hitung rata-rata nilai mentah
        $rataTugas = TugasUser::where('user_id', $userId)->whereHas('tugas', fn ($q) => $q->where('tipe', 'tugas'))->avg('nilai');
        $rataEvaluasi = TugasUser::where('user_id', $userId)->whereHas('tugas', fn ($q) => $q->where('tipe', 'evaluasi_mingguan'))->avg('nilai');
        $rataTryout = TugasUser::where('user_id', $userId)->whereHas('tugas', fn ($q) => $q->where('tipe', 'tryout'))->avg('nilai');

        // Ambil bobot dinamis
        $bobotDB = BobotPenilaian::pluck('bobot', 'jenis_penilaian')->toArray();
        $bobotTugas = $bobotDB['tugas'] ?? 0;
        $bobotEvaluasi = $bobotDB['evaluasi_mingguan'] ?? 0;
        $bobotTryout = $bobotDB['tryout'] ?? 0;

        // Hitung nilai akhir berbobot
        $totalNilaiAktif = ($rataTugas ?? 0) * $bobotTugas + ($rataEvaluasi ?? 0) * $bobotEvaluasi + ($rataTryout ?? 0) * $bobotTryout;
        $totalBobotAktif = ($rataTugas !== null ? $bobotTugas : 0) + ($rataEvaluasi !== null ? $bobotEvaluasi : 0) + ($rataTryout !== null ? $bobotTryout : 0);
        $nilaiAkhir = $totalBobotAktif > 0 ? round($totalNilaiAktif / $totalBobotAktif) : 0;

        // Kirim nilai ke API sesuai format yang diminta (3 nilai terpisah)
        $hasilPrediksi = 'Belum ada prediksi';
        $saran = 'Belum ada data prediksi.';

        try {
            $response = Http::post('http://127.0.0.1:5001/prediksi', [
                'tugas' => $rataTugas ?? 0,
                'evaluasi' => $rataEvaluasi ?? 0,
                'tryout' => $rataTryout ?? 0,
            ]);

            if ($response->successful()) {
                $json = $response->json();
                $hasilPrediksi = $json['hasil'];
                $saran = $json['saran'];
            }
        } catch (\Exception $e) {
            $hasilPrediksi = 'Gagal memuat prediksi';
            $saran = 'Terjadi kesalahan...';
        }

        return [
            'rataTugas' => $rataTugas, 'rataEvaluasi' => $rataEvaluasi, 'rataTryout' => $rataTryout,
            'nilaiAkhir' => $nilaiAkhir, // Nilai berbobot tetap dihitung untuk tampilan
            'hasilPrediksi' => $hasilPrediksi,
            'saran' => $saran,
        ];
    }


    private function getNilaiTugas($userId): Collection
    {
        return TugasUser::with('tugas')
            ->where('user_id', $userId)
            ->whereHas('tugas', function ($query) {
                $query->where('tipe', 'tugas');
            })
            ->orderBy('id')
            ->pluck('nilai');
    }

    private function getNilaiEvaluasi($userId)
    {
        $nilai = TugasUser::join('tugas', 'tugas.id', '=', 'tugas_user.tugas_id')
            ->where('tugas_user.user_id', $userId)
            ->where('tugas.tipe', 'evaluasi_mingguan')
            ->whereNotNull('tugas_user.nilai')
            ->orderBy('tugas_user.id')
            ->pluck('tugas_user.nilai')
            ->toArray();

        // Isi default untuk 5 nilai evaluasi
        $nilaiLengkap = array_pad($nilai, 5, null); // null agar nanti ditampilkan sebagai '-'

        $rata = count(array_filter($nilaiLengkap, fn($n) => $n !== null)) > 0
            ? round(array_sum(array_filter($nilaiLengkap, fn($n) => $n !== null)) / count(array_filter($nilaiLengkap, fn($n) => $n !== null)), 2)
            : 0;

        return [
            'nilai' => $nilaiLengkap,
            'rata' => $rata,
        ];
    }

    private function getNilaiTryout($userId): array
    {
        $tryout = TugasUser::with('tugas')
            ->where('user_id', $userId)
            ->whereHas('tugas', function ($query) {
                $query->where('tipe', 'tryout');
            })
            ->orderBy('id')
            ->pluck('nilai');

        $choka1 = $tryout->get(0) ?? 0;
        $choka2 = $tryout->get(1) ?? 0;

        return [
            'nilai' => [round($choka1, 2), round($choka2, 2)],
            'rata' => round(($choka1 + $choka2) / 2, 2),
        ];
    }

    public function unduhRapor()
    {
        $user = auth()->user();

        $tugas = $this->getNilaiTugas($user->id);
        $evaluasi = $this->getNilaiEvaluasi($user->id);
        $tryout = $this->getNilaiTryout($user->id);

        $pdf = Pdf::loadView('siswa.konten.unduh', [
            'user' => $user,
            'tugas' => $tugas, // Collection
            'evaluasi' => $evaluasi['nilai'], // Array
            'tryout' => $tryout['nilai'],     // Array
            'rataTugas' => round($tugas->avg(), 2),
            'rataEvaluasi' => $evaluasi['rata'],
            'rataTryout' => $tryout['rata'],
        ]);

        return $pdf->download('Rapor-' . $user->nama_lengkap . '.pdf');
    }


}
