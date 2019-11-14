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

use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    // return view('index');
    return Redirect('/zakazi');
});

Route::get('/nama','MainController@nama');

Route::get('/glavna','MainController@kriticni')->middleware('login');

Route::prefix('/kriticni')->middleware('login')->group(function()
{
    Route::get('/','MainController@kriticni');
    Route::post('/findServiseDate','MainController@findServiseDate');
    Route::post('/sheduleServise','MainController@sheduleServise');
    Route::get('/initiateServis/{id}','MainController@initiateServis');
});

Route::prefix('/servis')->middleware('login')->group(function()
{
    Route::get('/','MainController@servis');
    Route::post('/endServis','MainController@endServis');
    Route::get('/servisCar/{id}','MainController@servisCar');
});

Route::prefix('/prijem')->middleware('login')->group(function()
{
    Route::get('/','MainController@prijem');
    Route::post('/izmeniKM','MainController@izmeniKM');
    
});

Route::prefix('/auto')->middleware('login')->group(function()
{
    Route::get('/','MainController@auto');
    Route::get('/sviModeli','TipoviAutomobilaController@modeli1');
    Route::get('/info/{id}','MainController@autoInfo');
    Route::get('/cancel/{id}','MainController@cancelReservationA');
});

//depricated
// Route::prefix('/rezervacija')->middleware('login')->group(function()
// {
//     Route::get('/','MainController@rezervacija1');
//     Route::post('/posalji1','MainController@rezervacija2');
//     Route::post('/posalji2','MainController@rezervacija3');
//     Route::post('/posalji3','MainController@makeBookingWithFetch');
    
// });

Route::prefix('/rezervacijeInfo')->middleware('login')->group(function()
{
    Route::get('/','MainController@rezervacijeInfo'); //buduce rezervacije-nepotrebno
    Route::post('/allReservationForm','MainController@allReservationForm');
    Route::get('/all','MainController@allReservations');
    Route::post('/extendReservation','MainController@extendReservation');
    Route::get('/all/{num}','MainController@allReservations'); //ne koristi se
    Route::get('/cancelReservation/{id}','MainController@cancelReservation');
    Route::get('/extendForm/{id}','MainController@getExtendForm');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->middleware('admin')->group(function()
{
    Route::get('/','AdminController@home');
    Route::get('/roleChange/{id}','AdminController@formaRole');
    Route::post('/change','AdminController@change');
    Route::get('/delete/{id}','AdminController@delete');
    
});

//ovo je nebitno
// Route::prefix('/test')->group(function()
// {
//     Route::get('/','MainController@test1');
//     Route::get('/posalji1','MainController@test2');
// });

Route::prefix('/zakazi')->group(function()
{
    Route::get('/','MainController@zakaziPrikaz1');
    Route::post('/makeJSONforBooking','MainController@makeJSONforBooking');
    Route::post('/makeBookingWithFetch','MainController@makeBookingWithFetch');
});

Route::prefix('/baza')->middleware('admin')->group(function()
{
    
    Route::get('/model/getAdd','TipoviAutomobilaController@getAdd');
    Route::post('/model/add','TipoviAutomobilaController@add');
    Route::get('/model/getChange','TipoviAutomobilaController@getChange');
    Route::post('/model/getFormChange','TipoviAutomobilaController@getFormChange');
    Route::post('/model/change','TipoviAutomobilaController@change');

    Route::get('/car/getAdd','CarController@getAdd');
    Route::post('/car/add','CarController@add');
    Route::get('/car/getChange','CarController@getChange');
    Route::post('/car/getFormChange','CarController@getFormChange');
    Route::post('/car/change','CarController@change');

    Route::get('/addImage1','AdminController@getFormImage');
    Route::post('/posaljiSliku','AdminController@uploadImage');

});

Route::prefix('/klient')->group(function()
{
    Route::get('/sviModeli','TipoviAutomobilaController@modeli2');
});




