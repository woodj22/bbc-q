<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Jobs\JobCollector;

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



}