<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\settingService;
use Illuminate\Http\Request;

class settingController extends Controller
{
    //


    public $settingService;
    public function __construct(

        settingService $settingService
    ) {
        $this->settingService = $settingService;
    }

    public function create(Request $request)
    {
        $response =   $this->settingService->create($request);
        return response()->json($response, $response->code);
    }


    public function updateSetting(Request $request)
    {

        $response =   $this->settingService->updateSetting($request);
        return response()->json($response, $response->code);
    }

    public function getSettingAll()
    {
        $response =   $this->settingService->getSettingAll();
        return response()->json($response, $response->code);
    }

    public function getStepAll()
    {
        $response =   $this->settingService->getStepAll();
        return response()->json($response, $response->code);
    }


    public function updateStep(Request $request)
    {

        $response =   $this->settingService->updateStep($request);
        return response()->json($response, $response->code);
    }
}
