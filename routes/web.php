<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\dashboardController;


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/siswa/dashboard', [DashboardController::class, 'indexsiswa'])->name('siswa.dashboard');
    Route::get('/admin/dashboard', [dashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/siswa/tambah', [AuthController::class, 'create'])->name('admin.siswa.create');
    Route::post('/admin/siswa/tambah', [AuthController::class, 'store'])->name('admin.siswa.store');
    Route::get('/admin/siswa/{id}', [AuthController::class, 'show'])->name('admin.siswa.detail');
    Route::post('/admin/siswa/{id}/dokumen', [AuthController::class, 'uploadDokumen'])->name('admin.siswa.upload_dokumen');
    Route::get('/admin/siswa/{id}/edit', [AuthController::class, 'edit'])->name('admin.siswa.edit');
    Route::post('/admin/siswa/{id}/update', [AuthController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{id}', [AuthController::class, 'destroy'])->name('admin.siswa.destroy');
    Route::get('/siswa', [AuthController::class, 'index'])->name('admin.siswa.index');
    Route::get('/rapot-siswa', [TugasController::class, 'nilaiRaporAdmin'])->name('admin.nilai');
    Route::get('/rapot-siswa/detail/{id}', [TugasController::class, 'detailNilai'])->name('detail.nilai');
    Route::get('/rapot-siswa/edit/{id}', [TugasController::class, 'edit'])->name('edit.rapot');
    Route::put('/rapot-siswa/update/{id}', [TugasController::class, 'update'])->name('rapot.update');





// Siswa
    Route::get('/tugas', [TugasController::class, 'indexSiswa'])->name('siswa.tugas');
    Route::post('/siswa/tugas/{id}/kirim', [TugasController::class, 'kirimJawaban'])->name('siswa.kirimJawaban');
    Route::get('/siswa/tugas/{id}', [TugasController::class, 'showSiswa'])->name('siswa.tugas.detail');
    Route::post('/kuis/{id}/jawab', [TugasController::class, 'submitKuis'])->name('kuis.jawab');
    Route::get('/ebook', [MateriController::class, 'siswaEbook'])->name('siswa.ebook');
    Route::get('/listening', [MateriController::class, 'siswaListening'])->name('siswa.listening');
    Route::get('/video', [MateriController::class, 'siswaVideo'])->name('siswa.video');
    Route::get('/sertifikat', [SertifikatController::class, 'siswaIndex'])->name('siswa.sertifikat');
    Route::get('/rapot', [dashboardController::class, 'nilaisiswa'])->name('siswa.nilai');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{roomId}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{roomId}/send', [ChatController::class, 'sendMessage'])->name('chat.send');

});



// Route::get('/chat', function () {
//     return view('siswa.konten.chat');
// });

// Route::get('/kelas/{id}', function ($id) {
//     $kelas = ['Kelas NIRUMA', 'Kelas INOVA', 'Kelas SUPREMA', 'Kelas VIRTUA'][$id - 1] ?? 'Nama Kelas';
//     return view('siswa.konten.isichat', ['kelas' => $kelas]);
// })->name('kelas.siswa.show');

// Route::get('/rapot', function () {
//     return view('siswa.konten.rapot');
// });

// Route::get('/sertifikat', function () {
//     return view('siswa.konten.sertifikat');
// });

// Route::get('/tugas', function () {
//     return view('siswa.konten.tugas');
// });


// Route::get('/profil', function () {
//     return view('siswa.konten.profil');
// });

Route::get('/profil', [ProfileController::class, 'profil'])->name('admin.profil');
Route::post('/siswa/profil/update', [ProfileController::class, 'updateProfilSiswa'])->name('siswa.update.profil');
Route::post('/siswa/profil/password', [ProfileController::class, 'updatePasswordSiswa'])->name('siswa.update.password');


// Route::get('/siswa/tugas/{id}', function ($id) {
//     return view('siswa.konten.detailtugas', ['id' => $id]);
// })->name('siswa.tugas.detail');

// Route::get('/siswa/kuis/{id}', function ($id) {
//     return view('siswa.konten.detailkuis', ['id' => $id]);
// })->name('siswa.kuis.detail');
// Route::get('/siswa/tugas/{id}', [TugasController::class, 'showSiswa'])->name('siswa.tugas.detail');
// Route::post('/kuis/{id}/jawab', action: [TugasController::class, 'submitKuis'])->name('kuis.jawab');



// Admin




Route::get('/profil-admin', [ProfileController::class, 'profilAdmin'])->name('admin.profil');
Route::post('/profil-admin/update', [AuthController::class, 'updateProfil'])->name('admin.update.profil');
Route::post('/profil-admin/password', [AuthController::class, 'updatePassword'])->name('admin.update.password');

// Route::get('/tambah-ebook', function () {
//     return view('admin.konten.tambahebook');
// });

// Route::get('/edit-ebook', function () {
//     return view('admin.konten.editebook');
// });

// Route::get('/ebook-admin', function () {
//     return view('admin.konten.ebook');
// });
Route::get('/tambah-materi/{tipe}', [MateriController::class, 'create'])->name('materi.create');
Route::post('/materi/store', [MateriController::class, 'store'])->name('materi.store');
Route::get('/edit-materi/{id}', [MateriController::class, 'edit'])->name('materi.edit');
Route::post('/update-materi/{id}', [MateriController::class, 'update'])->name('materi.update');
Route::delete('/hapus-materi/{id}', [MateriController::class, 'destroy'])->name('materi.destroy');


Route::get('/ebook-admin', [MateriController::class, 'indexEbook'])->name('materi.ebook');
Route::get('/listening-admin', [MateriController::class, 'indexListening'])->name('materi.listening');
Route::get('/video-admin', [MateriController::class, 'indexVideo'])->name('materi.video');

// Route::get('/listening-admin', action: function () {
//     return view('admin.konten.listening');
// });

// Route::get('/video-admin', function () {
//     return view('admin.konten.video');
// });

Route::get('/chat-admin', [ChatController::class, 'indexAdmin'])->name('chat.admin');
Route::get('/chat-admin/room/{id}', [ChatController::class, 'showAdmin'])->name('chat.admin.show');
Route::post('/chat-admin/room/{id}/send', [ChatController::class, 'sendMessageAdmin'])->name('chat.admin.send');
Route::get('/chat-admin/start/{userId}', [ChatController::class, 'startChatWithUser'])->name('chat.admin.start');
Route::post('/chat-admin/create-group', [ChatController::class, 'createGroup'])->name('chat.admin.createGroup');


Route::get('/input-nilai/{id}', [TugasController::class, 'formInputNilai'])->name('nilai.form');
Route::post('/simpan-nilai', [TugasController::class, 'simpanNilai'])->name('nilai.simpan');



// Route untuk detail tugas
// Route::get('/detail-tugas/{id}', function ($id) {
//     return view('admin.konten.detailtugas', ['id' => $id]);
// })->name('admin.tugas.detail');
Route::get('/tugas/{id}/pengumpulan', [TugasController::class, 'showPengumpulan'])->name('tugas.pengumpulan');


// Route untuk detail kuis
Route::get('/detail-kuis/{id}', [TugasController::class, 'showDetailKuis'])->name('admin.kuis.detail');



// Route::get('/sertifikat-admin', function () {
//     return view('admin.konten.sertifikat');
// });

// Route::get('/buat-sertifikat', function () {
//     return view('admin.konten.tambahsertifikat');
// });

// Route::get('/edit-sertifikat', function () {
//     return view('admin.konten.editsertifikat');
// });
Route::get('/sertifikat-admin', [SertifikatController::class, 'index'])->name('sertifikat.index');
Route::get('/buat-sertifikat', [SertifikatController::class, 'create'])->name('sertifikat.create');
Route::post('/simpan', [SertifikatController::class, 'store'])->name('sertifikat.store');
Route::get('/edit-sertifikat/{id}', [SertifikatController::class, 'edit'])->name('sertifikat.edit');
Route::post('/update/{id}', [SertifikatController::class, 'update'])->name('sertifikat.update');
Route::delete('/hapus/{id}', [SertifikatController::class, 'destroy'])->name('sertifikat.destroy');


Route::get('/tugas-admin', [TugasController::class, 'index'])->name('tugas.index');
Route::get('/tambah-tugas', [TugasController::class, 'create'])->name('tugas.create');
Route::post('/store-tugas', [TugasController::class, 'store'])->name('tugas.store');

Route::get('/edit-tugas/{id}', [TugasController::class, 'edit'])->name('tugas.edit');
Route::put('/update-tugas/{id}', [TugasController::class, 'update'])->name('tugas.update');

Route::delete('/hapus-tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');


// Route::get('/tugas-admin', function () {
//     return view('admin.konten.tugas');
// });

// Route::get('/tambah-tugas', function () {
//     return view('admin.konten.tambahtugas');
// });

// Route::get('/edit-tugas/{id}', function () {
//     return view('admin.konten.edittugas');
// });

// Route::get('/edit-kuis/{id}', function () {
//     return view('admin.konten.editkuis');
// });

// Route::get('/siswa', function () {
//     return view('admin.konten.siswa');
// });

// Route::get('/rapot-siswa', function () {
//     return view('admin.konten.rapotsiswa');
// });

// Route::get('/edit-rapot', function () {
//     return view('admin.konten.editrapot');
// });

// Route::get('/detail-nilai', function () {
//     return view('admin.konten.detailnilai');
// });
