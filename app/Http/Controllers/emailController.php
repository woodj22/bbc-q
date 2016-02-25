<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmail;
use App\Job;

class EmailController extends Controller
{
    public function index()
    {

     //   return view('emails');

    }
    public function handle(SendEmail $sendEmail)
    {


       $sendEmail->sendEmail();


        echo "email job has been called";



    }








}