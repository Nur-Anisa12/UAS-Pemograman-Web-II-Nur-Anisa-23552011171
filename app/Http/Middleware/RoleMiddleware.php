<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Cek apakah role-nya sesuai
        if (auth()->user()->role !== $role) {
            abort(403, 'Akses ditolak! Kamu tidak punya izin ke halaman ini.');
        }

        return $next($request);
    }
}