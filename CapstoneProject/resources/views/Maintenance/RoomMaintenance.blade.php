@extends('layout')

@section('WebpageTitle')
    <title>Room and Cottage Maintenance</title>
@endsection

@section('scripts')

    <script src="/js/input-validator.js" type="text/javascript"></script>
    <script src="/js/RoomMaintenance.js" type="text/javascript"></script>
    
@endsection


@section('content')

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
                            $ReservationDetail = Session::get('ReservationDetail');
                            foreach($ReservationDetail as $Detail){
                                echo "<li>" .$Detail->Name. "</li>";
                            }
                        ?>
                   </ul>
                   <button class="btn btn-simple pull-right" style="color: white" onclick="ShowModalGuestInfo()">Show Guest Info</button>
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
                            Cannot add room because of the following:<br>
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
    <div class="col-md-4 dropdown">
        <a href="#" class="btn-simple dropdown-toggle" data-toggle="dropdown">
        <h5 id="TitlePage">Room &amp; Cottage Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/RoomType">Accomodation Maintenance</a></li>
            <li><a href="/Maintenance/Boat">Boat Maintenance</a></li>
            <li><a href="/Maintenance/Item">Item Maintenance</a></li>
            <li><a href="/Maintenance/Activity">Activity Maintenance</a></li>
            <li><a href="/Maintenance/Fee">Fee Maintenance</a></li>
            <li><a href="/Maintenance/Package">Package Maintenance</a></li>
            <li><a href="/Maintenance/Operations">Operations Maintenance</a></li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <span class="nav-tabs-title">Accomodation:</span>
                        <ul class="nav nav-tabs" data-tabs="tabs">     
                            <li class="active" onclick="ResetTables('#CottageTable tbody tr')">
                                <a href="#RoomType" data-toggle="tab">
                                    <i class="material-icons">local_hotel</i>
                                    Rooms
                                <div class="ripple-container"></div></a>
                            </li>

                            <li class="" onclick="ResetTables('#RoomTable tbody tr')">
                                <a href="#Cottage" data-toggle="tab">
                                    <i class="material-icons">local_library</i>
                                    Cottages
                                <div class="ripple-container"></div></a>
                            </li>        
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="RoomType">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Room</label>
                                    <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('RoomTable', '2')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeleteRoom()"><i class="material-icons">delete</i> Delete</button>
                                <button type="button" class="btn btn-info pull-right" onclick="ShowModalEditRoom()"><i class="material-icons">create</i> Edit</button>
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddRoom()"><i class="material-icons">add</i> Add</button>
                            </div>             
                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="RoomTable" onclick="run(event)">
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'RoomTable', 'string')">Room ID</th>
                                        <th onclick="sortTable(1, 'RoomTable', 'string')">Room Type</th>
                                        <th onclick="sortTable(2, 'RoomTable', 'string')">Room Name</th>
                                        <th onclick="sortTable(3, 'RoomTable', 'string')">Room Status</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($Rooms as $Room)
                                        <tr onclick="HighlightRow(this)">
                                            <td>{{$Room -> strRoomID}}</td>
                                            <td>{{$Room -> strRoomType}}</td>
                                            <td>{{$Room -> strRoomName}}</td>
                                            <td>{{$Room -> strRoomStatus}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>                           
                    </div>

            <div class="tab-pane" id="Cottage">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Cottage</label>
                                    <input type="text" class="form-control" id="SearchBar2" onkeyup="SearchTable2('CottageTable', '2')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeleteRoom()"><i class="material-icons">delete</i> Delete</button>
                                <button type="button" class="btn btn-info pull-right" onclick="ShowModalEditRoom()"><i class="material-icons">create</i> Edit</button>
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddRoom()"><i class="material-icons">add</i> Add</button>
                            </div>             
                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="CottageTable" onclick="run(event)">
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'CottageTable', 'string')">ID</th>
                                        <th onclick="sortTable(1, 'CottageTable', 'string')">Cottage Type</th>
                                        <th onclick="sortTable(2, 'CottageTable', 'string')">Cottage Name</th>
                                        <th onclick="sortTable(3, 'CottageTable', 'string')">Cottage Status</th>
                                    </thead>
                                    <tbody>
                                       @foreach ($Cottages as $Cottage)
                                        <tr onclick="HighlightRow(this)">
                                            <td>{{$Cottage -> strRoomID}}</td>
                                            <td>{{$Cottage -> strRoomType}}</td>
                                            <td>{{$Cottage -> strRoomName}}</td>
                                            <td>{{$Cottage -> strRoomStatus}}</td>
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
<div id="DivModalAddRoom" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">add</i>
                            </div>
                            <div class="card-content">
                                <p class="category"></p>
                                <h3 class="title"><span class="close" onclick="HideModalAddRoom()">X</span></h3>
                                <h3 class="title" id="AddModalTitle"></h3>
                                <form id='RoomForm' onsubmit="return CheckForm()" method="post" action="/Maintenance/Room">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating" id="EditRoomIDError">
                                                <label class="control-label">ID</label>
                                                @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditRoomIDError')" onchange="ValidateInput(this, 'string', '#EditRoomIDError')"  name="RoomID" value="{{old('RoomID')}}" required>
                                                @else
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditRoomIDError')" onchange="ValidateInput(this, 'string', '#EditRoomIDError')"  name="RoomID" value="{{$RoomID}}" required>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class = "row" id="RoomTypeHolder">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label" id="AddSelectLabel"></label>
                                                <div class="selectBox">
                                                    <select name="RoomType" id="SelectRoomType" value="{{old('RoomType')}}">
                                       
                                                    </select>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating" id="EditRoomNameError">
                                                <label class="control-label">Name</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditRoomNameError')" onchange="ValidateInput(this, 'string', '#EditRoomNameError')" name="RoomName" value="{{old('RoomName')}}" required>
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


<div id="DivModalEditRoom" class="modal">
    <div class="Modal-content">
        <div class="row">
                    <div class="col-md-12">
                            <div class="card card-stats">

                                    <div class="card-header" data-background-color="blue">
                                        <i class="material-icons">create</i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category"></p>
                                        <h3 class="title"><span class="close" onclick="HideModalEditRoom()">X</span></h3>
                                        <h3 class="title" id="EditModalTitle"></h3>
                                        <form method="post" action="/Maintenance/Room/Edit" onsubmit="return CheckForm()" id="EditRoomForm">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="OldRoomID" id="OldRoomID" value="{{old('OldRoomID')}}">
                                            <input type="hidden" name="OldRoomName" id="OldRoomName" value="{{old('OldRoomName')}}">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-static" id="RoomIDError">
                                                        <label class="control-label">ID</label>
                                                        <input type="text" class="form-control" name="EditRoomID" id="EditRoomID" onkeyup="ValidateInput(this, 'string', '#RoomIDError')" onchange="ValidateInput(this, 'string', '#RoomIDError')" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class = "row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label" id="EditSelectLabel"></label>
                                                        <div class="selectBox">
                                                            <select name="EditRoomType" id="EditSelectRoomType" value="{{old('RoomType')}}">
                                                   
                                                            </select>
                                                          </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-static" id="RoomNameError">
                                                        <label class="control-label">Name</label>
                                                        <input type="text" class="form-control" name="EditRoomName" id="EditRoomName" onkeyup="ValidateInput(this, 'string', '#RoomNameError')" onchange="ValidateInput(this, 'string', '#RoomNameError')" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class = "row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-static">
                                                        <label class="control-label">Status</label>
                                                        <div class="selectBox">
                                                            <select name="EditRoomStatus" id="EditRoomStatus">
                                                              <option>Available</option>
                                                              <option>Unavailable</option>
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

                                            <button type="submit" class="btn btn-info pull-right">Save Changes</button>
                                            <div class="clearfix"></div>
                                        </form>

                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

<div id="DivModalDeleteRoom" class="modal">
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
                            <h3 class="title"><span class="close" onclick="HideModalDeleteRoom()">X</span></h3>
                            <h3 class="title" id="DeleteModalTitle"></h3>
                            <form method="post" action="/Maintenance/Room/Delete">
                                {{ csrf_field() }}
                                <input type="hidden" id="DeleteRoomID" name="DeleteRoomID" value="">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteRoom()">Cancel</button>
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
                                    <th>Reservation Status</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        $ReservationDetail = Session::get('ReservationDetail');
                                        foreach($ReservationDetail as $Detail){
                                            echo "<tr>";
                                            echo "<td>" .$Detail->Name. "</td>";
                                            echo "<td>" .$Detail->strCustContact. "</td>";
                                            echo "<td>" .$Detail->strCustEmail. "</td>";
                                            echo "<td>" .Carbon\Carbon::parse($Detail -> dtmResDArrival)->format('M j, Y'). "</td>";
                                            echo "<td>" .Carbon\Carbon::parse($Detail -> dtmResDDeparture)->format('M j, Y'). "</td>";
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
                        <em class="description-text" style="font-family: Roboto">Please notify the customer using the given email/contact number before changing their rooms!</em>
                        <br>
                        <button type="submit" class="btn btn-danger pull-right" onclick="HideModalGuestInfo()">Cancel</button>
                        <button type="submit" class="btn btn-success pull-right" rel="tooltip" title="Please notify the customer using the given email/contact number before changing their rooms!">Transfer Room</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
</div>
@endif
@endsection