<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $data;

    // Constructeur pour accepter les données
    public function __construct($data)
    {
        $this->data = $data;
    }

    // Retourner les données à exporter
    public function collection()
    {
        return $this->data;
    }

    public function map($data): array
    {

        return [
            $data->matricule,
            $data->firstName . ' ' . $data->lastName,
            $data->email,
            $data->jobTitle,
            $data->supervisor ? $data->supervisor->firstName . ' ' . $data->supervisor->lastName : 'N/A',
            $data->role,
        ];
    }

    public function headings(): array
    {
        return [
            'ResNo',
            'Staff Name',
            'Email',
            'Job Title',
            'Supervisor',
            'Role',
        ];
    }
}
