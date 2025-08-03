<?php

namespace App\Repositorie;

use App\Interface\jobInterface;
use App\Models\Recrutement;

class jobRepositorie implements jobInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createOrUpdate($data): mixed
    {
        try {
        $recruitement = Recrutement::updateOrCreate(
                ['uuid' => $data['uuid']], // condition de recherche
                $data                         // données à mettre à jour ou insérer
            );
            return (object) [
                'error' => null,
                'response' => $recruitement,
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

    public function all(): mixed
    {
        try {
            $Recruitement = Recrutement::get();

            return (object) [
                'error' => null,
                'response' => $Recruitement,
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

    public function find($colonne, $value, $relation = []): mixed
    {
        try {
            $job = Recrutement::when(count($relation) > 0, function ($query) use ($relation) {
                    return $query->with($relation);
                })
                ->where($colonne, $value)
                ->first();

            return (object) [
                'error' => null,
                'data' => $job,
                'message' => "found",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "error",
                'status' => false,
                'code' => 500
            ];
        }
    }
}
