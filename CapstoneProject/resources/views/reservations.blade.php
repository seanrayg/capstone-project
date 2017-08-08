@extends('layout')

@section('WebpageTitle')
    <title>Reservations</title>
@endsection

@section('scripts')
<script src="/js/Reservations.js" type="text/javascript"></script>

@endsection


@section('content')
<!-- Add success -->
@if(Session::has('flash_message'))
    <div class="row">
        <div class="col-md-6 col-md-offset-6">
            <div class="alert alert-success">
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



<h5 id="TitlePage">Reservations</h5>
<div class="row">
    <div class="col-lg-12">
            <button class="btn btn-success btn-round pull-right" onclick="ShowModalReservationOptions()"><i class="material-icons">add</i> Book a reservation</button>

    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <span class="nav-tabs-title">Reservations:</span>
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#ConfirmedReservations" data-toggle="tab">
                                    <i class="material-icons">done</i>
                                    Confirmed
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#PendingReservations" data-toggle="tab">
                                    <i class="material-icons">remove_circle_outline</i>
                                    Pending
                                <div class="ripple-container"></div></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="ConfirmedReservations">

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Reservations</label>
                                    <input type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="col-xs-3 pull-right">
                                <div class="form-group label-floating">
                                    <label class="control-label">Filter</label>
                                    <div class="selectBox">
                                        <select>
                                          <option>Show All</option>
                                          <option>Today</option>
                                          <option>This Week</option>
                                          <option>This Month</option>
                                        </select>
                                      </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Arrival Date</th>
                                        <th>Deparure Date</th>
                                        <th>Pax</th>
                                        <th>Contact Number</th>
                                        <th>Email Address</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>ID</td>
                                            <td>Name</td>
                                            <td>Arrival Date</td>
                                            <td>Deparure Date</td>
                                            <td>Pax</td>
                                            <td>Contact Number</td>
                                            <td>Email Address</td>
                                        </tr>
                                        <tr>
                                            <td>ID</td>
                                            <td>Name</td>
                                            <td>Arrival Date</td>
                                            <td>Deparure Date</td>
                                            <td>Pax</td>
                                            <td>Contact Number</td>
                                            <td>Email Address</td>
                                        </tr>
                                        <tr>
                                            <td>ID</td>
                                            <td>Name</td>
                                            <td>Arrival Date</td>
                                            <td>Deparure Date</td>
                                            <td>Pax</td>
                                            <td>Contact Number</td>
                                            <td>Email Address</td>
                                        </tr>
                                        <tr>
                                            <td>ID</td>
                                            <td>Name</td>
                                            <td>Arrival Date</td>
                                            <td>Deparure Date</td>
                                            <td>Pax</td>
                                            <td>Contact Number</td>
                                            <td>Email Address</td>
                                        </tr>
                                        <tr>
                                            <td>ID</td>
                                            <td>Name</td>
                                            <td>Arrival Date</td>
                                            <td>Deparure Date</td>
                                            <td>Pax</td>
                                            <td>Contact Number</td>
                                            <td>Email Address</td>
                                        </tr>
                                        <tr>
                                            <td>ID</td>
                                            <td>Name</td>
                                            <td>Arrival Date</td>
                                            <td>Deparure Date</td>
                                            <td>Pax</td>
                                            <td>Contact Number</td>
                                            <td>Email Address</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-danger pull-right" onclick="#"><i class="material-icons">highlight_off</i> Cancel</button>
                                <button type="button" class="btn btn-primary pull-right" onclick="#"><i class="material-icons">info</i> Info</button>
                                <a href="/EditReservations"><button type="button" class="btn btn-info pull-right"><i class="material-icons">create</i> Edit</button></a>
                                <button type="button" class="btn btn-success pull-right" onclick="#"><i class="material-icons">class</i> Check In</button>
                            </div> 
                        </div>                             
                    </div>

                    <div class="tab-pane" id="PendingReservations">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Reservations</label>
                                    <input type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="col-xs-3 pull-right">
                                <div class="form-group label-floating">
                                    <label class="control-label">Filter</label>
                                    <div class="selectBox">
                                        <select>
                                          <option>Show All</option>
                                          <option>Today</option>
                                          <option>This Week</option>
                                          <option>This Month</option>
                                        </select>
                                      </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="PendingReservationTable" onclick="run(event, 'Pending')">
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'PendingReservationTable', 'string')">ID</th>
                                        <th onclick="sortTable(1, 'PendingReservationTable', 'string')">Name</th>
                                        <th onclick="sortTable(2, 'PendingReservationTable', 'string')">Date Booked</th>
                                        <th onclick="sortTable(3, 'PendingReservationTable', 'string')">Payment Due Date</th>
                                        <th onclick="sortTable(4, 'PendingReservationTable', 'string')">Arrival Date</th>
                                        <th onclick="sortTable(5, 'PendingReservationTable', 'string')">Departure Date</th>
                                        <th onclick="sortTable(6, 'PendingReservationTable', 'string')">Contact Number</th>
                                        <th onclick="sortTable(7, 'PendingReservationTable', 'string')">Email Address</th>
                                        <th onclick="sortTable(8, 'PendingReservationTable', 'string')">Code</th>
                                    </thead>
                                    <tbody>
                                        @foreach($Reservations as $Reservation)
                                        <tr onclick="HighlightRow(this)">
                                            <td>{{$Reservation -> strReservationID}}</td>
                                            <td>{{$Reservation -> Name}}</td>
                                            <td>{{Carbon\Carbon::parse($Reservation -> dteResDBooking)->format('M j, Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($Reservation -> PaymentDueDate)->format('M j, Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($Reservation -> dtmResDArrival)->format('M j, Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($Reservation -> dtmResDDeparture)->format('M j, Y')}}</td>  
                                            <td>{{$Reservation -> strCustContact}}</td> 
                                            <td>{{$Reservation -> strCustEmail}}</td>
                                            <td>{{$Reservation -> strReservationCode}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-danger pull-right" onclick="ShowModalCancelReservation()"><i class="material-icons">highlight_off</i> Cancel</button>
                                <button type="button" class="btn btn-primary pull-right" onclick="ShowModalReservationInfo()"><i class="material-icons">info</i> Info</button>
                                <button type="button" class="btn btn-info pull-right" onclick="EditPendingReservation()"><i class="material-icons">create</i> Edit</button>
                                <button type="button" class="btn btn-success pull-right" onclick="#"><i class="material-icons">check</i> Paid</button>
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
<div id="DivModalReservationOptions" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
                    <div class="col-md-12">
                            <div class="card card-stats">

                            <div class="card-header" data-background-color="orange">
                                <i class="material-icons">pages</i>
                            </div>
                            <div class="card-content">
                                <h3 class="title">Avail a Package?</h3>
                                <br><br>
                                <div class = "row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <a href="/Reservation/Package"><button type="button" class="btn btn-success" onclick="#">Yes</button></a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="/BookReservations"><button type="button" class="btn btn-success" onclick="#">No</button></a>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
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

<div id="DivModalCancelReservation" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="red">
                            <i class="material-icons">backspace</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h5 class="title" id="WarningMessage"><span class="close" onclick="HideModalCancelReservation()">X</span></h5>
                            <form method="post" action="/Reservation/Cancel">
                                {{ csrf_field() }}
                                <input type="hidden" name="CancelReservationID" id="CancelReservationID" value="">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalCancelReservation()">No</button>
                                <button type="submit" class="btn btn-danger btn-sm pull-right">Yes</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
