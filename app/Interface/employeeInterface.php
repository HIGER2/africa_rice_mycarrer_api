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
    public function createOrUpdateDependent($data): mixed;
    public function createOrUpdateEmergencyContact($data): mixed;
    public function createOrUpdateBeneficiary($data): mixed;
    public function updateOrCreateDraft($data): mixed;
    public function getAllDraft($relation=[]): mixed;
    public function findDraft($key,$data): mixed;
    public function updateOrCreate($data): mixed;
    public function updateOrCreateEmployeePayroll($data): mixed;
    public function updateOrCreateEmployeeContract($data): mixed;
    public function updateOrCreateEmployeeRecruitment($data): mixed;
    public function find($colonne, $value, $relation = []): mixed;
}
