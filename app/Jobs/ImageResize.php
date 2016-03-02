<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 01/03/2016
 * Time: 14:17
 */
namespace App\Jobs;
use App\Jobs\JobModel;
use DB;

class ImageResize extends JobModel{


public function run ($payload){


}

    public function activate(){




    }

    public function  setup($taskId,$payload){

        DB::table('tasks')->insert(
            ['task_id' => $taskId,'status'=>1,'task_type'=>'ImageTask']
        );
    }

}