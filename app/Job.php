<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Job extends Model
{

    protected $casts = [
        'task_id' => 'integer',
        'job_type'=> 'string',
        'payload'=>'text',
        'status'=>'integer',
        'run_at'=>'timestamp',
        'recurring'=>'integer',
        'errorMessage'=>'text',


    ];



    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('c');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('c');
    }



}
