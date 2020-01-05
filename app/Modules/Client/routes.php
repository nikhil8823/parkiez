<?php
//Route::post('/isEmailExist','AuthController@isEmailExist');
Route::group(array('prefix' => 'client', 'module' => 'Clinet', 'namespace' => 'App\Modules\Client\Controllers'), function() {
    
    Route::get('/','AuthController@getLogin');
    Route::post('/login', 'AuthController@login');
    Route::get('/forgotPassword','AuthController@forgotPassword');
    Route::post('/isEmailExist','AuthController@isEmailExist');
    
    Route::group(array('middleware' => ['verifyClient']), function(){
    });

});