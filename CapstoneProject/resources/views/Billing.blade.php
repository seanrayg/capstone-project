@extends('layout')

@section('WebpageTitle')
    <title>Payment</title>
@endsection

@section('scripts')
    <script src="/js/Billing.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>
@endsection

@section('content')
<h5 id="TitlePage">Billing</h5>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-stats">  
            <div class="card-header" data-background-color="teal">
                <i class="material-icons">monetization_on</i>
            </div>
            <div class="card-content">
                <div class="row">
                    <p class="category"></p>
                    <h4 class="title">Customer Bills</h4>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Search</label>
                            <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('tblBill', '1')">
                        </div>
                    </div>
                </div>
                <table class="table" id="tblBill" onclick="run(event, 'Bill')">
                    <thead class="text-success">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Check In Date</th>
                            <th class="text-center">Check Out Date</th>
                            <th class="text-center">Total Bill</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ReservationInfo as $Info)
                        <tr class="text-center">
                            <td>{{$Info->strReservationID}}</td>
                            <td>{{$Info->Name}}</td>
                            <td>{{Carbon\Carbon::parse($Info -> dtmResDArrival)->format('M j, Y')}}</td>
                            <td>{{Carbon\Carbon::parse($Info -> dtmResDDeparture)->format('M j, Y')}}</td> 
                            <td>{{$Info->TotalBill}}</td>
                            <td>
                                <button type="button" rel="tooltip" title="Show reservation info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <button type="button" rel="tooltip" title="Show bill breakdown" class="btn btn-primary btn-simple btn-xs" onclick="ShowModalBillBreakdown()">
                                    <i class="material-icons">format_indent_increase</i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons text-danger"></i><a href="#pablo"></a>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection

@section('modals')
<div id="DivModalBillBreakdown" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="purple">
                        <i class="material-icons">format_indent_increase</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <h3 class="title">Bill Breakdown<span class="close" onclick="HideModalBillBreakdown()">X</span></h3>
                        </div>
                        <h5>Package Availed</h5>
                        <table class="table" style="font-family:'Roboto'" id="tblBillPackage">
                            <thead class="text-success">
                                <tr>
                                    <th class="text-center">Package</th>
                                    <th class="text-center">Price</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
     
                            </tbody>
                        </table>
                        <br><br>
                        
                        <h5>Reserved Rooms/Cottages</h5>
                        <table class="table" style="font-family:'Roboto'" id="tblBillAccommodation">
                            <thead class="text-success">
                                <tr>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Rate per day</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
     
                            </tbody>
                        </table>
                        <br><br>
                        
                        <h5>Additional Room/Cottages</h5>
                        <table class="table" style="font-family:'Roboto'" id="tblBillAdditional">
                            <thead class="text-success">
                                <tr>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Rate per day</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
     
                            </tbody>
                        </table>
                        <br><br>
                        
                        <h5>Upgraded Room/Cottages</h5>
                        <table class="table" style="font-family:'Roboto'" id="tblBillUpgrade">
                            <thead class="text-success">
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Payment Needed</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
     
                            </tbody>
                        </table>
                        <br><br>
                        
                        <h5>Days Extended</h5>
                        <table class="table" style="font-family:'Roboto'" id="tblBillExtend">
                            <thead class="text-success">
                                <tr>
                                    <th class="text-center">Number of days</th>
                                    <th class="text-center">Payment</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
     
                            </tbody>
                        </table>
                        <br><br>
                        
                        <h5>Item Rental</h5>
                        <table class="table" style="font-family:'Roboto'" id="tblBillItem">
                            <thead class="text-success">
                                <tr>
                                    <th class="text-center">Item Rental</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Hours used</th>
                                    <th class="text-center">Rate per hour</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                            </tbody>
                        </table>
                        <br><br>
                        
                        <h5>Beach Activities</h5>
                        <table class="table" style="font-family:'Roboto'" id="tblBillActivity">
                            <thead class="text-success">
                                <tr>
                                    <th class="text-center">Activity</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Price</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
        
                            </tbody>
                        </table>
                        <br><br>
                        
                        <h5>Fees</h5>
                         <table class="table" style="font-family:'Roboto'" id="tblBillFee">
                            <thead class="text-success">
                                <tr>
                                    <th class="text-center">Fee</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Price</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
  
                            </tbody>
                        </table>
                        <br><br>
                        
                        <h5>Boats</h5>
                        <table class="table" style="font-family:'Roboto'" id="tblBillBoat">
                            <thead class="text-success">
                                <tr>
                                    <th class="text-center">Boat</th>
                                    <th class="text-center">Price</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                            </tbody>
                        </table>
                        <br><br>
                        
                        <h5>Miscellaneous</h5>
                        <table class="table" style="font-family:'Roboto'" id="tblBillMiscellaneous">
                            <thead class="text-success">
                                <tr>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Remarks</th>
                                    <th class="text-center">Price</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                            </tbody>
                        </table>
                        <br><br>
                        
                        <button type="button" class="btn btn-info pull-right" onclick="HideModalBillBreakdown()">Close</button>
                        <div class="clearfix"></div>
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