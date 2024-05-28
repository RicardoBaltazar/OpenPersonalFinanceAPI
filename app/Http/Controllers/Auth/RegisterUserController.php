<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisterUserController extends Controller
{
    protected $registerUser;

    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     description="Endpoint to register a new user ",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="Name Teste"),
     *             @OA\Property(property="email", type="string", format="email", example="yoxig80660@qiradio.com"),
     *             @OA\Property(property="password", type="string", format="password", example="1234")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to register user",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to register user.")
     *         )
     *     )
     * )
     */
    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->all();
        try {
            $response = $this->registerUser->execute($data);
            return response()->json($response);
        } catch (HttpException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
