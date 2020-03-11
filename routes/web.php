<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {	

    Route::get('/home', 'HomeController@index')->name('home');

    Route::post('/claimdetail', 'HomeController@claimdetail')->name('claimdetail');

    Route::get('/usermanage', 'UserController@getusers')->name('usermanage');

    Route::post('/adduser', 'UserController@adduser')->name('adduser');

    Route::post('/edituser', 'UserController@edituser')->name('edituser');

    Route::post('/deleteuser', 'UserController@deleteuser')->name('deleteuser');

    Route::post('/search_result', 'HomeController@search_result')->name('search_result');

    Route::post('/submit_detail', 'HomeController@submit_detail')->name('submit_detail');

    Route::get('/success', 'HomeController@success')->name('success');

    Route::get('/imei_data', 'HomeController@imei_data')->name('imei_data');

    Route::post('/delete_imei', 'HomeController@delete_imei')->name('delete_imei');
    
    Route::get('/edit_imei/{id}', 'HomeController@edit_imei')->name('edit_imei');

    Route::post('/search_imei', 'HomeController@search_imei')->name('search_imei');

    Route::get('/service_center', 'ServiceCenterController@service_center')->name('service_center');

    Route::post('/add_location', 'ServiceCenterController@add_location')->name('add_location');
    
    Route::post('/edit_location', 'ServiceCenterController@edit_location')->name('edit_location');

    Route::post('/delete_location', 'ServiceCenterController@delete_location')->name('delete_location');

    // Route::get('/import-excel', 'ImportImeiController@index');
    Route::get('/import-excel', 'ImportImeiController@index');
    
    Route::post('import-excel', 'ImportImeiController@import');

});



