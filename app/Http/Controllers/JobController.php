<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Jobs\JobCollector;



class JobController extends RestController
{
    protected $modelType = 'App\Job';
    protected $postFields = ['job_type', 'payload','status'];
    protected $putFields = ['job_type', 'payload','status'];
    protected $allowedFilters = ['job_type',];

    protected $allowedSearchFilters = [
        'job_type',

    ];

    public function store(Request $request)
    {
        return $this->rootStore($request);
    }


    public function runJobCollector(){

        $jobCollector = new JobCollector();
        $jobCollector->searchTable();

    }


    public function getAttachments()
    {


/*

        $doc = new \DOMDocument();
        @$doc->loadHTML($html);

        $tags = $doc->getElementsByTagName('img');
       foreach ($tags as $tag) {

           echo $tag->getAttribute('src');
//'<?php echo $message->embed('.$tag.');
           $html = str_replace('rsgd','helo world'
               , $html);

        }


preg_match_all('/<img[^>]*src="([^"]*)"/i', $html, $matches);
       if (!isset($matches[0])) return;

       foreach ($matches[0] as $index => $img) {
           $name = 'blkimg' . $index.'.png';
           $src = $matches[1][$index];

           $path = Environment::GetSingleGlobal()->readConfig("locations.bulkImages").DIRECTORY_SEPARATOR.$name;

           $proxy = Environment::GetSingleGlobal()->readConfig("proxy");
           $client = GuzzleHelper::getClient();
           $request = $client->createRequest('GET', $src,[
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

           $mail->addEmbeddedImage($path, $name);

           $html = str_replace($src, 'cid:' . $name, $html);
*/




    }



}