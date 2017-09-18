@extends('layout')

@section('WebpageTitle')
    <title>Reservations</title>
@endsection

@section('scripts')
<script src="/js/Reservations.js" type="text/javascript"></script>
<script src="/js/input-validator.js" type="text/javascript"></script>
<script src="/js/MainJavascript.js" type="text/javascript"></script>
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
                                    <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('ConfirmedReservationTable', '1')">
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
                                <table class="table" id="ConfirmedReservationTable" onclick="run(event, 'Active')">
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'ConfirmedReservationTable', 'string')">ID</th>
                                        <th onclick="sortTable(1, 'ConfirmedReservationTable', 'string')">Name</th>
                                        <th onclick="sortTable(2, 'ConfirmedReservationTable', 'string')">Arrival Date</th>
                                        <th onclick="sortTable(3, 'ConfirmedReservationTable', 'string')">Deparure Date</th>
                                        <th onclick="sortTable(4, 'ConfirmedReservationTable', 'string')">Contact Number</th>
                                        <th onclick="sortTable(5, 'ConfirmedReservationTable', 'string')">Email Address</th>
                                        <th onclick="sortTable(6, 'ConfirmedReservationTable', 'string')">Reservation Code</th>
                                        <th style="display:none">Email Address</th>
                                        <th style="display:none">Reservation Code</th>
                                        <th onclick="sortTable(9, 'ConfirmedReservationTable', 'string')">Initial Bill</th>
                                    </thead>
                                    <tbody>
                                        @foreach($PaidReservations as $Reservation)
                                        <tr onclick="HighlightRow(this)">
                                            <td>{{$Reservation -> strReservationID}}</td>
                                            <td>{{$Reservation -> Name}}</td>
                                            <td>{{Carbon\Carbon::parse($Reservation -> dtmResDArrival)->format('M j, Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($Reservation -> dtmResDDeparture)->format('M j, Y')}}</td>  
                                            <td>{{$Reservation -> strCustContact}}</td> 
                                            <td>{{$Reservation -> strCustEmail}}</td>
                                            <td>{{$Reservation -> strReservationCode}}</td>
                                            <td style="display:none">{{Carbon\Carbon::parse($Reservation -> dtmResDArrival)->format('m/d/Y h:m:s')}}</td>
                                            <td style="display:none">{{Carbon\Carbon::parse($Reservation -> dtmResDArrival)->format('m/d/Y h:m:s')}}</td>
                                            <td>{{$Reservation -> dblPayAmount}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class = "row">
                            <div class="col-xs-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="ElementError" id="CheckInError"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-8">
                                <button type="button" class="btn btn-danger pull-right" onclick="ShowModalCancelReservation()"><i class="material-icons">highlight_off</i> Cancel</button>
                                <button type="button" class="btn btn-primary pull-right" onclick="ShowModalReservationInfo()"><i class="material-icons">info</i> Info</button>
                                <button type="button" class="btn btn-info pull-right" onclick="EditConfirmedReservation()"><i class="material-icons">create</i> Edit</button>
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalCheckIn()"><i class="material-icons">class</i> Check In</button>
                            </div> 
                        </div>                             
                    </div>

                    <div class="tab-pane" id="PendingReservations">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Reservations</label>
                                    <input type="text" class="form-control" id="SearchBar2" onkeyup="SearchTable2('PendingReservationTable', '1')">
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
                                        @foreach($FloatingReservations as $Reservation)
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
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalPaidReservation()"><i class="material-icons">check</i> Paid</button>
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
                        <h4><span class="close" onclick="HideModalReservationOptions()" style="color: black; font-family: Roboto Thin">X</span></h4>
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

<div id="DivModalDepositSlip" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="orange">
                        <i class="material-icons">local_atm</i>
                    </div>
                    <div class="card-content">
                        <h3 class="title">Reservation Downpayment<span class="close" onclick="HideModalDepositSlip()">X</span></h3>
                        <br><br>
                        <img style="height: 400px; width: 640px" class="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalNoDepositSlip" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="red">
                        <i class="material-icons">announcement</i>
                    </div>
                    <div class="card-content">
                        <h3 class="title"><span class="close" onclick="HideModalNoDepositSlip()">X</span></h3>
                        <br><br>
                        <div class = "row">
                            <div class="col-md-12">
                                <p class="paragraphText text-center">The Guest did not upload any deposit slip. Please verify the payment to continue.</p>
                            </div>
                        </div>
                        <div class="row">
                            <button type="button" class="btn btn-sm btn-danger pull-left" onclick="#">Close</button>
                            <button type="button" class="btn btn-sm btn-warning pull-right" onclick="#">Proceed without deposit slip</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalPaidReservation" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">monetization_on</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <h3 class="title">Reservation Downpayment<span class="close" onclick="HideModalPaidReservation()">X</span></h3>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <small><h4>Guest Information</h4></small>
                                <p class="paragraphText text-primary">Name:</p><p class="paragraphText" id="d-Name"></p><br>
                                <p class="paragraphText text-primary">Address:</p><p class="paragraphText" id="d-Address"></p><br>
                                <p class="paragraphText text-primary">Contact Number:</p><p class="paragraphText" id="d-ContactNumber"></p><br>
                                <p class="paragraphText text-primary">Email:</p><p class="paragraphText" id="d-Email"></p><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <small><h4>Bill Information</h4></small>
                                <p class="paragraphText text-primary">Date Booked:</p> <p class="paragraphText" id="d-DateBooked"></p><br>
                                <p class="paragraphText text-primary">Payment Due Date:</p><p class="paragraphText" id="d-PaymentDueDate"></p><br>
                                <p class="paragraphText text-primary">Initial Bill:</p> <p class="paragraphText" id="d-InitialBill"></p><br>
                                <p class="paragraphText text-primary">Required Downpayment:</p> <p class="paragraphText" id="d-RequiredDownpayment"></p><br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-xs-6">
                                <small><h4>Downpayment</h4></small>
                                <div class="form-group label-floating" id="DownPaymentError">
                                    <label class="control-label">Amount</label>
                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#DownPaymentError')" onchange="ValidateInput(this, 'double', '#DownPaymentError')" id="DownpaymentAmount">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="Col-md-6">
                                <p class="ErrorLabel"></p>
                            </div>
                        </div>
                        <button type="button" class="btn btn-md btn-info pull-left" onclick="ShowModalDepositSlip()">Show Desposit Slip</button>
                        <button type="button" class="btn btn-md btn-success pull-right" onclick="ProcessDownPayment()">Accept Downpayment</button>
                        
                        <form method="post" action="/Reservation/Downpayment" id="DownpaymentForm">
                            {{ csrf_field() }}
                            <input type="hidden" name="d-ReservationID" id="d-ReservationID" value = "">
                            <input type="hidden" name="d-DownpaymentAmount" id="d-DownpaymentAmount" value = "">
                        </form>
                        
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
                                <p class="paragraphText text-primary">Package Availed:</p> <p class="paragraphText" id="i-PackageAvailed"></p><br> 
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

<div id="DivModalCheckIn" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">beenhere</i>
                    </div>
                    <div class="card-content">
                        <p class="category"></p>
                        <h5 class="title">Check in the customer?<span class="close" onclick="HideModalCheckIn()">X</span></h5>
                        <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalCheckIn()">No</button>
                        <button type="button" class="btn btn-danger btn-sm pull-right" onclick="ShowModalPayment()">Yes</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalPayment" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="orange">
                        <i class="material-icons">pages</i>
                    </div>
                    <div class="card-content">
                        <h4><span class="close" onclick="HideModalPayment()" style="color: black; font-family: Roboto Thin">X</span></h4>
                        <h3 class="title">Pay Initial Bill?</h3>
                        <br><br>
                        <form method="post" action="/Reservation/CheckIn">
                            {{ csrf_field() }}
                            <input type="hidden" name="CheckInReservationID" id="CheckInReservationID" value="">
                            <div class = "row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success" onclick="ShowModalPayNow()">Yes</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success">No</button>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalPayNow" class="modal">
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
                            <h3 class="title">Payment<span class="close" onclick="HideModalPayNow()">X</span></h3>
                        </div>
                        <form method="POST" action="/Reservation/CheckIn/Payment" onsubmit="return CheckForm()">
                            <input type="hidden" name="PayReservationID" id="PayReservationID" value="">
                            {{ csrf_field() }}
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Total Amount</label>
                                        <input type="text" class="form-control" id="PayTotal" name="PayTotal" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static" id="PayPaymentError">
                                        <label class="control-label">Payment</label>
                                        <input type="text" class="form-control" onkeyup="SendPayment(this, 'double', '#PayPaymentError')" onchange="SendPayment(this, 'double', '#PayPaymentError')" id="PayPayment" name="PayPayment" required>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Change</label>
                                        <input type="text" class="form-control" id="PayChange" name="PayChange">
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class = "row">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-success pull-right" onclick="#"><i class="material-icons">done</i>Continue</button>
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
