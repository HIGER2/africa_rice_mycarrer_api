<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\StoreLinkDataRequest;
use App\Http\Requests\StorePayrollRequest;
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
            'email' => 'required|email,unique:draft_employees,email',
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

    public function createDraft(StoreLinkDataRequest $request)
    {

        // return 'hello';
        
        $response =   $this->employeeService->createOrUpdateDraft($request);
        return response()->json($response, $response->code);
    }

    public function updateByLink(StoreLinkDataRequest $request)
    {

        $validatedData = $request->validated();

        $response =   $this->employeeService->updateByLink($request);
        return response()->json($response, $response->code);
    }

    public function createOrUpdatePayroll(StorePayrollRequest $request)
    {
        $validatedData = $request->validated();
        // $validated = $request->validate([
        //     'id' => 'nullable|integer|exists:payrolls,id',
        //     'employee_id' => 'required|integer|exists:employees,employeeId',
        //     'contract_start_date' => 'nullable|date',
        //     'contract_end_date' => 'nullable|date|after_or_equal:contract_start_date',
        //     'probation_end_date_1' => 'nullable|date',
        //     'probation_end_date_2' => 'nullable|date',
        //     'type_of_contract' => 'nullable|string|max:255',
        //     // Ajoute les autres champs que tu attends
        // ]);

        $response =   $this->employeeService->createOrUpdatePayroll($request);
        return response()->json($response, $response->code);
    }

    public function assignPostToEmployee(Request $request)
    {

        // $validated = $request->validate([
        //     'id' => 'nullable|integer|exists:payrolls,id',
        //     'employee_id' => 'required|integer|exists:employees,employeeId',
        //     'contract_start_date' => 'nullable|date',
        //     'contract_end_date' => 'nullable|date|after_or_equal:contract_start_date',
        //     'probation_end_date_1' => 'nullable|date',
        //     'probation_end_date_2' => 'nullable|date',
        //     'type_of_contract' => 'nullable|string|max:255',
        //     // Ajoute les autres champs que tu attends
        // ]);

        $response =   $this->employeeService->assignPostToEmployee($request);
        return response()->json($response, $response->code);
    }
    

    public function createOrUpdateContract(StoreContractRequest $request)
    {
        $validatedData = $request->validated();
        $response =   $this->employeeService->createOrUpdateContract($request);
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

    public function ApprouveEmployeDraft($uuid)
    {
        // $validatedData = request()->validate([
        //     'uuid' => 'required|uuid',
        // ]);
        $response =   $this->employeeService->ApprouveEmployeDraft($uuid);
        return response()->json($response, $response->code);
    }

    public function duplicateEmployeeContract($uuid)
    {
        // $validatedData = request()->validate([
        //     'uuid' => 'required|uuid',
        // ]);
        $response =   $this->employeeService->duplicateEmployeeContract($uuid);
        return response()->json($response, $response->code);
    }

    public function getAllDraft()
    {
        $response =   $this->employeeService->getAllDraft();
        return response()->json($response, $response->code);
    }


    public function getUser($id)
    {
        $response =   $this->employeeService->getUser($id);
        return response()->json($response, $response->code);
    }

    public function importEmployee(Request $request)
    {
        $response =   $this->employeeService->importEmployee($request);
        return response()->json($response, $response->code);
    }

     public function find($identifier)
    {
        $response =   $this->employeeService->find($identifier);
        return response()->json($response, $response->code);
    }


    public function findByLink($identifier)
    {
        $response =   $this->employeeService->findByLink($identifier);
        return response()->json($response, $response->code);
    }
}