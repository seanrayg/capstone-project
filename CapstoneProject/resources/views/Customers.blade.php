@extends('layout')

@section('WebpageTitle')
    <title>Customers</title>
@endsection

@section('scripts')
    <script src="/js/Customers.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>
@endsection

@section('content')
<!-- Add success -->
@if(Session::has('flash_message'))
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="alert alert-success hide-automatic">
                <div class="container-fluid">
                  <div class="alert-icon">
                    <i class="material-icons">check</i>
                  </div>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                  </button>
                  {{ Session::get('flash_message') }}
                </div>
            </div> 
        </div>
    </div>
@endif

<!-- Duplicate Error -->
@if(Session::has('duplicate_message'))
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="alert alert-danger hide-on-click">
                <div class="container-fluid">
                  <div class="alert-icon">
                    <i class="material-icons">warning</i>
                  </div>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                  </button>
                  {{ Session::get('duplicate_message') }}
                </div>
            </div>
        </div>
    </div>
@endif

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
                                <table class="table" id="tblResortCustomers" onclick="run(event, 'Resort')">
                                    <thead class="text-primary">
                                        <th style="display:none" class="text-center">Customer ID</th>
                                        <th style="display:none" class="text-center">Reservation ID</th>
                                        <th onclick="sortTable(3, 'tblResortCustomers', 'string')" class="text-center">Firstname</th>
                                        <th onclick="sortTable(4, 'tblResortCustomers', 'string')" class="text-center">Middlename</th>
                                        <th onclick="sortTable(5, 'tblResortCustomers', 'string')" class="text-center">Lastname</th>
                                        <th onclick="sortTable(6, 'tblResortCustomers', 'string')" class="text-center">Contact #</th>
                                        <th onclick="sortTable(7, 'tblResortCustomers', 'string')" class="text-center">Email</th>
                                        <th onclick="sortTable(8, 'tblResortCustomers', 'string')" class="text-center">Check In Date</th>
                                        <th onclick="sortTable(9, 'tblResortCustomers', 'string')" class="text-center">Check Out Date</th>
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
                                            <td >{{Carbon\Carbon::parse($Customer -> dtmResDArrival)->format('M d, Y')}}</td>
                                            <td >{{Carbon\Carbon::parse($Customer -> dtmResDDeparture)->format('M d, Y')}}</td> 
                                            <td>
                                                <button type="button" rel="tooltip" title="Extend Stay" class="btn btn-warning btn-simple btn-xs" onclick="ShowModalExtendStay('{{Carbon\Carbon::parse($Customer -> dtmResDArrival)->format('m/d/y h:i:s')}}', '{{$Customer->strReservationID}}')">
                                                    <i class="material-icons">alarm_add</i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Add a room" class="btn btn-info btn-simple btn-xs" onclick="ShowModalAddRoom()">
                                                    <i class="material-icons">add_location</i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Checkout" class="btn btn-success btn-simple btn-xs" onclick="ShowModalCheckout('{{$Customer->strReservationID}}')">
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

                                <table class="table" id="tblCustomer" onclick="run(event, 'Record')">
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
<div id="DivModalUnavailableRooms" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">highlight_off</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Warning!<span class="close" onclick="HideModalUnavailableRooms()">X</span></h3>
                            </div>
                            <div class="row">
                                <br>
                                <h6 class="title text-center">Some of the reserved rooms are unavailable to extend:</h6>
                                <br>
                                <div class="col-sm-12">
                                    <ul id="UnavailableList" style="font-family: 'Roboto'">
                                    
                                    </ul>
                                </div>
                                <div class="col-sm-12">
                                <p class="descriptionText text-center" style="font-family: 'Roboto'">If the guest still wishes to extend their stay, they could transfer to another room or upgrade their room</p>
                                </div>
                            </div>
                            <br>
                            <div class = "row">
                                <div class="col-xs-12">
                                    <a href="/Rooms"><button type="button" class="btn btn-success pull-right">Manage Rooms</button></a>
                                </div> 
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>    
    
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
                            <div class="row">
                                <br>
                                <h5 class="title text-center">Extend stay for how many nights?</h5>
                                <div class="col-sm-12">
                                    <div class="form-group label-static" id="ExtendNightError">
                                        <label class="control-label">Number of nights</label>
                                        <input type="text" class="form-control" id="ExtendNight" name="ExtendNight" onkeyup="ValidateInput(this, 'int', '#ExtendNightError')" onchange="ValidateInput(this, 'int', '#ExtendNightError')">
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
                                    <button type="button" class="btn btn-success pull-right" onclick="ShowModalExtendStayPayment()"><i class="material-icons">done</i>Save</button>
                                </div> 
                            </div>
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
                                <input type="hidden" id="CheckoutReservationID" name="CheckoutReservationID">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalCheckout()">Cancel</button>
                                <button type="button" class="btn btn-danger btn-sm pull-right" onclick="RedirectCheckout()">Checkout</button>  
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
                            <button type="button" class="btn btn-danger pull-right" style="margin-right: 50px;" onclick="HideModalAddRoom()">Cancel</button>
                            <button type="button" class="btn btn-success pull-right" style="margin-right: 50px;" onclick="ShowModalAddRoomPayment()">Add Rooms</button>    
                            <div class="clearfix"></div>
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
                            <form method="POST" action="/Customer/Edit" onsubmit="return CheckForm()">
                                {{ csrf_field() }}
                                <input type="hidden" name="EditCustomerID" id="EditCustomerID">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group label-static" id="CustFirstNameError">
                                            <label class="control-label">Firstname</label>
                                            <input type="text" class="form-control" id="CustFirstName" name="CustFirstName" onkeyup="ValidateInput(this, 'string2', '#CustFirstNameError')" onchange="ValidateInput(this, 'string2', '#CustFirstNameError')" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-static" id="CustMiddleNameError">
                                            <label class="control-label">Middlename</label>
                                            <input type="text" class="form-control" id="CustMiddleName" name="CustMiddleName" onkeyup="ValidateInput(this, 'string2', '#CustMiddleNameError')" onchange="ValidateInput(this, 'string2', '#CustMiddleNameError')"  required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-static" id="CustLastNameError">
                                            <label class="control-label">Lastname</label>
                                            <input type="text" class="form-control" id="CustLastName" name="CustLastName" onkeyup="ValidateInput(this, 'string2', '#CustLastNameError')" onchange="ValidateInput(this, 'string2', '#CustLastNameError')" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group label-static" id="CustAddressError">
                                            <label class="control-label">Address</label>
                                            <input type="text" class="form-control" id="CustAddress" name="CustAddress" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group label-static" id="CustContactError">
                                            <label class="control-label">Contact Number</label>
                                            <input type="text" class="form-control" id="CustContact" name="CustContact" onkeyup="ValidateInput(this, 'contact', '#CustContactError')" onchange="ValidateInput(this, 'contact', '#CustContactError')" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group label-static" id="CustEmailError">
                                            <label class="control-label">Email</label>
                                            <input type="email" class="form-control" id="CustEmail" name="CustEmail" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group label-static" id="CustNationalityError">
                                            <label class="control-label">Nationality</label>
                                            <input type="text" class="form-control" id="CustNationality" name="CustNationality" onkeyup="ValidateInput(this, 'string2', '#CustNationalityError')" onchange="ValidateInput(this, 'string2', '#CustNationalityError')" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group label-static" id="CustBirthdayError">
                                            <label class="control-label">Date of Birth</label>
                                            <input type="text" class="datepicker form-control" id="CustBirthday" name="CustBirthday"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xs-12">
                                       <p id="gender-label">Gender</p>
                                        <div class="selectBox">
                                            <select id="CustGender" name="CustGender">
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
                            <form method="post" action="/Customer/Delete">
                                {{ csrf_field() }}
                                <input type="hidden" id="DeleteCustomerID" name="DeleteCustomerID">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteCustomer()">Cancel</button>
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
    
<div id="DivModalExtendStayPayment" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">monetization_on</i>
                    </div>
                    <div class="card-content">
                        <h4><span class="close" onclick="HideModalExtendStayPayment()" style="color: black; font-family: Roboto Thin">X</span></h4>
                        <h3 class="title">Pay now?</h3>
                        <br>
                        <p class="category text-center" style="font-family: Roboto; color:black" id="ExtendTotalAmount"></p>
                        <br><br>
                        <div class = "row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success" onclick="ShowModalExtendStayPayNow()">Yes</button>
                            </div> 
                            <form method="post" action="/Customer/Extend">
                                {{ csrf_field() }}
                                <input type="hidden" name="ExtendLaterReservationID" id="ExtendLaterReservationID">
                                <input type="hidden" name="ExtendLaterNight" id="ExtendLaterNight">
                                <input type="hidden" name="ExtendLaterAmount" id="ExtendLaterAmount">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success">No</button>
                                </div>
                            </form>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalExtendStayPayNow" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">monetization_on</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title">Payment<span class="close" onclick="HideModalExtendStayPayNow()">X</span></h3>
                        </div>
                        <form method="POST" action="/Customer/ExtendPay" onsubmit="return CheckForm()">
                            <input type="hidden" name="ExtendNowReservationID" id="ExtendNowReservationID">
                            <input type="hidden" name="ExtendNowNight" id="ExtendNowNight">
                            {{ csrf_field() }}
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Total Amount</label>
                                        <input type="text" class="form-control" id="ExtendPayTotal" name="ExtendPayTotal" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static" id="ExtendPayPaymentError">
                                        <label class="control-label">Payment</label>
                                        <input type="text" class="form-control" onkeyup="SendExtendPayment(this, 'double', '#ExtendPayPaymentError')" onchange="SendExtendPayment(this, 'double', '#ExtendPayPaymentError')" id="ExtendPayPayment" name="ExtendPayPayment" required>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Change</label>
                                        <input type="text" class="form-control" id="ExtendPayChange" name="ExtendPayChange">
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class = "row">
                                <div class="col-xs-12">
                                    <button type="button" class="btn btn-success pull-left push-left" onclick="#"><i class="material-icons">done</i>Print Invoice</button>
                                    <button type="submit" class="btn btn-success pull-right push-right" onclick="#"><i class="material-icons">done</i>Continue</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalAddRoomPayment" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">monetization_on</i>
                    </div>
                    <div class="card-content">
                        <h4><span class="close" onclick="HideModalAddRoomPayment()" style="color: black; font-family: Roboto Thin">X</span></h4>
                        <h3 class="title">Pay now?</h3>
                        <p class="category" style="font-family: Roboto; color:black" id="AddTotalAmount"></p>
                        <br><br>
                        <div class = "row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success" onclick="ShowModalAddRoomPayNow()">Yes</button>
                            </div> 
                            <form method="post" action="/Customer/Rooms" id="formAddRoom">
                                {{ csrf_field() }}
                                <input type="hidden" name="AddChosenRooms" id="AddChosenRooms">
                                <input type="hidden" name="AddReservationID" id="AddReservationID">
                                <input type="hidden" name="AddRoomAmount" id="AddRoomAmount">
                                <input type="hidden" name="AddToday" id="AddToday">
                                <input type="hidden" name="AddDeparture" id="AddDeparture">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success">No</button>
                                </div>
                            </form>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalAddRoomPayNow" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">monetization_on</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title">Payment<span class="close" onclick="HideModalAddRoomPayNow()">X</span></h3>
                        </div>
                        <form method="POST" action="/Customer/RoomsPay" onsubmit="return CheckForm()">
                            <input type="hidden" name="AddPayChosenRooms" id="AddPayChosenRooms">
                            <input type="hidden" name="AddPayReservationID" id="AddPayReservationID">
                            <input type="hidden" name="AddPayToday" id="AddPayToday">
                            <input type="hidden" name="AddPayDeparture" id="AddPayDeparture">
                            {{ csrf_field() }}
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Total Amount</label>
                                        <input type="text" class="form-control" id="AddPayTotal" name="AddPayTotal" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static" id="AddPayPaymentError">
                                        <label class="control-label">Payment</label>
                                        <input type="text" class="form-control" onkeyup="SendPayment(this, 'double', '#AddPayPaymentError')" onchange="SendPayment(this, 'double', '#AddPayPaymentError')" id="AddPayPayment" name="AddPayPayment" required>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Change</label>
                                        <input type="text" class="form-control" id="AddPayChange" name="AddPayChange">
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class = "row">
                                <div class="col-xs-12">
                                    <button type="button" class="btn btn-success pull-left push-left" onclick="#"><i class="material-icons">done</i>Print Invoice</button>
                                    <button type="submit" class="btn btn-success pull-right push-right" onclick="#"><i class="material-icons">done</i>Continue</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection