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

use App\Jobs\JobModel;
use DB;

class SendEmail extends JobModel
{

    private $params;


    public function run($payload)
    {


       // $this->params = parent::decodeJson($payload);

        $jsonDecode = json_decode($payload, true);
      //  echo implode($jsonDecode,",");
         $this->params = $jsonDecode;
        $this->activate();

    }


    public function activate()

    {


        Mail::send('emails', $this->params, function ($message) {
            $message->from('us@example.com', 'Laravel');

            $message->to('joe.wood@bbc.co.uk');
        });



        echo "email has been sent";


    }


}