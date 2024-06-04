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
