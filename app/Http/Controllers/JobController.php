<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Jobs\JobCollector;

use App\Jobs\Tasks;
use Carbon;
use App\Job;
use App\Task;



class JobController extends RestController
{
    protected $modelType = 'App\Job';
    protected $postFields = ['job_type', 'payload','status'];
    protected $putFields = ['job_type', 'payload','status'];
    protected $allowedFilters = ['job_type',];

    protected $allowedSearchFilters = [
        'job_type',

    ];

    public function store(Request $request)
    {
        return $this->rootStore($request);
    }


    public function runJobCollector(){

        $jobCollector = new JobCollector();
        $jobCollector->searchTable();

    }


    public function searchTable()


    {



        $jobList = Job::all();

        foreach ($jobList as $job) {

            if ($job->status == true) {

                $myTime = Carbon\Carbon::now();
                $runAtTime = $myTime::createFromTimestamp($job->run_at);

                echo "mtime: ".$myTime;
                echo "runAtTim: ".$runAtTime;
                if($myTime >=$runAtTime) {

                    echo "its running";

                    $jobName = 'App\\Jobs\\' . $job->job_type;
                    $jobClassToUse = new $jobName;
                    $jobClassToUse->setup($job->task_id, $job->payload, $job->job_type);
                    $job_Task_Id = $job->task_id;



                    $taskList = Task::where('task_id', $job_Task_Id)->get();


                    foreach ($taskList as $task) {


                        if ($task->status == true) {


                            $taskName = 'App\\Jobs\\Tasks\\' . $task->task_type;
                            $taskClassToUse = new $taskName;
                            $taskClassToUse->setTaskId($job->task_id);
                            $taskClassToUse->setHTML($job->job_type);

                            $taskClassToUse->run($task->payload);
                            $jStatus = $taskClassToUse->getStatus();
                            $jTime = $taskClassToUse->getTime();

                            Task::where('id', $task->id)->update(['status' => 0]);


                        }

                    }

                    if($job->recurring>0){
                        echo "this job is recurring".$job->recurring;
                        $recurringJobEntry = new Job();

                       /* Job::create(['run_at' => $runAtTime->addMinutes($job->recurring),
                            'job_type' => $job->job_type,
                            'recurring' => $job->recurring,
                            'payload' => $job->payload

                        ]);*/
                        $recurringJobEntry->run_at = $runAtTime->addMinutes($job->recurring);
                        $recurringJobEntry->job_type = $job->job_type;
                        $recurringJobEntry->recurring =$job->recurring;
                        $recurringJobEntry->payload =$job->payload;
                        $recurringJobEntry->status = 1;
                        $recurringJobEntry->task_id = $job->task_id +1;


                        $recurringJobEntry->save();

                    }
                    Job::where('id', $job->id)->update(['status' => 0]);

                }



            }


        }

    }




}