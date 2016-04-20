<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 19/04/2016
 * Time: 17:11
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;


class hasKeyMiddleware  {

    public function handle($request, Closure $next)
    {
        header('Access-Control-Allow-Origin', '*');

        header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        //    echo  $request;
        if($request->header('sharedKey')) {

            echo "hello world";

          if($request->header('sharedKey')== "woodj22"){

              echo "hello world";
          }

          //  return Redirect('home');
        }

        return $next($request);

    }


}