<?php

namespace App\Interface;

interface employeeInterface
{
    //
    public function create($data): mixed;
    public function getAll(): mixed;
    public function getOne($id, $uid): mixed;
    public function update($model, $data): mixed;
    public function delete(): mixed;
    public function userExist($email = null): mixed;
    public function userOne($data): mixed;
    public function userOneByid($id): mixed;
    public function getEmployeesWithAtLeast4SentObjectives(): mixed;
    public function getEmployeesWithLessThan4SentObjectives(): mixed;
    public function getEmployeesWithAtLeast4ApprovedObjectives(): mixed;
    public function getEmployeesWithLessThan4ApprovedObjectives(): mixed;
    public function getEmployeesWithAtLeast4SelfEvaluations(): mixed;
    public function getEmployeesWithLessThan4SelfEvaluations(): mixed;
    public function getEmployeesWithEvaluations(): mixed;
    public function getEmployeesWithoutEvaluations(): mixed;
}
