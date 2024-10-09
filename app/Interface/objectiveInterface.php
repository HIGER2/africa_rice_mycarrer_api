<?php

namespace App\Interface;

interface objectiveInterface
{
    //
    public function create($data): mixed;
    public function getAll(): mixed;
    public function getOne($id, $uid): mixed;
    public function update($data): mixed;
    public function delete(): mixed;
}
