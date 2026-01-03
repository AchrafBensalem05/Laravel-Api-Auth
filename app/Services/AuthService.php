<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
        // Attempt to find the user and verify the password
        $user = User::where('email', $credentials['email'] ?? null)->first();

        if (! $user || ! Hash::check($credentials['password'] ?? '', $user->password)) {
            return null;
        }

        // Create a personal access token for the user
        $tokenResult = $user->createToken('api-token');

        return $tokenResult->accessToken ?? $tokenResult->plainTextToken ?? null;
    }

    public function logout(): void
    {
        $user = auth()->user();

        if ($user && $user->token()) {
            $user->token()->revoke();
        }
    }
}
