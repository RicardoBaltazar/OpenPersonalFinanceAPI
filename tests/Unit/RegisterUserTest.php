<?php

namespace Tests\Unit;

use App\Actions\Auth\RegisterUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mockery;
use PHPUnit\Framework\TestCase;

class RegisterUserTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testExecuteRegistersUserSuccessfully()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret',
        ];

        Hash::shouldReceive('make')
            ->once()
            ->with($data['password'])
            ->andReturn('hashedpassword');

        $userMock = Mockery::mock('alias:' . User::class);
        $userMock->shouldReceive('create')
            ->once()
            ->with([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => 'hashedpassword',
            ])
            ->andReturn((object) ['id' => 1, 'name' => 'Test User', 'email' => 'test@example.com']);

        $registerUser = new RegisterUser();
        $result = $registerUser->execute($data);

        $this->assertEquals([
            'success' => true,
            'message' => 'User registered successfully.'
        ], $result);
    }

    public function testExecuteFailsToRegisterUser()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret',
        ];

        Hash::shouldReceive('make')
            ->once()
            ->with($data['password'])
            ->andReturn('hashedpassword');

        $userMock = Mockery::mock('alias:' . User::class);
        $userMock->shouldReceive('create')
            ->once()
            ->with([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => 'hashedpassword',
            ])
            ->andThrow(new \Exception('Failed to register user.'));

        $registerUser = new RegisterUser();
        $result = $registerUser->execute($data);

        $this->assertEquals([
            'success' => false,
            'message' => 'Failed to register user.'
        ], $result);
    }
}
