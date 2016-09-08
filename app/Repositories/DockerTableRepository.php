<?php

namespace App\Repositories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Collection;
use App\Providers\DockerServiceProvider;


class DockerTableRepository
{

    protected $application;
    protected $dockerServiceProvider;

    public function __construct(Application $application, DockerServiceProvider $dockerServiceProvider) {
        $this->application = $application;
        $this->dockerServiceProvider = $dockerServiceProvider;
    }

    private function getDbName($idApplication){

        $dbName = $this->application
                                    ->select('db_name')
                                    ->where('id','=', $idApplication)
                                    ->first();
        return $dbName->db_name;

    } 

    public function getTables(Array $inputs){
        //récupération du nom de la Base de donnée

        $tables = "use " . $this->getDbName($inputs['idApplication']) . "; SHOW tables;";

        

        return $tables;
    }

    /**
    * Méthode pour enregistrer une nouvelle actualité en base de donnée
    *
    * @param $inputs = valeur des champs enregistrés
    *
    * @return array() $actuality
    *
    */
    public function store(Array $inputs)
    {
        // var_dump($inputs['nameColumnsTable']);die;
        // dd($inputs['nameColumnsTable']);
        //AIME PAS LES VARCHAR
 
        $createTable = "use" . $this->getDbName($inputs['idApplication']) . "; create table if not exists " . $inputs['name_table'] . " ( " .

                            $string = "id INT UNSIGNED NOT NULL AUTO_INCREMENT,"; 

                            foreach($inputs['nameColumnsTable'] as $valNameColumnsTable){
                                    $string .= " " . $valNameColumnsTable->name;
                                    $string .= " " . $valNameColumnsTable->type;
                                    $string .= " " . $valNameColumnsTable->nullable . ",";
                            }
                           
                        "PRIMARY KEY(id)
                    )
                    ENGINE=INNODB;";

        //bash qui créer les tables;

        return $createTable;

        
    }

    /**
    * Méthode pour modifier une actualité
    *
    * @param $id = id de l'actualité
    *
    * @param $inputs = valeur des champs existants
    */
    public function update(Array $inputs)
    {
    }

    /**
    * Méthode pour modifier une actualité existante en base de donnée
    *
    * @param $actuality = le Model Actualite
    *
    * @param $inputs = valeur des champs enregistrés
    */
    private function save(Array $inputs)
    {
        
        $destroy = $this->destroy($inputs['name_table']);
        $create = $this->create($inputs);

        return ($destroy && $create);
    }

    /**
    * Méthode pour delete une actualité
    *
    * @param $id = id de l'actualité
    *
    */
    public function destroy(Array $inputs)
    {
        $dropTable = "use " . $this->getDbName($inputs['idApplication']) . "; drop table " . $inputs['name_table'] . ";";

        //petit coup de bash

        return $dropTable;
    }

}