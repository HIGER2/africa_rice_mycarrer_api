<?php

namespace App\Repositorie;

use App\Interface\employeeInterface;
use App\Models\DraftEmployee;
use App\Models\Employee;
use App\Models\EmployeeBeneficiary;
use App\Models\EmployeeContract;
use App\Models\EmployeeDependents;
use App\Models\EmployeeEmergencyContacts;
use App\Models\EmployeePayroll;
use App\Models\employeeRecruitment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class employeeRepositorie implements employeeInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function create($data): mixed
    {
        try {
            DB::beginTransaction();
            $user = User::create($data);
            DB::commit();

            return (object) [
                'error' => null,
                'response' => $user,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }


    public function updateOrCreate($data): mixed
    {
        try {
            $empployee =  Employee::updateOrCreate(
                ['uuid' => $data['uuid'] ?? null],
                $data
            );
            return (object) [
                'error' => null,
                'data' => $empployee,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "erreur employe",
                'status' => true,
                'code' => 500
            ];
        }
    }

    public function userOne($data): mixed
    {

        try {
            $userOne = User::where('phone', $data)
                ->orWhere('email', $data)
                ->first();
            return (object) [
                'error' => null,
                'response' => $userOne,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return [
                'error' => $th->getMessage(),
                'response' => null
            ];
        }
    }


    public function findDraft($key,$data): mixed
    {

        try {
            $userOne = DraftEmployee::where($key, $data)->first();
            return (object) [
                'error' => null,
                'data' => $userOne,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return [
                'error' => $th->getMessage(),
                'data' => null,
                'message' => "erreur",
                'status' =>false,
                'code' => 500
            ];
        }
    }

    public function userOneByid($id): mixed
    {
        try {
            $userOne = User::with('supervisor')
                ->where('employeeId', $id)
                ->first();
            return (object) [
                'error' => null,
                'response' => $userOne,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return [
                'error' => $th->getMessage(),
                'response' => null
            ];
        }
    }

    public function userExist($email = null): mixed
    {
        try {
            $userOne = User::where('phone', $email)
                ->orWhere('email', $email)->exists();

            return (object) [
                'error' => null,
                'response' => $userOne,
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

    public function getAll($take = 0): mixed
    {
        try {

            $employees = DB::table('employees as e')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
                    'e.employeeId',
                    'e.uuid',
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    'e.phone2',
                    's.lastName as supervisorLastName',
                    's.firstName as supervisorFirstName',
                    // 'e.matricule',
                    // 'e.lastName as employeeLastName',
                    // 'e.firstName as employeeFirstName',
                    // 'e.jobTitle as Title',

                    // 'e.phone2 as Division'
                )
                // ->when($year, function ($query, $year) {
                //     $query->whereYear('o.objectiveYear', $year);
                // })
                ->whereNull('e.deletedAt')
                // ->whereNotNull('e.matricule')
                ->orderBy('employeeId', 'desc')
                ->get();
            // $users = User::selec()
            //     ->with('supervisor')
            //     ->when($take, function ($query) use ($take) {
            //         $query->take($take);
            //     })
            //     ->get();
            return (object) [
                'error' => null,
                'response' => $employees,
                'message' => "liste",
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

        public function getAllBy($take = 0, $relation = [], $field = []): mixed
        {
            try {
                $query = Employee::query();

                // Si on a des champs spécifiques, on les sélectionne
                if (count($field) > 0) {
                    $query->select($field);
                }

                // Si on a des relations à charger
                if (count($relation) > 0) {
                    $query->with($relation);
                }

                // Filtrer les employés non supprimés (soft delete)
                $query->whereNull('deletedAt');

                // Trier par ID descendant
                $query->orderBy('employeeId', 'desc');

                // Appliquer une limite si $take > 0
                if ($take > 0) {
                    $query->take($take);
                }

                // Récupérer les résultats
                $employees = $query->get();

                return (object) [
                    'error' => null,
                    'response' => $employees,
                    'message' => "liste",
                    'status' => true,
                    'code' => 200
                ];
            } catch (\Throwable $th) {
                return (object) [
                    'error' => $th->getMessage(),
                    'response' => false,
                    'message' => "erreur",
                    'status' => false,
                    'code' => 500
                ];
            }
        }


    public function getOne($id, $uid): mixed
    {
        try {

            $user = User::where('employeeId', $id)
                ->first();

            return (object) [
                'error' => null,
                'response' => $user,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }

    public function find($colonne, $value, $relation = []): mixed
    {
        try {
            $user = Employee::when(count($relation) > 0, function ($query) use ($relation) {
                    return $query->with($relation);
                })
                ->where($colonne, $value)
                ->first();

            return (object) [
                'error' => null,
                'data' => $user,
                'message' => "found",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "error",
                'status' => false,
                'code' => 500
            ];
        }
    }
    public function update($model, $data): mixed
    {
        try {

            DB::beginTransaction();
            $user =  $model->update($data);
            DB::commit();
            return (object) [
                'error' => null,
                'response' => $model,
                'message' => "mise à jour effectuée",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }

    public function delete(): mixed
    {
        try {
            DB::beginTransaction();

            $User = $this->read();

            if ($User->response) {
                // L'entrée avec l'ID existe, mettre à jour les données
                $User->response->delete();
            } else {
                // L'entrée avec l'ID n'existe pas, retourner un message d'erreur
                return (object) [
                    'error' => true,
                    'response' => false,
                    'message' => "L'ID fourni ne correspond à aucune entrée.",
                    'status' => true,
                    'code' => 422
                ];
            }
            DB::commit();
            return (object) [
                'error' => null,
                'response' => $User,
                'message' => "liste",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }

    public function createOrUpdateDependent($data): mixed
    {
        try {
        $dependent=  EmployeeDependents::updateOrCreate(
                [
                    'uuid' => $data['uuid'] ?? null
                ],
                $data
            );
            return (object) [
                'error' => null,
                'data' => $dependent,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }

    public function createOrUpdateEmergencyContact($data): mixed
    {
        try {
            $contact = EmployeeEmergencyContacts::updateOrCreate(
                [
                    'uuid' => $data['uuid'] ?? null
                ],
                $data
            );
            return (object) [
                'error' => null,
                'data' => $contact,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }

    public function createOrUpdateBeneficiary($data): mixed
    {
        try {
            $beneficiary = EmployeeBeneficiary::updateOrCreate(
                [
                    'uuid' => $data['uuid'] ?? null
                ],
                $data
            );
            return (object) [
                'error' => null,
                'data' => $beneficiary,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }

    public function updateOrCreateDraft($data): mixed
    {
        try {
            $empployee =  DraftEmployee::updateOrCreate(
                ['uuid' => $data['uuid'] ?? null],
                $data
            );
            return (object) [
                'error' => null,
                'data' => $empployee,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }

    public function getAllDraft($relation=[]): mixed
    {
        try {

            $employees = DraftEmployee::when(count($relation)>0, function ($query) use ($relation) {
                    $query->with($relation);
                })
                // ->when($take, function ($query) use ($take) {
                //     $query->take($take);
                // })
                ->orderBy('created_at', 'desc')
                ->get();
            return (object) [
                'error' => null,
                'data' => $employees,
                'message' => "liste",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }


    public function updateOrCreateEmployeeContract($data): mixed
    {
        try {
            $empployee =  EmployeeContract::updateOrCreate(
                ['uuid' => $data['uuid'] ?? null],
                $data
            );
            return (object) [
                'error' => null,
                'data' => $empployee,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }

    public function updateOrCreateEmployeePayroll($data): mixed
    {
        try {
            $values =  EmployeePayroll::updateOrCreate(
                ['uuid' => $data['uuid'] ?? null],
                $data
            );
            return (object) [
                'error' => null,
                'data' => $values,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }

    public function updateOrCreateEmployeeRecruitment($data): mixed
        {
        try {
            $values =  employeeRecruitment::updateOrCreate(
                ['uuid' => $data['uuid'] ?? null],
                $data
            );
            return (object) [
                'error' => null,
                'data' => $values,
                'message' => "crate",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "erreur",
                'status' => true,
                'code' => 500
            ];
        }
    }

}
