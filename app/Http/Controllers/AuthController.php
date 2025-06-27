<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DokumenSiswa;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('siswa.login.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); // 👈 inilah yang aktifkan Auth::check() dan Auth::id()
        
            return $user->role === 'admin' 
                ? redirect()->route('admin.dashboard')
                : redirect()->route('siswa.dashboard');
        }
    
        return back()->withErrors(['login' => 'Email atau password salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    
    public function index()
    {
        // Ambil semua user yang rolenya "siswa"
        $siswas = User::where('role', 'siswa')->get();

        return view('admin.konten.siswa', compact('siswas'));
    }

    public function create() {
        return view('admin.konten.tambahsiswa');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'kelas' => 'required|string',
            'bidang' => 'required|string|in:Perawatan (Kaigo/Caregiver),Pembersihan Gedung,Konstruksi,Manufaktur Mesin Industri,Elektronik dan Listrik,Perhotelan,Pertanian,Perikanan,Pengolahan Makanan dan Minuman,Jasa Makanan',
            'foto' => 'nullable|image',
            'tanggal_lahir' => 'nullable|date',
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png'
        ]);


        $user = new User();
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->kelas = $request->kelas;
        $user->bidang = $request->bidang;
        $user->role = 'siswa';
        $user->tanggal_lahir = $request->tanggal_lahir;


        if ($request->hasFile('foto')) {
            $user->foto = $request->file('foto')->store('foto_siswa', 'public');
        }

        $user->save();

        // Simpan dokumen jika ada
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $jenis => $file) {
                if ($file) {
                    $path = $file->store('dokumen_siswa', 'public');
                    DokumenSiswa::create([
                        'user_id' => $user->id,
                        'jenis_dokumen' => $jenis,
                        'file' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa dan dokumen berhasil ditambahkan');
    }

    public function show($id) {
        $siswa = User::with(['dokumen', 'sertifikat'])->findOrFail($id);
        $dokumenList = ['Paspor', 'Visa', 'MCU', 'TTD Kontrak', 'Izin Tinggal', 'E-KTLN', 'Tiket Pesawat'];
        $dokumenUser = $siswa->dokumen->pluck('jenis_dokumen')->toArray();
        $statusLengkap = count(array_intersect($dokumenList, $dokumenUser)) === count($dokumenList);

        return view('admin.konten.detailsiswa', compact('siswa', 'statusLengkap'));
    }

    // Edit Dokumen
    public function editDokumen($siswaId, $dokumenId)
    {
        $siswa = User::findOrFail($siswaId);
        $dokumen = $siswa->dokumen()->findOrFail($dokumenId);

        return view('admin.konten.edit_dokumen', compact('siswa', 'dokumen'));
    }

    // Hapus Dokumen
    public function deleteDokumen($siswaId, $dokumenId)
    {
        $siswa = User::findOrFail($siswaId);
        $dokumen = $siswa->dokumen()->findOrFail($dokumenId);
        $dokumen->delete();

        return redirect()->route('admin.siswa.detail', $siswaId)->with('success', 'Dokumen berhasil dihapus.');
    }

    // Edit Sertifikat
    public function editSertifikat($siswaId, $sertifikatId)
    {
        $siswa = User::findOrFail($siswaId);
        $sertifikat = $siswa->sertifikat()->findOrFail($sertifikatId);

        return view('admin.konten.edit_sertifikat', compact('siswa', 'sertifikat'));
    }

    // Hapus Sertifikat
    public function deleteSertifikat($siswaId, $sertifikatId)
    {
        $siswa = User::findOrFail($siswaId);
        $sertifikat = $siswa->sertifikat()->findOrFail($sertifikatId);
        $sertifikat->delete();

        return redirect()->route('admin.siswa.detail', $siswaId)->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function uploadDokumen(Request $request, $id) {
        $request->validate([
            'jenis_dokumen' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $filePath = $request->file('file')->store('dokumen_siswa', 'public');

        DokumenSiswa::create([
            'user_id' => $id,
            'jenis_dokumen' => $request->jenis_dokumen,
            'file' => $filePath
        ]);

        return back()->with('success', 'Dokumen berhasil diupload');
    }

    public function edit($id)
    {
        $siswa = User::findOrFail($id);
        return view('admin.konten.editsiswa', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);
        
        $request->validate([
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $siswa->id,
            'kelas' => 'required|string',
        ]);

        $siswa->nama_lengkap = $request->nama_lengkap;
        $siswa->email = $request->email;
        $siswa->kelas = $request->kelas;

        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $siswa->foto = $request->file('foto')->store('foto_siswa', 'public');
        }

        $siswa->save();

        return redirect()->route('admin.konten.detail', $siswa->id)->with('success', 'Data siswa berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus');
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'status' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->status = $request->status;

        if ($request->hasFile('photo')) {
            // Hapus file lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $request->file('photo')->store('profile', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }

}
