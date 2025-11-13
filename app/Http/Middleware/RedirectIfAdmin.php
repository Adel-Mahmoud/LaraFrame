<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RedirectIfAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            if (Route::has('admin.dashboard')) {
                return redirect()->route('admin.dashboard');
            }
            return redirect('/admin/dashboard');
        } else {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}