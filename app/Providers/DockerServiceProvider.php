<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DockerServiceProvider extends ServiceProvider
{
    public function __construct() {
      return $this;
    }
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }


    public function initDocker($dbName, $dbUser) {
      $dbPassword = str_random(20);
      $process = new Process('echo 0000 | sudo -S docker run -d -e "DB_USER='.$dbUser.'" -e "DB_PASS='.$dbPassword.'" -e "DB_NAME='.$dbName.'" sameersbn/mysql:latest || echo FAILURE');
      $process->run();
      $output = rtrim($process->getOutput(), "\n");

      if($output === 'FAILURE') {
        return array('status'=>'fail');
      }
      $dockerId = $output;

      $process = new Process('echo 0000 | sudo -S docker exec -t '.$dockerId.' sh -c \'service mysql restart\' || echo FAILURE');
      $process->run();
      $process = new Process('echo 0000 | sudo -S docker exec -t '.$dockerId.' sh -c \'mysql --user=root --execute="create user \"'.$dbUser.'\"@\"localhost\" IDENTIFIED BY \"'.$dbPassword.'\";"\' || echo FAILURE');
      $process->run();

      $process = new Process('echo 0000 | sudo -S docker exec -t '.$dockerId.' sh -c \'mysql --user=root --execute="GRANT ALL PRIVILEGES ON '.$dbName.'.* TO \''.$dbUser.'\'@\'localhost\'; FLUSH PRIVILEGES;"\' || echo FAILURE');
      $process->run();

      return array('status'=>'success', 'idDocker'=>$dockerId, 'dbPassword'=>$dbPassword);
    }

    public function destroyDocker($dockerId) {
      $process = new Process('echo 0000 | sudo -S docker kill '.$dockerId.' || echo FAILURE');
      $process->run();
      $output = rtrim($process->getOutput(), "\n");

      if($output === $dockerId) {
        return array('status'=>'success');
      }

      return array('status'=>'fail');
    }


    public function queryDockerDb($dockerId, $dbUser, $dbPassword, $query) {
      $process = new Process('echo 0000 | sudo -S docker exec -t '.$dockerId.' sh -c "mysql -u'.$dbUser.' -p'.$dbPassword.' -e\"'.$query.'\" | cat"');
      $process->run();
      $output = rtrim($process->getOutput(), "\n");
      if($output === 'FAILURE' || substr($output, 0, 5) === 'ERROR') {
        return array('status'=>'fail');
      }
      if(!$output) {
        return array('status'=>'success');
      } else {
        return $this->parseBashMysqlResult($output);
      }
    }


    public function parseBashMysqlResult($bashResult) {
      $result = [];

      $bashResult = preg_split('/\n|\r\n?/', $bashResult);
      $columns = preg_split('/\t/', $bashResult[0]);
      array_splice($bashResult, 0 , 1);
      array_splice($bashResult, -1 , 1);
      foreach($bashResult as $line) {
        $line = preg_split('/\t/', $line);
        $object = [];
        foreach($line as $key=>$value) {
          $key = $key ? $key : 0;
          $object[$columns[$key]] = $value;
        }
        array_push($result, $object);
      }
      return array('status'=>'success', 'data'=>$result);
    }
}
