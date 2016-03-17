<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{

    protected $casts = [

        'samAccountName' => 'string',
        'cn' => 'string',
        'department'=> 'string',
        'divison'=>'string',
        'surname'=>'string',
        'givenName'=>'string',
        'displayName'=>'string',
        'employeeID'=>'integer',
        'mail'=>'string',
        'personalTitle'=>'string',

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
