@extends('layout')

@section('WebpageTitle')
    <title>Activities</title>
@endsection

@section('scripts')

    <script src="/js/Activities.js" type="text/javascript"></script>
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


<h5 id="TitlePage">Activities</h5>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#AvailableActivities" data-toggle="tab">
                                    <i class="material-icons">local_activity</i>
                                    Available Activities
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#AvailedActivities" data-toggle="tab">
                                    <i class="material-icons">beach_access</i>
                                    Availed Activities
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#PackagedActivities" data-toggle="tab">
                                    <i class="material-icons">pages</i>
                                    Packaged Activities
                                <div class="ripple-container"></div></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="AvailableActivities">

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Activities</label>
                                    <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('tblAvailableActivities', '1')">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="tblAvailableActivities" onclick="run(event, 'Avail')">
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'tblAvailableActivities', 'string')">ID</th>
                                        <th onclick="sortTable(1, 'tblAvailableActivities', 'string')">Name</th>
                                        <th onclick="sortTable(2, 'tblAvailableActivities', 'double')">Rate</th>
                                        <th onclick="sortTable(3, 'tblAvailableActivities', 'string')">Is boat needed?</th>
                                        <th onclick="sortTable(4, 'tblAvailableActivities', 'string')">Description</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($Activities as $Activity)
                                        <tr onclick="HighlightRow(this)">
                                            <td>{{$Activity -> strBeachActivityID}}</td>
                                            <td>{{$Activity -> strBeachAName}}</td>
                                            <td>{{$Activity -> dblBeachARate}}</td>
                                            <td>{{$Activity -> intBeachABoat}}</td>
                                            <td>{{$Activity -> strBeachADescription}}</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Avail Activity" class="btn btn-success btn-simple btn-xs" onclick="ShowModalAvailActivity()">
                                                    <i class="material-icons">playlist_add_check</i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>                            
                    </div>

                    <div class="tab-pane" id="AvailedActivities">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search</label>
                                    <input type="text" class="form-control" >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" onclick="run(event, 'Done')">
                                    <thead class="text-primary">
                                        <th>Activity</th>
                                        <th>Availed by</th>
                                        <th>Boat Used</th>
                                        <th>Time Availed</th>
                                        <th>Expected Time of Return</th>
                                        <th style="display:none">Schedule ID</th>
                                        <th style="display:none">Avail ID</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($AvailedActivities as $Activity)
                                        <tr onclick="HighlightRow(this)">
                                            <td>{{$Activity -> strBeachAName}}</td>
                                            <td>{{$Activity -> Name}}</td>
                                            <td>{{$Activity -> strBoatName}}</td>
                                            <td>{{Carbon\Carbon::parse($Activity -> dtmBoatSPickUp)->format('M j, Y g:i A')}}</td>  
                                            <td>{{Carbon\Carbon::parse($Activity -> dtmBoatSDropOff)->format('M j, Y g:i A')}}</td>
                                            <td style="display:none">{{$Activity -> strBoatScheduleID}}</td>
                                            <td style="display:none">{{$Activity -> strAvailBeachActivityID}}</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Activity Done" class="btn btn-success btn-simple btn-xs" onclick="ShowModalActivityDone()">
                                                    <i class="material-icons">done</i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <form id="FormDoneActivity" method="POST" action="/Activity/Done">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="DoneAvailID" name="DoneAvailID">
                                    <input type="hidden" id="DoneBoatSchedID" name="DoneBoatSchedID">
                                </form>
                            </div>
                        </div> 
                    </div>

                    <div class="tab-pane" id="PackagedActivities">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search</label>
                                    <input type="text" class="form-control" >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table">
                                    <thead class="text-primary" id="tblPackageActivities">
                                        <th onclick="sortTable(0, 'tblPackageActivities', 'string')">Activity</th>
                                        <th onclick="sortTable(1, 'tblPackageActivities', 'string')">Customer</th>
                                        <th onclick="sortTable(2, 'tblPackageActivities', 'int')">Quantity included</th>
                                        <th>Boat</th>
                                        <th>Activity ID</th>
                                        <th>Reservation ID</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($PackageActivities as $Activity)
                                            <tr>
                                                <td>{{$Activity -> strBeachAName}}</td>
                                                <td>{{$Activity -> Name}}</td>
                                                <td>{{$Activity -> intPackageAQuantity}}</td>
                                                <td>{{$Activity -> intBeachABoat}}</td>
                                                <td>{{$Activity -> strBeachActivityID}}</td>
                                                <td>{{$Activity -> strReservationID}}</td>
                                                <td>
                                                    <button type="button" rel="tooltip" title="Avail Activity" class="btn btn-success btn-simple btn-xs" onclick="ShowModalAvailActivityPackage('{{$Activity -> strBeachAName}}', '{{$Activity -> Name}}', '{{$Activity -> intPackageAQuantity}}', '{{$Activity -> intBeachABoat}}', '{{$Activity -> strBeachActivityID}}', '{{$Activity -> strReservationID}}')">
                                                        <i class="material-icons">playlist_add_check</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalAvailPackagedActivity()"><i class="material-icons">done</i> Avail</button>
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
<div id="DivModalAvailActivity" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">rowing</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Avail Activity<span class="close" onclick="HideModalAvailActivity()">X</span></h3>
                            </div>
                            <form id="AvailActivityForm" method="POST" action="/Activity/Avail" onsubmit="return CheckAvailForm()">
                                {{ csrf_field() }}
                                <input type="hidden" id="AvailActivityType" name="AvailActivityType">
                                <input type="hidden" id="AvailActivityID" name="AvailActivityID">
                                <input type="hidden" id="AvailActivityTotalPrice" name="AvailActivityTotalPrice">
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Activity to avail</label>
                                            <input type="text" class="form-control" id="AvailActivityName" name="AvailActivityName" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                     <p style="font-family: 'Roboto'">Rented By:</p>
                                        <input list="GuestsList" class="inputlist" id="AvailCustomerName" name="AvailCustomerName">
                                        <datalist id="GuestsList">
                                          @foreach($Guests as $Guest)
                                            <option id="{{$Guest -> strReservationID}}" value="{{$Guest -> Name}}">{{$Guest -> Name}}</option>
                                          @endforeach
                                        </datalist> 
                                    </div>
                                </div>
                                <div id="DivLandActivity" style="display:none">
                                   <div class = "row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="AvailLandQuantityError">
                                                <label class="control-label">Quantity</label>
                                                <input type="text" class="form-control" onkeyup="ComputePrice(this, 'int', '#AvailLandQuantityError')" onchange="ComputePrice(this, 'int', '#AvailLandQuantityError')" id="AvailLandQuantity" name="AvailLandQuantity" value="0" required>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class = "row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="AvailLandQuantityError">
                                                <label class="control-label">Price to pay</label>
                                                <input type="text" class="form-control" id="LandActivityRate" name="LandActivityRate" readonly>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div id="DivWaterActivity" style="display:none">
                                    <div class = "row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="AvailGuestQuantityError">
                                                <label class="control-label">No. of guests to avail</label>
                                                <input type="text" class="form-control" onkeyup="SendGuestInput(this, 'int', '#AvailGuestQuantityError')" onchange="SendGuestInput(this, 'int', '#AvailGuestQuantityError')" id="AvailGuestQuantity" name="AvailGuestQuantity" value="0" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group label-static">
                                                <label class="control-label">Chosen Boat</label>
                                                <input type="text" class="form-control" id="AvailBoat" name="AvailBoat" value="Please choose a boat" onclick="ShowModalAvailableBoat('Not Package')" rel="tooltip" title="Please specify number of guests to avail before choosing a boat" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <p id="time-label">Expected Duration</p>
                                            <div class="selectBox">
                                                <select id="DurationTime" name="DurationTime">
                                                  <option>0</option>
                                                  <option selected>1</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <p id="time-label2">Minute</p>
                                            <div class="selectBox">
                                                <select id="DurationMinute" name="DurationMinute">
                                                  <option>00</option>
                                                  <option>15</option>
                                                  <option>30</option>
                                                  <option>45</option>
                                                </select>
                                            </div>
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
                                    <div class="col-xs-6">
                                        <button type="button" class="btn btn-success pull-left" onclick="ShowModalPayActivity()"><i class="material-icons">done</i> Pay now</button>
                                    </div> 
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-success pull-right"><i class="material-icons">done</i> Pay at check out</button>
                                    </div> 
                                </div>
                                
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalAvailActivityPackage" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">rowing</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Avail Activity<span class="close" onclick="HideModalAvailActivityPackage()">X</span></h3>
                            </div>
                            <form id="AvailActivityForm" method="POST" action="/Activity/Avail/Package" onsubmit="return CheckAvailPackageForm()">
                                {{ csrf_field() }}
                                <input type="hidden" id="PackageReservationID" name="PackageReservationID">
                                <input type="hidden" id="PackageActivityID" name="PackageActivityID">
                                <input type="hidden" id="PackageActivityType" name="PackageActivityType">
                                <input type="hidden" id="PackageQuantityIncluded" name="PackageQuantityIncluded">
                                
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Activity to avail</label>
                                            <input type="text" class="form-control" id="PackageActivityName" name="PackageActivityName" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" id="PackageCustomerName" name="PackageCustomerName" readonly>
                                        </div>
                                    </div>
                                </div>

                               <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static" id="PackageGuestQuantityError">
                                            <label class="control-label">No. of guests to avail</label>
                                            <input type="text" class="form-control" onkeyup="SendGuestPackageInput(this, 'int', '#PackageGuestQuantityError')" onchange="SendGuestPackageInput(this, 'int', '#PackageGuestQuantityError')" id="PackageGuestQuantity" name="PackageGuestQuantity" value="0" required>
                                        </div>
                                    </div>
                                </div>
                                <div id="DivPackageWaterActivity" style="display:none">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group label-static">
                                                <label class="control-label">Chosen Boat</label>
                                                <input type="text" class="form-control" id="PackageAvailBoat" name="PackageAvailBoat" value="Please choose a boat" onclick="ShowModalAvailableBoat('Package')" rel="tooltip" title="Please specify number of guests to avail before choosing a boat" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <p id="time-label">Expected Duration</p>
                                            <div class="selectBox">
                                                <select id="DurationTime" name="PackageDurationTime">
                                                  <option>0</option>
                                                  <option selected>1</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <p id="time-label2">Minute</p>
                                            <div class="selectBox">
                                                <select id="DurationMinute" name="PackageDurationMinute">
                                                  <option>00</option>
                                                  <option>15</option>
                                                  <option>30</option>
                                                  <option>45</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="ErrorLabel" id="PackageError"></p>
                                    </div>
                                </div>
                                
                                <div class = "row">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-success pull-right" onclick="#"><i class="material-icons">done</i>Avail</button>
                                    </div> 
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalPayActivity" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">rowing</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Avail Activity<span class="close" onclick="HideModalPayActivity()">X</span></h3>
                            </div>
                            <form id="AvailActivityForm" method="POST" action="/Activity/AvailPay" onsubmit="return CheckForm()">
                                {{ csrf_field() }}
                                <input type="hidden" id="PayActivityType" name="PayActivityType">
                                <input type="hidden" id="PayActivityID" name="PayActivityID">
                                <input type="hidden" id="PayReservationID" name="PayReservationID">
                                <input type="hidden" id="PayLandQuantity" name="PayLandQuantity">
                                <input type="hidden" id="PayLandActivityRate" name="PayLandQuantityRate">
                                <input type="hidden" id="PayWaterActivityRate" name="PayActivityRate">
                                <input type="hidden" id="PayDurationTime" name="PayDurationTime">
                                <input type="hidden" id="PayDurationMinute" name="PayDurationMinute">
                                <input type="hidden" id="PayAvailBoat" name="PayAvailBoat">

                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Total Amount</label>
                                            <input type="text" class="form-control" id="ActivityTotalPrice" name="ActivityTotalPrice" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static" id="ActivityPaymentError">
                                            <label class="control-label">Payment</label>
                                            <input type="text" class="form-control" onkeyup="SendPayment(this, 'double', '#ActivityPaymentError')" onchange="SendPayment(this, 'double', '#ActivityPaymentError')" id="ActivityPayment" name="ActivityPayment" required>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Change</label>
                                            <input type="text" class="form-control" id="ActivityChange" name="ActivityChange">
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <div class = "row">
                                    <div class="col-xs-12">
                                        <input type="button" class="btn btn-success pull-left push-right" value="Print Invoice" onclick="PrintInvoice()" />
                                        <button type="submit" class="btn btn-success pull-right push-right" onclick="#"><i class="material-icons">done</i>Continue</button>
                                    </div> 
                                </div>
                                
                            </form>
                            <form id="InvoiceForm" method="POST" action="/Reservation/Invoice" target="_blank">
                                {{ csrf_field() }}
                                <input type="hidden" name="InvoiceType" value="Activities">
                                <input type="hidden" name="ReservationID" id="ReservationID">
                                <input type="hidden" name="ActivityName" id="ActivityName">
                                <input type="hidden" name="ActivityRate" id="ActivityRate">
                                <input type="hidden" name="iAmountTendered" id="actAmountTendered">
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalActivityDone" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">done</i>
                    </div>
                    <div class="card-content">
                        <h4><span class="close" onclick="HideModalActivityDone()" style="color: black; font-family: Roboto Thin">X</span></h4>
                        <h3 class="title">Activity Done?</h3>
                        <br><br>
                        <div class = "row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success" onclick="SubmitActivityForm()">Yes</button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success" onclick="HideModalActivityDone()">No</button>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalAvailPackagedActivity" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">rowing</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title">Activity Done<span class="close" onclick="HideModalAvailPackagedActivity()">X</span></h3>

                        </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalAvailableBoat" class="modal">
    <div class="Modal-content" style="max-width: 1000px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="teal">
                            <i class="material-icons">directions_boat</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Available Boats<span class="close" onclick="HideModalAvailableBoat()">X</span></h3>
                            </div>
                            
                            <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Boats</label>
                                    <input type="text" class="form-control" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" onclick="run(event)" style="font-family: Roboto" id="tblAvailBoat">
                                    <thead class="text-success">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Capacity</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($BoatsAvailable as $AvailableBoat)
                                        <tr onclick="HighlightRow(this)">
                                            <td>{{$AvailableBoat -> strBoatID}}</td>
                                            <td>{{$AvailableBoat -> strBoatName}}</td>
                                            <td>{{$AvailableBoat -> intBoatCapacity}}</td>
                                            <td>{{$AvailableBoat -> dblBoatRate}}</td>
                                            <td>{{$AvailableBoat -> strBoatDescription}}</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Use Boat" class="btn btn-success btn-simple btn-xs" onclick="ChooseBoat('{{$AvailableBoat -> strBoatName}}')">
                                                    <i class="material-icons">loyalty</i>
                                                </button>
                                            </td>
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