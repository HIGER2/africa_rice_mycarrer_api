<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\jobService;
use Illuminate\Http\Request;

class jobController extends Controller
{   

     public function __construct(

    protected  jobService $jobService
    ) {
    }


    public function createOrUpdate(Request $request)
    {
        $validatedData = $request->validate([
            // 'role' => 'required|string',
            // 'email' => 'required|email,unique:draft_employees,email',
            // // 'supervisor' => 'required|email',
            // 'firstName' => 'required|string',
            // 'lastName' => 'required|string',
            // 'matricule' => 'required|string',
            // 'jobTitle' => 'required|string',
            // 'personalEmail' => 'nullable|email',
            // 'phone2' => 'nullable|string',
            // 'phone' => 'nullable|string',
            // 'address' => 'nullable|string',
            // 'password' => 'nullable|string',
            // 'category' => 'nullable|string',
            // 'grade' => 'nullable|string',
            // 'bgLevel' => 'nullable|string',
            // 'deletedAt' => 'nullable|date',
            // 'secretKey' => 'nullable|string',
        ]);
        $response =   $this->jobService->createOrUpdate($request);
        return response()->json($response, $response->code);
    }

    public function all(Request $request)
    {
        $validatedData = $request->validate([
            // 'role' => 'required|string',
            // 'email' => 'required|email,unique:draft_employees,email',
            // // 'supervisor' => 'required|email',
            // 'firstName' => 'required|string',
            // 'lastName' => 'required|string',
            // 'matricule' => 'required|string',
            // 'jobTitle' => 'required|string',
            // 'personalEmail' => 'nullable|email',
            // 'phone2' => 'nullable|string',
            // 'phone' => 'nullable|string',
            // 'address' => 'nullable|string',
            // 'password' => 'nullable|string',
            // 'category' => 'nullable|string',
            // 'grade' => 'nullable|string',
            // 'bgLevel' => 'nullable|string',
            // 'deletedAt' => 'nullable|date',
            // 'secretKey' => 'nullable|string',
        ]);
        $response =   $this->jobService->all($request);
        return response()->json($response, $response->code);
    }

    public function find($uuid)
    {
        $response =   $this->jobService->find($uuid);
        return response()->json($response, $response->code);
    }
}
