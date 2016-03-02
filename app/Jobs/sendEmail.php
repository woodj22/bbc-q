<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 23/02/2016
 * Time: 16:56
 */
namespace app\Jobs;


use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

use App\Jobs\JobModel;
use DB;
use App\user;
use Illuminate\View\View;

class SendEmail extends JobModel
{

    public $params;
    public $multiAddress;



    public function setup($taskId,$payload){

        $this->params = parent::decodeJson($payload);


        foreach($this->params['info'] as $i){


            DB::table('tasks')->insert(
                ['task_id' => $taskId,'status'=>1,'task_type'=>'ReminderEmail']
            );



        }


    }

    public function run($payload)
    {


        $this->params = parent::decodeJson($payload);


       // $x = new Task();
/*

        $x->id('hello');
        $x->id = 'hello';
        $x->createNew();
        $x->save(); */

        $this->activate();

    }




    public function activate()

    {



            $data=[];

            Mail::send('welcome', $data, function ($message) {
                $message->from('ex@example.co.uk', 'Laravel');
                $message->to($this->params['info']);
            });







     //   echo $this->statusVar;



    }

    public function getAttachments()
    {


       // $html = file_get_contents('resources/views/emails.blade.php');
/*

        preg_match_all('/<img[^>]*src="([^"]*)"/i', $html, $matches);
        if (!isset($matches[0])) return;

        foreach ($matches[0] as $index => $img) {
            $name = 'blkimg' . $index . '.png';
            $src = $matches[1][$index];

            $path = Environment::GetSingleGlobal()->readConfig("locations.bulkImages") . DIRECTORY_SEPARATOR . $name;

            $proxy = Environment::GetSingleGlobal()->readConfig("proxy");
            $client = GuzzleHelper::getClient();
            $request = $client->createRequest('GET', $src, [
                'verify' => false,
                'allow_redirects' => true,
                'exceptions' => false,
                'connect_timeout' => 60,
                'timeout' => 60,
                'cookies' => true,
                'proxy' => $proxy,
                'save_to' => $path,
            ]);
            $response = $client->send($request);

            //  $mail->addEmbeddedImage($path, $name);

            $html = str_replace($src, 'cid:' . $name, $html);


        }

*/
    }

     function multipleAddress(){


        $p = $this->params;
        $pRecipient = $p['recipient'];
        $pE =explode(',',$pRecipient);
       // echo  $pE[0];



        return $pE;




    }




}