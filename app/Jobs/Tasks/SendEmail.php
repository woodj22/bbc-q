<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 23/02/2016
 * Time: 16:56
 */
namespace app\Jobs\Tasks;


use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Storage;
use Illuminate\Support\Facades\Guzzle;
use App\Jobs\JobModel;

use App\user;
use Illuminate\View\View;

class SendEmail extends JobModel
{

    public $params;
    public $multiAddress;
    public $data;

    public function setup($taskId, $payload)
    {

        $this->params = parent::decodeJson($payload);


        foreach ($this->params['info'] as $i) {

            $t = new Task;
            $t->task_id = $taskId;
            $t->status =1;
            $t->task_type= 'SendEmail';
            $t->save();


        }


    }

    public function run($payload)
    {


        $this->params = parent::decodeJson($payload);


        $this->activate();

    }


    public function activate()

    {




         $this->getAttachments();




        $data = [];



        Mail::send('emails', $data, function ($message) {



            $message->from('ex@example.co.uk', 'Laravel');
            $message->to($this->params['info']);


    });



    }

    public function getAttachments()

    {

         $html = file_get_contents('/Applications/XAMPP/htdocs/Queue/resources/views/emails.blade.php');


             preg_match_all('/<img[^>]*src="([^"]*)"/i', $html, $matches);

             if (!isset($matches[0])) return;


             foreach ($matches[0] as $index => $img) {

                 $src = $matches[1][$index];
                 echo $src;


                 $md5Src = md5($src );
                 $imgName= $md5Src.'.png';

              //  $this->data
                 if (strpos($src, '<?php echo $message->embed') !== false) {

                     echo 'contains php';


                       $img = null;

                     unset($matches[1][$index]);

                     break;



                }else {


                     unset($matches[1][$index]);
                     $img = '/Applications/XAMPP/xamppfiles/htdocs/Queue/storage/'.$imgName;


                   //  $client = new Client();
                     $request = \Guzzle::get($src,[
                         'verify' => false,
                         'exceptions' => false,
                        // 'cookies' => true,
                         'proxy' => 'www-cache.reith.bbc.co.uk:80',
                         'save_to' => $img,
                     ]);


                     $html = str_replace($src, '<?php echo $message->embed('."'"  . $img ."'".'); ?>', $html);
                     echo $html;

                       file_put_contents('/Applications/XAMPP/htdocs/Queue/resources/views/emails.blade.php', $html);



                   }






             }



    }





}