<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
{
    public function index()
    {

     //   return view('emails');

    }
    public function sendEmailReminder(EmailRequest $request, $id)
    {

        echo "hello world";
exit();

   /*
    $data = ['name'=> 'luke',
    'email'=>'joe.wood@bbc.co.uk'];


        Mail::send('emails', $data, function ($message) {
            $message->from('us@example.com', 'Laravel');

            $message->to($data['email']);
        });



*/

    }








}