<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 23/02/2016
 * Time: 16:56
 */
namespace App\Tasks;


use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
//use Storage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Guzzle;
use App\Tasks\TaskModel;
use App\Job;

use App\user;
use Illuminate\View\View;
use App\People;

class SendEmail extends TaskModel

{
    public $payloadData;
    public $htmlPage;
    public $errorExists;

    public function setup($taskId, $payload, $job_type)


    {

        $this->htmlPage = $job_type;
        $this->params = parent::decodeJson($payload);

        foreach ($this->params['info'] as $i) {

            $t = new Task;
            $t->task_id = $taskId;
            $t->status = 1;
            $t->task_type = 'SendEmail';
            $t->payload = $i;
            $t->save();
        }
        $this->payLoadData = $i;


    }

    public function run($payload)
    {

        $this->payloadData = $payload;

        $this->activate();

    }

    public function activate()

    {

        $this->getAttachments();


        $peopleData = People::where('samAccountName', $this->payloadData)->get();
        $data = [
            'samAccountName' => $peopleData[0]['samAccountName'],
            'cn' => $peopleData[0]['cn'],
            'department' => $peopleData[0]['department'],
            'division' => $peopleData[0]['division'],
            'surname' => $peopleData[0]['surname'],
            'givenName' => $peopleData[0]['givenName'],
            'displayName' => $peopleData[0]['displayName'],
            'employeeID' => $peopleData[0]['employeeID'],
            'mail' => $peopleData[0]['mail'],
            'personalTitle' => $peopleData[0]['personalTitle'],

        ];


    if (Mail::send($this->htmlPage, $data, function ($message) use ($data) {

        $message->from('ex@example.co.uk', 'Laravel');
        $message->to($data['mail']);


    })

    ) {

        echo "mail has sent";

    } else {

        return;
    }


    }


    public function getAttachments()

    {


        $html = file_get_contents('/Applications/XAMPP/htdocs/Queue/resources/views/' . $this->htmlPage . '.blade.php');

        if (preg_match_all('/<img[^>]*src="([^"]*)"/i', $html, $matches)) {

            foreach ($matches[0] as $index => $img) {


                $src = $matches[1][$index];
                $md5Src = md5($src);
                $imgName = $md5Src . '.png';

                if (strpos($src, '<?php echo $message->embed') !== false) {


                    $img = null;

                } else {
                    echo "guzzle is activated";
                    unset($matches[1][$index]);
                    $img = storage_path() . "/" . $imgName;
                    // echo $img;
                    $request = \Guzzle::get($src, [
                        'verify' => false,
                        'exceptions' => false,
                        // 'cookies' => true,
                        'proxy' => 'www-cache.reith.bbc.co.uk:80',
                        'save_to' => $img,
                    ]);

                    $html = str_replace($src, '<?php echo $message->embed(' . "'" . $img . "'" . '); ?>', $html);
                    file_put_contents(base_path() . '/resources/views/' . $this->htmlPage . ".blade.php", $html);


                }

            }
        } else {

            return;
        }


    }

    public function setError($err){


        $this->errorExists = $err;


    }

    public function getError (){

        return   $this->errorExists;
    }


}