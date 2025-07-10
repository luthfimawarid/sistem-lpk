<?php

namespace App\Http\Controllers;
// ChatController.php

use App\Models\ChatRoom;
use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // List semua chat room yang user tergabung (grup kelas dan private chat)
    public function index()
    {
        $user = Auth::user();
        $rooms = $user->chatRooms()->with(['users', 'messages' => function($q) {
            $q->latest()->limit(1);
        }])->get();

        // jika mau munculkan grup kelas secara default jika user ada di kelas tertentu,
        // bisa gabungkan dengan query grup kelas yang user tergabung

        return view('siswa.konten.chat', compact('rooms'));
    }

    // Tampilkan isi chat room tertentu
    public function show($roomId)
    {
        $user = Auth::user();
        $room = ChatRoom::with(['users', 'messages.user'])->findOrFail($roomId);

        // Pastikan user tergabung di room
        if (!$room->users->contains($user->id)) {
            abort(403, 'Anda tidak tergabung di room ini.');
        }

        return view('siswa.konten.isichat', compact('room'));
    }

    // Kirim pesan ke room
    public function sendMessage(Request $request, $roomId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $room = ChatRoom::findOrFail($roomId);

        // Pastikan user tergabung di room
        if (!$room->users->contains($user->id)) {
            abort(403, 'Anda tidak tergabung di room ini.');
        }

        $message = ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $user->id,
            'message' => $request->message,
        ]);

        // Redirect kembali ke halaman chat
        return redirect()->route('chat.show', $room->id);
    }

    public function indexAdmin()
    {
        $admin = Auth::user();

        // Ambil semua siswa aktif
        $allStudents = User::where('role', 'like', 'siswa%')->get();

        // Ambil semua private chat room yang dimiliki admin
        $privateRooms = $admin->chatRooms()
            ->with([
                'users' => function ($q) {
                    $q->whereNotNull('users.id');
                },
                'messages' => function ($query) {
                    $query->latest()->limit(1);
                }
            ])
            ->where('type', 'private')
            ->get()
            ->filter(function ($room) use ($admin) {
                return $room->users->where('id', '!=', $admin->id)->isNotEmpty();
            });

        // Ambil ID siswa yang sudah punya chat dengan admin
        $studentIdsWithChat = $privateRooms->map(function ($room) use ($admin) {
            return $room->users->where('id', '!=', $admin->id)->first()?->id;
        })->filter()->values();

        // Siswa yang belum pernah chatting
        $additionalChats = $allStudents
            ->whereNotIn('id', $studentIdsWithChat)
            ->map(function ($siswa) use ($admin) {
                return (object)[
                    'type' => 'private',
                    'users' => collect([(object)[
                        'id' => $siswa->id,
                        'nama_lengkap' => $siswa->nama_lengkap,
                    ]]),
                    'messages' => collect(),
                    'id' => null,
                ];
            });

        // Ambil semua grup yang melibatkan admin
        $allGroups = ChatRoom::with([
                'users',
                'messages' => function ($q) {
                    $q->latest()->limit(1);
                }
            ])
            ->where('type', 'group')
            ->whereHas('users', function ($q) use ($admin) {
                $q->where('users.id', $admin->id);
            })
            ->get();

        // Gabungkan semua room: private + siswa belum chatting + grup
        $rooms = $privateRooms->concat($additionalChats)->concat($allGroups);

        // Kelompokkan siswa berdasarkan kelas
        $groupedByClass = $allStudents->groupBy('kelas');

        return view('admin.konten.chat', [
            'groupedStudents' => $groupedByClass,
            'allStudents' => $allStudents,
            'allGroups' => $allGroups,
            'rooms' => $rooms,
        ]);
    }


    public function showAdmin($id)
    {
        $room = ChatRoom::with(['users', 'messages.user'])->findOrFail($id);
        $allStudents = User::where('role', 'siswa')->get();

        $otherUser = null;

        // Jika bukan grup, ambil user lain selain admin
        if ($room->type === 'private') {
            $otherUser = $room->users->where('id', '!=', auth()->id())->first();
        }

        return view('admin.konten.isichat', [
            'room' => $room,
            'allStudents' => $allStudents,
            'otherUser' => $otherUser
        ]);
    }


    public function sendMessageAdmin(Request $request, $roomId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $room = ChatRoom::findOrFail($roomId);

        ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('chat.admin.show', $roomId);
    }

    public function startChatBetweenStudents($userId)
    {
        $currentUser = auth()->user();
        $targetUser = User::where('role', 'siswa')->findOrFail($userId);

        // Cek apakah room private sudah ada antara siswa
        $room = ChatRoom::whereHas('users', fn($q) => $q->where('user_id', $currentUser->id))
            ->whereHas('users', fn($q) => $q->where('user_id', $targetUser->id))
            ->withCount('users')
            ->get()
            ->filter(fn($r) => $r->users_count === 2 && $r->type === 'private') // hanya room private berdua
            ->first();

        // Buat room baru jika belum ada
        if (!$room) {
            $room = ChatRoom::create([
                'type' => 'private',
            ]);
            $room->users()->attach([$currentUser->id, $targetUser->id]);
        }

        return redirect()->route('chat.show', $room->id);
    }


    public function startChatWithUser($userId)
    {
        $admin = auth()->user();
        $user = User::findOrFail($userId);

        // Cari room private yang hanya antara admin dan user ini
        $room = ChatRoom::whereHas('users', fn($q) => $q->where('user_id', $admin->id))
            ->whereHas('users', fn($q) => $q->where('user_id', $user->id))
            ->withCount('users')
            ->get()
            ->filter(fn($r) => $r->users_count === 2) // pastikan hanya berdua
            ->first();

        // Jika belum ada, buat room baru
        if (!$room) {
            $room = ChatRoom::create([
                'name' => null, // bisa diset juga jadi "Admin & {nama_siswa}"
            ]);
            $room->users()->attach([$admin->id, $user->id]);
        }

        return redirect()->route('chat.admin.show', $room->id);
    }

    public function createGroup(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string|max:255',
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:users,id',
        ]);

        // Buat chat room dengan tipe group
        $room = ChatRoom::create([
            'name' => $request->kelas,
            'kelas' => $request->kelas,
            'type' => 'group',
        ]);

        // Tambahkan admin dan siswa ke grup
        $room->users()->attach(array_merge($request->siswa_ids, [auth()->id()]));

        return redirect()->route('chat.admin.show', $room->id)->with('success', 'Grup berhasil dibuat!');
    }

    public function addUserToGroup(Request $request, $roomId)
    {
        $request->validate([
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:users,id',
        ]);

        $room = ChatRoom::findOrFail($roomId);

        // Pastikan hanya grup yang bisa ditambahkan user
        if ($room->type !== 'group') {
            return redirect()->back()->with('error', 'Hanya grup yang bisa ditambahkan peserta.');
        }

        // Tambahkan siswa yang belum tergabung
        foreach ($request->siswa_ids as $siswaId) {
            if (!$room->users->contains($siswaId)) {
                $room->users()->attach($siswaId);
            }
        }

        return redirect()->route('chat.admin.show', $roomId)->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function updateGroup(Request $request, $roomId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $room = ChatRoom::findOrFail($roomId);
        $room->name = $request->name;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('group_photos', 'public');
            $room->photo = $path;
        }

        $room->save();

        return back()->with('success', 'Grup berhasil diperbarui');
    }

    public function removeUser($roomId, $userId)
    {
        $room = ChatRoom::findOrFail($roomId);
        $room->users()->detach($userId);

        return back()->with('success', 'Anggota dikeluarkan dari grup');
    }

    public function deleteGroup($id)
    {
        $admin = Auth::user();

        $group = ChatRoom::where('id', $id)
            ->where('type', 'group')
            ->whereHas('users', function ($q) use ($admin) {
                $q->where('users.id', $admin->id);
            })
            ->first();

        if (!$group) {
            return redirect()->back()->with('error', 'Grup tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // Hapus relasi user dan pesan dulu jika pakai foreign key constraint
        $group->messages()->delete();
        $group->users()->detach();

        // Hapus grup
        $group->delete();

        return redirect()->route('chat.admin')->with('success', 'Grup berhasil dihapus.');
    }

}
