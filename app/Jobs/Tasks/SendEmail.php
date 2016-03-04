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

use App\Jobs\JobModel;

use App\user;
use Illuminate\View\View;

class SendEmail extends JobModel
{

    public $params;
    public $multiAddress;

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

          //  $message->attach('http://www.google.com/logos/doodles/2015/googles-new-logo-5078286822539264.3-hp2x.gif');


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




                 if (strpos($src, '<?php echo $message->embed') !== false) {

                     echo 'contains php';
                    $src ='';
                    
                 }else {

                     $html = str_replace($src, '<?php echo $message->embed(' . '"' . $src . '"' . '); ?>', $html);

                 }
             }

             file_put_contents('/Applications/XAMPP/htdocs/Queue/resources/views/emails.blade.php', $html);
         }





}