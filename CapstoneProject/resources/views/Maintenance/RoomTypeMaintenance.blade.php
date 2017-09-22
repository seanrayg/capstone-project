@extends('layout')

@section('WebpageTitle')
    <title>Accomodation Maintenance</title>
@endsection

@section('scripts')
    <script src="/js/RoomTypeMaintenance.js" type="text/javascript"></script>
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
                            Cannot add because of the following:<br>
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
        <h5 id="TitlePage">Accomodation Maintenace</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/Room">Room &amp; Cottage Maintenance</a></li>
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
                        <span class="nav-tabs-title">Accomodations:</span>
                        <ul class="nav nav-tabs" data-tabs="tabs">     
                            <li class="active" onclick="ResetTables('#CottageTable tbody tr')">
                                <a href="#RoomType" data-toggle="tab">
                                    <i class="material-icons">local_hotel</i>
                                    Room Types
                                <div class="ripple-container"></div></a>
                            </li>

                            <li class="" onclick="ResetTables('#RoomTypeTable tbody tr')">
                                <a href="#Cottage" data-toggle="tab">
                                    <i class="material-icons">local_library</i>
                                    Cottage Types
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
                                    <label class="control-label">Search Room Type</label>
                                    <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('RoomTypeTable', '1')">
                                </div>
                            </div>
                            

                            <div class="col-md-6 pull-right">
                                <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeleteRoomType()"><i class="material-icons">delete</i> Delete</button>
                                <button type="button" class="btn btn-info pull-right" onclick="ShowModalEditRoomType()"><i class="material-icons">create</i> Edit</button>
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddRoomType()"><i class="material-icons">add</i> Add</button>
                                <button type="button" class="btn btn-primary pull-right" onclick="ShowModalImages()"><i class="material-icons">insert_photo</i> Images</button>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="RoomTypeTable" onclick="run(event, 'room')">
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'RoomTypeTable', 'string')">ID</th>
                                        <th onclick="sortTable(1, 'RoomTypeTable', 'string')">Name</th>
                                        <th onclick="sortTable(2, 'RoomTypeTable', 'string')" style="display:none">Category</th>
                                        <th onclick="sortTable(3, 'RoomTypeTable', 'int')">Capacity</th>
                                        <th onclick="sortTable(4, 'RoomTypeTable', 'int')">Beds</th>
                                        <th onclick="sortTable(5, 'RoomTypeTable', 'int')">Bathrooms</th>
                                        <th onclick="sortTable(6, 'RoomTypeTable', 'string')">Aircondition</th>
                                        <th onclick="sortTable(7, 'RoomTypeTable', 'double')">Rate</th>
                                        <th onclick="sortTable(8, 'RoomTypeTable', 'string')">Description</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($RoomTypes as $RoomType)
                                            <tr onclick="HighlightRow(this)">
                                                <td>{{$RoomType -> strRoomTypeID}}</td>
                                                <td>{{$RoomType -> strRoomType}}</td>
                                                <td style="display:none">{{$RoomType -> intRoomTCategory}}</td>
                                                <td>{{$RoomType -> intRoomTCapacity}}</td>
                                                <td>{{$RoomType -> intRoomTNoOfBeds}}</td>
                                                <td>{{$RoomType -> intRoomTNoOfBathrooms}}</td>
                                                <td>{{$RoomType -> intRoomTAirconditioned}}</td>
                                                <td>{{$RoomType -> dblRoomRate}}</td>
                                                <td>{{$RoomType -> strRoomDescription}}</td>
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
                                    <label class="control-label">Search Cottage Type</label>
                                    <input type="text" class="form-control" id="SearchBar2" onkeyup="SearchTable2('CottageTable', '1')">
                                </div>
                            </div>
                            
                            <div class="col-md-6 pull-right">
                                <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeleteRoomType()"><i class="material-icons">delete</i> Delete</button>
                                <button type="button" class="btn btn-info pull-right" onclick="ShowModalEditRoomType()"><i class="material-icons">create</i> Edit</button>
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddRoomType()"><i class="material-icons">add</i> Add</button>
                                <button type="button" class="btn btn-primary pull-right" onclick="ShowModalImages()"><i class="material-icons">insert_photo</i> Images</button>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="CottageTable" onclick="run(event, 'cottage')">
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'CottageTable', 'string')">ID</th>
                                        <th onclick="sortTable(1, 'CottageTable', 'string')">Name</th>
                                        <th onclick="sortTable(2, 'CottageTable', 'string')" style="display:none">Category</th>
                                        <th onclick="sortTable(3, 'CottageTable', 'int')">Capacity</th>
                                        <th style="display:none" onclick="sortTable(4, 'CottageTable', 'int')">Beds</th>
                                        <th style="display:none" onclick="sortTable(5, 'CottageTable', 'int')">Bathrooms</th>
                                        <th style="display:none" onclick="sortTable(6, 'CottageTable', 'string')">Aircondition</th>
                                        <th onclick="sortTable(7, 'CottageTable', 'double')">Rate</th>
                                        <th onclick="sortTable(8, 'CottageTable', 'string')">Description</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($CottageTypes as $Cottage)
                                            <tr onclick="HighlightRow(this)">
                                                <td>{{$Cottage -> strRoomTypeID}}</td>
                                                <td>{{$Cottage -> strRoomType}}</td>
                                                <td style="display:none">{{$Cottage -> intRoomTCategory}}</td>
                                                <td>{{$Cottage -> intRoomTCapacity}}</td>
                                                <td style="display:none">{{$Cottage -> intRoomTNoOfBeds}}</td>
                                                <td style="display:none">{{$Cottage -> intRoomTNoOfBathrooms}}</td>
                                                <td style="display:none">{{$Cottage -> intRoomTAirconditioned}}</td>
                                                <td>{{$Cottage -> dblRoomRate}}</td>
                                                <td>{{$Cottage -> strRoomDescription}}</td>
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

<div id="DivModalAddRoomType" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">add</i>
                    </div>
                    <div class="card-content">
                        <p class="category"></p>
                        <h3 class="title"><span class="close" onclick="HideModalAddRoomType()">X</span></h3>
                        <h3 class="title" id="AddModalTitle"></h3>

                        <form method="POST" action="/Maintenance/RoomType" onsubmit="return CheckForm()" id="RoomTypeForm">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating" id="RoomTypeCodeError">
                                        <label class="control-label">Accomodation ID</label>
                                        @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                        <input type="text" class="form-control" id="RoomTypeCode" onkeyup="ValidateInput(this, 'string', '#RoomTypeCodeError')" onchange="ValidateInput(this, 'string', '#RoomTypeCodeError')" name="RoomTypeCode" value="{{old('RoomTypeCode')}}" required>
                                        @else
                                        <input type="text" class="form-control" id="RoomTypeCode" onkeyup="ValidateInput(this, 'string', '#RoomTypeCodeError')" onchange="ValidateInput(this, 'string', '#RoomTypeCodeError')" name="RoomTypeCode" value="{{$RoomTypeID}}" required>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating" id="RoomTypeNameError">
                                        <label class="control-label">Name</label>
                                        <input type="text" class="form-control" id="RoomTypeName" onkeyup="ValidateInput(this, 'string', '#RoomTypeNameError')"
                                        onchange="ValidateInput(this, 'string', '#RoomTypeNameError')" name="RoomTypeName" value="{{old('RoomTypeName')}}" required>
                                    </div>
                                </div>
                            </div>

                            <div class = "row" style="display: none">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Amenity Type</label>
                                        <div class="selectBox">
                                            <select name="RoomCategory" id="RoomCategory">
                                              @if((count($errors) > 0) || (Session::has('duplicate_message')))
                                                  @if(old('RoomCategory') == 'Cottage')
                                                      <option>Room</option>
                                                      <option selected>Cottage</option>
                                                  @else
                                                      <option>Room</option>
                                                      <option>Cottage</option>
                                                  @endif
                                              @else
                                                  <option>Room</option>
                                                  <option>Cottage</option>
                                              @endif
                                            </select>
                                          </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating" id="RoomCapacityError">
                                        <label class="control-label">Capacity</label>
                                        <input type="text" class="form-control" id="RoomCapacity" onkeyup="ValidateInput(this, 'int', '#RoomCapacityError')"
                                        onchange="ValidateInput(this, 'int', '#RoomCapacityError')" name="RoomCapacity" value="{{old('RoomCapacity')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating" id="RoomRateError">
                                        <label class="control-label">Rate</label>
                                        <input type="text" class="form-control" id="RoomRate" onkeyup="ValidateInput(this, 'double', '#RoomRateError')" onchange="ValidateInput(this, 'double', '#RoomRateError')" name="RoomRate" value="{{old('RoomRate')}}" id="RoomCapacity" required>
                                    </div>
                                </div>
                            </div>

                            <div id="RoomPerks">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-static" id="BedsError">
                                            <label class="control-label">Number of Beds</label>
                                            <input type="text" class="form-control" id="NoOfBeds" onkeyup="AlterInput(this, 'int', '#BedsError')" onchange="AlterInput(this, 'int', '#BedsError')" name="NoOfBeds" value="{{old('NoOfBeds')}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-static" id="BathroomsError">
                                            <label class="control-label">Number of Bathrooms</label>
                                            <input type="text" class="form-control" id="NoOfBathrooms" onkeyup="ValidateInput(this, 'int2', '#BathroomsError')" onchange="ValidateInput(this, 'int2', '#BathroomsError')" name="NoOfBathrooms" value="{{old('NoOfBathrooms')}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="RoomAirconditioned" id="RoomAirconditioned">
                                                Is the room airconditioned?
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">

                                        <div class="form-group label-floating">
                                            <label class="control-label">Description</label>
                                            <textarea class="form-control" rows="5" name="RoomDescription" value="{{old('RoomDescription')}}"></textarea>
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

<div id="DivModalEditRoomType" class="modal">
        <div class="Modal-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-stats">

                        <div class="card-header" data-background-color="blue">
                            <i class="material-icons">create</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="Title"><span class="close" onclick="HideModalEditRoomType()">X</span></h3>
                            <h3 class="title" id="EditModalTitle"></h3>
                            <form method="post" action="/Maintenance/RoomType/Edit" id="EditRoomTypeForm" onsubmit="return CheckForm()">
                                {{ csrf_field() }}
                                <input type="hidden" name="OldRoomTypeCode" id="OldRoomTypeCode" value="{{old('OldRoomTypeCode')}}">
                                <input type="hidden" name="OldRoomTypeName" id="OldRoomTypeName" value="{{old('OldRoomTypeName')}}">
                                <input type="hidden" name="OldRoomRate" id="OldRoomRate" value="{{old('OldRoomRate')}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static" id="EditRoomTypeCodeError">
                                            <label class="control-label">Accomodation ID</label>
                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditRoomTypeCodeError')" onchange="ValidateInput(this, 'string', '#EditRoomTypeCodeError')" id="EditRoomTypeCode" name="EditRoomTypeCode" value="{{old('EditRoomTypeCode')}}" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static" id="EditRoomTypeNameError">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditRoomTypeNameError')" onchange="ValidateInput(this, 'string', '#EditRoomTypeNameError')" id="EditRoomTypeName" name="EditRoomTypeName" value="{{old('EditRoomTypeName')}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class = "row" style="display: none">
                                    <div class="col-md-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Room Category</label>
                                            <div class="selectBox">
                                                <select name="EditRoomCategory" id="EditRoomCategory">
                                                  @if((count($errors) > 0) || (Session::has('duplicate_message')))
                                                      @if(old('EditRoomCategory') == 'Cottage')
                                                          <option>Room</option>
                                                          <option selected>Cottage</option>
                                                      @else
                                                          <option>Room</option>
                                                          <option>Cottage</option>
                                                      @endif
                                                  @else
                                                      <option>Room</option>
                                                      <option>Cottage</option>
                                                  @endif
                                                </select>
                                              </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-static" id="EditRoomCapacityError">
                                            <label class="control-label">Capacity</label>
                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int', '#EditRoomCapacityError')" onchange="ValidateInput(this, 'int', '#EditRoomCapacityError')" id="EditRoomCapacity" name="EditRoomCapacity" value="{{old('EditRoomCapacity')}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-static" id="EditRoomRateError">
                                            <label class="control-label">Rate</label>
                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#EditRoomRateError')" onchange="ValidateInput(this, 'double', '#EditRoomRateError')" id="EditRoomRate" name="EditRoomRate" value="{{old('EditRoomRate')}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div id="EditRoomPerks">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-static" id="EditBedsError">
                                                <label class="control-label">Number of Beds</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int', '#EditBedsError')" onchange="ValidateInput(this, 'int', '#EditBedsError')" id="EditNoOfBeds" name="EditNoOfBeds" value="{{old('EditNoOfBeds')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-static" id="EditBathroomsError">
                                                <label class="control-label">Number of Bathrooms</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int2', '#EditBathroomsError')" onchange="ValidateInput(this, 'int2', '#EditBathroomsError')" id="EditNoOfBathrooms" name="EditNoOfBathrooms" value="{{old('EditNoOfBathrooms')}}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="EditAirconditioned" name="EditAirconditioned">
                                                    Is the room airconditioned?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <div class="form-group label-static">
                                                <label class="control-label">Description</label>
                                                <textarea class="form-control" id="EditRoomDescription" name="EditRoomDescription" value="{{old('EditRoomDescription')}}" rows="5"></textarea>
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

<div id="DivModalDeleteRoomType" class="modal">
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
                            <h3 class="title" id="DeleteModalTitle"><span class="close" onclick="HideModalDeleteRoomType()">X</span></h3>
                            <h3 class="title"></h3>
                            <form method="post" action="/Maintenance/RoomType/Delete" onsubmit="return DeleteRoomType()">
                                {{ csrf_field() }}
                                <input type="hidden" id="d-RoomTypeID" name="d-RoomTypeID">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteRoomType()">Cancel</button>
                                <button type="submit" class="btn btn-danger btn-sm pull-right">Delete</button>
                                <div class="clearfix"></div>
                            </form>           
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="DivModalImages" class="modal">
    <div class="Modal-content" style="max-width: 1000px">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">
                        
                        <div class="card-header" data-background-color="purple">
                            <i class="material-icons">insert_photo</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title" id="DeleteModalTitle"><span class="close" onclick="HideModalImages()">X</span></h3>
                            <h3 class="title">Images</h3>
                            <br><br>
                            <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddImages()"><i class="material-icons">add</i> Add</button>
                            <table class="table" id="tblRoomTypeImages">
                                <thead class="text-primary" style="font-family:'Roboto'">
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Action</th>
                                </thead>
                                <tbody class="text-center">
                                
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="DivModalAddImages" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="purple">
                            <i class="material-icons">insert_photo</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title">Add Image<span class="close" onclick="HideModalAddImages()">X</span></h3>
                            <br>
                            <form method="post" action="/Maintenance/RoomType/Image/Add" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="AddImageRoomTypeID" id="AddImageRoomTypeID">

                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label">Image</label>
                                        <input type="file" accept="image/*" id="RoomTypeImage" name="RoomTypeImage" style="font-family:'Roboto'" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success pull-right" onclick="ShowModalAddImages()"><i class="material-icons">add</i> Add</button>
                            </form>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="DivModalEditImages" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="blue">
                            <i class="material-icons">insert_photo</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title">Edit Image<span class="close" onclick="HideModalEditImages()">X</span></h3>
                            <br>
                            <form method="post" action="/Maintenance/RoomType/Image/Edit" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="EditRoomPictureID" id="EditRoomPictureID">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label">Image</label>
                                        <input type="file" accept="image/*" id="EditRoomTypeImage" name="EditRoomTypeImage" style="font-family:'Roboto'" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info pull-right"><i class="material-icons">edit</i> Edit</button>
                            </form>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="DivModalDeleteImages" class="modal">
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
                            <h3 class="title">Delete Image?<span class="close" onclick="HideModalDeleteImages()">X</span></h3>
                            <h3 class="title"></h3>
                            <form method="post" action="/Maintenance/RoomType/Image/Delete" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" id="DeleteRoomPictureID" name="DeleteRoomPictureID">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteImages()">Cancel</button>
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