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

    public function createDraft(Request $request)
    {

            // return 'hello';
        $validatedData = $request->validate([
            'user.firstName' => 'required|string',
            'user.lastName' => 'required|string',
            'user.date_of_birth' => 'nullable|date',
            'user.personal_email' => 'required|email|unique:draft_employees,personal_email',
            'user.country_of_birth' => 'nullable|string',
        ], [
            'user.firstName.required' => 'Le prénom est requis.',
            'user.firstName.string' => 'Le prénom doit être une chaîne de caractères.',

            'user.lastName.required' => 'Le nom est requis.',
            'user.lastName.string' => 'Le nom doit être une chaîne de caractères.',

            'user.date_of_birth.date' => 'La date de naissance doit être une date valide.',

            'user.personal_email.required' => 'L\'email personnel est requis.',
            'user.personal_email.email' => 'Veuillez fournir une adresse email valide.',
            'user.personal_email.unique' => 'Cet email personnel est déjà utilisé.',

            'user.country_of_birth.string' => 'Le pays de naissance doit être une chaîne de caractères.',
        ]);


        $response =   $this->employeeService->createOrUpdateDraft($request);
        return response()->json($response, $response->code);
    }

    public function updateByLink(Request $request)
    {

        // return 'hello';
        $validatedData = $request->validate([
            // 'user.firstName' => 'required|string',
            // 'user.lastName' => 'required|string',
            // 'user.date_of_birth' => 'nullable|date',
            // 'user.email' => 'required|email|unique:draft_employees,email',
            // 'user.country_of_birth' => 'nullable|string',
        ]);

        $response =   $this->employeeService->updateByLink($request);
        return response()->json($response, $response->code);
    }

    public function createOrUpdatePayroll(Request $request)
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
    

    public function createOrUpdateContract(Request $request)
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