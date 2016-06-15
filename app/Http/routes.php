<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Http\Request;

/*
Route::post('/api/testMiddle',['middleware' => 'checkKey:READ', function () {
    return response()->json(['gone though middleware']

    );
}]); */
/*
Route::group(['middleware' => 'checkKey:READ'], function() {

    Route::resource('api/jobs', 'JobController', ['only' => ['index', 'show', 'store', 'destroy']]);

});*/

Route::get('api/do', 'JobController@runJobTable');

Route::resource('api/tasks', 'TaskController', ['only' => ['index', 'show']]);

Route::get('api/tests', 'JobController@runLdapMapper');

Route::any('foo', function () {
    $contentDirectory= base_path()."/resources/views/". $this->htmlPage . '.blade.php';
    echo $contentDirectory;

    return $contentDirectory;


});

