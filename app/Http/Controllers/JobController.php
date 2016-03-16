<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Jobs\JobCollector;
use Carbon;

use App\Jobs;
use App\Job;

use App\Task;
use App\Tasks;



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

            //this method is now obsolete as seach table is done below and their is no jobCollector class.
        $jobCollector = new JobCollector();
        $jobCollector->searchTable();

    }

    public function searchTable()


    {

        $jobList = Job::all();

        foreach ($jobList as $job) {

            if ($job->status == 1) {

                Job::where('id', $job->id)->update(['status' => 1]);

                $myTime = Carbon\Carbon::now();
                $runAtTime = $myTime::createFromTimestamp($job->run_at);

                if($myTime >=$runAtTime) {


                    if(class_exists ('App\\Jobs\\'.$job->job_type)) {

                        $jobName = 'App\\Jobs\\' . $job->job_type;
                        $jobClassToUse = new $jobName;
                        $jobClassToUse->setup($job->task_id, $job->payload, $job->job_type);

                   }else{

                        echo "Job class does not exist!! Check namespace and make sure it is located in App\\Jobs folder";
                    }


                    $this->searchTaskTable($job);


                    if($job->recurring>0){
                        echo "this job is recurring".$job->recurring;


                        //creates and fills the new recurring entry into the job table.
                                    // The below line desides if the recurring event starts after the the run_at value
                                    // of the original job or if it happens from when it was run.
                                    $recurringJobEntry = new Job();
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



    public function searchTaskTable($job){

        $taskList = Task::where('task_id', $job->task_id)->get();


        foreach ($taskList as $task) {


            if ($task->status == true) {
                Task::where('id', $task->id)->update(['status' => 2]);

                $taskName = 'App\\Tasks\\' . $task->task_type;
                $taskClassToUse = new $taskName;
                $taskClassToUse->setTaskId($job->task_id);
                $taskClassToUse->setHTML($job->job_type);

                $taskClassToUse->run($task->payload);
                $jStatus = $taskClassToUse->getStatus();
                $jTime = $taskClassToUse->getTime();

                Task::where('id', $task->id)->update(['status' => 0]);


            }

        }



}




}