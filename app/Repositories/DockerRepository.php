<?php

namespace App\Repositories;


use App\Models\Application;
use App\User;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use App\Providers\DockerServiceProvider;

class DockerRepository
{

    protected $application;
    protected $user;
    protected $subscription;
    protected $dockerServiceProvider;

    public function __construct(Application $application, User $user, Subscription $subscription, DockerServiceProvider $dockerServiceProvider){
        $this->application = $application;
        $this->user = $user;
        $this->subscription = $subscription;
        $this->dockerServiceProvider = $dockerServiceProvider;
    }


    /**
    *
    * Permet de récupérer toutes les applications d'un user
    *
    * @param integer $userId
    *
    * @return Array $applications
    *
    */
    public function getApplications($userId){
        $user = $this->user
                            ->with('applications')
                            ->select('*')
                            ->where('id', '=', $userId)
                            ->first();
        return $user;
    }

    /**
    * Permet de récuprer les infos d'une appli
    * 
    * @param int $id
    *
    * @return $application
    *
    */
    public function findApplicationById($id){

        $application = $this->application
                                        ->select('applications.*')
                                        ->where('applications.id', '=', $id)
                                        ->first();

        // dd($application->toSql());
        return $application;
    }

    /**
    * Permet de retrouver le nombre d'appli que la personne a le droit de créer
    *
    * @param int $userId
    *
    * @return boolean $nbApplication
    *
    */
    public function findNbAppliSubscriptions($userId){

        $userSubscription = $this->user
                                        ->with('subscriptions')
                                        ->select('*')
                                        ->where('id', '=', $userId)
                                        ->first();

        foreach($userSubscription->subscriptions as $valUserSubscription){

            if($valUserSubscription->subscriptions_types_id == true) {    
                $subscriptions_types_id = $valUserSubscription->subscriptions_types_id;
            }
        
        }

        $nbApplication = $this->subscription
                                            ->rightjoin('subscriptions_types', 'subscriptions_types.id','=','subscriptions_types_id')
                                            ->select('subscriptions_types.nbApplication')
                                            ->where('subscriptions_types.id','=', $subscriptions_types_id)
                                            ->first();


        return $nbApplication;
    }

    private function getUser($idUser){

        $user = $this->user
                            ->select('lastname')
                            ->where('id','=', $idUser)
                            ->first();

        return $user->lastname;
    }

    /**
    * Permet de créer une appli
    *
    * @param Array $inputs
    *
    * @return boolean (!$error && $result)
    *
    */
    public function store(Array $inputs)
    {

        $initDocker = $this->dockerServiceProvider->initDocker($inputs['db_name'] ,$this->getUser($inputs['userId']));

        if($initDocker['status'] === 'fail' ){
            return $initDocker;
        }

        $application = new $this->application;
        $application->id_docker = $initDocker['idDocker'];
        $application->name = $inputs['db_name'];
        $application->db_name = $inputs['db_name'];

        //donner par le bash
        $application->password_user = $initDocker['dbPassword'];
        $application->login_user = $this->getUser($inputs['userId']);
        $application->description = $inputs['description'];
        $application->created_at = time();
        $application->updated_at = time();

        $result = $application->save();

        $error = $application->users()->attach($inputs['userId']);

        return (!$error && $result);

    }

    /**
    * Permet d'update le nom et la description de l'appli
    *
    * @param Array $inputs
    * @param int $id
    *
    * @return boolean $updateApplication
    *
    */
    public function update(Array $inputs)
    {
        $updateApplication = $this->save($inputs, $this->findApplicationById($inputs['idApplication']));
        return $updateApplication;
    }

    /**
    * Permet de save l'update de l'appli
    *
    * @param Array $inputs
    * @param Object $application
    *
    * @return boolean
    *
    */
    private function save(Array $inputs, Application $application)
    {
        $application->name = $inputs['name'];
        $application->description = $inputs['description'];
        $application->created_at = time();
        $application->updated_at = time();

        return $application->save(); 
    }

    /**
    * Permet de destroy l'appli
    *
    * @param int $idApplication
    *
    * @return boolean $detach && $delete
    *
    */
    public function destroy($idApplication)
    {
        $getDocker = $this->findApplicationById($idApplication);

        $destroyDocker = $this->dockerServiceProvider->destroyDocker($getDocker->id_docker);

        if($destroyDocker['status'] === 'fail'){
            return false;
        }

        $detach = $this->findApplicationById($idApplication)->users()->detach();
        $delete = $this->findApplicationById($idApplication)->delete();

        return ($delete && $detach);
    }


}
