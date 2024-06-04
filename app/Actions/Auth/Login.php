<?php

namespace App\Actions\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Login
{
    public function execute(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpException(401, 'Invalid credentials.');
        }

        try {
            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'success' => true,
                'message' => 'User logged in successfully.',
                'token' => $token,
                'email' => $user->email
            ];
        } catch (Exception $e) {
            throw new HttpException(500, 'Failed to login.');
        }
    }
}
