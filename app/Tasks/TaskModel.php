<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 26/02/2016
 * Time: 15:13
 */

namespace App\Tasks;
use Faker\Provider\DateTime;
use Carbon\Carbon;

abstract class TaskModel

{
   // public $params;
    abstract protected function run($payload);
    protected  $statusVar ;
    abstract protected function activate();
    protected $taskIdVar;
    protected $htmlPage;
    abstract protected function setup($taskId,$payload,$job_type);


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


    public Function setHTML($htmlPage){
        //$htmlPage = "this is html page";
        $this->htmlPage = $htmlPage;
    }

    public Function getHTML(){

        return $this->htmlPage;
    }

}
