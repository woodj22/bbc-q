<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Jobs\Tasks\SendEmail;
use App\Job;

class EmailController extends Controller
{
    public function index()
    {

     //   return view('emails');

    }
    public function handle()
    {

        $sendEmail = new sendEmail();

        $sendEmail->activate();


        echo "email job has been called";



    }








}