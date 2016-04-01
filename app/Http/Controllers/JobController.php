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
use Illuminate\Support\Facades\View;
use App\Task;
use App\Tasks;


class JobController extends RestController
{
    protected $modelType = 'App\Job';
    protected $postFields = ['job_type', 'payload', 'status'];
    protected $putFields = ['job_type', 'payload', 'status'];
    protected $allowedFilters = ['job_type',];
    protected $exceptionCaught;
    protected $errorList = [];

    protected $allowedSearchFilters = [
        'job_type',

    ];

    public function store(Request $request)
    {
        return $this->rootStore($request);
    }


    public function runJobCollector()
    {

        //this method is now obsolete as search table is done below and their is no jobCollector class.
        $jobCollector = new JobCollector();
        $jobCollector->searchTable();

    }

    public function runJobTable()

    {

        $jobList = Job::all();

        foreach ($jobList as $job) {

            if ($job->status >= 1) {

                $myTime = Carbon\Carbon::now();
                $runAtTime = $myTime::createFromTimestamp($job->run_at);

                if ($myTime >= $runAtTime) {


                    if (class_exists('App\\Jobs\\' . $job->job_type)) {

                        $jobName = 'App\\Jobs\\' . $job->job_type;
                        $jobClassToUse = new $jobName;
                        $jobClassToUse->setup($job->task_id, $job->payload, $job->job_type);


                    } else {

                        echo "Job class does not exist!! Check namespace and make sure it is located in App\\Jobs folder";

                    }


                    Job::where('task_id', $job->task_id)->update(['status' => 2]);

                    try {
                        $this->runTaskTable($job);
                    } catch (\Exception $e) {
                        echo "job has carried on ";

                    }
                    if ($job->recurring > 0) {
                        echo "this job is recurring" . $job->recurring;


                        //creates and fills the new recurring entry into the job table.
                        // The below line desides if the recurring event starts after the the run_at value
                        // of the original job or if it happens from when it was run.
                        $recurringJobEntry = new Job();
                        $recurringJobEntry->run_at = $runAtTime->addMinutes($job->recurring);
                        $recurringJobEntry->job_type = $job->job_type;
                        $recurringJobEntry->recurring = $job->recurring;
                        $recurringJobEntry->payload = $job->payload;
                        $recurringJobEntry->status = 1;
                        $recurringJobEntry->save();
                    }


                }


            }


        }

    }


    public function runTaskTable($job)
    {


        // $taskList = Task::where('task_id', $job->task_id)->get();
        $taskList = Task::all();

        foreach ($taskList as $task) {


            $this->exceptionCaught = false;


            if ($task->status >= 1) {
                // Task::where('id', $task->id)->update(['status' => 2]);
                $taskName = 'App\\Tasks\\' . $task->task_type;
                $taskClassToUse = new $taskName;
                //   $taskClassToUse->setTaskId($job->task_id);

                if ($task->task_id > 1) {
                    // echo $task->task_id;
                }
                $taskClassToUse->setHTML($job->job_type);


                try {


                    $taskClassToUse->run($task->payload);
                } catch (\Exception $e) {
                    $strError = 'failed to run task with id: ' . $task->id . $e->getMessage();
                    //echo $strError;
                    array_push($this->errorList, $task->id . "Error: " . $e->getMessage());

                    //array_push($this->errorList,$e->getMessage());

                    echo $strError;
                    Task::where('id', $task->id)->update(['status' => 2]);
                    Job::where('task_id', $task->task_id)->update(['errorMessage' => $strError]);
                    Job::where('task_id', $task->task_id)->update(['status' => 2]);

                    $this->exceptionCaught = true;
                    continue;

                }      //  echo "this is task id  ".$task->task_id;
                $impErrorList = implode(",", $this->errorList);
                $strError = '   failed to run tasks with id: ' . $impErrorList;

                Job::where('task_id', $task->task_id)->update(['errorMessage' => $strError]);
                //to make work fully, change status below to '0'. This is set to one for development purposes so that it dosent need to be manually change it.
                Task::where('id', $task->id)->update(['status' => 0]);

                Task::where('id', $task->id)->update(['status' => 0]);
                echo "this is job status  " . $job->status;


            }

        }

    }


    public function catchUnfinishedJobs()
    {
        $unfinishedList = Job::where('status', 2)->get();
        $view = View::make('incompleteList')->with("unfinishedList", $unfinishedList);

        return $view;
    }


}