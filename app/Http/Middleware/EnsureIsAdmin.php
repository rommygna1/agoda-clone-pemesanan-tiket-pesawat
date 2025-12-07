<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek Login DAN Role (role === 'admin')
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jika gagal, tendang ke halaman depan
        return redirect('/');
    }
}