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
    return view('index');
});

Route::get('/glavna','MainController@kriticni')->middleware('login');

Route::prefix('/kriticni')->middleware('login')->group(function()
{
    Route::get('/','MainController@kriticni');
    Route::post('/posalji1','MainController@posalji1');
    Route::post('/posalji2','MainController@posalji2');
    Route::get('/{id}','MainController@zakaziServis');
});

Route::prefix('/servis')->middleware('login')->group(function()
{
    Route::get('/','MainController@servis');
    Route::post('/finish','MainController@endServis');
    Route::get('/{id}','MainController@servisCar');
});

Route::prefix('/prijem')->middleware('login')->group(function()
{
    Route::get('/','MainController@prijem');
    Route::post('/izmeniKM','MainController@izmeniKM');
    
});

Route::prefix('/auto')->middleware('login')->group(function()
{
    Route::get('/','MainController@auto');
    Route::get('/{id}','MainController@autoInfo');
});

Route::prefix('/rezervacija')->middleware('login')->group(function()
{
    Route::get('/','MainController@rezervacija1');
    Route::post('/posalji1','MainController@rezervacija2');
    Route::post('/posalji2','MainController@rezervacija3');
    Route::post('/posalji3','MainController@rezervacija4');
    
});

Route::prefix('/rezervacijeInfo')->middleware('login')->group(function()
{
    Route::get('/','MainController@rezervacijeInfo');
    Route::post('forma1','MainController@rezervacijeSveForm');
    Route::get('/sve','MainController@rezervacijeSve');
    Route::get('/sve/{num}','MainController@rezervacijeSve');
    Route::get('/cancel/{id}','MainController@cancelReservation');
    Route::get('/extendForm/{id}','MainController@getExtendForm');
    Route::post('/extend','MainController@extend');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->middleware('admin')->group(function()
{
    Route::get('/','AdminController@home');
    Route::get('/{id}','AdminController@formaRole');
    Route::post('/forma1','AdminController@change');
    Route::get('/delete/{id}','AdminController@delete');
    
});

Route::prefix('/test')->group(function()
{
    Route::get('/','MainController@test1');
    Route::get('/posalji1','MainController@test2');
    
});

Route::prefix('/zakazi')->group(function()
{
    Route::get('/','MainController@zakaziPrikaz1');
    Route::post('/posalji1','MainController@podaci');
    Route::post('/posalji2','MainController@rezervacija4');
});




