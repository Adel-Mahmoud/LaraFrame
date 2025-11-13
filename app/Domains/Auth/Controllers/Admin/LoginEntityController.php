<?php

namespace App\Domains\Auth\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Auth\Requests\AdminLoginRequest;
use App\Domains\Auth\Repositories\AdminRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LoginEntityController extends Controller
{
    protected $admins;

    public function __construct(AdminRepository $admins)
    {
        $this->admins = $admins;
    }

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return Route::has('admin.dashboard')
                ? redirect()->route('admin.dashboard')
                : redirect('/admin/dashboard');
        }

        return view('auth::admin.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($this->admins->attemptLogin($credentials)) {
            $request->session()->regenerate();
            
            return Route::has('admin.dashboard')
                ? redirect()->route('admin.dashboard')
                : redirect('/admin/dashboard');
        }

        return back()->with('error', 'بيانات تسجيل الدخول غير صحيحة.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}

// public function register(Request $request)
// {
//     $request->validate([
//         'name'     => 'required|string|max:255',
//         'email'    => 'required|string|email|unique:admins,email',
//         'password' => 'required|string|min:6|confirmed',
//     ]);

//     $admin = Admin::create([
//         'name'     => $request->name,
//         'email'    => $request->email,
//         'password' => Hash::make($request->password),
//     ]);

//     Auth::guard('admin')->login($admin);
    
//     return redirect()->route('/admin/dashboard');
// }
