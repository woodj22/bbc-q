<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 01/03/2016
 * Time: 14:17
 */
namespace App\Jobs\Tasks;
use App\Jobs\JobModel;
use App\Task;

class ImageResize extends JobModel{


public function run ($payload){


}

    public function activate(){


    }

    public function  setup($taskId,$payload){



        $t = new Task;
        $t->task_id = $taskId;
        $t->status =1;
        $t->task_type = "ImageResize";
        $t->save();


    }

}