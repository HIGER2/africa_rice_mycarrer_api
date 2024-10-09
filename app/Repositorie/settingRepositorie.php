<?php

namespace App\Repositorie;

use App\Interface\settingInterface;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class settingRepositorie implements settingInterface
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
            $Setting = Setting::create($data);
            DB::commit();

            return (object) [
                'error' => null,
                'response' => $Setting,
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
            $Setting = Setting::get();
            return (object) [
                'error' => null,
                'response' => $Setting,
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

            $Setting = Setting::where('settingId', $id)
                ->first();
            return (object) [
                'error' => null,
                'response' => $Setting,
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
                'response' => $Setting,
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
