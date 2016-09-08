<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DockerTableRepository;
use App\Http\Requests\DockerTableRequest;

use App\Http\Requests;

class DockerTableController extends Controller
{

	protected $dockerTableRepository;

	public function __construct(DockerTableRepository $dockerTableRepository){
		$this->dockerTableRepository = $dockerTableRepository;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DockerTableRequest $request)
    {
        $tables = $this->dockerTableRepository->getTables($request->all());

        if($tables['status'] === "fail"){
            return ['message' => 'Problème de requete'];
        }
        
        if(!array_key_exists("data", $tables)){
            return ['message' => 'Vous n\'avez pas de tables dans votre application'];
        }

        return $tables['data'];

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DockerTableRequest $request)
    {
      	$table = $this->dockerTableRepository->store($request->all());

    	if($tables->status === "success"){
        	return $tables->data;
        }else{
        	return $tables->message;
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
     * @return \Illuminate\Http\Response
     */
    public function update(DockerTableRequest $request)
    {
        $this->dockerTableRepository->save($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DockerTableRequest $request)
    {
       $destroyTable = $this->dockerTableRepository->destroy($request->all());

       if($destroyTable['status'] === "fail"){
            return ['message' => 'Problème de suppression'];
        }

        return ['message' => 'la table '  . $request->input('name_table') . ' a bien été supprimée'];

    }
}
