<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::find(session('user_id'));
        return view('siswa.konten.profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(session('user_id'));

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'kelas' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->kelas = $request->kelas;

        // Jika ada upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::delete('public/foto/'.$user->foto);
            }

            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/foto', $filename);
            $user->foto = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
