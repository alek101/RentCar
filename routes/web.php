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
    // return view('index');
    return Redirect('/zakazi');
});

Route::get('/izmeniPodatkeUser','AdminController@changeUser')->middleware('auth');
Route::get('/izmeniLozinku','ChangePasswordController@changePassForm')->middleware('auth');
Route::post('/madeChangeUser','AdminController@madeChangeUser')->middleware('auth');
Route::post('/changePassword','ChangePasswordController@changePassword')->middleware('auth');

Route::get('/glavna','CarInfoController@kriticni')->middleware('login');

Route::prefix('/kriticni')->middleware('login')->group(function()
{
    Route::get('/','CarInfoController@kriticni');
    Route::post('/findServiseDate','CarInfoController@findServiseDate');
    Route::post('/sheduleServise','CarInfoController@sheduleServise');
    Route::get('/initiateServis/{id}','CarInfoController@initiateServis');
});

Route::prefix('/servis')->middleware('login')->group(function()
{
    Route::get('/','ServiseController@servis');
    Route::post('/endServis','ServiseController@endServis');
    Route::get('/servisCar/{id}','ServiseController@servisCar');
});

Route::prefix('/prijem')->middleware('login')->group(function()
{
    Route::get('/','ServiseController@prijem');
    Route::post('/izmeniKM','ServiseController@izmeniKM');
    
});

Route::prefix('/auto')->middleware('login')->group(function()
{
    Route::get('/','CarInfoController@auto');
    Route::get('/info/{id}','CarInfoController@autoInfo');
    Route::get('/cancelReservation/{id}','ReservationController@cancelReservation');
    Route::get('/infoPlates/{plates}','CarInfoController@autoInfoPlates');
});

//depricated
Route::prefix('/rezervacija')->group(function()
{
    Route::get('/','MainController@rezervacija1');
    Route::post('/posalji1','MainController@rezervacija2');
    Route::post('/posalji2','MainController@rezervacija3');
    Route::post('/posalji3','MainController@makeBookingWithFetch');
    
});

Route::prefix('/rezervacijeInfo')->middleware('login')->group(function()
{
    // Route::get('/','MainController@rezervacijeInfo'); //buduce rezervacije-nepotrebno
    Route::get('/','ReservationController@defaultReservations');
    Route::post('/allReservationForm','ReservationController@allReservationForm');
    Route::get('/all','ReservationController@defaultReservations');
    Route::get('/now','ReservationController@getReservationsNow');
    Route::post('/extendReservation','ReservationController@extendReservation');
    Route::get('/cancelReservation/{id}','ReservationController@cancelReservation');
    Route::get('/cancelReservationFromRezervacijeInfoPage/{id}','ReservationController@cancelReservationFromRezervacijeInfoPage');
    Route::get('/extendForm/{id}','ReservationController@getExtendForm');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->middleware('admin')->group(function()
{
    Route::get('/','AdminController@home');
    Route::get('/sviModeli','TipoviAutomobilaController@modeliSvi');
    Route::get('/roleChange/{id}','AdminController@formaRole');
    Route::post('/change','AdminController@change');
    Route::get('/unactiveAuto','CarInfoController@unactiveAuto');
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
    Route::get('/','BookingController@zakaziPrikazVUE');
    Route::get('/zakaziStaro','BookingController@zakaziPrikazJS');
    Route::post('/makeJSONforBooking','BookingController@makeJSONforBooking');
    Route::post('/makeBookingWithFetch','BookingController@makeBookingWithFetch');
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
    Route::get('/sviModeli','TipoviAutomobilaController@modeliAktivniStranica');
    Route::get('/nama','FrontPageController@nama');
    Route::get('/uslovi','FrontPageController@uslovi');
    Route::get('/jsonAds','AdsController@makeJSONforAds');
    Route::get('/jsonAdsFixedNumber','AdsController@makeJSONforAdsFixedNumber');
});




