<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class JobController extends RestController
{
    protected $modelType = 'App\Job';
    protected $postFields = ['job_type', 'parameter'];
    protected $putFields = ['job_type', 'parameter'];
    protected $allowedFilters = [
        'job_type',

    ];

    protected $allowedSearchFilters = [
        'job_type',

    ];


    public function store(JobRequest $request)
    {
        return $this->rootStore($request);
    }




}