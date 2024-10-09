<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\stepService;
use Illuminate\Http\Request;

class stepController extends Controller
{
    //


    public $stepService;
    public function __construct(

        stepService $stepService
    ) {
        $this->stepService = $stepService;
    }

    public function create(Request $request)
    {
        $response =   $this->stepService->create($request);
        return response()->json($response, $response->code);
    }


    public function update(Request $request)
    {

        $response =   $this->stepService->update($request);
        return response()->json($response, $response->code);
    }

    public function getAll()
    {
        $response =   $this->stepService->getAll();
        return response()->json($response, $response->code);
    }
}
