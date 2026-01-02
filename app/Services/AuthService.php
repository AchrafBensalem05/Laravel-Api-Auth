<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // Password will be hashed by the model cast
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
