<?php

Route::group(['middleware' => 'web'], function () {
Route::group(array('prefix' => 'admin', 'module' => 'Admin', 'namespace' => 'App\Modules\Admin\Controllers'), function() {
    
    Route::get('/','AuthController@getLogin');
    Route::post('/login', 'AuthController@login');
    Route::get('/forgotPassword','AuthController@forgotPassword');
    Route::post('/isEmailExist','AuthController@isEmailExist');
    
    Route::group(array('middleware' => ['verifyAdmin']), function(){
        //dashboard
       Route::get('/dashboard', 'DashboardController@getDashboard');
       Route::post('/getDetails', 'DashboardController@getDetails');
       //Manage Clients
       Route::get('/manageClient',['as' => 'manageClient', 'uses' => 'ClientController@clientView']);
       Route::get('/getClientGrid', 'ClientController@getClientGridAjaxData');
       Route::any('/manageClientActions', 'ClientController@manageClientActions');
       Route::post('/isUniqueClientEmail','\App\Modules\Admin\Controllers\AuthController@isUniqueClientEmail');
       // Manage Parking
       Route::get('/manageParking',['as' => 'manageParking', 'uses' => 'ParkingController@manageParking']);
       Route::get('/getParkingGrid', 'ParkingController@getParkingGridAjaxData');
       Route::any('/manageParkingActions', 'ParkingController@manageParkingActions');
    });

});
});