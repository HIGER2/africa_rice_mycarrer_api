<?php

namespace App\Repositorie;

use App\Interface\stepIterface;
use App\Models\Step;
use Illuminate\Support\Facades\DB;

class stepRepositorie implements stepIterface
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
            $Step = Step::create($data);
            DB::commit();

            return (object) [
                'error' => null,
                'response' => $Step,
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

    public function getAll(): mixed
    {

        try {
            $Step = Step::get();
            return (object) [
                'error' => null,
                'response' => $Step,
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

    public function getOne($id): mixed
    {
        try {

            $Step = Step::where('stepId', $id)
                ->first();
            return (object) [
                'error' => null,
                'response' => $Step,
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

    public function update($model, $data): mixed
    {

        try {

            DB::beginTransaction();
            $user =  $model->update($data);
            DB::commit();
            return (object) [
                'error' => null,
                'response' => $model,
                'message' => "mise à jour effectuée",
                'status' => true,
                'code' => 200
            ];
            DB::commit();
            return (object) [
                'error' => null,
                'response' => $Step,
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
