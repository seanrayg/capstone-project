@extends('layout')


@section('WebpageTitle')
    <title>Activity Maintenance</title>
@endsection

@section('scripts')
    <script src="/js/ActivityMaintenance.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>
    
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
        <h5 id="TitlePage">Activity Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/Room">Room Maintenance</a></li>
            <li><a href="/Maintenance/RoomType">Room Type Maintenance</a></li>
            <li><a href="/Maintenance/Boat">Boat Maintenance</a></li>
            <li><a href="/Maintenance/Item">Item Maintenance</a></li>
            <li><a href="/Maintenance/Fee">Fee Maintenance</a></li>
            <li><a href="/Maintenance/Package">Package Maintenance</a></li>
            <li><a href="/Maintenance/Operations">Operations Maintenance</a></li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Search Activities</label>
            <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('ActivityTable' ,'1')">
        </div>
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeleteActivity()"><i class="material-icons">delete</i> Delete</button>
        <button type="button" class="btn btn-info pull-right" onclick="ShowModalEditActivity()"><i class="material-icons">create</i> Edit</button>
        <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddActivity()"><i class="material-icons">add</i> Add</button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Activities</h4>
                <p class="category"></p>
            </div>
            <div class="card-content table-responsive scrollable-table" id="style-1">
                <table class="table" id="ActivityTable" onclick="run(event)">
                    <thead class="text-primary">
                        <th onclick="sortTable(0, 'ActivityTable', 'string')">ID</th>
                        <th onclick="sortTable(1, 'ActivityTable', 'string')">Name</th>
                        <th onclick="sortTable(2, 'ActivityTable', 'string')">Status</th>
                        <th onclick="sortTable(3, 'ActivityTable', 'double')">Rate</th>
                        <th onclick="sortTable(4, 'ActivityTable', 'string')">Is boat needed?</th>
                        <th onclick="sortTable(5, 'ActivityTable', 'string')">Description</th>
                    </thead>
                    <tbody>
                        @foreach ($Activities as $Activity)
                        <tr onclick="HighlightRow(this)">
                            <td>{{$Activity -> strBeachActivityID}}</td>
                            <td>{{$Activity -> strBeachAName}}</td>
                            <td>{{$Activity -> strBeachAStatus}}</td>
                            <td>{{$Activity -> dblBeachARate}}</td>
                            <td>{{$Activity -> intBeachABoat}}</td>
                            <td>{{$Activity -> strBeachADescription}}</td>
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
<div id="DivModalAddActivity" class="modal">
        <div class="Modal-content">
            <div class="row">
	                    <div class="col-md-12">
                                <div class="card card-stats">

                                        <div class="card-header" data-background-color="green">
                                            <i class="material-icons">add</i>
                                        </div>
                                        <div class="card-content">
                                            <p class="category"></p>
                                            <h3 class="title">Add Activity<span class="close" onclick="HideModalAddActivity()">X</span></h3>
                                            <form id="ActivityForm" onsubmit="return CheckForm()" method="post" action="/Maintenance/Activity">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating" id="ActivityIDError">
                                                            <label class="control-label">Activity ID</label>
                                                            @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#ActivityIDError')" onchange="ValidateInput(this, 'string', '#ActivityIDError')" name="ActivityID" value="{{old('ActivityID')}}" required>
                                                            @else
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#ActivityIDError')" onchange="ValidateInput(this, 'string', '#ActivityIDError')" name="ActivityID" value="{{$ActivityID}}" required>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating" id="ActivityNameError">
                                                            <label class="control-label">Activity Name</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#ActivityNameError')" onchange="ValidateInput(this, 'string', '#ActivityNameError')" name="ActivityName" value="{{old('ActivityName')}}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating" id="ActivityRateError">
                                                            <label class="control-label">Activity Rate</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#ActivityRateError')" onchange="ValidateInput(this, 'double', '#ActivityRateError')" name="ActivityRate" value="{{old('ActivityRate')}}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="ActivityBoat">
                                                                Is boat needed?
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Activity Description</label>
                                                                <textarea class="form-control" name="ActivityDescription" value="{{old('ActivityDescription')}}" rows="5"></textarea>
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


    <div id="DivModalEditActivity" class="modal">
        <div class="Modal-content">
            <div class="row">
	                    <div class="col-md-12">
                                <div class="card card-stats">

                                        <div class="card-header" data-background-color="blue">
                                            <i class="material-icons">create</i>
                                        </div>
                                        <div class="card-content">
                                            <p class="category"></p>
                                            <h3 class="title">Edit Activity<span class="close" onclick="HideModalEditActivity()">X</span></h3>
                                            <form id="EditActivityForm" onsubmit="return CheckForm()" method="post" action="/Maintenance/Activity/Edit">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="OldActivityID" id="OldActivityID" value="{{old('OldActivityID')}}">
                                                <input type="hidden" name="OldActivityName" id="OldActivityName" value="{{old('OldActivityName')}}">
                                                <input type="hidden" name="OldActivityRate" id="OldActivityRate" value="{{old('OldActivityRate')}}">
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-static" id="EditActivityIDError">
                                                            <label class="control-label">Activity ID</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditActivityIDError')" onchange="ValidateInput(this, 'string', '#EditActivityIDError')" id="EditActivityID" name="EditActivityID" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-static" id="EditActivityNameError">
                                                            <label class="control-label">Activity Name</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditActivityNameError')" onchange="ValidateInput(this, 'string', '#EditActivityNameError')" id="EditActivityName" name="EditActivityName" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-static" id="EditActivityRateError">
                                                            <label class="control-label">Activity Rate</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#EditActivityRateError')" onchange="ValidateInput(this, 'double', '#EditActivityRateError')" name="EditActivityRate" id="EditActivityRate" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-static">
                                                            <label class="control-label">Activity Status</label>
                                                            <div class="selectBox">
                                                                <select id="EditActivityStatus" name="EditActivityStatus">
                                                                  <option>Available</option>
                                                                  <option>Unavailable</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="EditActivityBoat" id="EditActivityBoat">
                                                                Is boat needed?
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">

                                                            <div class="form-group label-static">
                                                                <label class="control-label">Activity Description</label>
                                                                <textarea class="form-control" name="EditActivityDescription" id="EditActivityDescription" rows="5"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

												<div class="row">
                                                    <div class="col-md-12">
                                                        <p class="ErrorLabel"></p>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-info pull-right">Save</button>
                                                <div class="clearfix"></div>
                                            </form>
                                        </div>

                                </div>
                            </div>
        </div>
      </div>
    </div>

    <div id="DivModalDeleteActivity" class="modal">
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
                                <h3 class="title">Delete Activity?<span class="close" onclick="HideModalDeleteActivity()">X</span></h3>
                                <form method="post" action="/Maintenance/Activity/Delete">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="DeleteActivityID" id="DeleteActivityID" value="">
                                    <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteActivity()">Cancel</button>
                                    <button type="submit" class="btn btn-danger btn-sm pull-right" onclick="DeleteActivity()">Delete</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection