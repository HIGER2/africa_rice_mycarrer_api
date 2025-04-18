<?php

namespace App\Service;

use App\Helpers\httpHelper;
use App\Interface\employeeInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authService
{
    /**
     * Create a new class instance.
     */
    /**
     * Create a new class instance.
     */
    public $employeeRepositorie;
    public function __construct(

        employeeInterface $employeeRepositorie
    ) {
        $this->employeeRepositorie = $employeeRepositorie;
    }


    public function login($request)
    {
        // $url = "https://mycareer.africarice.org/api/auth/login";
        // $options = [
        //     'json' => [ // Utiliser 'json' pour envoyer les données sous forme JSON
        //         "email" => $request->email,
        //         "password" => $request->password
        //     ],
        //     'headers' => [
        //         'Accept' => 'application/json',
        //         'Content-Type' => 'application/json',
        //     ]
        // ];
        // $apiResponse = httpHelper::fetchApi('POST', $url, $options);
        // if ($apiResponse->error) {
        //     if ($apiResponse->response_body && $apiResponse->response_body == "Unauthorized") {
        //         return (object)[
        //             'error' => true,
        //             'response' => $apiResponse->data,
        //             'message' => "identifiant de connexion incorrect",
        //             'status' => false,
        //             'code' => 400
        //         ];
        //     }
        // }
        // unset($apiResponse->data->user->password);
        $user = $this->employeeRepositorie->userOne($request->email);
        $user->token =  $user->response->createToken("token")->plainTextToken;
        // $apiResponse->data->user->token =  $user->response->createToken("token")->plainTextToken;
        return (object)[
            'error' => false,
            'response' => $user,
            'message' => "connected",
            'status' => false,
            'code' => 200
        ];
        // $employee = Auth::user();

        // $employee = User::where('email', $request->email)->first();
        // if (!$employee) {
        // }

        // if ($employee->grade !== "abidjan") {
        //     return back()->withErrors([
        //         'message' => 'not authorized',
        //     ]);
        // }


        // if (Hash::needsRehash($request->password)) {
        //     $url = "https://mycareer.africarice.org/api/auth/login";
        //     $options = [
        //         'json' => [ // Utiliser 'json' pour envoyer les données sous forme JSON
        //             "email" => $request->email,
        //             "password" => $request->password
        //         ],
        //         'headers' => [
        //             'Accept' => 'application/json',
        //             'Content-Type' => 'application/json',
        //         ]
        //     ];
        //     $apiResponse = httpHelper::fetchApi('POST', $url, $options);
        //     if ($apiResponse->error) {
        //         if ($apiResponse->response_body && $apiResponse->response_body == "Unauthorized") {
        //             return back()->withErrors([
        //                 'message' => 'Les informations d\'identification ne correspondent pas.',
        //             ]);
        //         }
        //     }

        //     else {
        //         $employee->update([
        //             "password" => Hash::make($request->password),
        //         ]);
        //     }
        // }


        // $attemptWithNumero = Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]);

        // if (!$attemptWithNumero) {


        // return $this->employeeRepositorie->create($request->all());
    }

    public function logout()
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return (object) [
            'response' => true,
            'message' => "Déconnexion réussie",
            'status' => true,
            'error' => false,
            'code' => 200
        ];
    }

    public function connected()
    {

        return (object)[
            'error' => false,
            // 'response' => $apiResponse->data->user,
            'message' => "identifiant de connexion incorrect",
            'status' => false,
            'code' => 200
        ];
    }
}
