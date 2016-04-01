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


class TaskController extends RestController
{
    protected $modelType = 'App\Task';
    protected $postFields = [];
    protected $putFields = [];
    protected $allowedFilters = ['job_type','task_id','id'];
    protected $exceptionCaught;

    protected $allowedSearchFilters = [
        'job_type',

    ];

}