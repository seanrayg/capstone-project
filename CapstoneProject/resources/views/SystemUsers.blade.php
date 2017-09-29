@extends('layout')

@section('WebpageTitle')
    <title>System Users</title>
@endsection

@section('scripts')
    <script src="/js/SystemUsers.js" type="text/javascript"></script>
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

<h5 id="TitlePage">System Users</h5>

<div class="row">
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Search</label>
            <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('tblContact', '1')">
        </div>
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeleteUser()"><i class="material-icons">delete</i>Delete</button>
        <button type="button" class="btn btn-info pull-right" onclick="ShowModalEditUser()"><i class="material-icons">create</i>Edit</button>
        <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddUser()"><i class="material-icons">add</i> Add</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">System Users</h4>
                <p class="category"></p>
            </div>
            <div class="card-content table-responsive scrollable-table" id="style-1">
                <table class="table" id="tblUsers" onclick="run(event)">
                    <thead class="text-success">
                        <th style="display:none">Contact ID</th>
                        <th onclick="sortTable(1, 'tblUsers', 'string')" class="text-center">User</th>
                        <th onclick="sortTable(2, 'tblUsers', 'string')" class="text-center">Room Management</th>
                        <th onclick="sortTable(3, 'tblUsers', 'string')" class="text-center">Boat Schedule</th>
                        <th onclick="sortTable(4, 'tblUsers', 'string')" class="text-center">Fees</th>
                        <th onclick="sortTable(5, 'tblUsers', 'string')" class="text-center">Item Rental</th>
                        <th onclick="sortTable(6, 'tblUsers', 'string')" class="text-center">Activities</th>
                        <th onclick="sortTable(7, 'tblUsers', 'string')" class="text-center">Billing</th>
                        <th onclick="sortTable(8, 'tblUsers', 'string')" class="text-center">Maintenance</th>
                        <th onclick="sortTable(9, 'tblUsers', 'string')" class="text-center">Utilities</th>
                        <th onclick="sortTable(10, 'tblUsers', 'string')" class="text-center">Reports</th>
                        <th style="display:none">Reports</th>
                    </thead>
                    <tbody class="text-center">
                        @foreach($SystemUsers as $User)
                            <tr onclick="HighlightRow(this)">
                                <td style="display:none">{{$User->strUserID}}</td>
                                <td>{{$User->strUsername}}</td>
                                <td>{{$User->intRoom}}</td>
                                <td>{{$User->intBoat}}</td>
                                <td>{{$User->intFee}}</td>
                                <td>{{$User->intItem}}</td>
                                <td>{{$User->intActivity}}</td>
                                <td>{{$User->intBilling}}</td>
                                <td>{{$User->intMaintenance}}</td>
                                <td>{{$User->intUtilities}}</td>
                                <td>{{$User->intReports}}</td>
                                <td style="display:none">{{$User->strUserPassword}}</td>
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

<div id="DivModalAddUser" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">add</i>
                            </div>
                            <div class="card-content">
                                
                                <div class="row">
                                    <p class="category"></p>
                                    <h3 class="title">Add User<span class="close" onclick="HideModalAddUser()">X</span></h3>
                                </div>
                                
                                <form onsubmit="return CheckForm()" method="post" action="/Users/Add" id="AddUserForm">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="UserID" id="UserID" value="{{$UserID}}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-floating" id="UsernameError">
                                                <label class="control-label">Username</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#Username')" onchange="ValidateInput(this, 'string', '#UsernameError')" id="Username" name="Username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Password</label>
                                                <input type="password" class="form-control" id="UserPassword" name="UserPassword" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view, add, edit or cancel reservation/walkin and upgrade/transfer room of guests">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="ToggleRoom">
                                                    Room Management
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view, add, edit or cancel boat schedules">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="ToggleBoat">
                                                    Boat Schedule
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view, add, edit or delete fees to the guests">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="ToggleFee">
                                                    Fees
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view, add or edit item rental of guests">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="ToggleItem">
                                                    Item Rental
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view, add or edit beach activities of guests">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="ToggleActivity">
                                                    Activities
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view all of the bills of the guests">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="ToggleBilling">
                                                    Billing
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Has an access to the maintenance of the system">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="ToggleMaintenance">
                                                    Maintenance
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Has an access to the utilities of the system">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="ToggleUtilities">
                                                    Utilities
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can generate reports">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="ToggleReports">
                                                    Reports
                                                </label>
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

<div id="DivModalEditUser" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">create</i>
                            </div>
                            <div class="card-content">
                                
                                <div class="row">
                                    <p class="category"></p>
                                    <h3 class="title">Edit User<span class="close" onclick="HideModalEditUser()">X</span></h3>
                                </div>
                                
                                <form onsubmit="return CheckForm()" method="post" action="/Users/Edit" id="AddUserForm">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="EditUserID" id="EditUserID">
                                    <input type="hidden" name="EditOldUsername" id="EditOldUsername">
                                    <input type="hidden" name="EditOldPassword" id="EditOldPassword">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-static" id="EditUsernameError">
                                                <label class="control-label">Username</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditUsername')" onchange="ValidateInput(this, 'string', '#EditUsernameError')" id="EditUsername" name="EditUsername" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Password</label>
                                                <input type="password" class="form-control" id="EditUserPassword" name="EditUserPassword" rel="tooltip" title="Leave blank if you will not change the password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view, add, edit or cancel reservation/walkin and upgrade/transfer room of guests">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="EditToggleRoom" id="EditToggleRoom">
                                                    Room Management
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view, add, edit or cancel boat schedules">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="EditToggleBoat" id="EditToggleBoat">
                                                    Boat Schedule
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view, add, edit or delete fees to the guests">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="EditToggleFee" id="EditToggleFee">
                                                    Fees
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view, add or edit item rental of guests">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="EditToggleItem" id="EditToggleItem">
                                                    Item Rental
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view, add or edit beach activities of guests">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="EditToggleActivity" id="EditToggleActivity">
                                                    Activities
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can view all of the bills of the guests">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="EditToggleBilling" id="EditToggleBilling">
                                                    Billing
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Has an access to the maintenance of the system">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="EditToggleMaintenance" id="EditToggleMaintenance">
                                                    Maintenance
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Has an access to the utilities of the system">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="EditToggleUtilities" id="EditToggleUtilities">
                                                    Utilities
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="togglebutton" rel="tooltip" title="Can generate reports">
                                                <label class="toggleLabel">
                                                    <input type="checkbox" name="EditToggleReports" id="EditToggleReports">
                                                    Reports
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="ErrorLabel"></p>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info pull-right">Update</button>
                                    <div class="clearfix"></div>


                                </form>
                            </div>

                    </div>
                </div>
        </div>
    </div>
</div>



<div id="DivModalDeleteUser" class="modal">
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
                            <h3 class="title">Delete User?<span class="close" onclick="HideModalDeleteUser()">X</span></h3>
                            <form method="post" action="/Users/Delete">
                                {{ csrf_field() }}
                                <input type="hidden" name="DeleteUserID" id="DeleteUserID" value="">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteUser()">Cancel</button>
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