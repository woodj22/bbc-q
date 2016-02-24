<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmail;

class EmailController extends Controller
{
    public function index()
    {

     //   return view('emails');

    }
    public function sendEmail(SendEmail $sendEmail)
    {

        $sendEmail->sendEmail();


        echo "email job has been called";

/*

    $data = ['name'=> 'luke',
    'email'=>'joe.wood@bbc.co.uk'];


        Mail::send('emails', $data, function ($message) {
            $message->from('us@example.com', 'Laravel');

            $message->to('joe.wood@bbc.co.uk');
        });
*/


    }








}