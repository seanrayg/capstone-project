@extends('layout')


@section('WebpageTitle')
    <title>Boat Maintenance</title>
@endsection

@section('scripts')
    <script src="/js/BoatMaintenance.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>
@endsection



@section('content')


<!-- Success Message -->
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

<!-- Delete Error -->
@if(Session::has('error_message'))
    <div class="row">
        <div class="col-md-7 col-md-offset-5">
            <div class="alert alert-danger hide-on-click">
                <div class="container-fluid">
                  <div class="alert-icon">
                    <i class="material-icons">warning</i>
                  </div>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                  </button>
                   <ul>
                       {{ Session::get('error_message') }}<br>
                       <?php 
                            $ReservedBoats = Session::get('ReservedBoats');

                        ?>
                   </ul>
                   <button class="btn btn-simple pull-right" style="color: white" onclick="ShowModalGuestInfo()">Show Guest Info</button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Delete Error -->
@if(Session::has('error_message2'))
    <div class="row">
        <div class="col-md-7 col-md-offset-5">
            <div class="alert alert-danger hide-on-click">
                <div class="container-fluid">
                  <div class="alert-icon">
                    <i class="material-icons">warning</i>
                  </div>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                  </button>
                   <ul>
                       {{ Session::get('error_message2') }}<br>
                   </ul>
                </div>
            </div>
        </div>
    </div>
@endif


<!-- Misc Error -->
@if (count($errors) > 0)
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
                        <ul>
                            Cannot add room type because of the following:<br>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
@endif

<div class="row">
    <div class="col-md-3 dropdown">
        <a href="#" class="btn-simple dropdown-toggle" data-toggle="dropdown">
        <h5 id="TitlePage">Boat Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/Room">Room &amp; Cottage Maintenance</a></li>
            <li><a href="/Maintenance/RoomType">Accomodation Maintenance</a></li>
            <li><a href="/Maintenance/Item">Item Maintenance</a></li>
            <li><a href="/Maintenance/Activity">Activity Maintenance</a></li>
            <li><a href="/Maintenance/Fee">Fee Maintenance</a></li>
            <li><a href="/Maintenance/Package">Package Maintenance</a></li>
            <li><a href="/Maintenance/Operations">Operations Maintenance</a></li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Search Boats</label>
            <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('BoatTable', '1')">
        </div>
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeleteBoat()"><i class="material-icons">delete</i> Delete</button>
        <button type="button" class="btn btn-info pull-right" onclick="ShowModalEditBoat()"><i class="material-icons">create</i> Edit</button>
        <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddBoat()"><i class="material-icons">add</i> Add</button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Boats</h4>
                <p class="category"></p>
            </div>
            <div class="card-content table-responsive scrollable-table" id="style-1">
                <table class="table" id="BoatTable" onclick="run(event)">
                    <thead class="text-primary">
                        <th onclick="sortTable(0, 'BoatTable', 'string')">ID</th>
                        <th onclick="sortTable(1, 'BoatTable', 'string')">Name</th>
                        <th onclick="sortTable(2, 'BoatTable', 'int')">Capacity</th>
                        <th onclick="sortTable(3, 'BoatTable', 'string')">Status</th>
                        <th onclick="sortTable(4, 'BoatTable', 'double')">Rate</th>
                        <th onclick="sortTable(5, 'BoatTable', 'string')">Description</th>
                    </thead>
                    <tbody>
                        @foreach ($Boats as $Boat)
                        <tr onclick="HighlightRow(this)">
                            <td>{{$Boat -> strBoatID}}</td>
                            <td>{{$Boat -> strBoatName}}</td>
                            <td>{{$Boat -> intBoatCapacity}}</td>
                            <td>{{$Boat -> strBoatStatus}}</td>
                            <td>{{$Boat -> dblBoatRate}}</td>
                            <td>{{$Boat -> strBoatDescription}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection

@section('modals')
<div id="DivModalAddBoat" class="modal">
        <div class="Modal-content">
            <div class="row">
	                    <div class="col-md-12">
                                <div class="card card-stats">

                                        <div class="card-header" data-background-color="green">
                                            <i class="material-icons">add</i>
                                        </div>
                                        <div class="card-content">
                                            <p class="category"></p>
                                            <h3 class="title">Add Boat<span class="close" onclick="HideModalAddBoat()">X</span></h3>
                                            <form method="POST" action="/Maintenance/Boat" id="BoatForm" onsubmit="return CheckForm()">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating" id="BoatIDError">
                                                            <label class="control-label">Boat ID</label>
                                                            @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#BoatIDError')" onchange="ValidateInput(this, 'string', '#BoatIDError')" name="BoatID" value="{{old('OldBoatID')}}" required>
                                                            @else
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#BoatIDError')" onchange="ValidateInput(this, 'string', '#BoatIDError')" name="BoatID" value="{{$BoatID}}" required>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating" id="BoatNameError">
                                                            <label class="control-label">Boat Name</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#BoatNameError')" onchange="ValidateInput(this, 'string', '#BoatNameError')" name="BoatName" value="{{old('OldBoatName')}}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group label-floating" id="BoatCapacityError">
                                                            <label class="control-label">Boat Capacity</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int', '#BoatCapacityError')" onchange="ValidateInput(this, 'int', '#BoatCapacityError')" name="BoatCapacity" value="{{old('OldBoatCapacity')}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group label-floating" id="BoatRateError">
                                                            <label class="control-label">Boat Rate</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#BoatRateError')" onchange="ValidateInput(this, 'double', '#BoatRateError')" name="BoatRate" value="{{old('OldBoatRate')}}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label"> Boat Description</label>
                                                                <textarea class="form-control" name="BoatDescription" value="{{old('OldBoatDescription')}}" rows="5"></textarea>
                                                            </div>
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


    <div id="DivModalEditBoat" class="modal">
        <div class="Modal-content">
            <div class="row">
	                    <div class="col-md-12">
                                <div class="card card-stats">

                                        <div class="card-header" data-background-color="blue">
                                            <i class="material-icons">create</i>
                                        </div>
                                        <div class="card-content">
                                            <p class="category"></p>
                                            <h3 class="title">Edit Boat<span class="close" onclick="HideModalEditBoat()">X</span></h3>
                                            <form id="EditBoatForm" onsubmit="return CheckForm()" method="post" action="/Maintenance/Boat/Edit">
                                                {{ csrf_field() }}
                                                <input type="hidden" id="OldBoatID" name="OldBoatID" value="{{old('BoatID')}}">
                                                <input type="hidden" id="OldBoatName" name="OldBoatName" value="{{old('BoatName')}}">
                                                <input type="hidden" id="OldBoatRate" name="OldBoatRate" value="{{old('BoatRate')}}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-static" id="EditBoatIDError">
                                                            <label class="control-label">Boat ID</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditBoatIDError')" onchange="ValidateInput(this, 'string', '#EditBoatIDError')" name="EditBoatID" id="EditBoatID" required>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-static" id="EditBoatNameError">
                                                            <label class="control-label">Boat Name</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditBoatNameError')" onchange="ValidateInput(this, 'string', '#EditBoatNameError')" name="EditBoatName" id="EditBoatName" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group label-static" id="EditBoatCapacityError">
                                                            <label class="control-label">Boat Capacity</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int', '#EditBoatCapacityError')" onchange="ValidateInput(this, 'int', '#EditBoatCapacityError')" name="EditBoatCapacity" id="EditBoatCapacity" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group label-static" id="EditBoatRateError">
                                                            <label class="control-label">Boat Rate</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#EditBoatRateError')" onchange="ValidateInput(this, 'double', '#EditBoatRateError')" name="EditBoatRate" id="EditBoatRate" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class = "row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-static">
                                                            <label class="control-label">Status</label>
                                                            <div class="selectBox">
                                                                <select name="EditBoatStatus" id="EditBoatStatus">
                                                                  <option>Available</option>
                                                                  <option>Unavailable</option>
                                                                </select>
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-group label-static">
                                                                <label class="control-label"> Boat Description</label>
                                                                <textarea class="form-control" rows="5" id="EditBoatDescription" id="EditBoatDescription"></textarea>
                                                            </div>
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

    <div id="DivModalDeleteBoat" class="modal">
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
                                <h3 class="title">Delete Boat?<span class="close" onclick="HideModalDeleteBoat()">X</span></h3>
                                <form method="post" action="/Maintenance/Boat/Delete">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="DeleteBoatID" id="DeleteBoatID" value="">
                                    <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteBoat()">Cancel</button>
                                    <button type="submit" class="btn btn-danger btn-sm pull-right">Delete</button>
                                </form>
                                <div class="clearfix"></div>
                            </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @if(Session::has('error_message'))
        <div id="DivModalGuestInfo" class="modal">
            <div class="Modal-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="red">
                                <i class="material-icons">account_box</i>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <p class="category"></p>
                                    <h3 class="title"><span class="close" onclick="HideModalGuestInfo()">X</span></h3>
                                    <h3 class="title" id="AddModalTitle"></h3>
                                </div>

                                <div class="row" style="font-family: Roboto">
                                    <table class="table">
                                        <thead class="text-primary">
                                            <th>Guest Name</th>
                                            <th>Contact Number</th>
                                            <th>Email</th>
                                            <th>Arrival Date</th>
                                            <th>Departure Date</th>
                                            <th>Pickup Time</th>
                                            <th>Reservation Status</th> 
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $ReservedBoats = Session::get('ReservedBoats');

                                                foreach($ReservedBoats as $Detail){
                                                    echo "<tr>";
                                                    echo "<td>" .$Detail->Name. "</td>";
                                                    echo "<td>" .$Detail->strCustContact. "</td>";
                                                    echo "<td>" .$Detail->strCustEmail. "</td>";
                                                    echo "<td>" .Carbon\Carbon::parse($Detail -> dtmResDArrival)->format('M j, Y'). "</td>";
                                                    echo "<td>" .Carbon\Carbon::parse($Detail -> dtmResDDeparture)->format('M j, Y'). "</td>";
                                                    echo "<td>" .$Detail->PickUpTime. "</td>";
                                                    echo "<td>" .$Detail->intResDStatus. "</td>";  
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <br><br>
                            </div>
                            <div class="card-footer">
                                <em class="description-text" style="font-family: Roboto">Please notify the guest using the given email/contact number before changing their boat(s)!</em>
                                <br>
                                <button type="submit" class="btn btn-danger pull-right" onclick="HideModalGuestInfo()">Cancel</button>
                                <a href="/Reservations"><button type="submit" class="btn btn-success pull-right" rel="tooltip" title="Please notify the guest using the given email/contact number before changing their boat(s)!">Change Boat</button></a>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
        </div>
    @endif
@endsection