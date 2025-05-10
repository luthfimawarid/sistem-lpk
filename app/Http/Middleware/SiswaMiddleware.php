<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session('user_role') !== 'siswa') {
            return redirect('/login')->withErrors(['login' => 'Akses ditolak']);
        }
        return $next($request);
    }
}
