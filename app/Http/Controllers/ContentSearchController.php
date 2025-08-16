<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Models\User;


class ContentSearchController extends Controller
{
    public function search(Request $request)
    {

    $query = $request->query('q');

    $chats = ChatRoom::with(['users', 'messages' => fn($qmsg) => $qmsg->latest()->limit(1)])
        ->where('type', 'private')
        ->get()
        ->filter(fn($room) => $room->users->where('id', '!=', auth()->id())->isNotEmpty())
        ->filter(fn($room) => 
            stripos(
                $room->users->where('id', '!=', auth()->id())->first()?->nama_lengkap ?? '',
                $query
            ) !== false
        );


        $students = User::where('role', 'like', 'siswa%')
            ->where('nama_lengkap', 'like', "%$query%")
            ->get();

        $tugas = Tugas::where('judul', 'like', "%$query%")->get();

        // Materi dibagi berdasarkan tipe
        $materiEbook = Materi::where('tipe', 'ebook')->where('judul', 'like', "%$query%")->get();
        $materiListening = Materi::where('tipe', 'listening')->where('judul', 'like', "%$query%")->get();
        $materiVideo = Materi::where('tipe', 'video')->where('judul', 'like', "%$query%")->get();
        $ujianAkhir = Tugas::where('tipe', 'ujian_akhir')->where('judul', 'like', "%$query%")->get();
        $tugasList = Tugas::where('tipe', 'tugas')->where('judul', 'like', "%$query%")->get();
        $kuisList = Tugas::where('tipe', 'kuis')->where('judul', 'like', "%$query%")->get();
        $evaluasiList = Tugas::where('tipe', 'evaluasi_mingguan')->where('judul', 'like', "%$query%")->get();
        $tryoutList = Tugas::where('tipe', 'tryout')->where('judul', 'like', "%$query%")->get();

        return view('partials.search-results', compact(
            'chats', 'students',
            'materiEbook', 'materiListening', 'materiVideo',
            'ujianAkhir', 'tugasList', 'kuisList', 'evaluasiList', 'tryoutList'
        ));

    }

}
