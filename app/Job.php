<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Job extends Model
{

    protected $casts = [
        'id' => 'integer',
        'task_id' => 'integer',
        'job_type'=> 'string',
        'parameter'=> 'text',
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
