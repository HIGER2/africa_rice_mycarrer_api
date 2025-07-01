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

            $employees = DB::table('employees as e')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
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
                ->when($year, function ($query, $year) {
                    $query->whereYear('o.objectiveYear', $year);
                })
                ->whereNull('e.deletedAt')
                ->whereNotNull('e.matricule')
                ->get();
            // $users = User::selec()
            //     ->with('supervisor')
            //     ->when($take, function ($query) use ($take) {
            //         $query->take($take);
            //     })
            //     ->orderBy('employeeId', 'desc')
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

    public function getEmployeesWithAtLeast4SentObjectives($year): mixed
    {
        try {
            $employees = DB::table('employees as e')
                ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
                    // 'e.matricule',
                    // 'e.lastName as employeeLastName',
                    // 'e.firstName as employeeFirstName',
                    // 'e.jobTitle as Title',
                    // 's.lastName as supervisorLastName',
                    // 's.firstName as supervisorFirstName',
                    // 'e.phone2 as Division',
                    'o.objectiveYear',
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    'e.phone2',
                    's.lastName as supervisorLastName',
                    's.firstName as supervisorFirstName',
                )
                ->whereIn('o.status', ['ok', 'sent'])
                
                ->whereNull('e.deletedAt')
                ->whereNotNull('e.matricule')
                ->groupBy(
                    'o.objectiveYear',
                    'e.employeeId',
                    'e.supervisorId',
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    'e.phone2',
                    's.lastName',
                    's.firstName',
                    // 'o.objectiveYear'
                )
                ->havingRaw('COUNT(o.objectiveId) >= 4')
                ->when($year, function ($query) use ($year) {
                    $query->where('o.objectiveYear', $year);
                })
                ->orderBy('e.lastName')
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

    public function getEmployeesWithLessThan4SentObjectives($year): mixed
    {
        try {
            $employees = DB::table('employees as e')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
                    // 'e.matricule as exmatricule',
                    // 'e.lastName as employeeLastName',
                    // 'e.firstName as employeeFirstName',
                    // 'e.jobTitle as Title',
                    // 's.lastName as supervisorLastName',
                    // 's.firstName as supervisorFirstName',
                    // 'e.phone2 as Division'
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName as supervisorLastName',
                    's.firstName as supervisorFirstName',
                    'e.phone2'
                )
                ->whereNull('e.deletedAt')
                ->whereNotNull('e.matricule')
                
                ->whereNotIn('e.employeeId', function ($query) use ($year) {
                    $query->select('e.employeeId')
                        ->from('employees as e')
                        ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
                        ->whereIn('o.status', ['ok', 'sent'])
                        ->when($year, function ($query, $year) {
                                $query->where('o.objectiveYear', $year);
                            })
                        ->groupBy('e.employeeId')
                        ->havingRaw('COUNT(o.objectiveId) >= 4');
                })
                ->get();

            // $employees = User::with('supervisor')->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
            //     ->leftJoin('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
            //     ->where(function ($query) {
            //         $query->whereNull('objectives.objectiveId') // Pas d'objectifs
            //             ->orWhere(function ($query) {
            //                 $query->where('objectives.status', 'sent')
            //                     ->groupBy('employees.employeeId')
            //                     ->havingRaw('COUNT(objectives.objectiveId) < 4');
            //             });
            //     })
            //     ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
            //     ->orderBy('employees.employeeId')
            //     ->get();

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

    public function getEmployeesWithAtLeast4ApprovedObjectives($year): mixed
    {
        try {


            $employees = DB::table('employees as e')
                ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName as supervisorLastName',
                    's.firstName as supervisorFirstName',
                    'e.phone2'
                )
                ->where('o.status', 'ok')
                ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
                })
                ->groupBy(
                    'e.employeeId',
                    'e.supervisorId',
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName',
                    's.firstName',
                    'e.phone2'
                )
                ->havingRaw('COUNT(o.objectiveId) >= 4')
                ->orderBy('e.lastName')
                ->get();
            // $employees = User::with('supervisor')->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
            //     ->join('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
            //     ->where('objectives.status', 'Ok')
            //     ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
            //     ->havingRaw('COUNT(objectives.objectiveId) >= 4')
            //     ->orderBy('employees.employeeId')
            //     ->get();

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
    // Liste Self objectif review soumis
    public function getEmployeesWithLessThan4ApprovedObjectives($year): mixed
    {
        try {

            $employees = DB::table('employees as e')
                ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName as supervisorLastName',
                    's.firstName as supervisorFirstName',
                    'e.phone2'
                )
                ->where('o.selfevaluationStatus', 'sent')
                ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
                })
                ->groupBy(
                    'e.employeeId',
                    'e.supervisorId',
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName',
                    's.firstName',
                    'e.phone2'
                )
                ->havingRaw('COUNT(o.objectiveId) >= 4')
                ->orderBy('e.lastName')
                ->get();
            // $employees = User::with('supervisor')->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
            //     ->join('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
            //     ->where('objectives.status', 'Ok')
            //     ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
            //     ->havingRaw('COUNT(objectives.objectiveId) < 4')
            //     ->orderBy('employees.employeeId')
            //     ->get();

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
    // List  Self objectif evaluation approuvé
    public function getEmployeesWithAtLeast4SelfEvaluations($year): mixed
    {
        try {
            $employees = DB::table('employees as e')
                ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName as supervisorLastName',
                    's.firstName as supervisorFirstName',
                    'e.phone2'
                )
                ->where('o.evaluationStatus', 'sent')
                ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
                })
                ->groupBy(
                    'e.employeeId',
                    'e.supervisorId',
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName',
                    's.firstName',
                    'e.phone2'
                )
                ->havingRaw('COUNT(o.objectiveId) >= 4')
                ->orderBy('e.lastName')
                ->get();
            // $employees = User::with('supervisor')->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
            //     ->join('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
            //     ->where('objectives.selfEvaluationStatus', 'sent')
            //     ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
            //     ->havingRaw('COUNT(objectives.objectiveId) >= 4')
            //     ->orderBy('employees.employeeId')
            //     ->get();


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
    // Evaluation non soumis
    public function getEmployeesWithLessThan4SelfEvaluations($year): mixed
    {
        try {
            $employees = DB::table('employees as e')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName as supervisorLastName',
                    's.firstName as supervisorFirstName',
                    'e.phone2'
                )
                ->whereNull('e.deletedAt')
                ->whereNotNull('e.matricule')
                // ->when($year, function ($query, $year) {
                //     $query->whereYear('o.objectiveYear', $year);
                // })
                ->whereNotIn('e.employeeId', function ($query) use ($year) {
                    $query->select('e.employeeId')
                        ->from('employees as e')
                        ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
                        ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                        ->where('o.selfevaluationStatus', 'sent')
                        ->when($year, function ($query, $year) {
                            $query->where('o.objectiveYear', $year);
                        })
                        ->groupBy(
                            'e.employeeId',
                            'e.supervisorId',
                            'e.matricule',
                            'e.lastName',
                            'e.firstName',
                            'e.jobTitle',
                            's.lastName',
                            's.firstName',
                            'e.phone2'
                        )
                        ->havingRaw('COUNT(o.objectiveId) >= 4');
                })
                ->get();
            // $employees = User::with('supervisor')->select('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
            //     ->leftJoin('objectives', 'employees.employeeId', '=', 'objectives.employeeId')
            //     ->where(function ($query) {
            //         $query->whereNull('objectives.objectiveId') // Aucune auto-évaluation
            //             ->orWhere(function ($query) {
            //                 $query->where('objectives.selfEvaluationStatus', 'sent')
            //                     ->groupBy('employees.employeeId')
            //                     ->havingRaw('COUNT(objectives.objectiveId) < 4');
            //             });
            //     })
            //     ->groupBy('employees.employeeId', 'employees.role', 'employees.email', 'employees.supervisorId', 'employees.personalEmail', 'employees.phone2', 'employees.phone', 'employees.address', 'employees.firstName', 'employees.lastName', 'employees.password', 'employees.jobTitle', 'employees.category', 'employees.grade', 'employees.bgLevel', 'employees.matricule', 'employees.deletedAt', 'employees.secretKey')
            //     ->orderBy('employees.employeeId')
            //     ->get();
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
    // Objectifs non approuvé
    public function getEmployeesWithEvaluations($year): mixed
    {
        try {
            $employees = DB::table('employees as e')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName as supervisorLastName',
                    's.firstName as supervisorFirstName',
                    'e.phone2'
                )
                ->whereNull('e.deletedAt')
                ->whereNotNull('e.matricule')
                ->whereNotIn('e.employeeId', function ($query) use ($year) {
                    $query->select('e.employeeId')
                        ->from('employees as e')
                        ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
                        ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                        ->where('o.status', 'ok')
                        ->when($year, function ($query, $year) {
                            $query->where('o.objectiveYear', $year);
                        })
                        ->groupBy(
                            'e.employeeId',
                            'e.supervisorId',
                            'e.matricule',
                            'e.lastName',
                            'e.firstName',
                            'e.jobTitle',
                            's.lastName',
                            's.firstName',
                            'e.phone2'
                        )
                        ->havingRaw('COUNT(o.objectiveId) >= 4');
                })
                ->get();
            // $employees = User::with('supervisor')->whereHas('evaluations')->get();

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
    // Objectifs soumis non approuvé

    public function getEmployeesWithoutEvaluations($year): mixed
    {
        try {
            $employees = DB::table('employees as e')
                ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName as supervisorLastName',
                    's.firstName as supervisorFirstName',
                    'e.phone2'
                )
                ->where('o.status', 'sent') // Objectifs soumis mais pas encore approuvés
                ->whereNull('e.deletedAt')
                ->whereNotNull('e.matricule')
                ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
                })
                ->groupBy(
                    'e.employeeId',
                    'e.supervisorId',
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    's.lastName',
                    's.firstName',
                    'e.phone2'
                )
                ->havingRaw('COUNT(o.objectiveId) >= 4')
                ->orderBy('e.lastName')
                ->get();
            // $employees = User::with('supervisor')->whereDoesntHave('evaluations')->get();;

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

    public function getEmployeesDefault($year): mixed
    {
        try {
            $employees = DB::table('employees as e')
                ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
                ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
                ->select(
                    // 'e.matricule',
                    // 'e.lastName as employeeLastName',
                    // 'e.firstName as employeeFirstName',
                    // 'e.jobTitle as Title',
                    // 's.lastName as supervisorLastName',
                    // 's.firstName as supervisorFirstName',
                    // 'e.phone2 as Division',
                    // 'o.objectiveYear',
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    'e.phone2',
                    's.lastName as supervisorLastName',
                    's.firstName as supervisorFirstName',
                )
                // ->whereIn('o.status', ['ok','sent','draft'])
                
                ->whereNull('e.deletedAt')
                ->whereNotNull('e.matricule')
                ->groupBy(
                    // 'o.objectiveYear',
                    'e.employeeId',
                    'e.supervisorId',
                    'e.matricule',
                    'e.lastName',
                    'e.firstName',
                    'e.jobTitle',
                    'e.phone2',
                    's.lastName',
                    's.firstName',
                    // 'o.objectiveYear'
                )
                ->havingRaw('COUNT(o.objectiveId) >= 1')
                ->when($year, function ($query) use ($year) {
                    $query->where('o.objectiveYear', $year);
                })
                ->orderBy('e.lastName')
                ->get();

            return (object) [
                'error' => null,
                'response' => $employees,
                'message' => "Liste des employés avec au moins 4 objectifs envoyés ou pas.",
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
