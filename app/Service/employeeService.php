<?php

namespace App\Service;

use App\Interface\employeeInterface;
use App\Interface\jobInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class employeeService
{
    /**
     * Create a new class instance.
     */
    public $employeeRepositorie;
    public function __construct(
        employeeInterface $employeeRepositorie,
        protected jobInterface $jobInterface
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

    public function duplicateEmployeeContract($uuid)
    {
        try {
        DB::beginTransaction();
        $employee = $this->employeeRepositorie->find('uuid', $uuid);
        $positions = $employee->data->postes;
        //  return $employee;
        if (!$positions->isNotEmpty()) {
            $employee->error = true;
            $employee->code = 422;
            $employee->message = "Please assign a post to the staff member before editing.";
            return $employee;
        }

        if (!$employee || !$employee->data) {
            $employee->code =422;
            $employee->messsage ="employe not found";
        }

            $employeeData = $employee->data;
            // 1. Rendre les anciens éléments inactifs
            $employeeData->postes()->update(['is_active' => 'inactive']);
            $employeeData->contracts()->update(['is_active' => 'inactive']);
            $employeeData->payrolls()->update(['is_active' => 'inactive']);

            // 2. Récupère les derniers (si besoin)
            $latestPosition = $employeeData->postes()->latest()->first();
            $latestContract = $employeeData->contracts()->latest()->first();
            $latestPayroll = $employeeData->payrolls()->latest()->first();

                // 3. Duplique chaque entité avec replicate()
                $newPosition =null;
            if ($latestPosition) {
                $newPosition = $latestPosition->replicate();
                $newPosition->is_active = 'active';
                $newPosition->date = now()->toDateString();
                $newPosition->save();
                // (si besoin, relie au nouvel employé ou conserve les relations)
                $employeeData->postes()->save($newPosition);
            }

            if ($latestContract) {
                $newContract = $latestContract->replicate();
                $newContract->is_active = 'active';
                $newContract->recrutement_id = $newPosition->id;
                $newContract->date = now()->toDateString();
                $newContract->save();
                $employeeData->contracts()->save($newContract);
            }

            if ($latestPayroll) {
                $newPayroll = $latestPayroll->replicate();
                $newPayroll->is_active = 'active';
                $newPayroll->recrutement_id = $newPosition->id;
                $newPayroll->date = now()->toDateString();
                $newPayroll->save();
                $employeeData->payrolls()->save($newPayroll);
            }
            
            DB::commit();

            return (object) [
                'error' => null,
                'data' => true,
                'message' => "operation successfully",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
        DB::rollBack();
        //throw $th;
            return (object) [
                'error' => $th->getMessage(),
                'data' => null,
                'message' => "An error occurred while creating or updating the draft employee",
                'status' => false,
                'code' => 500
            ];
        }
        
    }


    public function createOrUpdateDraft($request)
    {
        try {
            DB::beginTransaction();
        // create or update the draft employee
        $employee = $request->user;
        $employee =  $this->createOrUpdateDraftEmployee($employee);

        if (!$employee->data) {
            return $employee;
        }

        // create or update dependents
        // if (isset($request->dependents)) {
        //     $request->dependents = collect($request->dependents)->map(function ($dependent) use ($employee) {
        //         $dependent['draft_employee_id'] = $employee->draft_employee_id;
        //         $dependent['employee_id'] = $employee->employeeId;
        //         return $dependent;
        //     })->toArray();
        // }
        $dependents = $request->dependent ?? [];
        $dependents = $this->createOrUpdateDependents($dependents, $employee->data->id, null);
        if (!$dependents->data) {
            DB::rollBack();
            return $dependents;
        }
        // create or update emergency contacts
        $emergency = $request->emergency ?? [];
        $emergency=$this->createOrUpdateEmergencyContacts($emergency, $employee->data->id, null);
        if (!$emergency->data) {
             DB::rollBack();
            return $emergency;
        }
        // ceate or update benefits
        $beneficiaries = $request->beneficiary ?? [];
       $beneficiaries = $this->createOrUpdateBeneficiaries($beneficiaries, $employee->data->id, null);
        if (!$beneficiaries->data) {
            DB::rollBack();
            return $beneficiaries;
        }
        DB::commit();

        return (object) [
            'error' => null,
            'data' => $employee->data,
            'message' => "Draft employee created or updated successfully",
            'status' => true,
            'code' => 200
        ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return (object) [
                'error' => $th->getMessage(),
                'data' => null,
                'message' => "An error occurred while creating or updating the draft employee",
                'status' => false,
                'code' => 500
            ];
        }
    }

    public function updateByLink($request)
    {
        try {
            DB::beginTransaction();
        // create or update the draft employee
            $staff = $request->user;
            $employee = $this->employeeRepositorie->find('uuid', $staff['uuid']);


        if (!$employee || !$employee->data) {
            $employee->code =422;
            $employee->messsage ="employe not found";
        }

        // update staff
        $employeeData = $employee->data;
        $employeeData->update($request->input('user'));

        // create or update depandante
        $dependents = $request->dependent ?? [];
        $dependents = $this->createOrUpdateDependents($dependents,null, $employee->data->employeeId);
        if (!$dependents || $dependents->error) {
            DB::rollBack();
            return $dependents;
        }
        // create or update emergency contacts
        $emergency = $request->emergency ?? [];
        $emergency=$this->createOrUpdateEmergencyContacts($emergency,null, $employee->data->employeeId);

        if (!$emergency || $emergency->error) {
            DB::rollBack();
            return $emergency;
        }
        // ceate or update benefits
        $beneficiaries = $request->beneficiary ?? [];
        $beneficiaries = $this->createOrUpdateBeneficiaries($beneficiaries,null, $employee->data->employeeId);
        if (!$beneficiaries || $beneficiaries->error) {
            DB::rollBack();
            return $beneficiaries;
        }
        DB::commit();

        return (object) [
            'error' => null,
            'data' => $employee->data,
            'message' => "Draft employee created or updated successfully",
            'status' => true,
            'code' => 200
        ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return (object) [
                'error' => $th->getMessage(),
                'data' => null,
                'message' => "An error occurred while creating or updating the draft employee",
                'status' => false,
                'code' => 500
            ];
        }
    }

    public function createOrUpdateDraftEmployee($data)
    {
        try {
            $job = $this->jobInterface->find('recrutement_id',$data['recrutement_id']);
            $draft = $this->employeeRepositorie->findDraft('personal_email',$data['personal_email']);

            if ($job && $job->data->employee) {
                $job->data =false;
                $job->error =true;
                $job->message ="Vous ne pouvez pas soumettre pour l'instant";
                $job->code=422;
                return $job ;
            }

            if ($draft && $draft->data) {
                $draft->data =false;
                $draft->error =true;
                $draft->message ="Vous ne pouvez pas soumettre pour l'instant";
                $draft->code=422;
                return $draft ;
            }

           

            $draftEmployee = $this->employeeRepositorie->updateOrCreateDraft($data);
            if (!$draftEmployee->data) {
                return (object) [
                    'error' => $draftEmployee->error,
                    'data' => null,
                    'message' => "Draft employee not found",
                    'status' => false,
                    'code' => 404
                ];
            }
            return (object) [
                'error' => null,
                'data' => $draftEmployee->data,
                'message' => "Draft employee created or updated successfully",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => null,
                'message' => "An error occurred while creating or updating the draft employee",
                'status' => false,
                'code' => 500
            ];
        }
        
    }


    public function createOrUpdateDependents($dependents,$draft_employee_id =null,$employeeId=null)
    {
        try {
            foreach ($dependents as $dependent) {
                $dependent['draft_employee_id'] = $draft_employee_id;
                $dependent['employee_id'] = $employeeId;
                $dependents= $this->employeeRepositorie->createOrUpdateDependent($dependent);
                if ($dependents->error) {
                        return $dependents;
                        break;
                    }
            }

            return (object) [
                'error' => null,
                'data' => true,
                'message' => "Dependents created or updated successfully",
                'status' => true,
                'code' => 200
            ];
        } catch (\Throwable $th) {
            return (object) [
                'error' => $th->getMessage(),
                'data' => false,
                'message' => "An error occurred while creating or updating dependents",
                'status' => false,
                'code' => 500
            ];
        }
    }

    public function createOrUpdateEmergencyContacts($emergency, $draft_employee_id = null, $employeeId = null)
    {
       try {
        
        foreach ($emergency as $contact) {
            $contact['draft_employee_id'] = $draft_employee_id;
            $contact['employee_id'] = $employeeId;
            $emergency= $this->employeeRepositorie->createOrUpdateEmergencyContact($contact);
            if ($emergency->error) {
                return $emergency;
                break;
            }
        }

        return (object) [
            'error' => null,
            'data' => $emergency,
            'message' => "Emergency contacts created or updated successfully",
            'status' => true,
            'code' => 200
        ];
       } catch (\Throwable $th) {
        //throw $th;
        return (object) [
            'error' => $th->getMessage(),
            'data' => false,
            'message' => "An error occurred while creating or updating emergency contacts",
            'status' => false,
            'code' => 500
        ];
       }
    }

    public function createOrUpdateBeneficiaries($beneficiaries, $draft_employee_id = null, $employeeId = null)
    {
       try {
        foreach ($beneficiaries as $beneficiary) {
            $beneficiary['draft_employee_id'] = $draft_employee_id;
            $beneficiary['employee_id'] = $employeeId;
            $beneficiaries = $this->employeeRepositorie->createOrUpdateBeneficiary($beneficiary);

            if ($beneficiaries->error) {
                return $beneficiaries;
                break;
            }
        }

        return (object) [
            'error' => null,
            'data' => true,
            'message' => "Beneficiaries created or updated successfully",
            'status' => true,
            'code' => 200
        ];
       } catch (\Throwable $th) {
        //throw $th;
        return (object) [
            'error' => $th->getMessage(),
            'data' => false,
            'message' => "An error occurred while creating or updating beneficiaries",
            'status' => false,
            'code' => 500
        ];
       }
    }


    public function find($identifier)
    {
        return $this->employeeRepositorie->find('uuid',$identifier,[
            'posteActif',
            'dependents',
            'emergencyContacts',
            'beneficiaries',
            'payrollActif',
            'contractActif',
            'postes' => function ($query) {
                    $query->with(['contract','payroll'])
                    ->orderByRaw("CASE WHEN is_active = 'active' THEN 0 ELSE 1 END ASC");
                }
        ]);
    }

    public function importEmployee($request)
    {

        $fields=[
                'employeeId',
                'uuid', 
                'matricule',
                'lastName',
                'firstName',
                'jobTitle',
                'phone2',
                // 's.lastName as supervisorLastName',
                // 's.firstName as supervisorFirstName',
                'matricule',
                ]  ;

                // 'e.employeeId',
                // 'e.uuid',
                // 'e.matricule',
                // 'e.lastName',
                // 'e.firstName',
                // 'e.jobTitle',
                // 'e.phone2',
                // 's.lastName as supervisorLastName',
                // 's.firstName as supervisorFirstName',
                // 'e.matricule',
                // 'e.lastName as employeeLastName',
                // 'e.firstName as employeeFirstName',
                // 'e.jobTitle as Title',

        $requestData = $request->all();  
        $requestData[] = 'supervisor';  
        return $this->employeeRepositorie->getAllBy(0,$requestData,$fields);
    }

    public function findByLink($identifier)
    {
        return $this->employeeRepositorie->find('uuid',$identifier,[
            'dependents',
            'emergencyContacts',
            'beneficiaries',
        ]);
    }
    public function createOrUpdatePayroll($request)
    {
        $employee =  $this->employeeRepositorie->find('employeeId',$request->employee_id);
        $positions = $employee->data->postes;
        //  return $employee;
        if (!$positions->isNotEmpty()) {
            $employee->error = true;
            $employee->code = 422;
            $employee->message = "Please assign a post to the staff member before editing.";
            return $employee;
        }
        // return $employee;
        if (!$employee->data->payrolls) {
            
        }
        $employee->data->payrolls()->updateOrCreate([
                'id'=>$request->id ?? null,
                'employee_id'=>$request->employee_id ?? null
            ],
            $request->all()
            );
            $employee->message="operation successfull";
            return $employee;
    }

    public function createOrUpdateContract($request)
    {
        $employee=  $this->employeeRepositorie->find('employeeId',$request->employee_id);
        $positions = $employee->data->postes;
        if (!$positions->isNotEmpty()) {
            $employee->error = true;
            $employee->code = 422;
            $employee->message = "Please assign a post to the staff member before editing.";
            return $employee;
        }

        $employee->data->contracts()->updateOrCreate([
                'id'=>$request->id ?? null,
                'employee_id'=>$request->employee_id ?? null
            ],
            $request->all()
            );
            $employee->data->matricule = $request->resno;
            $employee->data->save();
            $employee->message="operation successfull";
            return $employee;
    }

    public function assignPostToEmployee($request)
    {
        $employee=  $this->employeeRepositorie->find('uuid',$request->uuid);
        if (!$employee || !$employee->data) {
            $employee->code= 404;
            $employee->error= true;
            $employee->data= false;
            $employee->message='This staff is not found.' ;
            return $employee;
        }

        $job =  $this->jobInterface->find('recrutement_id',strtolower($request->recrutement_id));
        if (!$job || !$job->data) {
            $job->code= 404;
            $job->error= true;
            $job->data= false;
            $job->message='This post is not found.' ;
            return $job;
        }
        if ($job->data->employee_id !== null) {
            $job->code= 422;
            $job->error= true;
            $job->data= false;
            $job->message='This post is already assigned to an staff.' ;
            return $job;
        }

        $job->data->employee_id = $employee->data->employeeId;
        $job->data->save();

        return $employee;
        
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
        return $this->employeeRepositorie->getAll();
    }

    public function ApprouveEmployeDraft($uuid)
    {
        try {
            DB::beginTransaction();
            $draft = $this->employeeRepositorie->findDraft('uuid', $uuid);
            $job = $this->jobInterface->find('recrutement_id',$draft->data->recrutement_id);
            if ($job && $job->data->employee) {
                $job->data =false;
                $job->error =true;
                $job->message ="ce poste est deja attribue";
                $job->code=422;

                return $job ;
            }

            $fields = [
                'firstName', 'uuid', 'lastName', 'date_of_birth', 'country_of_birth',
                'gender', 'nationality_1', 'nationality_2', 'indentity_number',
                'social_security_number', 'permanent_address', 'country_of_residence',
                'town_of_residence', 'phone', 'marital_status',
                'number_of_children', 'family_living_with_staff', 'family_residence_location',
                'spouse_works', 'spouse_workplace',
            ];

            if ($draft && !$draft->data ) {
                $draft->code = 404;
                $draft->status  = false;
                $draft->error  = true;
                $draft->message ="draft not found";
                return $draft ;
            }

            
                // return $draft ;
            $data = collect($draft->data)->only($fields)->toArray();
            $data['jobTitle'] ='';
            $data['password'] ='';

            $employee = $this->employeeRepositorie->updateOrCreate($data);

            if ($employee->error) {
                DB::rollBack();
                $employee->message ="erreur employee";
                return $employee;
            }

            if ($job && $job->data) {
                $job->data->employee_id = $employee->data->employeeId;
                $job->data->save();
            }

            $draft->data->dependents()->update(
                [
                'employee_id' => $employee->data->employeeId]
            );

            $draft->data->emergencyContacts()->update(
                [
                'employee_id' => $employee->data->employeeId]
            );

            $draft->data->beneficiaries()->update(
                [
                'employee_id' => $employee->data->employeeId
                ]
            );

            $response =null;
            $response =  $this->employeeRepositorie->updateOrCreateEmployeePayroll([
                'employee_id' => $employee->data->employeeId,
                'recrutement_id' => $job->data->id,
            ]);
            if ($response && $response->error) {
                DB::rollBack();
                $response->message = "erreur payroll";
                return $response;
            }
            $response= $this->employeeRepositorie->updateOrCreateEmployeeContract([
                'employee_id' => $employee->data->employeeId,
                'recrutement_id' => $job->data->id,
            ]);
            if ($response && $response->error) {
                DB::rollBack();
                $response->message = "erreur contract";
                return $response;
            }
            $draft->data->delete();

            DB::commit();

            // $employee->data->load('dependents', 'emergencyContacts', 'beneficiaries', 'contract', 'payroll', 'position');
            return $employee;

        } catch (\Throwable $th) {

        DB::rollBack();
        return (object) [
            'error' => $th->getMessage(),
            'data' => null,
            'message' => "An error occurred while approving the draft employee",
            'status' => false,    
            'code' => 500
        ];  
        //throw $th;
       }
    }

    public function getAllDraft()
    {
        return $this->employeeRepositorie->getAllDraft(['dependents', 'emergencyContacts', 'beneficiaries']);
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