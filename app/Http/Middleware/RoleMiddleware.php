<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        // Kalau belum login, arahkan ke login
        if (! $user) {
            return redirect()->route('login');
        }

        // Cek apakah role user ada di list yang diizinkan
        if (! in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki hak akses.');
        }

        return $next($request);
    }
}
