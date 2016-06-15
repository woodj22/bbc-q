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

        $sharedSecret = "password";

        header('Access-Control-Allow-Origin', '*');

        header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        //    echo  $request;
        if($request->header('sharedKey')) {

            echo "hello world";

          if($request->header('sharedKey')== $sharedSecret){


              echo "hello world";

              return $next($request);

          }

          //  return Redirect('home');
        }
        return \App::abort(403, 'Access denied');

    }


}