<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role   = $request->get('role');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, fn($query) => $query->where('role', $role))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:admin,petugas',
        ], [
            'name.required'      => 'Nama wajib diisi!',
            'email.required'     => 'Email wajib diisi!',
            'email.unique'       => 'Email sudah digunakan!',
            'password.required'  => 'Password wajib diisi!',
            'password.min'       => 'Password minimal 8 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'role.required'      => 'Role wajib dipilih!',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        ActivityLogger::log(
            action: 'create',
            module: 'user',
            description: "Membuat akun baru: {$user->name} sebagai {$user->role}"
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil dibuat! ' . ucfirst($request->role) . ' bisa login sekarang.');
    }

    public function show(User $user)
    {
        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,petugas',
            // Password opsional saat edit
            'password' => 'nullable|min:8|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi!',
            'email.required'     => 'Email wajib diisi!',
            'email.unique'       => 'Email sudah digunakan!',
            'password.min'       => 'Password minimal 8 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        // Hanya update password kalau diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        ActivityLogger::log(
            action: 'update',
            module: 'user',
            description: "Mengubah akun: {$user->name}"
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        // Jangan sampai hapus diri sendiri!
        if ($user->id === Auth::user()->id) {
            return redirect()->back()
                ->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        $nama = $user->name;
        $user->delete();
        ActivityLogger::log(
            action: 'delete',
            module: 'user',
            description: "Menghapus akun: {$nama}"
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil dihapus!');
    }
}
