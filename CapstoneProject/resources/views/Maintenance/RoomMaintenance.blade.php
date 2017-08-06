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
    <div class="col-md-3 dropdown">
        <a href="#" class="btn-simple dropdown-toggle" data-toggle="dropdown">
        <h5 id="TitlePage">Room Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/RoomType">Room Type Maintenance</a></li>
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Rooms</h4>
                <p class="category"></p>
            </div>
            <div class="card-content table-responsive scrollable-table" id="style-1">
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
                                        <h3 class="title">Add Room<span class="close" onclick="HideModalAddRoom()">X</span></h3>
                                        <form id='RoomForm' onsubmit="return CheckForm()" method="post" action="/Maintenance/Room">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-floating" id="EditRoomIDError">
                                                        <label class="control-label">Room ID</label>
                                                        @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                                        <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditRoomIDError')" onchange="ValidateInput(this, 'string', '#EditRoomIDError')"  name="RoomID" value="{{old('RoomID')}}" required>
                                                        @else
                                                        <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditRoomIDError')" onchange="ValidateInput(this, 'string', '#EditRoomIDError')"  name="RoomID" value="{{$RoomID}}" required>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class = "row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Room Type</label>
                                                        <div class="selectBox">
                                                            <select name="RoomType" value="{{old('RoomType')}}">
                                                                @foreach ($RoomTypes as $RoomType)
                                                                    <option>{{$RoomType}}</option>
                                                                @endforeach
                                                            </select>
                                                          </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-floating" id="EditRoomNameError">
                                                        <label class="control-label">Room Name</label>
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
                                        <h3 class="title">Edit Room<span class="close" onclick="HideModalEditRoom()">X</span></h3>
                                        <form method="post" action="/Maintenance/Room/Edit" onsubmit="return CheckForm()" id="EditRoomForm">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="OldRoomID" id="OldRoomID" value="{{old('OldRoomID')}}">
                                            <input type="hidden" name="OldRoomName" id="OldRoomName" value="{{old('OldRoomName')}}">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-static" id="RoomIDError">
                                                        <label class="control-label">Room ID</label>
                                                        <input type="text" class="form-control" name="EditRoomID" id="EditRoomID" onkeyup="ValidateInput(this, 'string', '#RoomIDError')" onchange="ValidateInput(this, 'string', '#RoomIDError')" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class = "row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-static">
                                                        <label class="control-label">Room Type</label>
                                                        <div class="selectBox">
                                                            <select name="EditRoomType" id="EditRoomType">
                                                            @foreach ($RoomTypes as $RoomType)
                                                                <option>{{$RoomType}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-static" id="RoomNameError">
                                                        <label class="control-label">Room Name</label>
                                                        <input type="text" class="form-control" name="EditRoomName" id="EditRoomName" onkeyup="ValidateInput(this, 'string', '#RoomNameError')" onchange="ValidateInput(this, 'string', '#RoomNameError')" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class = "row">
                                                <div class="col-md-12">
                                                    <div class="form-group label-static">
                                                        <label class="control-label">Room Status</label>
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
                            <h3 class="title">Delete Room?<span class="close" onclick="HideModalDeleteRoom()">X</span></h3>
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
@endsection