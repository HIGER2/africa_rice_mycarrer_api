<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecrutementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
    return [
        // 'employee_id' => 'required',
        'center' => 'required|string',
        // 'uuid' => 'required|uuid',
        'country_duty_station' => 'required|string',
        'city_duty_station' => 'required|string',
        'position_title' => 'required|string',
        'recrutement_id' => 'required|string|unique:recrutements,recrutement_id',
        'contract_from' => 'required|date',
        'contract_to' => 'required|date|after_or_equal:contract_from',
        'grade' => 'required|string',
        'division' => 'required|string',
        'program' => 'required|string',
        'sub_unit' => 'required|string',
        'education_level' => 'required|string',
        'resources_type' => 'required|string',
        'contract_time' => 'required|string',
        'supervisor_name' => 'required|string',
        'supervisor_position' => 'required|string',
        'recruitment_type' => 'required|string',
        'country_of_recruitment' => 'required|string',
        'cgiar_workforce_group' => 'required|string',
        'cgiar_group' => 'required|string',
        'cgiar_appointed' => 'required|string',
        'percent_time_other_center' => 'required|numeric|min:0|max:100',
        'shared_working_arrangement' => 'required|string',
        'initiative_lead' => 'required|string',
        'initiative_personnel' => 'required|string',
        'salary_post' => 'required',
    ];
    }

    public function messages()
{
    return [
        'employee_id.required' => 'Employee ID is required.',
        'center.required' => 'Center is required.',
        'center.string' => 'Center must be a string.',
        'uuid.required' => 'UUID is required.',
        'uuid.uuid' => 'UUID must be a valid UUID format.',
        'country_duty_station.required' => 'Country duty station is required.',
        'country_duty_station.string' => 'Country duty station must be a string.',
        'city_duty_station.required' => 'City duty station is required.',
        'city_duty_station.string' => 'City duty station must be a string.',
        'position_title.required' => 'Position title is required.',
        'position_title.string' => 'Position title must be a string.',
        'recrutement_id.required' => 'The recruitment code is required.',
        'recrutement_id.string' => 'The recruitment code must be a string.',
        'recrutement_id.unique' => 'This recruitment code is already in use.',
        'contract_from.required' => 'Contract start date is required.',
        'contract_from.date' => 'Contract start date must be a valid date.',
        'contract_to.required' => 'Contract end date is required.',
        'contract_to.date' => 'Contract end date must be a valid date.',
        'contract_to.after_or_equal' => 'Contract end date must be after or equal to contract start date.',
        'grade.required' => 'Grade is required.',
        'grade.string' => 'Grade must be a string.',
        'division.required' => 'Division is required.',
        'division.string' => 'Division must be a string.',
        'program.required' => 'Program is required.',
        'program.string' => 'Program must be a string.',
        'sub_unit.required' => 'Sub unit is required.',
        'sub_unit.string' => 'Sub unit must be a string.',
        'education_level.required' => 'Education level is required.',
        'education_level.string' => 'Education level must be a string.',
        'resources_type.required' => 'Resources type is required.',
        'resources_type.string' => 'Resources type must be a string.',
        'contract_time.required' => 'Contract time is required.',
        'contract_time.string' => 'Contract time must be a string.',
        'supervisor_name.required' => 'Supervisor name is required.',
        'supervisor_name.string' => 'Supervisor name must be a string.',
        'supervisor_position.required' => 'Supervisor position is required.',
        'supervisor_position.string' => 'Supervisor position must be a string.',
        'recruitment_type.required' => 'Recruitment type is required.',
        'recruitment_type.string' => 'Recruitment type must be a string.',
        'country_of_recruitment.required' => 'Country of recruitment is required.',
        'country_of_recruitment.string' => 'Country of recruitment must be a string.',
        'cgiar_workforce_group.required' => 'CGIAR workforce group is required.',
        'cgiar_workforce_group.string' => 'CGIAR workforce group must be a string.',
        'cgiar_group.required' => 'CGIAR group is required.',
        'cgiar_group.string' => 'CGIAR group must be a string.',
        'cgiar_appointed.required' => 'CGIAR appointed is required.',
        'cgiar_appointed.string' => 'CGIAR appointed must be a string.',
        'percent_time_other_center.required' => 'Percent time other center is required.',
        'percent_time_other_center.numeric' => 'Percent time other center must be a number.',
        'percent_time_other_center.min' => 'Percent time other center must be at least 0.',
        'percent_time_other_center.max' => 'Percent time other center must not exceed 100.',
        'shared_working_arrangement.required' => 'Shared working arrangement is required.',
        'shared_working_arrangement.string' => 'Shared working arrangement must be a string.',
        'initiative_lead.required' => 'Initiative lead is required.',
        'initiative_lead.string' => 'Initiative lead must be a string.',
        'initiative_personnel.required' => 'Initiative personnel is required.',
        'initiative_personnel.string' => 'Initiative personnel must be a string.',
        'salary_post.required' => 'Salary post is required.',
        'salary_post.string' => 'Salary post must be a string.',
    ];
}
}
