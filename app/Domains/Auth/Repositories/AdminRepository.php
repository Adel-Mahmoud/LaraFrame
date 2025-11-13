<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRepository
{
    public function create(array $data)
    {
        return Admin::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function attemptLogin(array $credentials): bool
    {
        return auth('admin')->attempt($credentials);
    }
}
