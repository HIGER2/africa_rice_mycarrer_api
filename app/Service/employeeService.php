<?php

namespace App\Service;

use App\Interface\employeeInterface;
use Illuminate\Support\Facades\Hash;

class employeeService
{
    /**
     * Create a new class instance.
     */
    public $employeeRepositorie;
    public function __construct(

        employeeInterface $employeeRepositorie
    ) {
        $this->employeeRepositorie = $employeeRepositorie;
    }


    public function create($request)
    {
        $userExiste = $this->employeeRepositorie->userExist($request->email);
        $superviseur = $this->employeeRepositorie->userOne($request->supervisor);

        if ($userExiste->response) {
            $userExiste->code = 422;
            $userExiste->message = "cet utilisateur à déja un compte";
            return $userExiste;
        }

        if (!$superviseur->response) {
            $superviseur->code = 422;
            $superviseur->message = "ce superviseur n'existe pas";
            return $superviseur;
        }

        $request['supervisorId'] = $superviseur->response->employeeId;
        $request['password'] = Hash::make($request->matricule);
        return $this->employeeRepositorie->create($request->all());
    }


    public function update($request)
    {
        $userExiste = $this->employeeRepositorie->userOne($request->email);
        $user = $this->employeeRepositorie->userOneByid($request->employeeId);
        $superviseur = $this->employeeRepositorie->userOne($request->supervisor);

        if (!$user->response) {
            $superviseur->code = 422;
            $superviseur->message = "ce utilisateur n'existe pas";
            return $superviseur;
        }


        if ($userExiste->response && ($userExiste->response->employeeId !== $user->response->employeeId)) {
            $userExiste->code = 422;
            $userExiste->message = "cet email est déjà associé à un compte";
            $userExiste->response = null;
            return $userExiste;
        }

        if (!$superviseur->response) {
            $superviseur->code = 422;
            $superviseur->message = "ce superviseur n'existe pas";
            return $superviseur;
        }

        $request['supervisorId'] = $superviseur->response->employeeId;
        if (isset($request->password)) {
            $request->password = Hash::make($request->password);
        }
        return $this->employeeRepositorie->update($user->response, $request->all());
    }

    public function getAll()
    {
        return $this->employeeRepositorie->getAll(50);
    }

    public function getUser($id)
    {
        $response = $this->employeeRepositorie->userOneByid($id);
        if (!$response->response) {
            $response->code = 422;
            $response->message = "ce utilisateur n'existe pas";
            return $response;
        }
        return $response;
    }
}