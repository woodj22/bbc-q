<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Task extends Model
{


    protected $casts = [
        'id' => 'integer',
        'job_id' => 'integer'
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



