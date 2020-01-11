<?php

Route::group(array('prefix' => 'client', 'module' => 'Client', 'namespace' => 'App\Modules\Client\Controllers'), function() {
    
    Route::get('/','AuthController@getLogin');
    Route::post('/login', 'AuthController@login');
    Route::get('/forgotPassword','AuthController@forgotPassword');
    Route::post('/isEmailExist','AuthController@isEmailExist');
    
    Route::group(array('middleware' => ['verifyClient']), function(){
        
        Route::get('/myParkings', 'ParkingController@myParkings');
        Route::get('/parkingDetail/{parkingId}', 'ParkingController@parkingDetail');
        Route::post('/bookingAction', 'ParkingController@bookingAction');
        Route::post('/calculatePrice', 'ParkingController@calculatePrice');
    });

});