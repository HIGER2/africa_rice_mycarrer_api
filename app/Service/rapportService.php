<?php

namespace App\Service;

use App\Exports\EmployeeExport;
use App\Interface\employeeInterface;
use Maatwebsite\Excel\Facades\Excel;

class rapportService
{
    /**
     * Create a new class instance.
     */
    public $employeeRepositorie;
    public function __construct(

        employeeInterface $employeeRepositorie
    ) {
        $this->employeeRepositorie = $employeeRepositorie;
    }

    public function filterEmployee($filter)
    {
        $response = "";
        switch ($filter) {
            case '1':
                $response =  $this->employeeRepositorie->getEmployeesWithAtLeast4SentObjectives();
                break;
            case '2':
                $response =  $this->employeeRepositorie->getEmployeesWithLessThan4SentObjectives();
                break;
            case '3':
                $response =  $this->employeeRepositorie->getEmployeesWithAtLeast4ApprovedObjectives();
                break;
            case '4':
                $response =  $this->employeeRepositorie->getEmployeesWithLessThan4ApprovedObjectives();
                break;
            case '5':
                $response =  $this->employeeRepositorie->getEmployeesWithAtLeast4SelfEvaluations();
                break;
            case '6':
                $response =  $this->employeeRepositorie->getEmployeesWithLessThan4SelfEvaluations();
                break;
            case '7':
                $response =  $this->employeeRepositorie->getEmployeesWithEvaluations();
                break;
            case '8':
                $response =  $this->employeeRepositorie->getEmployeesWithoutEvaluations();
                break;
            default:
                $response =  $this->employeeRepositorie->getAll(50);
                break;
        }
        return $response;
    }

    public function getAllEmployeeByFilter($filter)
    {
        return $this->filterEmployee($filter);
    }

    public function exportEmployee($filter)
    {
        $response =  $this->filterEmployee($filter);

        // if ($response->response) {
        //     $response->response  = Excel::raw(new EmployeeExport(), \Maatwebsite\Excel\Excel::XLSX);
        // }
        return Excel::raw(new EmployeeExport($response->response), \Maatwebsite\Excel\Excel::XLSX);
    }
}