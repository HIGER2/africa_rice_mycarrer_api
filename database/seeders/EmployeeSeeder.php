<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeBeneficiary;
use App\Models\EmployeeContract;
use App\Models\EmployeeDependents;
use App\Models\EmployeeEmergencyContacts;
use App\Models\EmployeePayroll;
use App\Models\employeeRecruitment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Création de l'employé principal
        $employee = Employee::create([
            'name' => 'Daniel',
            'surname' => 'Douma',
            'date_of_birth' => '1995-08-15',
            'country_of_birth' => 'Côte d\'Ivoire',
            'gender' => 'Male',
            'nationality_1' => 'Ivorian',
            'nationality_2' => 'French',
            'passport_number' => 'CI123456789',
            'social_security_number' => 'SSN99887766',
            'permanent_address' => 'Cocody, Abidjan, Côte d\'Ivoire',
            'country_of_residence' => 'Côte d\'Ivoire',
            'town_of_residence' => 'Abidjan',
            'phone_number' => '+2250778618454',
            'personal_email' => 'daniel.douma@example.com',
            'marital_status' => 'Married',
            'number_of_children' => 2,
            'family_living_with_staff' => true,
            'family_residence_location' => null,
            'spouse_works' => true,
            'spouse_workplace' => 'Banque Atlantique, Abidjan',
        ]);

        // Conjoint
        EmployeeDependents::create([
            'employee_id' => $employee->id,
            'full_name' => 'Sarah Douma',
            'relation' => 'Spouse',
            'gender' => 'Female',
            'date_of_birth' => '1993-03-12',
            'nationality' => 'Ivorian',
            'residence_or_school' => 'Abidjan',
        ]);

        // Enfant 1
        EmployeeDependents::create([
            'employee_id' => $employee->id,
            'full_name' => 'Noah Douma',
            'relation' => 'Child',
            'gender' => 'Male',
            'date_of_birth' => '2018-05-10',
            'nationality' => 'Ivorian',
            'residence_or_school' => 'École Primaire La Fontaine',
        ]);

        // Enfant 2
        EmployeeDependents::create([
            'employee_id' => $employee->id,
            'full_name' => 'Maya Douma',
            'relation' => 'Child',
            'gender' => 'Female',
            'date_of_birth' => '2021-11-22',
            'nationality' => 'Ivorian',
            'residence_or_school' => 'Garderie Les Petits Génies',
        ]);

        // Contacts d’urgence
        EmployeeEmergencyContacts::create([
            'employee_id' => $employee->id,
            'name' => 'Jean Kouassi',
            'relationship' => 'Brother',
            'address' => 'Yopougon, Abidjan',
            'telephone' => '+2250145223366',
            'email' => 'jeank@example.com',
        ]);

        EmployeeEmergencyContacts::create([
            'employee_id' => $employee->id,
            'name' => 'Clarisse Doumbia',
            'relationship' => 'Friend',
            'address' => 'Treichville, Abidjan',
            'telephone' => '+2250155887766',
            'email' => 'clarisse.d@example.com',
        ]);

        // Bénéficiaires
        EmployeeBeneficiary::create([
            'employee_id' => $employee->id,
            'full_name' => 'Sarah Douma',
            'relationship' => 'Spouse',
            'birthday' => '1993-03-12',
            'address' => 'Cocody, Abidjan',
            'email' => 'sarah.douma@example.com',
            'percentage_share' => 60.00,
        ]);

        EmployeeBeneficiary::create([
            'employee_id' => $employee->id,
            'full_name' => 'Noah Douma',
            'relationship' => 'Child',
            'birthday' => '2018-05-10',
            'address' => 'Cocody, Abidjan',
            'email' => 'noah.douma@example.com',
            'percentage_share' => 20.00,
        ]);

        EmployeeBeneficiary::create([
            'employee_id' => $employee->id,
            'full_name' => 'Maya Douma',
            'relationship' => 'Child',
            'birthday' => '2021-11-22',
            'address' => 'Cocody, Abidjan',
            'email' => 'maya.douma@example.com',
            'percentage_share' => 20.00,
        ]);

        EmployeeContract::create([
            'employeeId' => $employee->id,
            'resno' => 'RES12345',
            'position_posno' => 'POS7890',
            'type_of_contract' => 'Fixed-term',
            'contract_start_date' => '2023-01-01',
            'contract_end_date' => '2024-12-31',
            'probation_end_date_1' => '2023-03-31',
            'probation_end_date_2' => '2023-06-30',
            'bg_level_equivalent' => 'BG5',
            'supervisor_posno' => 'SUP4567',
            'position_classification' => 'Professional Staff',
        ]);

        // PAIE
        EmployeePayroll::create([
            'employeeId' => $employee->id,
            'basic_salary' => 2500.00,
            'salary_currency' => 'USD',
            'salary_frequency' => 'Monthly',
            'transport_allowance' => 200.00,
            'housing_allowance' => 500.00,
            'dependent_allowance' => 100.00,
            'installation_allowance' => 1000.00,
            'arrival_shipping_allowance' => 800.00,
            'departure_shipping_allowance' => 900.00,
            'health_insurance' => 150.00,
            'social_contribution' => 75.00,
            'life_insurance' => 50.00,
            'salary_taxes' => 200.00,
            'home_leave' => true,
            'flight_ticket' => true,
            'installation_assistance' => true,
        ]);

        // POSITION
        employeeRecruitment::create([
            'employeeId' => $employee->id,
            'center' => 'AfricaRice',
            'country_duty_station' => 'Côte d\'Ivoire',
            'city_duty_station' => 'Bouaké',
            'position_title' => 'Software Developer',
            'recruitment_id' => 'REC9876',
            'contract_from' => '2023-01-01',
            'contract_to' => '2024-12-31',
            'grade' => 'P2',
            'division' => 'IT Department',
            'program' => 'Digital Transformation',
            'sub_unit' => 'Development Unit',
            'education_level' => 'Master',
            'resources_type' => 'Core',
            'contract_time' => 'Full time',
            'supervisor_name' => 'Jean Koffi',
            'supervisor_position' => 'IT Manager',
            'recruitment_type' => 'External',
            'country_of_recruitment' => 'Côte d\'Ivoire',
            'cgiar_workforce_group' => 'Professional',
            'cgiar_group' => 'Group A',
            'cgiar_appointed' => true,
            'percent_time_other_center' => 0.00,
            'shared_working_arrangement' => false,
            'initiative_lead' => 'AgriTech Initiative',
            'initiative_personnel' => 'Platform Dev Team',
        ]);
    }
}
