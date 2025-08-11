<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
public function authorize()
    {
        return true; // à adapter selon ta logique d’accès
    }

    public function rules()
    {
        return [
            // 'employee_id' => 'required',
            'resno' => 'required|string',
            // 'uuid' => 'required|uuid',
            'position_posno' => 'required|string',
            // 'recrutement_id' => 'required|string',
            'type_of_contract' => 'required|string',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after_or_equal:contract_start_date',
            'probation_end_date_1' => 'nullable|date',
            'probation_end_date_2' => 'nullable|date|after_or_equal:probation_end_date_1',
            'bg_level_equivalent' => 'required|string',
            'supervisor_posno' => 'required|string',
            'position_classification' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Employee ID is required.',
            'resno.required' => 'Resno is required.',
            'resno.string' => 'Resno must be a string.',
            'uuid.required' => 'UUID is required.',
            'uuid.uuid' => 'UUID must be a valid UUID format.',
            'position_posno.required' => 'Position posno is required.',
            'position_posno.string' => 'Position posno must be a string.',
            'recrutement_id.required' => 'Recruitment ID is required.',
            'recrutement_id.string' => 'Recruitment ID must be a string.',
            'type_of_contract.required' => 'Type of contract is required.',
            'type_of_contract.string' => 'Type of contract must be a string.',
            'contract_start_date.required' => 'Contract start date is required.',
            'contract_start_date.date' => 'Contract start date must be a valid date.',
            'contract_end_date.required' => 'Contract end date is required.',
            'contract_end_date.date' => 'Contract end date must be a valid date.',
            'contract_end_date.after_or_equal' => 'Contract end date must be after or equal to contract start date.',
            'probation_end_date_1.date' => 'Probation end date 1 must be a valid date.',
            'probation_end_date_2.date' => 'Probation end date 2 must be a valid date.',
            'probation_end_date_2.after_or_equal' => 'Probation end date 2 must be after or equal to probation end date 1.',
            'bg_level_equivalent.required' => 'BG level equivalent is required.',
            'bg_level_equivalent.string' => 'BG level equivalent must be a string.',
            'supervisor_posno.required' => 'Supervisor posno is required.',
            'supervisor_posno.string' => 'Supervisor posno must be a string.',
            'position_classification.required' => 'Position classification is required.',
            'position_classification.string' => 'Position classification must be a string.',
        ];
    }
}
