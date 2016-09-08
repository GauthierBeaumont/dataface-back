<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DockerRepository;
use App\Http\Requests\DockerRequest;

use App\Http\Requests;

class DockerController extends Controller
{

    protected $dockerRepository;

    public function __construct(DockerRepository $dockerRepository) {
        $this->dockerRepository = $dockerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return json Array $applications
     *
     */
    public function index(DockerRequest $request)
    {
        $applications = $this->dockerRepository->getApplications($request->input('userId'));

        if($applications != null){
            return $applications; 
        }else{
            return ['status' => 'fail', 'errorMessage' => 'il y a eu un problème d\'affichage'];
        }
                    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return json boolean $createApplication
     */
    public function store(DockerRequest $request)
    {
        $this->dockerRepository->findApplicationById($request->input('idApplication'));

        $subscription = $this->dockerRepository->findNbAppliSubscriptions($request->input('userId'));

        if($subscription->nbApplication < count($this->dockerRepository->getApplications($request->input('userId')))){
            return ['status' => 'fail', 'errorMessage' => 'Nombre d\'application atteinte'];
        }

        $createApplication = $this->dockerRepository->store($request->all());

        if($createApplication){
            return ['status' => 'success', 'message' => 'votre application à bien été créée'];
        }else{
            return ['status' => 'fail', 'errorMessage' => 'il y a eu un problème d\'enregistrement'];
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return json boolean $updateApplication
     */
    public function update(DockerRequest $request)
    {
        $updateApplication = $this->dockerRepository->update($request->except('userId'));

        if($updateApplication){
            return ['status' => 'success', 'message' => 'votre application à bien été modifiée'];
        }else{
            return ['status' => 'fail', 'errorMessage' => 'il y a eu un problème de modification'];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return json boolean $deleteApplication
     */
    public function destroy(DockerRequest $request)
    {
        $deleteApplication = $this->dockerRepository->destroy($request->input('idApplication'));

        if($deleteApplication){
            return ['status' => 'success', 'message' => 'votre application à bien été supprimée'];
        }else{
            return ['status' => 'fail', 'errorMessage' => 'il y a eu un problème de suppression'];
        }
    }
}
