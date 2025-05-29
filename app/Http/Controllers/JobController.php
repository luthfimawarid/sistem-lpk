<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobMatching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function adminIndex()
    {
        $jobs = JobMatching::withCount('jobApplications')->get(); // Hitung pelamar
        return view('admin.konten.jobmatching', compact('jobs'));
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

        // Cek lowongan
        $job = JobMatching::where('id', $jobId)->where('status', 'terbuka')->firstOrFail();

        // Cek apakah sudah melamar
        $alreadyApplied = JobApplication::where('job_matching_id', $jobId)->where('user_id', $userId)->exists();

        if ($alreadyApplied) {
            return redirect()->back()->with('error', 'Kamu sudah mengajukan lamaran untuk posisi ini.');
        }

        // Simpan lamaran
        JobApplication::create([
            'job_matching_id' => $jobId,
            'user_id' => $userId,
            'status' => 'diajukan',
        ]);

        return redirect()->back()->with('success', 'Lamaran berhasil diajukan.');
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
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();  // pastikan user login, kalau belum ada bisa diisi manual

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
            'lokasi' => 'required|string|max:255',  // tambah validasi lokasi
            'deskripsi' => 'required',
            'status' => 'required|in:terbuka,tertutup',
        ]);

        $job = JobMatching::findOrFail($id);
        $job->update($request->all());

        return redirect()->route('admin.job-matching.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $job = JobMatching::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.job-matching.index')->with('success', 'Lowongan berhasil dihapus.');
    }


}
