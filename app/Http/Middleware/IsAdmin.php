<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, \Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        // Cek: Jika user TIDAK punya role 'admin', tolak aksesnya
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak. Halaman ini khusus Admin.');
        }

        return $next($request);
    }
}
