<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\Login;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginController extends Controller
{
    protected $login;

    public function __construct(Login $login)
    {
        $this->login = $login;
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="login user",
     *     description="Endpoint to login user ",
     *     tags={"Login"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="yoxig80660@qiradio.com"),
     *             @OA\Property(property="password", type="string", format="password", example="1234")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(property="message", type="string", example="User registered successfully."),
     *             @OA\Property(property="token", type="string", example="1|EiQkOPXbqaSm8X17TqQX4lsBGvPuGIZViJaklxEl336a4ff6"),
     *             @OA\Property(property="email", type="string", format="email", example="yoxig80660@qiradio.com"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid credentials.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to login",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to login.")
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="Content-Type",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="application/json"
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
        $data = $request->all();

        try {
            $response = $this->login->execute($data);
            return response()->json($response);
        } catch (HttpException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
