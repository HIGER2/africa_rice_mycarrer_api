<?php

namespace App\Interface;

interface employeeInterface
{
    //
    public function create($data): mixed;
    public function getAll($year): mixed;
    public function getOne($id, $uid): mixed;
    public function update($model, $data): mixed;
    public function delete(): mixed;
    public function userExist($email = null): mixed;
    public function userOne($data): mixed;
    public function userOneByid($id): mixed;
    public function getEmployeesWithAtLeast4SentObjectives($year): mixed;
    public function getEmployeesWithLessThan4SentObjectives($year): mixed;
    public function getEmployeesWithAtLeast4ApprovedObjectives($year): mixed;
    public function getEmployeesWithLessThan4ApprovedObjectives($year): mixed;
    public function getEmployeesWithAtLeast4SelfEvaluations($year): mixed;
    public function getEmployeesWithLessThan4SelfEvaluations($year): mixed;
    public function getEmployeesWithEvaluations($year): mixed;
    public function getEmployeesWithoutEvaluations($year): mixed;
    public function getEmployeesDefault($year): mixed;
}
