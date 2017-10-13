@extends('layout')

@section('WebpageTitle')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Walk in</title>
@endsection

@section('scripts')
    <script src="/js/MainJavascript.js" type="text/javascript"></script>
    <script src="/js/Walkin.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>
    <!--<script src="/js/Reservations.js" type="text/javascript"></script>-->
@endsection

@section('content')
<h5 id="TitlePage">Walk in</h5>
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
                                        <input type="text" class="datepicker form-control" id="CheckInDate" disabled/>
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
                            <button type="button" class="btn btn-success pull-right" onclick="CheckDate()">Check Availability</button>
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
                        <br><br><br>
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
                                    <div class="col-sm-6">
                                        <div class="form-group label-floating" id="TotalRoomsError">
                                            <label class="control-label">How many rooms?</label>
                                            <input type="text" class="form-control" onkeyup="CheckInput(this, 'AddRoomError', '#TotalRoomsError')" onchange="CheckInput(this, 'AddRoomError', '#TotalRoomsError')" id="TotalRooms">
                                        </div>
                                    </div>
                                    <div class="col-xs-offset-2 col-xs-4">
                                        <button type="button" class="btn btn-success pull-right" onclick="AddRoom()">Add</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="ElementError" id="AddRoomError"></p>
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
                            <div class="card-content">
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
                                
                                <div class = "row">
                                    <div class="col-sm-6">
                                        <div class="form-group label-floating" id="RemoveRoomsError">
                                            <label class="control-label">How many rooms?</label>
                                            <input type="text" class="form-control" onkeyup="CheckInput(this, 'RemoveRoomError', '#RemoveRoomsError')" onchange="CheckInput(this, 'RemoveRoomError', '#RemoveRoomsError')" id="TotalRemoveRooms">
                                        </div>
                                    </div>
                                    <div class="col-xs-offset-2 col-xs-4">
                                        <button type="button" class="btn btn-danger pull-right" onclick="RemoveRoom()">Remove</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="ElementError" id="RemoveRoomError"></p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="row">
            
                    <div class="col-sm-5 pull-left">
                        <div class="card card-stats">
                            <div class="card-content">
                                <div class="row">
                                    <p class="paragraphText">Total Room Capacity:</p> <p class="paragraphText" id="TotalCapacity">0</p><br>
                                    <p class="paragraphText">Total Number of Guests:</p> <p class="paragraphText" id="TotalGuests">0</p>
                                </div>
                            </div>
                        </div>
                    </div>    

                    <div class="col-sm-5 pull-right">
                        <div class="card card-stats">
                            <div class="card-content">
                                <div class="row">
                                    <p class="ErrorLabel" id="RoomError"></p>
                                    <button type="button" class="btn btn-info pull-left" onclick="GoBack('#ReservationRoom','#ReservationDate','#RoomList','#DateList')">Change Dates</button>
                                    <button type="button" class="btn btn-success pull-right" onclick="CheckRooms()">Continue</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
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
                                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'contact', '#ContactError')" onchange="ValidateInput(this, 'contact', '#ContactError')" id="ContactNumber">
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
                                        <h3 class="title">Initial Invoice</h3>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-10">
                                            <small><h3 class="text-primary">Accomodation Fee</h3></small>
                                            <div class="row"></div>
                                            <table class="table" id="tblBill">
                                                <thead class="text-primary">
                                                    <th>Room</th>
                                                    <th>Rate per day</th>
                                                    <th>Quantity</th>
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
                                            <small><h3 class="text-primary">Other Fees</h3></small>
                                            <table class="table" id="tblOtherFee">
                                                <thead class="text-primary">
                                                    <th>Fee</th>
                                                    <th>Amount</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table><br><br>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <button type="button" class="btn btn-success btn-sm pull-left" onclick="ShowModalAddFee()">Add Fee</button>
                                                </div>
                                            </div>
                                            <br>
                                            
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
                <button type="button" class="btn btn-success pull-right" onclick="ShowModalPaymentChoice()">Proceed</button>
                
                <form method="post" action="/Walkin/Add" id="WalkInForm">
                    {{ csrf_field() }}
                    <input type="hidden" name="s-CheckInDate" id="s-CheckInDate" value = "">
                    <input type="hidden" name="s-CheckOutDate" id="s-CheckOutDate" value = "">
                    <input type="hidden" name="s-NoOfAdults" id="s-NoOfAdults" value = "">
                    <input type="hidden" name="s-NoOfKids" id="s-NoOfKids" value = "">
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
                    <input type="hidden" name="s-GrandTotal" id="s-GrandTotal" value = "">
                    <input type="hidden" name="s-AmountTendered" id="s-AmountTendered" value = "">
                    <input type="hidden" name="s-OtherFees" id="s-OtherFees" value = "">
                    <input type="hidden" name="s-AddFees" id="s-AddFees" value = "">
                </form>
                
            </div>
        
            


        </div><!--Tab content-->
    </div>

</div>
</div>

@endsection

@section('modals')

<div id="DivModalPaymentChoice" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="orange">
                        <i class="material-icons">pages</i>
                    </div>
                    <div class="card-content">
                        <h3 class="title">Pay now?</h3>
                        <br><br>
                        <div class = "row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-success pull-left" onclick="ProcessPayment()">Yes, Pay now.</button>
                            </div>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-success pull-right" onclick="SaveTransaction()">Pay at Checkout</button>
                            </div>
                            <div class="col-md-1"></div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="DivModalAddFee" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">add</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title"><span class="close" onclick="HideModalAddFee()">X</span></h3>
                            <h3 class="title">Add Fee</h3>
                        </div>
                        <div class = "row">
                            <div class="col-md-12">
                                <div class="form-group label-static">
                                    <label class="control-label">Fees</label>
                                    <div class="selectBox">
                                        <select id="SelectFees" onchange="FilterFee()">
                                            @foreach($Fees as $Fee)
                                                <option>{{$Fee->strFeeName}}</option>
                                            @endforeach
                                                <option>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="OtherInput" style="display: none">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group label-floating" id="FeeNameError">
                                        <label class="control-label">Fee</label>
                                        <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#FeeNameError')" onchange="ValidateInput(this, 'string', '#FeeNameError')" id="FeeName">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="checkbox">
                                        <label rel="tooltip" title="Add this fee to the system for future use">
                                            <input type="checkbox" id="CheckSaveFee">
                                            Save this fee?
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group label-static" id="FeeAmountError">
                                    <label class="control-label">Amount</label>
                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#FeeAmountError')" onchange="ValidateInput(this, 'double', '#FeeAmountError')" id="FeeAmount">
                                </div>
                            </div>
                        </div>
                            
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group label-floating" id="FeeQuantityError">
                                    <label class="control-label">Quantity</label>
                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int', '#FeeQuantityError')" onchange="ValidateInput(this, 'int', '#FeeQuantityError')" id="FeeQuantity">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <p class="ErrorLabel"></p>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success pull-right" onclick="AddFee()">Add Fee</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalPayNow" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">add</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title"><span class="close" onclick="HideModalPayNow()">X</span></h3>
                            <h3 class="title">Payment</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <h5 class="paragraphText">Grand Total:</h5> <h5 class="paragraphText" id="p-GrandTotal"></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <h5 class="paragraphText" style="margin-top: 30px">Amount Tendered:</h5><br>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group label-floating" id="AmountTenderedError">
                                <input type="text" class="form-control" onkeyup="SendInput(this, 'double', '#AmountTenderedError')" onchange="SendInput(this, 'double', '#AmountTenderedError')" id="AmountTendered" value = "0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">
                            <h5 class="paragraphText">Change:</h5> <h5 class="paragraphText" id="Change">0</h5><br>
                        </div>
                    </div>

                    <form method="POST" action="/Reservation/Invoice" onsubmit="SetInvoiceInfo()" target="_blank">
                        {{ csrf_field() }}
                        <input type="hidden" name="DaysOfStay" id="DaysOfStay">
                        <input type="hidden" name="InvoiceType" value="WalkIn">
                        <input type="hidden" name="tblRoomInfo" id="tblRoomInfo">
                        <input type="hidden" name="tblFeeInfo" id="tblFeeInfo">
                        <input type="hidden" name="iCustomerName" id="iCustomerName">
                        <input type="hidden" name="iCustomerAddress" id="iCustomerAddress">
                        <input type="hidden" name="iTotalAdults" id="iTotalAdults">
                        <input type="hidden" name="iAmountTendered" id="iAmountTendered">
                        <input type="submit" class="btn btn-success pull-left" value="Show Invoice">
                    </form>
                    <button type="button" class="btn btn-success pull-right" onclick="SaveReservation()">Continue</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="DivModalExceedGuest" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="orange">
                        <i class="material-icons">assignment_late</i>
                    </div>
                    <div class="card-content">
                        <h4><span class="close" onclick="HideModalExceedGuest()" style="color: black; font-family: Roboto Thin">X</span></h4>
                        <br><br><br>
                        <h5 class="title text-center">The number of guests exceeds the total room capacity</h5>
                        <br><br>
                        <div class = "row">
                                <button type="button" class="btn btn-success pull-left push-left" onclick="HideModalExceedGuest()">Make Changes</button>
                                <button type="button" class="btn btn-success pull-right push-right" onclick="ExceedContinue()">Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection