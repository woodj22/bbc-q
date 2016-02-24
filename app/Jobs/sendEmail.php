<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 23/02/2016
 * Time: 16:56
 */
namespace app\Jobs;


use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;



class SendEmail
{

    public function sendEmail()

    {



        $data = ['name' => 'luke',
            'email' => 'joe.wood@bbc.co.uk'];


        Mail::send('emails', $data, function ($message) {
            $message->from('us@example.com', 'Laravel');

            $message->to('joe.wood@bbc.co.uk');
        });


        echo "email has been sent";


    }
}