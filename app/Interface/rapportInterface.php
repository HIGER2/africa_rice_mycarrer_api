<?php

namespace App\Interface;

interface rapportInterface
{
    public function listStaff($year= null);
    public function listStaffObjectivesSubmitted($year= null);
    public function listStaffWithoutObjectives($year= null);
    public function listApprovedObjectives($year= null);
    public function listSelfReviewSubmitted($year= null);
    public function listSelfEvaluationApproved($year= null);
    public function listEvaluationNotSubmitted($year= null);
    public function listObjectivesNotApproved($year= null);
    public function listObjectivesSubmittedNotApproved($year= null);
}
