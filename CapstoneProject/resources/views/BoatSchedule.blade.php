@extends('layout')


@section('WebpageTitle')
    <title>Boat Schedule</title>
@endsection

@section('scripts')
    <script>
        function ShowModalRentBoat(){
            document.getElementById("DivModalRentBoat").style.display = "block";
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
        
        

    </script>
    <script src="/js/BoatSchedule.js" type="text/javascript"></script>
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
                                <table class="table" onclick="run(event)">
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
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Name</th>
                                        <th>Used Boat</th>
                                        <th>No. of passengers</th>
                                        <th>Purpose</th>
                                        <th>Pick up</th>
                                        <th>Drop off</th>
                                        <th>Rented By</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>Used Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Used Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Used Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Used Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Used Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Used Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-success pull-right" onclick="#"><i class="material-icons">check</i> Trip Done</button>
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
                                        <th>Name</th>
                                        <th>Reserved Boat</th>
                                        <th>No. of passengers</th>
                                        <th>Purpose</th>
                                        <th>Pick up</th>
                                        <th>Drop off</th>
                                        <th>Rented By</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>Reserved Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Reserved Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Reserved Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Reserved Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Reserved Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Reserved Boat</td>
                                            <td>No. of passengers</td>
                                            <td>Purpose</td>
                                            <td>Pick up</td>
                                            <td>Drop off</td>
                                            <td>Rented By</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
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
                                <form>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Boat to be rented</label>
                                                <input type="text" id="BoatName" value="Boat Name" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12">
                                         <p style="font-family: 'Roboto'">Rented By:</p>
                                            <input list="GuestsList" class="inputlist">
                                            <datalist id="GuestsList">
                                              @foreach($ActiveCustomers as $ActiveCustomer)
                                                <option id="{{$ActiveCustomer -> strCustomerID}}">{{$ActiveCustomer -> strCustFirstName}} {{$ActiveCustomer -> strCustLastName}}</option>
                                              @endforeach
                                            </datalist> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Number of passengers</label>
                                                <input type="text" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Purpose</label>
                                                <input type="text" class="form-control" required>
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