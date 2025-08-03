<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeUuid extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Employee::all() as $employee) {
            $employee->update(['uuid' => (string) Str::uuid()]);
            // if (empty($employee->)) {
                
            // }
        }
    }
}
