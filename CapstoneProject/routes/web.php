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
    return view('Login');
});

Route::get('/Dashboard', 'ViewDashboardController@getDashboard');

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

Route::post('/UserLogin', 'UtilitiesController@AuthenticateUser');

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

Route::post('/Maintenance/RoomType/Image/Edit', 'MaintenanceController@editRoomTypeImage');

Route::post('/Maintenance/RoomType/Image/Delete', 'MaintenanceController@deleteRoomTypeImage');

Route::get('/Accommodation/Images/Get', 'ViewController@getRoomImage');


/*----------- RESERVATION -------------*/

//Check reservation records
Route::get('/Reservation/Customers', 'ViewController@getCustomerReservation');

//Book Reservation
Route::post('/Reservation/Add', 'ReservationController@addReservation');

//Book Reservation with package
Route::post('/Reservation/Add/Package', 'ReservationController@addReservationPackage');

//Get Downpayment
Route::get('/Reservation/Downpayment', 'ViewController@getDownpayment');

//Edit Downpayment
Route::post('/Reservation/Downpayment/Edit', 'ReservationController@editDownpayment');

//Cancel Reservation

Route::post('/Reservation/Cancel', 'ReservationController@cancelReservation');

//Checkin Reservation
Route::post('/Reservation/CheckIn', 'ReservationController@checkInReservation');

//Check in with payment
Route::post('/Reservation/CheckIn/Payment', 'ReservationController@checkInReservationPayment');

//Edit Reservation
Route::post('/Reservation/Info/Edit', 'ReservationController@updateReservationInfo');

//Edit Room Reservation
Route::post('/Reservation/Room/Edit', 'ReservationController@updateReservationRoom');

//Edit Reservation Dates
Route::post('/Reservation/Date/Edit', 'ReservationController@updateReservationDate');

//Edit Reservation Package
Route::post('/Reservation/Package/Edit', 'ReservationController@updateReservationPackage');

//Edit Reservation Boat
Route::post('/Reservation/Boat/Edit', 'ReservationController@updateReservationBoat');

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

Route::get('/Reservation/Dates', 'ViewController@getReservationDates');

Route::get('/Reservation/Packages/Availability', 'ViewController@getAvailablePackages');

//Reservation Downpayment
Route::post('/Reservation/Downpayment', 'ReservationController@saveDownpayment');

//Reservation Deposit Slip

Route::get('/Reservation/DepositSlip', 'ViewController@getDepositSlip');



/*---------------- WALK IN ------------------*/

//Save Walk In
Route::post('/Walkin/Add', 'ReservationController@addWalkIn');

//Save Walk in with package
Route::post('/Walkin/Add/Package', 'ReservationController@addWalkInPackage');

Route::post('/Walkin/Add/Package/Pay', 'ReservationController@addWalkInPackagePayNow');

//View walk in package page
Route::get('/Walkin/Package', 'ViewResortController@ViewWalkInPackage');

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

Route::get('/SalesReport', function () {
    return view('SalesReport');
});

// Query Report AJAX
Route::get("/Reports/Query", 'ViewReportController@getQueryReport');

Route::get('/Reports/Query/Reservation', 'ViewReportController@getReservationReport');

// Sales Report AJAX
Route::get("/Reports/Sales", 'ViewReportController@getSalesReport');


/*----------- ITEM RENTAL -------------*/

Route::post('/ItemRental/Rent', 'ResortController@storeRentalItem');

Route::post('/ItemRental/Rent/Package', 'ResortController@storeRentalItemPackage');

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

Route::post('/Activity/Avail/Package', 'ResortController@AvailActivityPackage');

Route::post('/Activity/AvailPay', 'ResortController@AvailActivityPayment');

Route::post('/Activity/Done', 'ResortController@ActivityDone');


/*------------- FEE ---------------*/

Route::post('/Fee/Add', 'ResortController@AddFee');

Route::get('/Fee/Details', 'ViewResortController@GetFeeDetails');

Route::get('/Fee/Price', 'ViewResortController@GetFeePrice');

Route::post('/Fee/Edit', 'ResortController@EditFee');

Route::post('/Fee/Delete', 'ResortController@DeleteFee');

Route::post('/Fee/Pay', 'ResortController@PayFee');

Route::get('/Fee/Package', 'ViewResortController@getPackageFees');

/*------------ BILLING ------------*/

Route::get('/Billing/Info', 'ViewResortController@getBillBreakdown');

Route::get('/Billing/Deductions/{id}/{Total}', 'ViewResortController@getBillDeductions');

Route::post('/Billing/Deduction/Add', 'ResortController@addBillDeduction');

Route::post('/Billing/Deduction/Edit', 'ResortController@editBillDeduction');

Route::post('/Billing/Deduction/Delete', 'ResortController@deleteBillDeduction');


/*------------ CUSTOMERS -----------*/

Route::get('/Customers/GetRooms', 'ViewResortController@getAddAvailableRooms');

Route::get('/Customers/History', 'ViewResortController@getCustomerHistory');

Route::post('/Customer/Rooms', 'ResortController@saveAddRooms');

Route::post('/Customer/RoomsPay', 'ResortController@saveAddRoomsPayment');

Route::post('/Customer/Extend', 'ResortController@saveExtendStay');

Route::post('/Customer/ExtendPay', 'ResortController@saveExtendStayPay');

Route::get('/Customer/Extend/Availability', 'ViewResortController@checkExtendStay');

Route::post('/Customer/Extend/Free', 'ResortController@saveExtendStayFree');

Route::post('/Customer/Edit', 'ResortController@editCustomerInfo');

Route::post('/Customer/Delete', 'ResortController@deleteCustomer');

Route::post('/Customer/Block', 'ResortController@blockCustomer');

Route::post('/Customer/Restore', 'ResortController@restoreCustomer');

/*---------- CONTACT INFORMATION----------*/

Route::post('Contact/Save', 'UtilitiesController@saveContactInfo');

Route::post('Contact/Edit', 'UtilitiesController@editContactInfo');

Route::post('Contact/Delete', 'UtilitiesController@deleteContactInfo');


/*---------- CONTENT MANAGEMENT ---------*/
Route::get('/ContentManagement', 'ViewUtilitiesController@ViewContentManagement');

Route::post('/Utilities/Web/HomePage', 'UtilitiesController@saveHomePage');

Route::post('/Utilities/Web/Accommodation', 'UtilitiesController@saveAccommodation');

Route::post('/Utilities/Web/Packages', 'UtilitiesController@savePackages');

Route::post('/Utilities/Web/Activities', 'UtilitiesController@saveActivities');

Route::post('/Utilities/Web/Contacts', 'UtilitiesController@saveContacts');

Route::post('/Utilities/Web/Location', 'UtilitiesController@saveLocation');

Route::post('/Utilities/Web/AboutUs', 'UtilitiesController@saveAboutUs');



/*---------- SYSTEM USERS ------------*/

Route::get('SystemUsers', 'ViewUtilitiesController@ViewSystemUsers');

Route::post('/Users/Add', 'UtilitiesController@AddUser');

Route::post('/Users/Edit', 'UtilitiesController@EditUser');

Route::post('/Users/Delete', 'UtilitiesController@DeleteUser');

Route::get('SystemUsers/Restrictions', 'ViewUtilitiesController@getUserRestrictions');

/*----------- REPORTS ----------*/

Route::post('/QueryReports/Print', 'ViewReportController@PrintQueryReport');

Route::post('/Reservation/Invoice', 'InvoiceController@GenerateInvoice');

/*----------- CHECKOUT ----------*/
Route::get('/Checkout/{id}', 'ViewResortController@ViewCheckout');

Route::post('/Checkout/Pay', 'ResortController@CheckoutCustomer');


/*----------- DASHBOARD -------------*/
Route::get('/Dashboard/Booking', 'ViewDashboardController@getBookingFrequency');

Route::get('/Dashboard/Reservation', 'ViewDashboardController@getMonthlyReservation');

Route::get('/Dashboard/Income', 'ViewDashboardController@getWeeklyIncome');
