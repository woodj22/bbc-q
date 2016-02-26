<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 24/02/2016
 * Time: 15:57
 */


//namespace App\Http\Controllers;

namespace App\Jobs;


use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Filesystem\Filesystem;

use App\Jobs;
use App\Job;


class JobCollector
{
    public function index()
    {


    }


    public function searchTable()
    {


        $jobList = Job::all();


        foreach ($jobList as $job) {

            if ($job->status == true) {


                $jobName = 'App\\Jobs\\' . $job->job_type;
                $classToUse = new $jobName;
                $classToUse->run($job->payload);


            }
        }

        // $sendEmail->sendEmail();


    }

}



