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
Route::get('/', 'ViewDashboardController@getDashboard');

Route::get('/Walkin', 'ViewResortController@ViewWalkIn');

Route::get('/Customers', 'ViewResortController@ViewCustomers');

Route::get('/BoatSchedule', 'ViewResortController@getAvailableBoats');

Route::get('/Rooms', 'ViewResortController@ViewRooms');

Route::get('/ItemRental', 'ViewResortController@getAvailableItems');

Route::get('/Activities', 'ViewResortController@getAvailableActivities');

Route::get('/Reports', function () {
    return view('Reports');
});

Route::get('/Utilities', function () {
    return view('Utilities');
});

Route::get('/Billing', 'ViewResortController@ViewBilling');

Route::get('/ChooseRooms/{id}', 'ViewResortController@ViewSelectedRooms');

Route::get('/UpgradeRoom/{id}/{RoomType}/{RoomName}', 'ViewResortController@ViewUpgradeRoom');

Route::get('/Fees', 'ViewResortController@ViewFees');

Route::get('/ContactInformation', 'ViewUtilitiesController@ViewContact');



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


//Room Maintenance AJAX

Route::get('/Maintenance/Rooms/RoomTypes', 'ViewController@getRoomTypes');

Route::get('/Maintenance/Rooms/CottageTypes', 'ViewController@getCottageTypes');


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

//Add Dates
Route::post('Maintenance/Operation', 'MaintenanceController@storeOperation');



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

//Edit Dates

Route::post('Maintenance/Operation/Edit', 'MaintenanceController@checkOperation');



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

//Delete Date

Route::post('Maintenance/Operation/Delete', 'MaintenanceController@deleteOperation');



//ROOM IMAGES

Route::post('/Maintenance/RoomType/Image/Add', 'MaintenanceController@addRoomTypeImage');


/*----------- RESERVATION -------------*/

//Book Reservation
Route::post('/Reservation/Add', 'ReservationController@addReservation');

//Book Reservation with package
Route::post('/Reservation/Add/Package', 'ReservationController@addReservationPackage');

//Cancel Reservation

Route::post('/Reservation/Cancel', 'ReservationController@cancelReservation');

//Checkin Reservation
Route::post('/Reservation/CheckIn', 'ReservationController@checkInReservation');

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

Route::get('/BookReservations', 'ViewController@ViewBookReservations');

Route::get('/EditReservations/{id}', 'ViewController@ViewEditReservation');

Route::get('/Reservation/Package', 'ViewController@ViewReservationPackages');

Route::get('/Reservation/Rooms', 'ViewController@getAvailableRooms');

Route::get('/Reservation/Boats', 'ViewController@getAvailableBoats');

Route::get('/Reservation/Fees', 'ViewController@getReservationFees');

Route::get('/Reservation/Info', 'ViewController@getReservationInfo');

Route::get('/Reservation/Packages/Availability', 'ViewController@getAvailablePackages');

//Reservation Downpayment
Route::post('/Reservation/Downpayment', 'ReservationController@saveDownpayment');



/*---------------- WALK IN ------------------*/

//Save Walk In
Route::post('/Walkin/Add', 'ReservationController@addWalkIn');

//get fee amount ajax
Route::get('/Walkin/Fees', 'ViewResortController@getFeeAmount');

//save new fees
Route::post('Walkin/AddFees', 'ReservationController@addFees');


/*------------- CHOOSE ROOMS ----------------*/

//Get Chosen Rooms
Route::get('/CheckIn/Rooms', 'ViewResortController@getChosenRooms');

//Get Available Rooms
Route::get('/CheckIn/AvailableRooms', 'ViewResortController@getAvailableRooms');

//Save Chosen Rooms

Route::post('/CheckIn/SaveRooms', 'ReservationController@saveChosenRooms');


/*------------- UPGRADE ROOMS ----------*/

Route::get('/Upgrade/AvailableRooms', 'ViewResortController@getAvailableUpgradeRooms');

Route::get('/Upgrade/Price', 'ViewResortController@getRoomPrice');

Route::get('/Upgrade/RoomTypes', 'ViewResortController@getAvailableRoomTypes');

Route::post('/Upgrade/Save', 'ResortController@saveUpgradeRoom');

Route::post('/Upgrade/Pay', 'ResortController@saveUpgradeRoomPayment');

/*----------- REPORTS ----------------*/

Route::get('/QueryReports', function () {
    return view('QueryReports');
});

// Query Report AJAX
Route::get("/Reports/Query", 'ViewReportController@getQueryReport');


/*----------- ITEM RENTAL -------------*/

Route::post('/ItemRental/Rent', 'ResortController@storeRentalItem');

Route::post('/ItemRental/RentPay', 'ResortController@storeRentalItemPayment');

Route::post('/ItemRental/Return', 'ResortController@storeReturnItem');

Route::post('/ItemRental/ReturnPay', 'ResortController@storeReturnItemPayment');

Route::post('ItemRental/Restore', 'ResortController@storeRestoreItem');

Route::post('ItemRental/Delete', 'ResortController@DeleteItemRental');

Route::post('ItemRental/Extend', 'ResortController@ExtendItemRental');

Route::post('ItemRental/ExtendPay', 'ResortController@ExtendItemRentalPayment');

/*----------- BOAT SCHEDULE -------------*/

Route::post('/BoatSchedule/RentBoat', 'ScheduleController@RentBoat');

Route::post('/BoatSchedule/RentDone', 'ScheduleController@RentDone');


/*------------ ACTIVITY ------------*/

Route::post('/Activity/Avail', 'ResortController@AvailActivity');

Route::post('/Activity/AvailPay', 'ResortController@AvailActivityPayment');

Route::post('/Activity/Done', 'ResortController@ActivityDone');


/*------------- FEE ---------------*/

Route::post('/Fee/Add', 'ResortController@AddFee');

Route::get('/Fee/Details', 'ViewResortController@GetFeeDetails');

Route::get('/Fee/Price', 'ViewResortController@GetFeePrice');

Route::post('/Fee/Edit', 'ResortController@EditFee');

Route::post('/Fee/Delete', 'ResortController@DeleteFee');

Route::post('/Fee/Pay', 'ResortController@PayFee');

/*------------ BILLING ------------*/

Route::get('/Billing/Info', 'ViewResortController@getBillBreakdown');


/*------------ CUSTOMERS -----------*/

Route::get('/Customers/GetRooms', 'ViewResortController@getAddAvailableRooms');

Route::post('/Customer/Rooms', 'ResortController@saveAddRooms');

Route::post('/Customer/RoomsPay', 'ResortController@saveAddRoomsPayment');

Route::post('/Customer/Extend', 'ResortController@saveExtendStay');

Route::post('/Customer/ExtendPay', 'ResortController@saveExtendStayPay');

Route::get('/Customer/Extend/Availability', 'ViewResortController@checkExtendStay');

Route::post('/Customer/Edit', 'ResortController@editCustomerInfo');

Route::post('/Customer/Delete', 'ResortController@deleteCustomer');


/*---------- CONTACT INFORMATION----------*/

Route::post('Contact/Save', 'UtilitiesController@saveContactInfo');

Route::post('Contact/Edit', 'UtilitiesController@editContactInfo');

Route::post('Contact/Delete', 'UtilitiesController@deleteContactInfo');

//testing reports
Route::post('/sample', function(){
	$customPaper = array(0,0,360,200);
	$pdf = PDF::loadview('pdf.invoice')->setPaper($customPaper);
	return $pdf->stream();
});