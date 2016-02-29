<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 26/02/2016
 * Time: 15:13
 */

namespace App\Jobs;
abstract class JobModel

{
    abstract protected function run($payload);
    abstract protected function activate();



    private $params;




    function decodeJson($payload){

        $jsonDecode = json_decode($payload, true);

        return $jsonDecode;
    }





     function returnStatus(){
            $thisReturn = 0;
         return $thisReturn;
     }

}
