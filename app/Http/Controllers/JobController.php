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

                $mytime = Carbon\Carbon::now();
                $runAtTime = $mytime::createFromTimestamp($job->run_at);


                if($mytime >=$runAtTime) {

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
                    Job::where('id', $job->id)->update(['status' => 0]);

                }



            }


        }

    }




}