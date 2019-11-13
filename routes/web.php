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
Route::prefix('/rezervacija')->middleware('login')->group(function()
{
    Route::get('/','MainController@rezervacija1');
    Route::post('/posalji1','MainController@rezervacija2');
    Route::post('/posalji2','MainController@rezervacija3');
    Route::post('/posalji3','MainController@rezervacija4');
    
});

//ovo ne diram, jedva ga namestih
Route::prefix('/rezervacijeInfo')->middleware('login')->group(function()
{
    Route::get('/','MainController@rezervacijeInfo');
    Route::post('forma1','MainController@rezervacijeSveForm');
    Route::get('/sve','MainController@rezervacijeSve');
    Route::post('/extend','MainController@extend');
    Route::get('/sve/{num}','MainController@rezervacijeSve');
    Route::get('/cancel/{id}','MainController@cancelReservation');
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
Route::prefix('/test')->group(function()
{
    Route::get('/','MainController@test1');
    Route::get('/posalji1','MainController@test2');
    
});

Route::prefix('/zakazi')->group(function()
{
    Route::get('/','MainController@zakaziPrikaz1');
    Route::post('/makeJSONforBooking','MainController@makeJSONforBooking');
    Route::post('/makeBookingWithFetch','MainController@makeBookingWithFetch');
});

Route::prefix('/baza')->middleware('admin')->group(function()
{
    
    Route::get('/add','TipoviAutomobilaController@getDodaj');
    Route::post('/posalji1','TipoviAutomobilaController@Dodaj');
    Route::get('/change','TipoviAutomobilaController@getIzmeni');
    Route::post('/posalji2','TipoviAutomobilaController@getFormIzmeni');
    Route::post('/posalji3','TipoviAutomobilaController@izmeni');

    Route::get('/add2','CarController@getDodaj');
    Route::post('/posalji4','CarController@dodaj');
    Route::get('/change2','CarController@getIzmeni');
    Route::post('/posalji5','CarController@getFormIzmeni');
    Route::post('/posalji6','CarController@izmeni');

    Route::get('/addImage1','AdminController@getFormImage');
    Route::post('/posaljiSliku','AdminController@uploadImage');

});

Route::prefix('/klient')->group(function()
{
    Route::get('/sviModeli','TipoviAutomobilaController@modeli2');
});




