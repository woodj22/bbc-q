<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 26/02/2016
 * Time: 15:13
 */

namespace App\Jobs;
use Faker\Provider\DateTime;
use Carbon\Carbon;

abstract class JobModel

{
   // public $params;
    abstract protected function run($payload);
    protected  $statusVar ;
    abstract protected function activate();
    protected $taskIdVar;
    abstract protected function setup($taskId,$payload);


    function decodeJson($payload)
    {

        $jsonDecode = json_decode($payload, true);

        return $jsonDecode;
    }


    function getStatus()
    {

        return $this->statusVar;
    }

    function getTime(){
        $mytime = Carbon::now();
         return $mytime;
    }
    public function setTaskId ($taskId){

            $this->taskIdVar = $taskId;
        return $this->taskIdVar;

    }
    function getTaskId(){

        return $this->taskIdVar;
    }

    public function setStatus($status){

        $this->statusVar = $status;

        return  $this->statusVar;
    }
}
