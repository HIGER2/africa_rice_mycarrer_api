<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePayrollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
        public function authorize()
    {
        // Modifier si tu veux gérer les permissions
        return true;
    }

    public function rules()
    {
        return [
            // 'employee_id' => 'required',
            'basic_salary' => 'required|numeric|min:0',
            // 'uuid' => 'required|uuid',
            'salary_currency' => 'required|string',
            'salary_frequency' => 'required|numeric',
            'transport_allowance' => 'required|numeric|min:0',
            'housing_allowance' => 'required|numeric|min:0',
            // 'recrutement_id' => 'required|string',
            'dependent_allowance' => 'required|numeric|min:0',
            'installation_allowance' => 'required|numeric|min:0',
            'arrival_shipping_allowance' => 'required|numeric|min:0',
            'departure_shipping_allowance' => 'required|numeric|min:0',
            'health_insurance' => 'required|numeric|min:0',
            'social_contribution' => 'required|numeric|min:0',
            'life_insurance' => 'required|numeric|min:0',
            'salary_taxes' => 'required|numeric|min:0',
            'home_leave' => 'required|string|in:yes,no',
            'flight_ticket' => 'required|string|in:yes,no',
            'installation_assistance' => 'required|string|in:yes,no',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Employee ID is required.',
            'basic_salary.required' => 'Basic salary is required.',
            'basic_salary.numeric' => 'Basic salary must be a number.',
            'basic_salary.min' => 'Basic salary must be at least 0.',
            'uuid.required' => 'UUID is required.',
            'uuid.uuid' => 'UUID must be a valid UUID format.',
            'salary_currency.required' => 'Salary currency is required.',
            'salary_currency.string' => 'Salary currency must be a string.',
            'salary_currency.max' => 'Salary currency must not exceed 5 characters.',
            'salary_frequency.required' => 'Salary frequency is required.',
            'salary_frequency.string' => 'Salary frequency must be a string.',
            'transport_allowance.numeric' => 'Transport allowance must be a number.',
            'transport_allowance.min' => 'Transport allowance must be at least 0.',
            'housing_allowance.numeric' => 'Housing allowance must be a number.',
            'housing_allowance.min' => 'Housing allowance must be at least 0.',
            'recrutement_id.required' => 'Recruitment ID is required.',
            'recrutement_id.string' => 'Recruitment ID must be a string.',
            'dependent_allowance.numeric' => 'Dependent allowance must be a number.',
            'dependent_allowance.min' => 'Dependent allowance must be at least 0.',
            'installation_allowance.numeric' => 'Installation allowance must be a number.',
            'installation_allowance.min' => 'Installation allowance must be at least 0.',
            'arrival_shipping_allowance.numeric' => 'Arrival shipping allowance must be a number.',
            'arrival_shipping_allowance.min' => 'Arrival shipping allowance must be at least 0.',
            'departure_shipping_allowance.numeric' => 'Departure shipping allowance must be a number.',
            'departure_shipping_allowance.min' => 'Departure shipping allowance must be at least 0.',
            'health_insurance.numeric' => 'Health insurance must be a number.',
            'health_insurance.min' => 'Health insurance must be at least 0.',
            'social_contribution.numeric' => 'Social contribution must be a number.',
            'social_contribution.min' => 'Social contribution must be at least 0.',
            'life_insurance.numeric' => 'Life insurance must be a number.',
            'life_insurance.min' => 'Life insurance must be at least 0.',
            'salary_taxes.numeric' => 'Salary taxes must be a number.',
            'salary_taxes.min' => 'Salary taxes must be at least 0.',
            'home_leave.numeric' => 'Home leave must be a number.',
            'home_leave.min' => 'Home leave must be at least 0.',
            'flight_ticket.numeric' => 'Flight ticket must be a number.',
            'flight_ticket.min' => 'Flight ticket must be at least 0.',
            'installation_assistance.numeric' => 'Installation assistance must be a number.',
            'installation_assistance.min' => 'Installation assistance must be at least 0.',
        ];
    }
}
