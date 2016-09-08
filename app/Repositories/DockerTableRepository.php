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

    private function getApplication($idApplication){

        $application = $this->application
                                    ->select('*')
                                    ->where('id','=', $idApplication)
                                    ->first();
        return $application;

    } 

    public function getTables(Array $inputs){
        //récupération du nom de la Base de donnée

        $application = $this->getApplication($inputs['idApplication']);

        $query = "use " . $application->db_name . "; SHOW tables;";

        $tables = $this->dockerServiceProvider->queryDockerDb($application->id_docker, $application->login_user, $application->password_user, $query);

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
        $application = $this->getApplication($inputs['idApplication']);
 
        $query = "use" . $this->getDbName($inputs['idApplication']) . "; create table if not exists " . $inputs['name_table'] . " ( " .

                            $query = "id INT UNSIGNED NOT NULL AUTO_INCREMENT,"; 

                            foreach($inputs['nameColumnsTable'] as $valNameColumnsTable){

                                    $query .= " " . $valNameColumnsTable->name;
                                    $query .= " " . $valNameColumnsTable->type;

                                    if($valNameColumnsTable->type == "varchar") {
                                        $query .= "(255)";
                                    }

                                    $query .= " " . $valNameColumnsTable->nullable . ",";
                            }
                           
                        "PRIMARY KEY(id)
                    )
                    ENGINE=INNODB;";

        $createTables = $this->dockerServiceProvider->queryDockerDb($application->id_docker, $application->login_user, $application->password_user, $query);

        return $createTables;

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
        $application = $this->getApplication($inputs['idApplication']);

        $query = "use " . $application->db_name . "; drop table " . $inputs['name_table'] . ";";

        $destroyTable = $this->dockerServiceProvider->queryDockerDb($application->id_docker, $application->login_user, $application->password_user, $query);

        return $destroyTable;
    }

}