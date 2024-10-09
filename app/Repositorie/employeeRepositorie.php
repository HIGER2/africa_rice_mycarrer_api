<?php

namespace App\Repositorie;

use App\Interface\employeeInterface;
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
            $users = User::with('supervisor')
                ->when($take, function ($query) use ($take) {
                    $query->take($take);
                })
                ->orderBy('employeeId', 'desc')
                ->get();
            return (object) [
                'error' => null,
                'response' => $users,
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

    // Employés ayant au moins 4 objectifs avec le statut 'sent'
    // Listes des staffs ayant soumis leurs objectifs .

    public function getEmployeesWithAtLeast4SentObjectives(): mixed
    {
        try {
            $employees = User::with('supervisor')
                ->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->join('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
                ->where('objectives.status', 'sent')
                ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->havingRaw('COUNT(objectives.objectiveId) >= 4')
                ->orderBy('employees.employeeId')
                ->get();

            return (object) [
                'error' => null,
                'response' => $employees,
                'message' => "Liste des employés avec au moins 4 objectifs envoyés.",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "Erreur lors de la récupération des employés.",
                'status' => false,
                'code' => 500
            ];
        }
    }

    // Employés n'ayant pas 4 objectifs avec le statut 'sent'
    //  Listes des staffs n’ayant pas soumis

    public function getEmployeesWithLessThan4SentObjectives(): mixed
    {
        try {
            $employees = User::with('supervisor')->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->leftJoin('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
                ->where(function ($query) {
                    $query->whereNull('objectives.objectiveId') // Pas d'objectifs
                        ->orWhere(function ($query) {
                            $query->where('objectives.status', 'sent')
                                ->groupBy('employees.employeeId')
                                ->havingRaw('COUNT(objectives.objectiveId) < 4');
                        });
                })
                ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->orderBy('employees.employeeId')
                ->get();

            return (object) [
                'error' => null,
                'response' => $employees,
                'message' => "Liste des employés avec moins de 4 objectifs envoyés.",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "Erreur lors de la récupération des employés.",
                'status' => false,
                'code' => 500
            ];
        }
    }

    // Employés ayant au moins 4 objectifs avec le statut 'Ok'
    // Liste des staffs dont les objectifs ont été approuvé.

    public function getEmployeesWithAtLeast4ApprovedObjectives(): mixed
    {
        try {
            $employees = User::with('supervisor')->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->join('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
                ->where('objectives.status', 'Ok')
                ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->havingRaw('COUNT(objectives.objectiveId) >= 4')
                ->orderBy('employees.employeeId')
                ->get();

            return (object) [
                'error' => null,
                'response' => $employees,
                'message' => "Liste des employés avec au moins 4 objectifs validés.",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "Erreur lors de la récupération des employés.",
                'status' => false,
                'code' => 500
            ];
        }
    }

    // Employés ayant moins de 4 objectifs avec le statut 'Ok'
    // Liste des staffs dont les objectifs ont été rejété
    public function getEmployeesWithLessThan4ApprovedObjectives(): mixed
    {
        try {
            $employees = User::with('supervisor')->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->join('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
                ->where('objectives.status', 'Ok')
                ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->havingRaw('COUNT(objectives.objectiveId) < 4')
                ->orderBy('employees.employeeId')
                ->get();

            return (object) [
                'error' => null,
                'response' => $employees,
                'message' => "Liste des employés avec moins de 4 objectifs validés.",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "Erreur lors de la récupération des employés.",
                'status' => false,
                'code' => 500
            ];
        }
    }

    // Employés ayant envoyé leur auto-évaluation avec au moins 4 objectifs
    public function getEmployeesWithAtLeast4SelfEvaluations(): mixed
    {
        try {
            $employees = User::with('supervisor')->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->join('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
                ->where('objectives.selfEvaluationStatus', 'sent')
                ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->havingRaw('COUNT(objectives.objectiveId) >= 4')
                ->orderBy('employees.employeeId')
                ->get();


            return (object) [
                'error' => null,
                'response' => $employees,
                'message' => "Liste des employés avec au moins 4 auto-évaluations.",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "Erreur lors de la récupération des employés.",
                'status' => false,
                'code' => 500
            ];
        }
    }

    // Employés ayant envoyé moins de 4 auto-évaluations ou aucune
    public function getEmployeesWithLessThan4SelfEvaluations(): mixed
    {
        try {
            $employees = User::with('supervisor')->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->leftJoin('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
                ->where(function ($query) {
                    $query->whereNull('objectives.objectiveId') // Aucune auto-évaluation
                        ->orWhere(function ($query) {
                            $query->where('objectives.selfEvaluationStatus', 'sent')
                                ->groupBy('employees.employeeId')
                                ->havingRaw('COUNT(objectives.objectiveId) < 4');
                        });
                })
                ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
                ->orderBy('employees.employeeId')
                ->get();
            return (object) [
                'error' => null,
                'response' => $employees,
                'message' => "Liste des employés avec moins de 4 auto-évaluations.",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "Erreur lors de la récupération des employés.",
                'status' => false,
                'code' => 500
            ];
        }
    }

    // Employés ayant des évaluations
    public function getEmployeesWithEvaluations(): mixed
    {
        try {
            $employees = User::with('supervisor')->whereHas('evaluations')->get();

            return (object) [
                'error' => null,
                'response' => $employees,
                'message' => "Liste des employés ayant des évaluations.",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "Erreur lors de la récupération des employés.",
                'status' => false,
                'code' => 500
            ];
        }
    }
    // Employés ayant pas des évaluations
    public function getEmployeesWithoutEvaluations(): mixed
    {
        try {
            $employees = User::with('supervisor')->whereDoesntHave('evaluations')->get();;

            return (object) [
                'error' => null,
                'response' => $employees,
                'message' => "Liste des employés ayant pas des évaluations.",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'response' => false,
                'message' => "Erreur lors de la récupération des employés.",
                'status' => false,
                'code' => 500
            ];
        }
    }
}
