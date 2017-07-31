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

Route::get('/Accomodation', 'ViewController@getRooms');

Route::get('/Packages', 'ViewController@getPackages');

Route::get('/Activities', 'ViewController@getActivities');

Route::get('/Package/RoomInfo', 'ViewController@getRoomInfo');

Route::get('/Package/ActivityInfo', 'ViewController@getActivityInfo');

Route::get('/Package/ItemInfo', 'ViewController@getItemInfo');

Route::get('/BookReservation', 'ViewController@bookReservation');

Route::get('/Reservation/Rooms', 'ViewController@getAvailableRooms');

Route::get('/Reservation/Boats', 'ViewController@getAvailableBoats');

Route::get('/Reservation/Fees', 'ViewController@getEntranceFee');

Route::post('/Reservation/Add', 'ReservationController@addReservation');

Route::post('/Login', 'SessionsController@create');

Route::get('/Logout', 'SessionsController@destroy');

Route::get('/BookPackages', function () {
    return view('BookPackages');
});

Route::get('/Location', function () {
    return view('Location');
});

Route::get('/AboutUs', function () {
    return view('AboutUs');
});

Route::get('/ContactUs', function () {
    return view('ContactUs');
});

Route::get('/Login', function () {
    return view('Login');
});

Route::get('/Reservation', function () {
    return view('Reservation');
});

Route::get('/ReservationPackage', function () {
    return view('ReservationPackage');
});
