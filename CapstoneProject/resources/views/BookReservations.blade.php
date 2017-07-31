@extends('layout')

@section('WebpageTitle')
    <title>Book Reservations</title>
@endsection

@section('scripts')
<script src="/js/BookReservations.js" type="text/javascript"></script>
<script src="/js/input-validator.js" type="text/javascript"></script>
@endsection

@section('content')
<h5 id="TitlePage">Book a Reservation</h5>
<div class="row">
                          
  <div class="col-lg-2"></div>    

  <div class="col-md-8">
    <ul class="nav nav-pills nav-pills-success" role="tablist">
        <li id="DateList" class="active">
            <a href="#ReservationDate" role="tab">
                <i class="material-icons">date_range</i>
                Date<br>1
            </a>
        </li>
        <li id="RoomList">
            <a href="#ReservationRoom" role="tab">
                <i class="material-icons">local_hotel</i>
                Rooms<br>2
            </a>
        </li>
        <li id="InfoList">
            <a href="#ReservationInfo" role="tab">
                <i class="material-icons">face</i>
                Information<br>3
            </a>
        </li>
        <li id="BillList">
            <a href="#ReservationBill" role="tab">
                <i class="material-icons">monetization_on</i>
                bill<br>4
            </a>
        </li>
    </ul>
  </div>
  <div class="col-lg-2"></div>
  <div class="row">
    <div class="col-lg-12">
        <a href="/Reservations">
            <button class="btn btn-success btn-round pull-right">
                <i class="material-icons">event</i> View reservations
            </button>
        </a>
    </div>
  </div>
</div>
<div class="row">
<div class="col-md-12">
    <div class="card card-nav-tabs transparent-background">
        <div class="tab-content">
            <div class="tab-pane active" id="ReservationDate">

                <div class="card-header" data-background-color="blue">
                    <h4 class="title">Reservation Dates</h4>
                    <p class="category">Please choose reservation dates</p>
                </div>

                <div class="card-content white-background">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group label-static" id="CheckInDateError">
                                        <label class="control-label">Check in Date</label>
                                        <input type="text" class="datepicker form-control" id="CheckInDate"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group label-static" id="CheckOutDateError">
                                        <label class="control-label">Check out Date</label>
                                        <input type="text" class="datepicker form-control" id="CheckOutDate"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <p id="time-label">Arrival Time</p>
                                    <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm" >
                                        <select id="PickUpTime">
                                          <option>1</option>
                                          <option>2</option>
                                          <option>3</option>
                                          <option>4</option>
                                          <option>5</option>
                                          <option>6</option>
                                          <option>7</option>
                                          <option>8</option>
                                          <option>9</option>
                                          <option>10</option>
                                          <option>11</option>
                                          <option>12</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <p id="time-label2">Minute</p>
                                    <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm">
                                        <select id="PickUpMinute">
                                          <option>00</option>
                                          <option>15</option>
                                          <option>30</option>
                                          <option>45</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <p id="time-label3">Merridean</p>
                                    <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm" >
                                        <select id="PickUpMerridean">
                                          <option>AM</option>
                                          <option>PM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group label-floating" id="NoOfAdultsError">
                                        <label class="control-label">Number of Adults</label>
                                        <input type="text" value="" class="form-control" onkeyup="InputSender(this, 'int', '#NoOfAdultsError')" onchange="InputSender(this, 'int', '#NoOfAdultsError')" id="NoOfAdults" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating" id="NoOfKidsError">
                                        <label class="control-label">Number of Kids</label>
                                        <input type="text" value="" onkeyup="InputSender(this, 'int2', '#NoOfKidsError')" onchange="InputSender(this, 'int2', '#NoOfKidsError')" id="NoOfKids" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <br>
                            <button type="button" class="btn btn-success pull-right" onclick="CheckInput()">Check Availability</button>
                            <div class="clearfix"></div>

                        </div>
                        <br><br>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="alert alert-danger hide-on-click" style="display: none;">
                                        <div class="container-fluid">
                                          <div class="alert-icon">
                                            <i class="material-icons">warning</i>
                                          </div>
                                          <button type="button" class="close" aria-label="Close" onclick="HideAlert()">
                                            <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                          </button>
                                          <p id="ErrorMessage"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    
                
            </div>

            <div class="tab-pane" id="ReservationRoom">
                <div class="row">

                    <div class="col-sm-6">
                        <div class="card card-stats">

                                    <div class="card-header" data-background-color="blue">
                                        <i class="material-icons">bookmark</i>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <p class="category">Available</p>
                                            <h5 class="title">Rooms</h5>
                                        </div>   
                                    </div>
                                    <div class="card-content">
                                        <table class="table" id="tblAvailableRooms" onclick="run(event, 'AvailableRooms')">
                                            <thead class="text-info">
                                                <th onclick="sortTable(0, 'tblAvailableRooms', 'string')">Room</th>
                                                <th onclick="sortTable(1, 'tblAvailableRooms', 'int')">Capacity</th>
                                                <th onclick="sortTable(2, 'tblAvailableRooms', 'double')">Rate per day</th>
                                                <th onclick="sortTable(3, 'tblAvailableRooms', 'int')">Number of rooms left</th>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
               
                                        <div class = "row">
                                            <div class="col-xs-6">
                                                <div class="form-group label-floating" id="TotalRoomsError">
                                                    <label class="control-label">How many rooms?</label>
                                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int', '#TotalRoomsError')" onchange="ValidateInput(this, 'int', '#TotalRoomsError')" id="TotalRooms">
                                                </div>
                                            </div>
                                            <div class="col-xs-offset-2 col-xs-4">
                                                <button type="button" class="btn btn-success pull-right" onclick="AddRoom()">Add</button>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="ElementError"></p>
                                            </div>
                                        </div>
                                        
                                    </div>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card card-stats">

                                    <div class="card-header" data-background-color="blue">
                                        <i class="material-icons">beenhere</i>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <p class="category">Chosen</p>
                                            <h5 class="title">Rooms</h5>
                                        </div> 
                                    </div>
                                    <div class="card-footer">
                                        <table class="table" id="tblChosenRooms" onclick="run(event, 'ChosenRooms')">
                                            <thead class="text-info">
                                                <th onclick="sortTable(0, 'tblChosenRooms', 'string')">Name</th>
                                                <th onclick="sortTable(0, 'tblChosenRooms', 'int')">Capacity</th>
                                                <th onclick="sortTable(0, 'tblChosenRooms', 'double')">Rate per day</th>
                                                <th onclick="sortTable(0, 'tblChosenRooms', 'int')">Quantity Availed</th>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-danger pull-right" onclick="RemoveRoom()">Remove</button>
                                        <div class="clearfix"></div>
                                    </div>

                        </div>
                    </div>

                </div>
                
                <div class="row">
                    <div class="col-md-5">
                        <div class="alert alert-danger hide-on-click" style="display: none;">
                            <div class="container-fluid">
                              <div class="alert-icon">
                                <i class="material-icons">warning</i>
                              </div>
                              <button type="button" class="close" aria-label="Close" onclick="HideAlert()">
                                <span aria-hidden="true"><i class="material-icons">clear</i></span>
                              </button>
                              <p id="RoomErrorMessage"></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <button type="button" class="btn btn-info pull-left" onclick="GoBack('#ReservationRoom','#ReservationDate','#RoomList','#DateList')">Change Dates</button>
                <button type="button" class="btn btn-success pull-right" onclick="CheckRooms()">Continue</button>
            </div>

            <div class="tab-pane" id="ReservationInfo">
                <div class="row">
                    <div class="col-md-1">
                    </div>
                    <div class="col-lg-10">
                            <div class="card card-stats">

                                    <div class="card-header" data-background-color="blue">
                                        <i class="material-icons">account_circle</i>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <p class="category">Please fill out all the fields</p>
                                            <h3 class="title">Guest Information</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <div class="form-group label-floating" id="FirstNameError">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string2', '#FirstNameError')" onchange="ValidateInput(this, 'string2', '#FirstNameError')" id="FirstName">
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group label-floating" id="MiddleNameError">
                                                    <label class="control-label">Middle Name</label>
                                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string2', '#MiddleNameError')" onchange="ValidateInput(this, 'string2', '#MiddleNameError')" id="MiddleName">
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group label-floating" id="LastNameError">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string2', '#LastNameError')" onchange="ValidateInput(this, 'string2', '#LastNameError')" id="LastName">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Address</label>
                                                    <input type="text" class="form-control" id="Address">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Email Address</label>
                                                    <input type="email" class="form-control" onkeyup="ValidateInput(this, 'email', '#EmailError')" onchange="ValidateInput(this, 'email', '#EmailError')" id="Email">
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group label-floating" id="ContactError">
                                                    <label class="control-label">Contact Number</label>
                                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int2', '#ContactError')" onchange="ValidateInput(this, 'int2', '#ContactError')" id="ContactNumber">
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group label-floating" id="NationalityError">
                                                    <label class="control-label">Nationality</label>
                                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string2', '#NationalityError')" onchange="ValidateInput(this, 'string2', '#NationalityError')" id="Nationality">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-xs-6">
                                                <div class="form-group label-static">
                                                    <label class="control-label">Date of birth</label>
                                                    <input type="text" class="datepicker form-control" id="DateOfBirth"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                               <p id="gender-label">Gender</p>
                                                <div class="selectBox">
                                                    <select id="Gender">
                                                      <option>Male</option>
                                                      <option>Female</option>
                                                    </select>
                                                </div> 
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">

                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Remarks</label>
                                                        <textarea class="form-control" rows="5" id="Remarks"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="ErrorLabel"></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="alert alert-danger hide-on-click" style="display: none;">
                                                    <div class="container-fluid">
                                                      <div class="alert-icon">
                                                        <i class="material-icons">warning</i>
                                                      </div>
                                                      <button type="button" class="close" aria-label="Close" onclick="HideAlert()">
                                                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                                      </button>
                                                      <p id="InfoErrorMessage"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <button type="button" class="btn btn-info pull-left" onclick="GoBack('#ReservationInfo','#ReservationRoom', '#InfoList', '#RoomList')">Back</button>
                                        <button type="button" class="btn btn-success pull-right" onclick="CheckReservationInfo()">Continue</button>
                                       
                                    </div>

                            </div>
                            <br><br><br><br><br><br>
                        </div>
                </div>
            </div>

            <div class="tab-pane" id="ReservationBill">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-stats">

                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">class</i>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <h3 class="title">Reservation Info</h3>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xs-1"></div>
                                    <div class="col-xs-10">

                                        <small><h3 class="text-primary">Accomodation</h3></small>
                                        <p class="paragraphText text-primary">Check in date:</p> <p class="paragraphText" id="i-CheckInDate"></p><br>
                                        <p class="paragraphText text-primary">Check out date:</p> <p class="paragraphText" id="i-CheckOutDate"></p><br>
                                        <p class="paragraphText text-primary">Time of arrival:</p> <p class="paragraphText" id="i-TimeOfArrival"></p><br>
                                        <p class="paragraphText text-primary">Number of adult guests:</p> <p class="paragraphText" id="i-TotalAdults"></p><br>
                                        <p class="paragraphText text-primary">Number of child guests:</p> <p class="paragraphText" id="i-TotalKids"></p><br>
                                        <p class="paragraphText text-primary">Remarks:</p> <p class="paragraphText" id="i-Remarks"></p><br>

                                        <small><h3 class="text-primary">Customer Information</h3></small>
                                        <p class="paragraphText text-primary">Customer Name:</p> <p class="paragraphText" id="i-FullName"></p><br>
                                        <p class="paragraphText text-primary">Address:</p> <p class="paragraphText" id="i-Address"></p><br>
                                        <p class="paragraphText text-primary">Email:</p> <p class="paragraphText" id="i-Email"></p><br>
                                        <p class="paragraphText text-primary">Contact Number:</p> <p class="paragraphText" id="i-Contact"></p><br>
                                        <p class="paragraphText text-primary">Nationality:</p> <p class="paragraphText" id="i-Nationality"></p><br>
                                        <p class="paragraphText text-primary">Date of birth:</p> <p class="paragraphText" id="i-DateOfBirth"></p><br>
                                        <p class="paragraphText text-primary">Gender:</p> <p class="paragraphText" id="i-Gender"></p><br>
                                        
                                        
                                    </div>
                                </div>
                                    
                                

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                            <div class="card card-stats">

                                <div class="card-header" data-background-color="blue">
                                    <i class="material-icons">monetization_on</i>
                                </div>
                                <div class="card-content">
                                    <div class="row">
                                        <h3 class="title">Inital Invoice</h3>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-10">
                                            <small><h3 class="text-primary">Accomodation Fee</h3></small>
                                            <div class="row"></div>
                                            <table class="table" id="tblBill">
                                                <thead class="text-primary">
                                                    <th>Room</th>
                                                    <th>Quantity</th>
                                                    <th>Rate per day</th>
                                                    <th>Price</th>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table><br><br>
                                            <p class="paragraphText">Total Room Fee:</p> <p class="paragraphText" id="b-TotalRoomFee"></p><br>
                                            <p class="paragraphText">Days of Stay:</p><p class="paragraphText" id="b-DaysOfStay"></p><br><br>
                                            <strong><p class="paragraphText">Total Accomodation Fee:</p> <p class="paragraphText" id="TotalAccomodationFee"></p></strong><br>

                                            <small><h3 class="text-primary">Miscellaneous Fee</h3></small>
                                            <p class="paragraphText">Total Adult Guests:</p> <p class="paragraphText" id="b-TotalAdults"></p><br>
                                            <p class="paragraphText">Entrance Fee:</p> <p class="paragraphText" id="EntranceFee"></p><br>
                                            <p class="paragraphText">Total Entrance Fee:</p> <p class="paragraphText" id="TotalEntranceFee"></p><br>
                                            <p class="paragraphText">Boat(s) Used:</p> <p class="paragraphText" id="BoatsUsed"></p><br>
                                            <p class="paragraphText">Transportation Fee:</p> <p class="paragraphText" id="TransportationFee"></p><br><br>
                                            <strong><p class="paragraphText">Total Miscellaneous Fee:</p> <p class="paragraphText" id="TotalMiscellaneousFee"></p></strong><br>

                                            <small><h3 class="text-primary">Grand Total</h3></small>
                                            <p class="paragraphText">Accomodation Fee:</p> <p class="paragraphText" id="AccomodationFee"></p><br>
                                            <p class="paragraphText">Miscellaneous Fee:</p> <p class="paragraphText" id="MiscellaneousFee"></p><br>
                                            <strong><h5 class="paragraphText text-primary">Grand Total:</h5> <h5 class="paragraphText" id="GrandTotal"></h5></strong><br>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                </div>
                
                <button type="button" class="btn btn-info pull-left" onclick="GoBack('#ReservationBill', '#ReservationInfo', '#BillList', 'InfoList')">Back</button>
                <form onsubmit="return SaveReservation()" method="post" action="/Reservation/Add">
                    {{ csrf_field() }}
                    <input type="hidden" name="s-CheckInDate" id="s-CheckInDate" value = "">
                    <input type="hidden" name="s-CheckOutDate" id="s-CheckOutDate" value = "">
                    <input type="hidden" name="s-PickUpTime" id="s-PickUpTime" value = "">
                    <input type="hidden" name="s-NoOfAdults" id="s-NoOfAdults" value = "">
                    <input type="hidden" name="s-NoOfKids" id="s-NoOfKids" value = "">
                    <input type="hidden" name="s-BoatsUsed" id="s-BoatsUsed" value = "">
                    <input type="hidden" name="s-ChosenRooms" id="s-ChosenRooms" value = "">
                    <input type="hidden" name="s-FirstName" id="s-FirstName" value = "">
                    <input type="hidden" name="s-MiddleName" id="s-MiddleName" value = "">
                    <input type="hidden" name="s-LastName" id="s-LastName" value = "">
                    <input type="hidden" name="s-Address" id="s-Address" value = "">
                    <input type="hidden" name="s-Email" id="s-Email" value = "">
                    <input type="hidden" name="s-Contact" id="s-Contact" value = "">
                    <input type="hidden" name="s-Nationality" id="s-Nationality" value = "">
                    <input type="hidden" name="s-DateOfBirth" id="s-DateOfBirth" value = "">
                    <input type="hidden" name="s-Gender" id="s-Gender" value = "">
                    <input type="hidden" name="s-Remarks" id="s-Remarks" value = "">
                    <button type="submit" class="btn btn-success pull-right">Book Reservation</button>
                </form>
                
            </div>

            


        </div><!--Tab content-->
    </div>

</div>
</div>
@endsection

@section('modals')
    

<!---- 1st Modal ---->
<div id="DivModalAvailBoat" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">
                        <div class="card-content">
                            <br>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h5 class="title">Would the guest like to avail a boat?</h5>
                                </div>  
                            </div>
                            <div class = "row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn btn-success" id="BtnAvailBoat">Yes</button>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="button" class="btn btn-success" id="BtnAvailNoBoat">No</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!---- 3rd Modal ---->
<div id="DivModalMultipleBoats" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">
                        <div class="card-content">
                            <br>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <p class="paragraphText">There are no boats that can accomodate the total number of guests, would the guest like to avail multiple boats?</p>
                                </div>  
                            </div>
                            <div class = "row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success btn-sm" id="BtnMultipleBoats">Reserve Multiple Boats</button>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success btn-sm" onclick="HideModalMultipleBoats()">Change date and time</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success btn-sm" id="BtnWithoutBoats2">Continue without reserving boats</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!---- 4th Modal ---->
<div id="DivModalNoMultipleBoats" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">
                        <div class="card-content">
                            <br>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <p class="paragraphText">There are still no available boats that can accomodate the total number of guests.</p>
                                </div>  
                            </div>
                            <div class = "row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success btn-sm" onclick="HideModalNoMultipleBoats()">Change date and time</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success btn-sm" id="BtnWithoutBoats3">Continue without reserving boats</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>
    
<!---- 2nd Modal ---->
<div id="DivModalNoBoats" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">
                        <div class="card-content">
                            <br>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <p class="paragraphText">There are no available boats based on the given date and time.</p>
                                </div>  
                            </div>
                            <div class = "row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success btn-sm" onclick="HideModalNoBoats()">Change date and time</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success btn-sm" id="ButtonWithoutBoats1">Continue without reserving boats</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection