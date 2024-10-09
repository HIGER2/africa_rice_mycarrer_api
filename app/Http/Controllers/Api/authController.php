<?php

namespace App\Http\Controllers\Api;

use App\Helpers\httpHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\authService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    //
    public $authService;

    function __construct(authService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $response = $this->authService->login($request);
        return response()->json($response, $response->code);
    }

    public function logout()
    {
        $response = $this->authService->logout();
        return response()->json($response, $response->code);
    }



    public function connected()
    {
        $response = $this->authService->connected();
        return response()->json($response, $response->code);
    }
}
