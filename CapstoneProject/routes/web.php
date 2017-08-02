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

use Illuminate\Support\Facades\Input;

//Misc
Route::get('/', function () {
    return view('dashboard');
});

Route::get('/Walkin', function () {
    return view('Walkin');
});

Route::get('/Customers', 'ViewResortController@ViewCustomers');

Route::get('/BoatSchedule', function () {
    return view('BoatSchedule');
});

Route::get('/Rooms', 'ViewResortController@ViewRooms');

Route::get('/ItemRental', 'ViewController@getAvailableItems');

Route::get('/Activities', 'ViewController@getAvailableActivities');

Route::get('/Reports', function () {
    return view('Reports');
});

Route::get('/Payment', function () {
    return view('Payment');
});

Route::get('/ChooseRooms/{id}', 'ViewResortController@ViewSelectedRooms');



/*-------------- MAINTENANCE --------------*/

Route::get('/Maintenance', function () {
    return view('Maintenance');
});

Route::get('/Maintenance/RoomType', 'ViewController@ViewRoomTypes');

Route::get('/Maintenance/Room', 'ViewController@ViewRooms');

Route::get('/Maintenance/Boat', 'ViewController@ViewBoats');
    
Route::get('/Maintenance/Item', 'ViewController@ViewItems');
    
Route::get('/Maintenance/Activity', 'ViewController@ViewActivities');
    
Route::get('/Maintenance/Package', 'ViewController@ViewPackages');

Route::get('/Maintenance/Operations', 'ViewController@ViewOperations');

Route::get('/Maintenance/Website', 'ViewController@ViewWebsite');

Route::get('/Maintenance/Fee', 'ViewController@ViewFees');

Route::get('/Maintenance/BoatPersonnel', 'ViewController@ViewBoatPersonnel');


//Package Maintenance

Route::get('/Maintenance/Package/Add', 'ViewController@ViewAddPackage');

Route::get('/Maintenance/Package/Edit/{id}', 'ViewController@ViewEditPackage');

Route::get('/Maintenance/Package/RoomCapacity', 'ViewController@TotalRoomCapacity');

//Get Rooms

Route::get('/Maintenance/Package/Rooms', 'ViewController@ViewPackageRooms');

//Get Package Inclusion

Route::get('/Maintenance/Package/Info', 'ViewController@getPackageInclusion');

// Get Room Type Details

Route::get('/Maintenance/Package/Add/RoomType', 'ViewController@ViewRoomTypeDetails');

//Get Item Details

Route::get('/Maintenance/Package/Add/Item', 'ViewController@ViewItemDetails');

//Get Activity Details

Route::get('/Maintenance/Package/Add/Activity', 'ViewController@ViewActivityDetails');

//Get Fee Details

Route::get('/Maintenance/Package/Add/Fee', 'ViewController@ViewFeeDetails');



//ADD



//Add Room Type

Route::post('/Maintenance/RoomType', 'MaintenanceController@storeRoomType');

//Add Boat

Route::post('/Maintenance/Boat', 'MaintenanceController@storeBoat');

//Add Item

Route::post('/Maintenance/Item', 'MaintenanceController@storeItem');

//Add Activity

Route::post('/Maintenance/Activity', 'MaintenanceController@storeActivity');

//Add Room

Route::post('/Maintenance/Room', 'MaintenanceController@storeRoom');

//Add Package

Route::post('/Maintenance/Package/Add', 'MaintenanceController@storePackage');

//Add Fee

Route::post('/Maintenance/Fee', 'MaintenanceController@storeFee');



//EDIT



//Edit Room Type
Route::post('/Maintenance/RoomType/Edit', 'MaintenanceController@checkRoomType');

//Edit Room

Route::post('/Maintenance/Room/Edit', 'MaintenanceController@checkRoom');

//Edit Boat

Route::post('/Maintenance/Boat/Edit', 'MaintenanceController@checkBoat');

//Edit Item

Route::post('/Maintenance/Item/Edit', 'MaintenanceController@checkItem');

//Edit Activity

Route::post('/Maintenance/Activity/Edit', 'MaintenanceController@checkActivity');

//Edit Package

Route::post('/Maintenance/Package/Edit', 'MaintenanceController@checkPackage');

//Edit Fee

Route::post('/Maintenance/Fee/Edit', 'MaintenanceController@checkFee');



//DELETE


//Delete Activity

Route::post('/Maintenance/Activity/Delete', 'MaintenanceController@deleteActivity');

//Delete Boat

Route::post('/Maintenance/Boat/Delete', 'MaintenanceController@deleteBoat');

//Delete Room

Route::post('/Maintenance/Room/Delete', 'MaintenanceController@deleteRoom');

//Delete Item

Route::post('/Maintenance/Item/Delete', 'MaintenanceController@deleteItem');

//Delete Room Type

Route::post('/Maintenance/RoomType/Delete', 'MaintenanceController@deleteRoomType');

//Delete Room Type

Route::post('/Maintenance/Package/Delete', 'MaintenanceController@deletePackage');

//Delete Fee

Route::post('/Maintenance/Fee/Delete', 'MaintenanceController@deleteFee');



/*----------- RESERVATION -------------*/

//Book Reservation
Route::post('/Reservation/Add', 'ReservationController@addReservation');

//Cancel Reservation

Route::post('/Reservation/Cancel', 'ReservationController@cancelReservation');

//Edit Reservation
Route::post('/Reservation/Info/Edit', 'ReservationController@updateReservationInfo');

//Edit Room Reservation
Route::post('/Reservation/Room/Edit', 'ReservationController@updateReservationRoom');

//Edit Reservation Dates
Route::post('/Reservation/Date/Edit', 'ReservationController@updateReservationDate');

//RESERVATION EDIT AJAX

Route::get('/Reservation/Info/View', 'ViewController@getReservationInclusion');

Route::get('/Reservation/Info/EditBoat', 'ViewController@getEditAvailableBoats');

Route::get('/Reservation/Info/Dates', 'ViewController@checkReservedRoomBoat');

//Reservations
Route::get('/Reservations', 'ViewController@ViewReservations');

Route::get('/BookReservations', function () {
    return view('BookReservations');
});

Route::get('/EditReservations/{id}', 'ViewController@ViewEditReservation');

Route::get('/Reservation/Package', 'ViewController@ViewReservationPackages');

Route::get('/Reservation/Rooms', 'ViewController@getAvailableRooms');

Route::get('/Reservation/Boats', 'ViewController@getAvailableBoats');

Route::get('/Reservation/Fees', 'ViewController@getReservationFees');

Route::get('/Reservation/Info', 'ViewController@getReservationInfo');



/*---------------- WALK IN ------------------*/

//Save Walk In
Route::post('/Walkin/Add', 'ReservationController@addWalkIn');


/*------------- CHOOSE ROOMS ----------------*/

//Get Chosen Rooms
Route::get('/CheckIn/Rooms', 'ViewResortController@getChosenRooms');

//Get Available Rooms
Route::get('/CheckIn/AvailableRooms', 'ViewResortController@getAvailableRooms');

//Save Chosen Rooms

Route::post('/CheckIn/SaveRooms', 'ReservationController@saveChosenRooms');

