<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\rapportService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class rapportController extends Controller
{
    //

    public $rapportService;
    public function __construct(

        rapportService $rapportService
    ) {
        $this->rapportService = $rapportService;
    }

    public function getRapportStaff(Request $request)
    {
        $response =   $this->rapportService->StaffReport($request);
        return response()->json($response, $response->code);
    }

    // public function exportEmployee($filter = null)
    // {
    //     $response = $this->rapportService->exportEmployee($filter);
    //     // return response()->json($response, 200);

    //     return response($response, 200)
    //         ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
    //         ->header('Content-Disposition', 'attachment; filename="employees.xlsx"');
    //     // ->header('Cache-Control', 'max-age=0')
    //     // ->header('Pragma', 'public');
    // }
}