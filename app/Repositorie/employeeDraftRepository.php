<?php

namespace App\Repositorie;

use App\Interface\employeeDraftInterface;
use App\Models\DraftEmployee;
use App\Models\Employee;

class employeeDraftRepository implements employeeDraftInterface
{
    
    public function __construct()
    {
        //
    }


    public function updateOrCreate($data): mixed
    {
        try {
            $empployee =  DraftEmployee::updateOrCreate(
                ['uuid' => $data['uuid'] ?? null],
                $data
            );
            return (object) [
                'error' => null,
                'response' => $empployee,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }
}
