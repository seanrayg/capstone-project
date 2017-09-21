@extends('layout')


@section('WebpageTitle')
    <title>Boat Schedule</title>
@endsection

@section('scripts')
    <script>
        function ShowModalRentBoat(){
            document.getElementById("DivModalRentBoat").style.display = "block";

            var dtmNow = new Date();

            var strTimeNow = formatAMPM(dtmNow, 1);
            var strTimeNowPlusTwo = formatAMPM(dtmNow, 2);

            document.getElementById("time1").value = strTimeNow;
            document.getElementById("time2").value = strTimeNowPlusTwo
        }

        function ChangeTime2(){
            var e = document.getElementById("PickUpTime");
            var intSelectedHour = e.options[e.selectedIndex].value;

            var strTime1 = document.getElementById("time1").value;
            var SplittedTime = strTime1.split(":");
            var intTime1Hour = SplittedTime[0];
            var SplittedTime2 = SplittedTime[1].split(" ");

            var intNewHour = parseInt(intSelectedHour) + parseInt(intTime1Hour);

            var strAMPM = SplittedTime2[1];
            if(SplittedTime2[1] == 'am'){
                if(intTime1Hour == 12){
                    var intNewHour = intNewHour - 12;
                }else{
                    if(intNewHour > 12){
                        var intNewHour = intNewHour - 12;
                        var strAMPM = 'pm';
                    }else if(intNewHour == 12){
                        var strAMPM = 'pm';
                    }
                }
            }else if(SplittedTime2[1] == 'pm'){
                if(intTime1Hour == 12){
                    var intNewHour = intNewHour - 12;
                }else{
                    if(intNewHour > 12){
                        var intNewHour = intNewHour - 12;
                        var strAMPM = 'am';
                    }else if(intNewHour == 12){
                        var strAMPM = 'am';
                    }
                }
            }

            var strTime2 = document.getElementById("time2").value;
            var SplittedTime = strTime1.split(":");
            var SplittedTime2 = SplittedTime[1].split(" ");

            var strNewTime2 = intNewHour + ':' + SplittedTime2[0] + ' ' + strAMPM;

            document.getElementById("time2").value = strNewTime2;
        }

        function formatAMPM(date, mode) {
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';

            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;

            var strTimeNow = hours + ':' + minutes + ' ' + ampm;

            hours = hours + 2;

            var strTimeNowPlusTwo = hours + ':' + minutes + ' ' + ampm;

            if(mode == 1){
                return strTimeNow;
            }else{
                return strTimeNowPlusTwo;
            }
        }
        
        function HideModalRentBoat(){
            document.getElementById("DivModalRentBoat").style.display = "none";
        }
        
        function ShowModalAddReserveBoat(){
            document.getElementById("DivModalAddReserveBoat").style.display = "block";
        }
        
        function HideModalAddReserveBoat(){
            document.getElementById("DivModalAddReserveBoat").style.display = "none";
        }
        
        function ShowModalEditReserveBoat(){
            document.getElementById("DivModalEditReserveBoat").style.display = "block";
        }
        
        function HideModalEditReserveBoat(){
            document.getElementById("DivModalEditReserveBoat").style.display = "none";
        }
        
        function ShowModalCancelReserveBoat(){
            document.getElementById("DivModalCancelReserveBoat").style.display = "block";
        }
        
        function HideModalCancelReserveBoat(){
            document.getElementById("DivModalCancelReserveBoat").style.display = "none";
        }
        
        $(function() {
          $('#CustomerName').on('input',function() {
            var opt = $('option[value="'+$(this).val()+'"]');
            
            document.getElementById('CustomerID').value = opt.attr('id');
          });
        });

    </script>
    <script src="/js/BoatSchedule.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>
@endsection

@section('content')
<h5 id="TitlePage">Boat Schedule</h5>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#AvailableBoats" data-toggle="tab">
                                    <i class="material-icons">done</i>
                                    Available Boats
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#RentedBoats" data-toggle="tab">
                                    <i class="material-icons">directions_boat</i>
                                    Rented Boats
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#ReservedBoats" data-toggle="tab">
                                    <i class="material-icons">event</i>
                                    Reserved Boats
                                <div class="ripple-container"></div></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="AvailableBoats">

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
                                <table class="table" onclick="run(event, 'AvailableBoats')">
                                    <thead class="text-primary">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Capacity</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                    </thead>
                                    <tbody>
                                        @foreach($AvailableBoats as $AvailableBoat)
                                            <tr onclick="HighlightRow(this)">
                                                <td>{{$AvailableBoat -> strBoatID}}</td>
                                                <td>{{$AvailableBoat -> strBoatName}}</td>
                                                <td>{{$AvailableBoat -> intBoatCapacity}}</td>
                                                <td>{{$AvailableBoat -> dblBoatRate}}</td>
                                                <td>{{$AvailableBoat -> strBoatDescription}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class = "row">
                            <div class="col-xs-12">
                                <button id="RentButton" type="button" class="btn btn-success pull-right" onclick="ShowModalRentBoat()" disabled=""><i class="material-icons">class</i> Rent</button> </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="RentedBoats">
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
                                <table class="table" onclick="run(event, 'RentedBoats')">
                                    <thead class="text-primary">
                                        <th>Boat ID</th>
                                        <th>Boat Name</th>
                                        <th>Pick up</th>
                                        <th>Drop off</th>
                                        <th>Rented By</th>
                                    </thead>
                                    <tbody>
                                        @foreach($RentedBoats as $RentedBoat)
                                            <tr onclick="HighlightRow(this)">
                                                <td style="display: none">{{$RentedBoat->strBoatScheduleID}}</td>
                                                <td>{{$RentedBoat->strBoatSBoatID}}</td>
                                                <td>{{$RentedBoat->strBoatName}}</td>
                                                <td>{{$RentedBoat->dtmBoatSPickUp}}</td>
                                                <td>{{$RentedBoat->dtmBoatSDropOff}}</td>
                                                <td>{{$RentedBoat->strCustomerName}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-xs-12">
                                <form method="post" action="/BoatSchedule/RentDone">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="BoatScheduleID" id="BoatScheduleID">
                                    <button type="submit" class="btn btn-success pull-right" onclick="#" id="TripDoneButton" disabled><i class="material-icons">check</i> Trip Done</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="ReservedBoats">
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
                                    <thead class="text-primary">
                                        <th>Boat ID</th>
                                        <th>Boat Name</th>
                                        <th>Pick Up</th>
                                        <th>Drop Off</th>
                                        <th>Reserved By</th>
                                    </thead>
                                    <tbody>
                                        @foreach($ReservedBoats as $ReservedBoat)
                                            <tr onclick="HighlightRow(this)">
                                                <td>{{$ReservedBoat -> strBoatSBoatID}}</td>
                                                <td>{{$ReservedBoat -> strBoatName}}</td>
                                                <td>{{$ReservedBoat -> dtmBoatSPickUp}}</td>
                                                <td>{{$ReservedBoat -> dtmBoatSDropOff}}</td>
                                                <td>{{$ReservedBoat -> strCustomerName}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row" style="display: none">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-danger pull-right" onclick="ShowModalCancelReserveBoat()"><i class="material-icons">clear</i> Cancel</button>
                                <button type="button" class="btn btn-info pull-right" onclick="ShowModalEditReserveBoat()"><i class="material-icons">create</i> Edit</button>
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddReserveBoat()"><i class="material-icons">add</i> Add</button>
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

<div id="DivModalRentBoat" class="modal">
        <div class="Modal-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">add_location</i>
                            </div>
                            <div class="card-content">
                                <p class="category"></p>
                                <h3 class="title">Rent Boat<span class="close" onclick="HideModalRentBoat()">X</span></h3>
                                <form method="POST" action="/BoatSchedule/RentBoat" onsubmit="return CheckSelectedCustomer()">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label>Boat to be rented</label>
                                                <input type="text" id="BoatName" name="BoatID" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label>Boat Rate</label>
                                                <input type="text" id="BoatRate" name="BoatRate" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                         <p style="font-family: 'Roboto'">Rented By:</p>
                                            <input id="CustomerName" name="CustomerName" list="GuestsList" class="inputlist" required>
                                            <input type="hidden" id="CustomerID" name="CustomerID">
                                            <datalist id="GuestsList">
                                              @foreach($ActiveCustomers as $ActiveCustomer)
                                                <option id="{{$ActiveCustomer -> strCustomerID}}" value="{{$ActiveCustomer -> strCustFirstName}} {{$ActiveCustomer -> strCustLastName}}" />
                                              @endforeach
                                            </datalist> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-floating">
                                                <label>Hours</label>
                                                <div class="selectBox" rel="tooltip" title="Minimum hours is 2">
                                                    <select id="PickUpTime" onchange="ChangeTime2()">
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
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-floating">
                                                <label>From: </label>
                                                <input id="time1" name="time1" type="text" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating">
                                                <label>To: </label>
                                                <input id="time2" name="time2" type="text" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p id="CustomerErrorLabel" class="ErrorLabel"></p>
                                        </div>
                                    </div>

                                    <input type="submit" name="action" class="btn btn-success pull-right" value="Pay At Checkout" />
                                    <button type="button" class="btn btn-success pull-left" onclick="ShowModalPayBoatRent()">Pay Now</button>

                                    <div id="DivModalPayBoatRent" class="modal">
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
                                                                    <h3 class="title">Rent Boat<span class="close" onclick="HideModalPayBoatRent()">X</span></h3>
                                                                </div>
                                                                
                                                                <div class = "row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group label-static">
                                                                            <label class="control-label">Total Amount</label>
                                                                            <input type="text" class="form-control" id="BoatRentPrice" name="BoatRentPrice" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class = "row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group label-static" id="ActivityPaymentError">
                                                                            <label class="control-label">Payment</label>
                                                                            <input type="text" class="form-control" onkeyup="SendPayment(this, 'double', '#ActivityPaymentError')" onchange="SendPayment(this, 'double', '#ActivityPaymentError')" id="ActivityPayment" name="ActivityPayment" value="0" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class = "row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group label-static">
                                                                            <label class="control-label">Change</label>
                                                                            <input type="text" class="form-control" id="BoatRentChange" name="BoatRentChange">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <br><br>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <p class="ErrorLabel"></p>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class = "row">
                                                                    <div class="col-xs-12">
                                                                        <input type="button" name="action" class="btn btn-success pull-left push-left" value="Print Invoice" />
                                                                        <input type="submit" name="action" class="btn btn-success pull-right push-right" value="Continue" />
                                                                    </div> 
                                                                </div>
                                                            </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                </form>
                            </div>

                    </div>
                </div>
        </div>
    </div>
</div>

<div id="DivModalAddReserveBoat" class="modal">
        <div class="Modal-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">add_location</i>
                            </div>
                            <div class="card-content">
                                <p class="category"></p>
                                <h3 class="title">Add Boat Reservation<span class="close" onclick="HideModalAddReserveBoat()">X</span></h3>
                                <form>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Boat to be rented</label>
                                                <input type="text" value="Banana Boat" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                           <p style="font-family: 'Roboto'">Rented By:</p>
                                            <input list="GuestsList" class="inputlist">
                                                <datalist id="GuestsList">
                                                </datalist> 
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group label-static" id="ReservationDate">
                                                <label class="control-label">Reservation Date</label>
                                                <input type="text" class="datepicker form-control"/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Number of passengers</label>
                                                <input type="text" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p id="time-label">Reservation Time</p>
                                            <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm">
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
                                        <div class="col-sm-2">
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
                                        <div class="col-sm-2">
                                            <p id="time-label3">Merridean</p>
                                            <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm">
                                                <select id="PickUpMerridean">
                                                  <option>AM</option>
                                                  <option>PM</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-2">
                                            <p id="time-label">Pick Up Time</p>
                                            <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm">
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
                                        <div class="col-sm-2">
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
                                        <div class="col-sm-2">
                                            <p id="time-label3">Merridean</p>
                                            <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm">
                                                <select id="PickUpMerridean">
                                                  <option>AM</option>
                                                  <option>PM</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="ErrorLabel"></p>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success pull-right">Save</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>

                    </div>
                </div>
        </div>
    </div>
</div>

<div id="DivModalEditReserveBoat" class="modal">
        <div class="Modal-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">edit_location</i>
                            </div>
                            <div class="card-content">
                                <p class="category"></p>
                                <h3 class="title">Edit Boat Reservation<span class="close" onclick="HideModalEditReserveBoat()">X</span></h3>
                                <form>

                                    <div class="row">
                                        <div class="col-sm-12">
                                           <p style="font-family: 'Roboto'">Boat Used:</p>
                                            <input list="GuestsList" class="inputlist">
                                                <datalist id="GuestsList">
                                                  <option value="1">
                                                  <option value="2">
                                                  <option value="3">
                                                  <option value="4">
                                                  <option value="5">
                                                </datalist> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                           <p style="font-family: 'Roboto'">Rented By:</p>
                                            <input list="GuestsList" class="inputlist">
                                                <datalist id="GuestsList">
                                                  <option value="1">
                                                  <option value="2">
                                                  <option value="3">
                                                  <option value="4">
                                                  <option value="5">
                                                </datalist> 
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group label-static" id="ReservationDate">
                                                <label class="control-label">Reservation Date</label>
                                                <input type="text" class="datepicker form-control"/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Number of passengers</label>
                                                <input type="text" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <p id="time-label">Reservation Time</p>
                                            <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm">
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
                                        <div class="col-sm-2">
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
                                        <div class="col-sm-2">
                                            <p id="time-label3">Merridean</p>
                                            <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm">
                                                <select id="PickUpMerridean">
                                                  <option>AM</option>
                                                  <option>PM</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-2">
                                            <p id="time-label">Pick Up Time</p>
                                            <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm">
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
                                        <div class="col-sm-2">
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
                                        <div class="col-sm-2">
                                            <p id="time-label3">Merridean</p>
                                            <div class="selectBox" rel="tooltip" title="Valid time is from 6am to 5pm">
                                                <select id="PickUpMerridean">
                                                  <option>AM</option>
                                                  <option>PM</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-12">
                                           <p style="font-family: 'Roboto'">Driver:</p>
                                            <input list="GuestsList" class="inputlist">
                                                <datalist id="GuestsList">
                                                  <option value="1">
                                                  <option value="2">
                                                  <option value="3">
                                                  <option value="4">
                                                  <option value="5">
                                                </datalist> 
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                           <p style="font-family: 'Roboto'">Assistant:</p>
                                            <input list="GuestsList" class="inputlist">
                                                <datalist id="GuestsList">
                                                  <option value="1">
                                                  <option value="2">
                                                  <option value="3">
                                                  <option value="4">
                                                  <option value="5">
                                                </datalist> 
                                        </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="ErrorLabel"></p>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success pull-right">Save</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>

                    </div>
                </div>
        </div>
    </div>
</div>

<div id="DivModalCancelReserveBoat" class="modal">
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
                                <h4 class="title">Cancel Boat Reservation?</h4>
                                <form>
                                    
                                    <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalCancelReserveBoat()">Cancel</button>
                                    <button type="submit" class="btn btn-danger btn-sm pull-right">Delete</button>
                                    <div class="clearfix"></div>
                                </form>           
                            </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection
