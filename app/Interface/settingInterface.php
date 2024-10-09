<?php

namespace App\Interface;

interface settingInterface
{
    public function create($data): mixed;
    public function update($model, $data): mixed;
    public function getOne($id): mixed;
    public function getAll(): mixed;
}
