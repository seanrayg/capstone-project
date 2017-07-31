@extends('layout')

@section('WebpageTitle')
    <title>Boat Personnel Maintenance</title>
@endsection

@section('scripts')
    <script>
        function ShowModalAddPersonnel(){
            document.getElementById("DivModalAddPersonnel").style.display = "block";
        }
        
        function HideModalAddPersonnel(){
            document.getElementById("DivModalAddPersonnel").style.display = "none";
        }
        
        function ShowModalEditPersonnel(){
            document.getElementById("DivModalEditPersonnel").style.display = "block";
        }
        
        function HideModalEditPersonnel(){
            document.getElementById("DivModalEditPersonnel").style.display = "none";
        }
        
        function ShowModalDeletePersonnel(){
            document.getElementById("DivModalDeletePersonnel").style.display = "block";
        }
        
        function HideModalDeletePersonnel(){
            document.getElementById("DivModalDeletePersonnel").style.display = "none";
        }

    </script>
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
        <h5 id="TitlePage">Boat Personnel Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/Room">Room Maintenance</a></li>
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
                <label class="control-label">Search Boat Personnel</label>
                <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('PersonnelTable', '1')">
            </div>
        </div>

        <div class="col-md-6">
            <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeletePersonnel()"><i class="material-icons">delete</i> Delete</button>
            <button type="button" class="btn btn-info pull-right" onclick="ShowModalEditPersonnel()"><i class="material-icons">create</i> Edit</button>
            <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddPersonnel()"><i class="material-icons">add</i> Add</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title">Boat Personnels</h4>
                    <p class="category"></p>
                </div>
                <div class="card-content table-responsive scrollable-table" id="style-1">
                    <table class="table" id="PersonnelTable">
                        <thead class="text-primary">
                            <th onclick="sortTable(0, 'PersonnelTable', 'string')">Personnel ID</th>
                            <th onclick="sortTable(1, 'PersonnelTable', 'string')">First Name</th>
                            <th onclick="sortTable(2, 'PersonnelTable', 'string')">Middle Name</th>
                            <th onclick="sortTable(3, 'PersonnelTable', 'string')">Last Name</th>
                            <th onclick="sortTable(4, 'PersonnelTable', 'string')">Gender</th>
                            <th onclick="sortTable(5, 'PersonnelTable', 'string')">Contact No.</th>
                            <th onclick="sortTable(6, 'PersonnelTable', 'string')">Address</th>
                            <th onclick="sortTable(7, 'PersonnelTable', 'string')">Personnel Type</th>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('modals')

<div id="DivModalAddPersonnel" class="modal">
        <div class="Modal-content">
            <div class="row">
	                    <div class="col-md-12">
                                <div class="card card-stats">

                                        <div class="card-header" data-background-color="green">
                                            <i class="material-icons">add</i>
                                        </div>
                                        <div class="card-content">
                                            <p class="category"></p>
                                            <h3 class="title">Add Personnel<span class="close" onclick="HideModalAddPersonnel()">X</span></h3>
                                            <form>
                                               <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Personnel ID</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">First Name</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Middle Name</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Last Name</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Address</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Contact Number</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                       <p id="gender-label" style="font-family: 'Roboto'">Gender</p>
                                                        <div class="selectBox">
                                                            <select>
                                                              <option>Male</option>
                                                              <option>Female</option>
                                                            </select>
                                                        </div> 
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                       <p id="gender-label" style="font-family: 'Roboto'">Personnel Type</p>
                                                        <div class="selectBox">
                                                            <select>
                                                              <option>Boat Driver</option>
                                                              <option>Assistant</option>
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


    <div id="DivModalEditPersonnel" class="modal">
        <div class="Modal-content">
            <div class="row">
	                    <div class="col-md-12">
                                <div class="card card-stats">

                                        <div class="card-header" data-background-color="blue">
                                            <i class="material-icons">create</i>
                                        </div>
                                        <div class="card-content">
                                            <p class="category"></p>
                                            <h3 class="title">Edit Personnel<span class="close" onclick="HideModalEditPersonnel()">X</span></h3>
                                            <form>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Personnel ID</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">First Name</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Middle Name</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Last Name</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Address</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Contact Number</label>
                                                            <input type="text" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                       <p id="gender-label" style="font-family: 'Roboto'">Gender</p>
                                                        <div class="selectBox">
                                                            <select>
                                                              <option>Male</option>
                                                              <option>Female</option>
                                                            </select>
                                                        </div> 
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                       <p id="gender-label" style="font-family: 'Roboto'">Personnel Type</p>
                                                        <div class="selectBox">
                                                            <select>
                                                              <option>Boat Driver</option>
                                                              <option>Assistant</option>
                                                            </select>
                                                        </div> 
                                                    </div>
                                                    <div class="col-xs-6">
                                                       <p id="gender-label" style="font-family: 'Roboto'">Status</p>
                                                        <div class="selectBox">
                                                            <select>
                                                              <option>Active</option>
                                                              <option>Inactive</option>
                                                            </select>
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

    <div id="DivModalDeletePersonnel" class="modal">
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
                                <h3 class="title">Delete Personnel?<span class="close" onclick="HideModalDeletePersonnel()">X</span></h3>
                                <form>
                                    
                                    <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeletePersonnel()">Cancel</button>
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