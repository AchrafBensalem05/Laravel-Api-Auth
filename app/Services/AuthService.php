<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'user',
        ]);
    }

    public function login(array $credentials): ?string
    {
        if (! $token = auth()->attempt($credentials)) {
            return null;
        }

        return $token;
    }

    public function logout(): void
    {
        auth()->logout();
    }
}
