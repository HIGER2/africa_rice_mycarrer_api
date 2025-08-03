<?php

namespace App\Interface;

interface jobInterface
{
    public function createOrUpdate($data): mixed;
    public function all(): mixed;
    public function find($colonne, $value, $relation = []): mixed;
}
