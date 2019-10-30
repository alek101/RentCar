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
    return view('mainPage');
});

Route::prefix('/kriticni')->group(function()
{
    Route::get('/','MainController@kriticni');
    Route::post('/posalji1','MainController@posalji1');
    Route::post('/posalji2','MainController@posalji2');
    Route::get('/{id}','MainController@zakaziServis');
});

Route::prefix('/servis')->group(function()
{
    Route::get('/','MainController@servis');
    Route::post('/finish','MainController@endServis');
    Route::get('/{id}','MainController@servisCar');
});

Route::prefix('/prijem')->group(function()
{
    Route::get('/','MainController@prijem');
    Route::post('/izmeniKM','MainController@izmeniKM');
    
});

Route::prefix('/auto')->group(function()
{
    Route::get('/','MainController@auto');
    Route::get('/{id}','MainController@autoInfo');
});

Route::prefix('/rezervacija')->group(function()
{
    Route::get('/','MainController@rezervacija1');
    Route::post('/posalji1','MainController@rezervacija2');
    Route::post('/posalji2','MainController@rezervacija3');
    
});

Route::prefix('/rezervacijeInfo')->group(function()
{
    Route::get('/','MainController@rezervacijeInfo');
    
    Route::get('/cancel/{id}','MainController@cancelReservation');
});
