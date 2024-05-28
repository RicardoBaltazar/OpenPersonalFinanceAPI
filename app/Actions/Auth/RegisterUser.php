<?php

namespace App\Actions\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class RegisterUser
{
    public function execute(array $data)
    {
        try {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            return ['success' => true, 'message' => 'User registered successfully.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Failed to register user.'];
        }
    }
}
