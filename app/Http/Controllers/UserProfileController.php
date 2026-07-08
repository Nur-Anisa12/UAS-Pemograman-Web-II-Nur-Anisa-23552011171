<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\ActivityLogger;

class UserProfileController extends Controller
{
    public function index()
    {
        /** @var User $user */        // ← tambah ini biar IDE tau tipe datanya
        $user    = Auth::user();
        $profile = $user->userprofile;
        return view('user-profile.index', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        /** @var User $user */        // ← tambah ini juga
        $user = Auth::user();

        $request->validate([
            'name'          => 'required|string|max:255',
            'no_telepon'    => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi!',
            'avatar.image'  => 'File harus berupa gambar!',
            'avatar.max'    => 'Ukuran foto maksimal 2MB!',
        ]);

        $user->update(['name' => $request->name]);

        ActivityLogger::log(
            action: 'update',
            module: 'profil',
            description: "Mengubah profil: {$user->name}"
        );

        $profileData = [
            'id_user'       => $user->id,
            'no_telepon'    => $request->no_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->userprofile && $user->userprofile->avatar) {
                Storage::disk('public')->delete($user->userprofile->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $profileData['avatar'] = $path;
        }

        UserProfile::updateOrCreate(
            ['id_user' => $user->id],
            $profileData
        );

        return redirect()->route('user-profile.index')
            ->with('success', 'Profil berhasil diupdate!');
    }
}
