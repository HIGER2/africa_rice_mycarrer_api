<?php

namespace App\Service;

use App\Interface\stepIterface;

class stepService
{
    /**
     * Create a new class instance.
     */
    public $stepRepositorie;
    public function __construct(

        stepIterface  $stepRepositorie
    ) {
        $this->stepRepositorie = $stepRepositorie;
    }


    public function create($request)
    {
        return $this->stepRepositorie->create($request->all());
    }

    public function update($request)
    {
        $setting = $this->stepRepositorie->getOne($request->settingId);
        return $this->stepRepositorie->update($setting->response, $request->all());
    }


    public function getAll()
    {
        return $this->stepRepositorie->getAll();
    }
}
