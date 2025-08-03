<?php

namespace App\Repositorie;

use App\Interface\rapportInterface;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class rapportRepositorie implements rapportInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    // ----- Liste Staff
    public function listStaff($year= null)
    {
        $employees = Employee::from('employees as e')
            ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
            ->whereNull('e.deletedAt')
            ->whereNotNull('e.matricule')
            ->select([
                'e.matricule',
                'e.lastName as employeeLastName',
                'e.firstName as employeeFirstName',
                'e.jobTitle as title',
                's.lastName as supervisorLastName',
                's.firstName as supervisorFirstName',
                'e.phone2 as division',
            ])->get();

        return (object) [
            'error' => null,
            'response' => $employees,
            'message' => 'Liste du personnel actif.',
            'status' => true,
            'code' => 200,
        ];
    }

    // ----- Liste staff objectifs soumis
    public function listStaffObjectivesSubmitted($year= null)
    {
        $employees = Employee::from('employees as e')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
            ->where(function($q) {
                $q->where('o.status', 'ok')->orWhere('o.status', 'sent');
            })
            ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->whereNull('e.deletedAt')
            ->whereNotNull('e.matricule')
            ->groupBy('e.employeeId', 'e.matricule', 'e.lastName', 'e.firstName', 'e.supervisorId', 's.lastName', 's.firstName','e.jobTitle','e.phone2','o.objectiveYear')
            ->havingRaw('COUNT(o.objectiveId) >= 4')
            ->orderBy('e.lastName')
            ->select([
                'e.matricule',
                'e.lastName as employeeLastName',
                'e.firstName as employeeFirstName',
                'e.jobTitle as title',
                's.lastName as supervisorLastName',
                's.firstName as supervisorFirstName',
                'e.phone2 as division',
                'o.objectiveYear as year',
            ])->get();

        return (object) [
            'error' => null,
            'response' => $employees,
            'message' => 'Liste des employés avec au moins 4 objectifs soumis.',
            'status' => true,
            'code' => 200,
        ];
    }

    // ----- Staff non soumis
    public function listStaffWithoutObjectives($year= null)
    {
        $subQuery = DB::table('employees as e')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->where(function ($q) {
                $q->where('o.status', 'ok')->orWhere('o.status', 'sent');
            })
            ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->groupBy('e.employeeId')
            ->havingRaw('COUNT(o.objectiveId) >= 4')
            ->pluck('e.employeeId');

        $employees = Employee::from('employees as e')
            ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->whereNull('e.deletedAt')
            ->whereNotNull('e.matricule')
            ->whereNotIn('e.employeeId', $subQuery)
            ->select([
                'e.matricule',
                'e.lastName as employeeLastName',
                'e.firstName as employeeFirstName',
                'e.jobTitle as title',
                's.lastName as supervisorLastName',
                's.firstName as supervisorFirstName',
                'e.phone2 as division',
                'o.objectiveYear as year'
            ])->get();

        return (object) [
            'error' => null,
            'response' => $employees,
            'message' => 'Liste des employés sans objectifs soumis.',
            'status' => true,
            'code' => 200,
        ];
    }

    // ----- Objectifs Approuvés
    public function listApprovedObjectives($year= null)
    {
        $employees = Employee::from('employees as e')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
            ->where('o.status', 'ok')
            ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->groupBy('e.employeeId', 'e.matricule', 'e.lastName', 'e.firstName', 'e.supervisorId', 's.lastName', 's.firstName','e.jobTitle','e.phone2','o.objectiveYear')
            ->havingRaw('COUNT(o.objectiveId) >= 4')
            ->orderBy('e.lastName')
            ->select([
                'e.matricule',
                'e.lastName as employeeLastName',
                'e.firstName as employeeFirstName',
                'e.jobTitle as title',
                's.lastName as supervisorLastName',
                's.firstName as supervisorFirstName',
                'e.phone2 as division',
                'o.objectiveYear as year'
            ])->get();

        return (object) [
            'error' => null,
            'response' => $employees,
            'message' => 'Liste des employés avec objectifs approuvés.',
            'status' => true,
            'code' => 200,
        ];
    }

    // ----- Liste Self objectif review soumis
    public function listSelfReviewSubmitted($year= null)
    {
        $employees = Employee::from('employees as e')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
            ->where('o.selfevaluationStatus', 'sent')
             ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->groupBy('e.employeeId', 'e.matricule', 'e.lastName', 'e.firstName', 'e.supervisorId', 's.lastName', 's.firstName','e.jobTitle','e.phone2','o.objectiveYear')
            ->havingRaw('COUNT(o.objectiveId) >= 4')
            ->orderBy('e.lastName')
            ->select([
                'e.matricule',
                'e.lastName as employeeLastName',
                'e.firstName as employeeFirstName',
                'e.jobTitle as title',
                's.lastName as supervisorLastName',
                's.firstName as supervisorFirstName',
                'e.phone2 as division',
                'o.objectiveYear as year'
            ])->get();

        return (object) [
            'error' => null,
            'response' => $employees,
            'message' => 'Liste des auto-évaluations soumises.',
            'status' => true,
            'code' => 200,
        ];
    }

    // ----- List Self objectif évaluation approuvée
    public function listSelfEvaluationApproved($year= null)
    {
        $employees = Employee::from('employees as e')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
            ->where('o.evaluationStatus', 'sent')
             ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->groupBy('e.employeeId', 'e.matricule', 'e.lastName', 'e.firstName', 'e.supervisorId', 's.lastName', 's.firstName','e.jobTitle','e.phone2','o.objectiveYear')
            ->havingRaw('COUNT(o.objectiveId) >= 4')
            ->orderBy('e.lastName')
            ->select([
                'e.matricule',
                'e.lastName as employeeLastName',
                'e.firstName as employeeFirstName',
                'e.jobTitle as title',
                's.lastName as supervisorLastName',
                's.firstName as supervisorFirstName',
                'e.phone2 as division',
                'o.objectiveYear as year'
            ])->get();

        return (object) [
            'error' => null,
            'response' => $employees,
            'message' => 'Liste des évaluations approuvées.',
            'status' => true,
            'code' => 200,
        ];
    }

    // ----- Évaluation non soumise
    public function listEvaluationNotSubmitted($year= null)
    {
        $subQuery = DB::table('employees as e')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->where('o.selfevaluationStatus', 'sent')
            ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->groupBy('e.employeeId', 'e.matricule', 'e.lastName', 'e.firstName')
            ->havingRaw('COUNT(o.objectiveId) >= 4')
            ->pluck('e.employeeId');

        $employees = Employee::from('employees as e')
            ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->whereNull('e.deletedAt')
            ->whereNotNull('e.matricule')
            ->whereNotIn('e.employeeId', $subQuery)
            ->select([
                'e.matricule',
                'e.lastName as employeeLastName',
                'e.firstName as employeeFirstName',
                'e.jobTitle as title',
                's.lastName as supervisorLastName',
                's.firstName as supervisorFirstName',
                'e.phone2 as division',
                'o.objectiveYear as year'
            ])->get();

        return (object) [
            'error' => null,
            'response' => $employees,
            'message' => "Liste des employés n'ayant pas soumis leur auto-évaluation.",
            'status' => true,
            'code' => 200,
        ];
    }

    // ----- Objectifs non approuvés
    public function listObjectivesNotApproved($year= null)
    {
        $subQuery = DB::table('employees as e')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->where('o.status', 'ok')
            ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->groupBy('e.employeeId', 'e.matricule', 'e.lastName', 'e.firstName')
            ->havingRaw('COUNT(o.objectiveId) >= 4')
            ->pluck('e.employeeId');

        $employees = Employee::from('employees as e')
            ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->whereNull('e.deletedAt')
            ->whereNotNull('e.matricule')
            ->whereNotIn('e.employeeId', $subQuery)
            ->select([
                'e.matricule',
                'e.lastName as employeeLastName',
                'e.firstName as employeeFirstName',
                'e.jobTitle as title',
                's.lastName as supervisorLastName',
                's.firstName as supervisorFirstName',
                'e.phone2 as division',
                'o.objectiveYear as year'
            ])->get();

        return (object) [
            'error' => null,
            'response' => $employees,
            'message' => 'Liste des objectifs soumis mais non approuvés.',
            'status' => true,
            'code' => 200,
        ];
    }

    // ----- Objectifs soumis non approuvés
    public function listObjectivesSubmittedNotApproved($year= null)
    {
        $employees = Employee::from('employees as e')
            ->join('objectives as o', 'e.employeeId', '=', 'o.employeeId')
            ->leftJoin('employees as s', 'e.supervisorId', '=', 's.employeeId')
            ->where('o.status', 'sent')
             ->when($year, function ($query, $year) {
                    $query->where('o.objectiveYear', $year);
            })
            ->whereNull('e.deletedAt')
            ->whereNotNull('e.matricule')
            ->groupBy('e.employeeId', 'e.matricule', 'e.lastName', 'e.firstName', 'e.supervisorId', 's.lastName', 's.firstName','e.jobTitle','e.phone2','o.objectiveYear')
            ->havingRaw('COUNT(o.objectiveId) >= 4')
            ->orderBy('e.lastName')
            ->select([
                'e.matricule',
                'e.lastName as employeeLastName',
                'e.firstName as employeeFirstName',
                'e.jobTitle as title',
                's.lastName as supervisorLastName',
                's.firstName as supervisorFirstName',
                'e.phone2 as division',
                'o.objectiveYear as year'
            ])->get();

        return (object) [
            'error' => null,
            'response' => $employees,
            'message' => 'Liste des objectifs soumis mais en attente de validation.',
            'status' => true,
            'code' => 200,
        ];
    }
}
