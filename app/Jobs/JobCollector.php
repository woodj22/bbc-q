<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 24/02/2016
 * Time: 15:57
 */


//namespace App\Http\Controllers;

namespace App\Jobs;


use App\Listeners\jobDoneConfirmed;
use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Filesystem\Filesystem;
use App\Jobs\Tasks;

use App\Job;
use App\Task;
use DB;

class JobCollector extends controller
{


    public function searchTable()


    {


        $jobList = Job::all();
        // echo $jobList;

        foreach ($jobList as $job) {


            if ($job->status == true) {


                $jobName = 'App\\Jobs\\' . $job->job_type;
                $jobClassToUse = new $jobName;
                $jobClassToUse->setup($job->task_id, $job->payload);


                $job_Task_Id = $job->task_id;


                $taskList = Task::where('task_id', $job_Task_Id)->get();
                echo $taskList;

                //  $taskList = DB::select('select * from tasks where task_id = :id', ['id' => $job_Task_Id]);


                foreach ($taskList as $task) {


                    if ($task->status == true) {


                        $taskName = 'App\\Jobs\\Tasks\\' . $task->task_type;
                        $taskClassToUse = new $taskName;
                        $taskClassToUse->setTaskId($job->task_id);
                        echo "hello world";
                        $taskClassToUse->run($job->payload);
                        $jStatus = $taskClassToUse->getStatus();
                        $jTime = $taskClassToUse->getTime();


                        Task::where('id', $task->id)->update(['status' => 0]);

                    }

                }


                Job::where('id', $job->id)->update(['status' => 1]);


            }
        }


    }

}



