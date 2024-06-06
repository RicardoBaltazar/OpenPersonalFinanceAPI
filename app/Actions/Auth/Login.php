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

        $this->validateCredentials($data, $user);

        try {
            $token = $this->getToken($user);

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

    private function validateCredentials(array $data, object $user): void
    {
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpException(401, 'Invalid credentials.');
        }
    }

    private function getToken(object $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }
}
