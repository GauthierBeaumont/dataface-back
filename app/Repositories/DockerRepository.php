<?php

namespace App\Repositories;


use App\Models\Application;
use App\User;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;

class DockerRepository
{

    protected $application;
    protected $user;
    protected $subscription;

    public function __construct(Application $application, User $user, Subscription $subscription){
        $this->application = $application;
        $this->user = $user;
        $this->subscription = $subscription;
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
                            ->select('email')
                            ->where('id','=', $idUser)
                            ->first();
        return $user->email;
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

        $application = new $this->application;
        $application->id_docker = "ijztzoier5878676z5r4eg";
        $application->name = $inputs['name'];
        $application->db_name = $inputs['name'];

        //donner par le bash
        $application->password_user = "etzerg5";
        $application->login_user = $this->getUser($inputs['userId']);

        $application->url_app = "etzerg57454dsfgrytyety";
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
        $application->id_docker = "ijztzoier5878676z5r4eg";
        $application->name = $inputs['name'];
        $application->db_name = $inputs['name'];
        $application->key_user = "etzerg5";
        $application->url_app = "etzerg57454dsfgrytyety";
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
        $detach = $this->findApplicationById($idApplication)->users()->detach();
        $delete = $this->findApplicationById($idApplication)->delete();

        return ($delete && $detach);
    }


}
