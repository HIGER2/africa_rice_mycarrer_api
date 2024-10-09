<?php

namespace App\Service;

use App\Interface\settingInterface;
use App\Interface\stepIterface;

class settingService
{
    /**
     * Create a new class instance.
     */
    public $settingRepositorie;
    public $stepRepositorie;
    public function __construct(

        settingInterface $settingRepositorie,
        stepIterface $stepRepositorie
    ) {
        $this->settingRepositorie = $settingRepositorie;
        $this->stepRepositorie = $stepRepositorie;
    }


    public function create($request)
    {
        return $this->settingRepositorie->create($request->all());
    }

    public function updateSetting($request)
    {

        $setting = '';
        foreach ($request->all() as $key => $data) {
            $setting = $this->settingRepositorie->getOne($data['settingId']);
            $this->settingRepositorie->update($setting->response, $data);
        }

        return $setting;
    }


    public function getSettingAll()
    {
        return $this->settingRepositorie->getAll();
    }

    public function getStepAll()
    {
        return $this->stepRepositorie->getAll();
    }

    public function updateStep($request)
    {
        $step = $this->stepRepositorie->getOne($request->stepId);
        return $this->stepRepositorie->update($step->response, $request->all());
    }
}
