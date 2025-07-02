<?php

namespace App\Service;

use App\Exports\EmployeeExport;
use App\Interface\employeeInterface;
use App\Interface\rapportInterface;
use Maatwebsite\Excel\Facades\Excel;

class rapportService
{
    /**
     * Create a new class instance.
     */
    public $employeeRepositorie;
    public function __construct(
        protected rapportInterface $rapportInterface,
        employeeInterface $employeeRepositorie
    ) {
        $this->employeeRepositorie = $employeeRepositorie;
    }

    public function StaffReport($request)
    {   
        $status = $request->query('status');
        $year = $request->query('year');  

        switch ($status) {
            case '1':
                $response =  $this->rapportInterface->listStaff($year);
                break;
            case '2':
                $response =  $this->rapportInterface->listStaffObjectivesSubmitted($year);
                break;
            case '3':
                $response =  $this->rapportInterface->listStaffWithoutObjectives($year);
                break;
            case '4':
                $response =  $this->rapportInterface->listApprovedObjectives($year);
                break;
            case '5':
                $response =  $this->rapportInterface->listSelfReviewSubmitted($year);
                break;
            case '6':
                $response =  $this->rapportInterface->listSelfEvaluationApproved($year);
                break;
            case '7':
                $response =  $this->rapportInterface->listEvaluationNotSubmitted($year);
                break;
            case '8':
                $response =  $this->rapportInterface->listObjectivesNotApproved($year);
                break;
            case '9':
                $response =  $this->rapportInterface->listObjectivesSubmittedNotApproved($year);
            default:
                $response =  $this->rapportInterface->listStaff($year);
                break;
        }
        return $response;
    }

    // public function getAllEmployeeByFilter($filter)
    // {
    //     return $this->filterEmployee($filter);
    // }

    // public function exportEmployee($filter)
    // {
    //     $response =  $this->filterEmployee($filter);
    //     // if ($response->response) {
    //     //     $response->response  = Excel::raw(new EmployeeExport(), \Maatwebsite\Excel\Excel::XLSX);
    //     // }
    //     return Excel::raw(new EmployeeExport($response->response), \Maatwebsite\Excel\Excel::XLSX);
    // }
}