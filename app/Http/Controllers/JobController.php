<?php

namespace App\Http\Controllers;

use App\Events\JobApplied;
use App\Models\Notifikasi; // ← ini penting
use App\Models\JobApplication;
use App\Models\JobMatching;
use Illuminate\Http\Request;
use App\Models\Tugas; // pastikan di atas ada ini
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function adminIndex(Request $request)
    {
        $sortField = $request->get('sort_by', 'posisi');
        $sortValue = $request->get('filter_value');

        // Validasi kolom yang diperbolehkan
        $allowedSortFields = ['posisi', 'bidang', 'lokasi', 'nama_perusahaan'];

        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'posisi';
        }

        // Ambil semua data yang sesuai filter (jika ada)
        $query = JobMatching::withCount('jobApplications');

        if ($sortValue) {
            $query->where($sortField, $sortValue);
        }

        $jobs = $query->orderBy($sortField)->get();

        // Ambil opsi unik dari DB
        $posisiOptions = JobMatching::select('posisi')->distinct()->pluck('posisi');
        $bidangOptions = JobMatching::select('bidang')->distinct()->pluck('bidang');
        $lokasiOptions = JobMatching::select('lokasi')->distinct()->pluck('lokasi');
        $perusahaanOptions = JobMatching::select('nama_perusahaan')->distinct()->pluck('nama_perusahaan');

        return view('admin.konten.jobmatching', compact(
            'jobs',
            'sortField',
            'sortValue',
            'posisiOptions',
            'bidangOptions',
            'lokasiOptions',
            'perusahaanOptions'
        ));
    }


    // Menampilkan pelamar untuk 1 job
    public function viewApplicants($id)
    {
        $job = JobMatching::findOrFail($id);
        $applicants = JobApplication::with('user')
            ->where('job_matching_id', $id)
            ->get();

        return view('admin.konten.detailjob', compact('job', 'applicants'));
    }

    public function apply($jobId)
    {
        $userId = Auth::id();

        $job = JobMatching::where('id', $jobId)
            ->where('status', 'terbuka')
            ->firstOrFail();

        $alreadyApplied = JobApplication::where('job_matching_id', $jobId)
            ->where('user_id', $userId)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->back()->with('error', 'Kamu sudah mengajukan lamaran untuk posisi ini.');
        }

        // Simpan lamaran
        JobApplication::create([
            'job_matching_id' => $jobId,
            'user_id' => $userId,
            'status' => 'diajukan',
        ]);

        // Tambahkan notifikasi
        Notifikasi::create([
            'user_id' => 1,
            'judul'   => 'Lamaran Baru',
            'pesan'   => Auth::user()->nama_lengkap . ' melamar posisi ' . $job->posisi . ' di ' . $job->nama_perusahaan,
            'tipe'    => 'Lamaran',
            'bidang'  => null, // karena nullable
            'dibaca'  => 0,
        ]);

        return redirect()->back()->with('success', 'Lamaran berhasil diajukan.');
    }



    public function updateApplication(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);
        $application->status = $request->status;
        $application->interview_message = $request->interview_message;
        $application->save();

        // (Opsional) Kirim notifikasi ke siswa, bisa pakai event/notification

        return back()->with('success', 'Lamaran diperbarui.');
    }


    public function create()
    {
        return view('admin.konten.tambah-edit', ['job' => new JobMatching()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'posisi' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required',
            'status' => 'required|in:terbuka,tertutup',
            'bidang' => 'required|string|max:255',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['butuh_sertifikat'] = $request->has('butuh_sertifikat'); // checkbox handling

        JobMatching::create($data);


        return redirect()->route('admin.job-matching.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $job = JobMatching::findOrFail($id);
        return view('admin.konten.tambah-edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'posisi' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required',
            'status' => 'required|in:terbuka,tertutup',
            'bidang' => 'required|string|max:255',
        ]);

        $job = JobMatching::findOrFail($id);

        $data = $request->all();
        $data['butuh_sertifikat'] = $request->has('butuh_sertifikat'); // checkbox: true if checked, false if not

        $job->update($data);

        return redirect()->route('admin.job-matching.index')->with('success', 'Lowongan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $job = JobMatching::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.job-matching.index')->with('success', 'Lowongan berhasil dihapus.');
    }

    public function index()
    {
        $user = auth()->user();
        $sertifikatLulus = $user->sertifikat()->count();
        $bidangSiswa = $user->bidang;

        // ✅ Cek nilai evaluasi mingguan di tabel tugas_user yang join dengan tugas
        $punyaNilaiEvaluasi = Tugas::join('tugas_user', 'tugas.id', '=', 'tugas_user.tugas_id')
            ->where('tugas_user.user_id', $user->id)
            ->where('tugas.tipe', 'evaluasi_mingguan')
            ->whereNotNull('tugas_user.nilai')
            ->exists();

        // ✅ Lowongan tanpa sertifikat hanya muncul kalau sudah ada nilai evaluasi mingguan
        $jobTanpaSertifikat = collect();
        if ($punyaNilaiEvaluasi) {
            $jobTanpaSertifikat = JobMatching::where('status', 'terbuka')
                ->where('butuh_sertifikat', false)
                ->where('bidang', $bidangSiswa)
                ->get();
        }

        // ✅ Lowongan yang butuh sertifikat
        $jobButuhSertifikat = $sertifikatLulus >= 2
            ? JobMatching::where('status', 'terbuka')
                ->where('butuh_sertifikat', true)
                ->where('bidang', $bidangSiswa)
                ->get()
            : collect();

        // ✅ Cek lamaran yang sudah dilakukan siswa
        $jobApplications = JobApplication::where('user_id', $user->id)
            ->get()
            ->keyBy('job_matching_id');

        return view('siswa.konten.job-matching', compact(
            'jobTanpaSertifikat',
            'jobButuhSertifikat',
            'jobApplications',
            'sertifikatLulus',
            'punyaNilaiEvaluasi'
        ));
    }






    // public function apply($id)
    // {
    //     $user = auth()->user();

    //     if (JobApplication::where('user_id', $user->id)->where('job_matching_id', $id)->exists()) {
    //         return back()->with('error', 'Kamu sudah melamar lowongan ini.');
    //     }

    //     JobApplication::create([
    //         'user_id' => $user->id,
    //         'job_matching_id' => $id,
    //         'status' => 'diajukan',
    //     ]);

    //     return back()->with('success', 'Lamaran berhasil diajukan.');
    // }



}
