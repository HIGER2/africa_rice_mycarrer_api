<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\employeeService;
use Illuminate\Http\Request;

class employeeController extends Controller
{
    //

    public $employeeService;
    public function __construct(

        employeeService $employeeService
    ) {
        $this->employeeService = $employeeService;
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|string',
            'email' => 'required|email',
            // 'supervisor' => 'required|email',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'matricule' => 'required|string',
            'jobTitle' => 'required|string',
            'personalEmail' => 'nullable|email',
            'phone2' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'password' => 'nullable|string',
            'category' => 'nullable|string',
            'grade' => 'nullable|string',
            'bgLevel' => 'nullable|string',
            'deletedAt' => 'nullable|date',
            'secretKey' => 'nullable|string',
        ]);
        $response =   $this->employeeService->create($request);
        return response()->json($response, $response->code);
    }


    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|string',
            'email' => 'required|email',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'matricule' => 'required|string',
            'jobTitle' => 'required|string',
            'personalEmail' => 'nullable|email',
            'phone2' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'password' => 'nullable|string',
            'category' => 'nullable|string',
            'grade' => 'nullable|string',
            'bgLevel' => 'nullable|string',
            'deletedAt' => 'nullable|date',
            'secretKey' => 'nullable|string',
        ]);
        $response =   $this->employeeService->update($request);
        return response()->json($response, $response->code);
    }

    public function getAll()
    {
        $response =   $this->employeeService->getAll();
        return response()->json($response, $response->code);
    }



    public function getUser($id)
    {
        $response =   $this->employeeService->getUser($id);
        return response()->json($response, $response->code);
    }
}