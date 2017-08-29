@extends('layout')

@section('WebpageTitle')
    <title>Customers</title>
@endsection

@section('scripts')
    <script src="/js/Customers.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>
@endsection

@section('content')
<h5 id="TitlePage">Customers</h5>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#CustomerResort" data-toggle="tab">
                                    <i class="material-icons">beach_access</i>
                                    Customer on resort
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#CustomerRecord" data-toggle="tab">
                                    <i class="material-icons">assignment</i>
                                    All Customer records
                                <div class="ripple-container"></div></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="CustomerResort">

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Search Customer</label>
                                    <input type="text" class="form-control" id="SearchBar2" onkeyup="SearchTable2('tblResortCustomers', '4')" placeholder="Please enter last name">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="tblResortCustomers">
                                    <thead class="text-primary">
                                        <th style="display:none" class="text-center">Customer ID</th>
                                        <th style="display:none" class="text-center">Reservation ID</th>
                                        <th onclick="sortTable(3, 'tblResortCustomers', 'string')" class="text-center">Firstname</th>
                                        <th onclick="sortTable(4, 'tblResortCustomers', 'string')" class="text-center">Middlename</th>
                                        <th onclick="sortTable(5, 'tblResortCustomers', 'string')" class="text-center">Lastname</th>
                                        <th onclick="sortTable(6, 'tblResortCustomers', 'string')" class="text-center">Contact #</th>
                                        <th onclick="sortTable(7, 'tblResortCustomers', 'string')" class="text-center">Email</th>
                                        <th class="text-center">Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($CustomerResort as $Customer)
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td style="display:none">{{$Customer->strCustomerID}}</td>
                                            <td style="display:none">{{$Customer->strReservationID}}</td>
                                            <td>{{$Customer->strCustFirstName}}</td>
                                            <td>{{$Customer->strCustMiddleName}}</td>
                                            <td>{{$Customer->strCustLastName}}</td>
                                            <td>{{$Customer->strCustContact}}</td>
                                            <td>{{$Customer->strCustEmail}}</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Extend Stay" class="btn btn-warning btn-simple btn-xs" onclick="ShowModalExtendStay()">
                                                    <i class="material-icons">alarm_add</i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Add a room" class="btn btn-info btn-simple btn-xs" onclick="ShowModalAddRoom()">
                                                    <i class="material-icons">add_location</i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Checkout" class="btn btn-success btn-simple btn-xs" onclick="ShowModalCheckout()">
                                                    <i class="material-icons">done_all</i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>                            
                    </div>

                    <div class="tab-pane" id="CustomerRecord">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Search Customer</label>
                                    <input type="text" class="form-control" placeholder="Please enter last name" id="SearchBar" onkeyup="SearchTable('tblCustomer', '3')">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger pull-right" onclick="ShowModalDeleteCustomer()"><i class="material-icons">delete</i> Delete</button>
                                <button type="submit" class="btn btn-info pull-right" onclick="ShowModalEditCustomer()"><i class="material-icons">create</i> Edit</button>
                                <button type="submit" class="btn btn-warning pull-right" onclick="ShowModalCustomerHistory()"><i class="material-icons">history</i> History</button>
                            </div>             
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">

                                <table class="table" id="tblCustomer">
                                    <thead class="text-primary">
                                        <th style="display:none">Customer ID</th>
                                        <th onclick="sortTable(1, 'tblCustomer', 'string')">Firstname</th>
                                        <th onclick="sortTable(2, 'tblCustomer', 'string')">Middlename</th>
                                        <th onclick="sortTable(3, 'tblCustomer', 'string')">Lastname</th>
                                        <th onclick="sortTable(4, 'tblCustomer', 'string')">Address</th>
                                        <th onclick="sortTable(5, 'tblCustomer', 'string')">Contact #</th>
                                        <th onclick="sortTable(6, 'tblCustomer', 'string')">Email</th>
                                        <th onclick="sortTable(7, 'tblCustomer', 'string')">Nationality</th>
                                        <th onclick="sortTable(8, 'tblCustomer', 'string')">Gender</th>
                                        <th onclick="sortTable(9, 'tblCustomer', 'string')">Date of birth</th>
                                    </thead>
                                    <tbody>
                                        @foreach($CustomerDetails as $Customer)
                                        <tr onclick="HighlightRow(this)">
                                            <td style="display:none">{{$Customer->strCustomerID}}</td>
                                            <td>{{$Customer->strCustFirstName}}</td>
                                            <td>{{$Customer->strCustMiddleName}}</td>
                                            <td>{{$Customer->strCustLastName}}</td>
                                            <td>{{$Customer->strCustAddress}}</td>
                                            <td>{{$Customer->strCustContact}}</td>
                                            <td>{{$Customer->strCustEmail}}</td>
                                            <td>{{$Customer->strCustNationality}}</td>
                                            <td>{{$Customer->strCustGender}}</td>
                                            <td>{{Carbon\Carbon::parse($Customer->dtmCustBirthday)->format('M j, Y')}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
      
                            </div>
                        </div> 
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
    
@section('modals')
<div id="DivModalExtendStay" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">monetization_on</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Extend Stay<span class="close" onclick="HideModalExtendStay()">X</span></h3>
                            </div>
                            <form method="POST" action="/Fee/Edit" onsubmit="return CheckForm()">
                                {{ csrf_field() }}
                                <input type="hidden" name="EditReservationID" id="EditReservationID">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group label-static" id="CheckInDateError">
                                            <label class="control-label">Check in Date</label>
                                            <input type="text" class="datepicker form-control" id="CheckInDate" value="08/31/2017" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group label-static" id="CheckOutDateError">
                                            <label class="control-label">Check out Date</label>
                                            <input type="text" class="datepicker form-control" id="CheckOutDate" readonly/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="ErrorLabel"></p>
                                    </div>
                                </div>
                                <br>
                                <div class = "row">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-success pull-right"><i class="material-icons">done</i>Save</button>
                                    </div> 
                                </div>

                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalCheckout" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">done_all</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title"><span class="close" onclick="HideModalCheckout()">X</span></h3>
                            <h3 class="title">Checkout the guest?</h3>
                            <form method="post" action="/Fee/Delete">
                                {{ csrf_field() }}
                                <input type="hidden" id="DeleteFeeID" name="DeleteFeeID">
                                <input type="hidden" id="DeleteReservationID" name="DeleteReservationID">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalCheckout()">Cancel</button>
                                <button type="submit" class="btn btn-danger btn-sm pull-right">Delete</button>  
                            </form>            
                            <div class="clearfix"></div>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>
    
<div id="DivModalAddRoom" class="modal">
    <div class="Modal-content bigger-modalContent">
        <div class="row">
            <div class="col-sm-6">
                <div class="card card-stats">

                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">bookmark</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Available</p>
                                <h5 class="title">Rooms</h5>
                            </div>
                            <div class="card-content">
                                <table class="table" style="font-family: 'Roboto'" id="tblAvailableRooms" onclick="run(event, 'AvailableRooms')">
                                    <thead class="text-info">
                                        <th>Room</th>
                                        <th>Capacity</th>
                                        <th>Rate per day</th>
                                        <th>Number of rooms left</th>
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
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success pull-right" onclick="AddRoom()" id="btnAddRoom">Add</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="ErrorLabel" id="AddRoomError"></p>
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
                                <p class="category">Chosen</p>
                                <h5 class="title">Rooms</h5>
                            </div>
                            <div class="card-content table-responsive">
                                <table class="table" style="font-family: 'Roboto'" id="tblChosenRooms" onclick="run(event, 'ChosenRooms')">
                                    <thead class="text-info">
                                        <th>Name</th>
                                        <th>Capacity</th>
                                        <th>Rate per day</th>
                                        <th>Quantity Availed</th>
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
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-danger pull-right" onclick="RemoveRoom()">Remove</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="ErrorLabel" id="RemoveRoomError"></p>
                                    </div>
                                </div>
                            </div>

                </div>
            </div>

        </div>

        <div class="row">  
            <div class="col-sm-5 pull-right">
                <div class="card card-stats">
                    <div class="card-content">
                        <div class="row">
                            <p class="ErrorLabel" id="RoomError"></p>
                            <form method="post" action="/Reservation/Room/Edit" id="frmEditRooms" onsubmit="return CheckRooms()">
                                {{ csrf_field() }}
                                <input type="hidden" name="ChosenRooms" id="ChosenRooms">
                                <input type="hidden" name="r-NoOfKids" id="r-NoOfKids">
                                <input type="hidden" name="r-NoOfAdults" id="r-NoOfAdults">
                                <input type="hidden" name="r-CheckInDate" id="r-CheckInDate">
                                <input type="hidden" name="r-CheckOutDate" id="r-CheckOutDate">
                                <input type="hidden" id="r-ReservationID" name="r-ReservationID">
                                <input type="hidden" name="r-BoatsUsed" id="r-BoatsUsed">
                                <input type="hidden" name="r-PickUpTime" id="r-PickUpTime">
                                <button type="button" class="btn btn-danger pull-right" style="margin-right: 50px;" onclick="HideModalAddRoom()">Cancel</button>
                                <button type="submit" class="btn btn-success pull-right" style="margin-right: 50px;">Add Rooms</button>    
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalEditCustomer" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="blue">
                            <i class="material-icons">create</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Edit Customer Info<span class="close" onclick="HideModalEditCustomer()">X</span></h3>
                            </div>
                            <form method="POST" action="/Fee/Edit" onsubmit="return CheckForm()">
                                {{ csrf_field() }}
                                <input type="hidden" name="EditReservationID" id="EditReservationID">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group label-static">
                                            <label class="control-label">Firstname</label>
                                            <input type="text" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-static">
                                            <label class="control-label">Middlename</label>
                                            <input type="text" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-static">
                                            <label class="control-label">Lastname</label>
                                            <input type="text" class="form-control" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Address</label>
                                            <input type="text" class="form-control" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group label-static">
                                            <label class="control-label">Contact Number</label>
                                            <input type="text" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group label-static">
                                            <label class="control-label">Email</label>
                                            <input type="text" class="form-control" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group label-static">
                                            <label class="control-label">Nationality</label>
                                            <input type="text" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group label-static">
                                            <label class="control-label">Date of Birth</label>
                                            <input type="text" class="datepicker form-control"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xs-12">
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
                                        <p class="ErrorLabel"></p>
                                    </div>
                                </div>
                                <br>
                                <div class = "row">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-success pull-right"><i class="material-icons">done</i>Save</button>
                                    </div> 
                                </div>

                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalDeleteCustomer" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="red">
                            <i class="material-icons">delete</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title"><span class="close" onclick="HideModalDeleteCustomer()">X</span></h3>
                            <h3 class="title">Delete Customer?</h3>
                            <form method="post" action="/Fee/Delete">
                                {{ csrf_field() }}
                                <input type="hidden" id="DeleteFeeID" name="DeleteFeeID">
                                <input type="hidden" id="DeleteReservationID" name="DeleteReservationID">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalCheckout()">Cancel</button>
                                <button type="submit" class="btn btn-danger btn-sm pull-right">Delete</button>  
                            </form>            
                            <div class="clearfix"></div>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>
    
<div id="DivModalCustomerHistory" class="modal">
    <div class="Modal-content" style="max-width:1000px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">history</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <h3 class="title">Customer History<span class="close" onclick="HideModalCustomerHistory()">X</span></h3>
                            </div>
                            <br>
                            <table class="table table-hover" onclick="run(event)" style="font-family: Roboto">
                            <thead class="text-warning">
                                <th class="text-center">ID</th>
                                <th class="text-center">Check In Date</th>   
                                <th class="text-center">Check Out Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </thead>
                            <tbody>
                                <tr onclick="HighlightRow(this)" class="text-center">
                                    <td>ID</td>
                                    <td>Check In Date</td>   
                                    <td>Check Out Date</td>
                                    <td>Status</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Show more info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="HighlightRow(this)" class="text-center">
                                    <td>ID</td>
                                    <td>Check In Date</td>   
                                    <td>Check Out Date</td>
                                    <td>Status</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Show more info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="HighlightRow(this)" class="text-center">
                                    <td>ID</td>
                                    <td>Check In Date</td>   
                                    <td>Check Out Date</td>
                                    <td>Status</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Show more info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="HighlightRow(this)" class="text-center">
                                    <td>ID</td>
                                    <td>Check In Date</td>   
                                    <td>Check Out Date</td>
                                    <td>Status</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Show more info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalReservationInfo" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="purple">
                        <i class="material-icons">pages</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <h3 class="title">Reservation Info<span class="close" onclick="HideModalReservationInfo()">X</span></h3>
                        </div>
                        <div class="row">
                            <div class="col-xs-1"></div>
                            <div class="col-xs-10">
                                <small><h4>Reservation Info:</h4></small>
                                <p class="paragraphText text-primary">Reservation ID:</p> <p class="paragraphText" id="i-ReservationID"></p><br>
                                <p class="paragraphText text-primary">Reservation Code:</p> <p class="paragraphText" id="i-ReservationCode"></p><br>
                                <p class="paragraphText text-primary">Check In Date:</p> <p class="paragraphText" id="i-CheckInDate"></p><br>
                                <p class="paragraphText text-primary">Check Out Date:</p> <p class="paragraphText" id="i-CheckOutDate"></p><br>
                                <p class="paragraphText text-primary">Pick Up Time:</p> <p class="paragraphText" id="i-PickUpTime"></p><br>
                                <p class="paragraphText text-primary">Number of adult guests:</p> <p class="paragraphText" id="i-NoOfAdults"></p><br>
                                <p class="paragraphText text-primary">Number of child guests:</p> <p class="paragraphText" id="i-NoOfKids"></p><br>
                                <p class="paragraphText text-primary">Remarks:</p> <p class="paragraphText" id="i-Remarks"></p><br>
                                <small><h4>Reserved Room(s):</h4></small>
                                <div class="row"></div>
                                <table class="table" id="tblChosenRooms" style="font-family: 'Roboto'">
                                    <thead class="text-primary">
                                        <th>Room</th>
                                        <th>Quantity</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table><br><br>
                                <small><h4>Reserved Boat(s):</h4></small>
                                <div class="row"></div>
                                <table class="table" id="tblChosenBoats" style="font-family: 'Roboto'">
                                    <thead class="text-primary">
                                        <th>Boat</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table><br><br>
                                <small><h4>Bill Information</h4></small>
                                <p class="paragraphText text-primary">Initial Bill:</p> <p class="paragraphText" id="i-InitialBill"></p><br>
                                <p class="paragraphText text-primary">Required Downpayment:</p> <p class="paragraphText" id="i-RequiredDownpayment"></p><br>
                                <p class="paragraphText text-primary">Date Booked:</p> <p class="paragraphText" id="i-DateBooked"></p><br>
                                <p class="paragraphText text-primary">Payment Due Date</p><p class="paragraphText" id="i-PaymentDueDate"></p><br><br>
                                <small><h4>Guest Information</h4></small>
                                <p class="paragraphText text-primary">Name:</p><p class="paragraphText" id="i-Name"></p><br>
                                <p class="paragraphText text-primary">Address:</p><p class="paragraphText" id="i-Address"></p><br>
                                <p class="paragraphText text-primary">Contact Number:</p><p class="paragraphText" id="i-ContactNumber"></p><br>
                                <p class="paragraphText text-primary">Email:</p><p class="paragraphText" id="i-Email"></p><br>
                                <p class="paragraphText text-primary">Age:</p><p class="paragraphText" id="i-Age"></p><br>
                                <p class="paragraphText text-primary">Gender:</p><p class="paragraphText" id="i-Gender"></p><br>
                                <p class="paragraphText text-primary">Nationality:</p><p class="paragraphText" id="i-Nationality"></p><br>
                                <br><br>

                                <button type="button" class="btn btn-info pull-right" onclick="HideModalReservationInfo()">Close</button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection