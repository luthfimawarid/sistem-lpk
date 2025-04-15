<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('siswa.login.login');
});

Route::get('/dashboard', function () {
    return view('siswa.konten.dashboard');
});

Route::get('/ebook', function () {
    return view('siswa.konten.ebook');
});

Route::get('/listening', action: function () {
    return view('siswa.konten.listening');
});

Route::get('/video', function () {
    return view('siswa.konten.video');
});

Route::get('/chat', function () {
    return view('siswa.konten.chat');
});

Route::get('/kelas/{id}', function ($id) {
    $kelas = ['Kelas NIRUMA', 'Kelas INOVA', 'Kelas SUPREMA', 'Kelas VIRTUA'][$id - 1] ?? 'Nama Kelas';
    return view('siswa.konten.isichat', ['kelas' => $kelas]);
})->name('kelas.siswa.show');

Route::get('/rapot', function () {
    return view('siswa.konten.rapot');
});

Route::get('/sertifikat', function () {
    return view('siswa.konten.sertifikat');
});

Route::get('/tugas', function () {
    return view('siswa.konten.tugas');
});

Route::get('/siswa/tugas/{id}', function ($id) {
    return view('siswa.konten.detailtugas', ['id' => $id]);
})->name('siswa.tugas.detail');

Route::get('/siswa/kuis/{id}', function ($id) {
    return view('siswa.konten.detailkuis', ['id' => $id]);
})->name('siswa.kuis.detail');



// Admin

Route::get('/admin', function () {
    return view('admin.konten.dashboard');
});

Route::get('/tambah-ebook', function () {
    return view('admin.konten.tambahebook');
});

Route::get('/edit-ebook', function () {
    return view('admin.konten.editebook');
});

Route::get('/ebook-admin', function () {
    return view('admin.konten.ebook');
});

Route::get('/listening-admin', action: function () {
    return view('admin.konten.listening');
});

Route::get('/video-admin', function () {
    return view('admin.konten.video');
});

Route::get('/chat-admin', function () {
    return view('admin.konten.chat');
});

Route::get('/kelas-admin/{id}', function ($id) {
    $kelas = ['Kelas NIRUMA', 'Kelas INOVA', 'Kelas SUPREMA', 'Kelas VIRTUA'][$id - 1] ?? 'Nama Kelas';
    return view('admin.konten.isichat', ['kelas' => $kelas]);
})->name('kelas.admin.show');

Route::get('/input-nilai/{id}', function ($id) {
    return view('admin.konten.inputnilai', ['id' => $id]);
});

// Route untuk detail tugas
Route::get('/detail-tugas/{id}', function ($id) {
    return view('admin.konten.detailtugas', ['id' => $id]);
})->name('admin.tugas.detail');

// Route untuk detail kuis
Route::get('/detail-kuis/{id}', function ($id) {
    return view('admin.konten.detailkuis', ['id' => $id]);
})->name('admin.kuis.detail');


Route::get('/sertifikat-admin', function () {
    return view('admin.konten.sertifikat');
});

Route::get('/buat-sertifikat', function () {
    return view('admin.konten.tambahsertifikat');
});

Route::get('/edit-sertifikat', function () {
    return view('admin.konten.editsertifikat');
});

Route::get('/tugas-admin', function () {
    return view('admin.konten.tugas');
});

Route::get('/tambah-tugas', function () {
    return view('admin.konten.tambahtugas');
});

Route::get('/edit-tugas/{id}', function () {
    return view('admin.konten.edittugas');
});

Route::get('/edit-kuis/{id}', function () {
    return view('admin.konten.editkuis');
});

Route::get('/siswa', function () {
    return view('admin.konten.siswa');
});

Route::get('/rapot-siswa', function () {
    return view('admin.konten.rapotsiswa');
});

Route::get('/edit-rapot', function () {
    return view('admin.konten.editrapot');
});

Route::get('/detail-nilai', function () {
    return view('admin.konten.detailnilai');
});
