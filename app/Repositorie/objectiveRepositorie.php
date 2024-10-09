<?php

namespace App\Repositorie;

use App\Interface\objectiveInterface;
use App\Models\Objective;
use Illuminate\Support\Facades\DB;

class objectiveRepositorie implements objectiveInterface
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
            $Objective = Objective::create($data);
            DB::commit();

            return (object) [
                'error' => null,
                'response' => $Objective,
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

    public function objectiveOne($data): mixed
    {

        try {
            $ObjectiveOne = Objective::where('phone', $data)
                ->orWhere('email', $data)
                ->first();
            return (object) [
                'error' => null,
                'response' => $ObjectiveOne,
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

    public function objectiveExist($email = null, $phone = null): mixed
    {
        try {
            $ObjectiveOne = Objective::where('phone', $phone)
                ->orWhere('email', $email)->first();

            return (object) [
                'error' => null,
                'response' => $ObjectiveOne,
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

    public function getAll(): mixed
    {

        try {
            $Objective = Objective::orderBy('created_at', 'desc')
                ->get();
            return (object) [
                'error' => null,
                'response' => $Objective,
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

            $Objective = Objective::where('employeeId', $id)
                ->where('employeeUid', $uid)
                ->first();

            return (object) [
                'error' => null,
                'response' => $Objective,
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

    public function update($data): mixed
    {

        try {

            DB::beginTransaction();

            $Objective = $this->objectiveOne($data);
            $Objective = $Objective["response"];
            if ($Objective) {
                // L'entrée avec l'ID existe, mettre à jour les données
                $Objective->update($data);
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
                'response' => $Objective,
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
    public function delete(): mixed
    {
        try {
            DB::beginTransaction();

            $Objective = $this->objectiveOne();

            if ($Objective->response) {
                // L'entrée avec l'ID existe, mettre à jour les données
                $Objective->response->delete();
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
                'response' => $Objective,
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
}
