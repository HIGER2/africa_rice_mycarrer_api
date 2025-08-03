<?php

namespace App\Service;

use App\Interface\jobInterface;

class jobService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected jobInterface $jobInterface
    )
    {
        //
    }


    public function createOrUpdate($request)
    {
        return $this->jobInterface->createOrUpdate($request->all());
    }

    public function all($request)
    {
        return $this->jobInterface->all();
    }

    public function find($uuid)
    {
        return $this->jobInterface->find('uuid',$uuid,['employee']);
    }
}

