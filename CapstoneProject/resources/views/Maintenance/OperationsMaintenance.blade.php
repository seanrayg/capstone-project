@extends('layout')

@section('WebpageTitle')
    <title>Operations Maintenance</title>
@endsection

@section('scripts')
    <script src="/js/OperationsMaintenance.js" type="text/javascript"></script>
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
        <h5 id="TitlePage">Operations Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/Room">Room &amp; Cottage Maintenance</a></li>
            <li><a href="/Maintenance/RoomType">Accomodation Maintenance</a></li>
            <li><a href="/Maintenance/Boat">Boat Maintenance</a></li>
            <li><a href="/Maintenance/Item">Item Maintenance</a></li>
            <li><a href="/Maintenance/Activity">Activity Maintenance</a></li>
            <li><a href="/Maintenance/Fee">Fee Maintenance</a></li>
            <li><a href="/Maintenance/Package">Package Maintenance</a></li>
        </ul>
    </div>
</div>

<div class = "row">
   <div class="col-lg-12">
        <div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">Dates</h4>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover" onclick="run(event)">
                    <thead class="text-success">
                        <th>Date ID</th>
                        <th>Title</th>   
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th style="display:none">Start Date2</th>
                        <th style="display:none">End Date2</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($Dates as $Date)
                            <tr onclick="HighlightRow(this)">
                                <td>{{$Date->strDateID}}</td>
                                <td>{{$Date->strDateTitle}}</td>
                                <td>{{Carbon\Carbon::parse($Date -> dteStartDate)->format('M j, Y')}}</td>
                                <td>{{Carbon\Carbon::parse($Date -> dteEndDate)->format('M j, Y')}}</td>
                                <td>{{$Date-> intDateStatus}}</td>
                                <td>{{$Date-> strDateDescription}}</td>
                                <td style="display: none">{{Carbon\Carbon::parse($Date -> dteStartDate)->format('m/d/Y')}}</td>
                                <td style="display: none">{{Carbon\Carbon::parse($Date -> dteEndDate)->format('m/d/Y')}}</td>
                                <td class="td-actions text-right">
                                    <button type="button" rel="tooltip" title="Edit" class="btn btn-primary btn-simple btn-xs" onclick="ShowModalEditDate()">
                                        <i class="material-icons">edit</i>
                                    </button>
                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs" onclick="ShowModalDeleteDate()">
                                        <i class="material-icons">close</i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddDate()">Add</button>
            </div>
        </div>
    </div> 
    
</div>






@endsection

@section('modals')


<div id="DivModalAddDate" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">
                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">add</i>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <h3 class="title">Add Date<span class="close" onclick="HideModalAddDate()">X</span></h3>
                                </div>
                                <form id="AddDateForm" onsubmit="return CheckForm()" method="POST" action="/Maintenance/Operation">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating" id="DateIDError">
                                                <label class="control-label">ID</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#DateIDError')" onchange="ValidateInput(this, 'string', '#DateIDError')" value="{{$DateID}}" id="DateID" name="DateID" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating" id="DateNameError">
                                                <label class="control-label">Title</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#DateNameError')" onchange="ValidateInput(this, 'string', '#DateNameError')" value="{{old('DateName')}}"  id="DateName" name="DateName" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-static" id="StartDateError">
                                                <label class="control-label">Start Date</label>
                                                <input type="text" class="datepicker form-control" value="{{old('StartDate')}}"  name="StartDate" id="StartDate" readonly required/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-static" id="EndDateError">
                                                <label class="control-label">End Date</label>
                                                <input type="text" class="datepicker form-control" value="{{old('EndDate')}}"  name="EndDate" id="EndDate" readonly required/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-group label-static">
                                                    <label class="control-label">Date Description</label>
                                                    <textarea class="form-control" name="DateDescription" value="{{old('DateDescription')}}"  id="DateDescription" rows="5"></textarea>
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

<div id="DivModalEditDate" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">create</i>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <h3 class="title">Edit Date<span class="close" onclick="HideModalEditDate()">X</span></h3>
                                </div>
                                <form id="EditDateForm" onsubmit="return CheckForm()" method="POST" action="/Maintenance/Operation/Edit">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="OldDateID" id="OldDateID" value="">
                                    <input type="hidden" name="OldDateName" id="OldDateName" value="">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="EditDateIDError">
                                                <label class="control-label">ID</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditDateIDError')" onchange="ValidateInput(this, 'string', '#EditDateIDError')" value="" id="EditDateID" name="EditDateID" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="EditDateNameError">
                                                <label class="control-label">Title</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditDateNameError')" onchange="ValidateInput(this, 'string', '#EditDateNameError')" id="EditDateName" name="EditDateName" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-static" id="EditStartDateError">
                                                <label class="control-label">Start Date</label>
                                                <input type="text" class="datepicker form-control" name="EditStartDate" id="EditStartDate" readonly required/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-static" id="EditEndDateError">
                                                <label class="control-label">End Date</label>
                                                <input type="text" class="datepicker form-control" name="EditEndDate" id="EditEndDate" readonly required/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class = "row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static">
                                                <label class="control-label">Status</label>
                                                <div class="selectBox">
                                                    <select name="EditDateStatus" id="EditDateStatus">
                                                      <option>Active</option>
                                                      <option>Inactive</option>
                                                    </select>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-group label-static">
                                                    <label class="control-label">Date Description</label>
                                                    <textarea class="form-control" name="EditDateDescription" id="EditDateDescription" rows="5"></textarea>
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

<div id="DivModalDeleteDate" class="modal">
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
                            <h3 class="title">Delete Date?<span class="close" onclick="HideModalDeleteDate()">X</span></h3>
                            <form id="EditDateForm" method="POST" action="/Maintenance/Operation/Delete">
                                {{ csrf_field() }}
                                <input type="hidden" name="DeleteDateID" id="DeleteDateID" value="">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteDate()">Cancel</button>
                                <button type="submit" class="btn btn-danger btn-sm pull-right">Delete</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="DivModalAddContact" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">add</i>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <h3 class="title">Add Date<span class="close" onclick="HideModalAddContact()">X</span></h3>
                                </div>
                                <form>
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="ContactIDError">
                                                <label class="control-label">Contact ID</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#ContactIDError')" onchange="ValidateInput(this, 'string', '#ContactIDError')" id="ContactID" name="ContactID" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="ContactNameError">
                                                <label class="control-label">Contact Name</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#ContactNameError')" onchange="ValidateInput(this, 'string', '#ContactNameError')" id="ContactName" name="ContactName" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="ContactInfoError">
                                                <label class="control-label">Contact Info</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#ContactInfoError')" onchange="ValidateInput(this, 'string', '#ContactInfoError')" id="ContactInfo" name="ContactInfo" required>
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


<div id="DivModalEditContact" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">create</i>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <h3 class="title">Edit Date<span class="close" onclick="HideModalEditContact()">X</span></h3>
                                </div>
                                <form>
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="EditContactIDError">
                                                <label class="control-label">Contact ID</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditContactIDError')" onchange="ValidateInput(this, 'string', '#EditContactIDError')" id="EditContactID" name="EditContactID" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="EditContactNameError">
                                                <label class="control-label">Contact Name</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditContactNameError')" onchange="ValidateInput(this, 'string', '#EditContactNameError')" id="EditContactName" name="EditContactName" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="EditContactInfoError">
                                                <label class="control-label">Contact Info</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditContactInfoError')" onchange="ValidateInput(this, 'string', '#EditContactInfoError')" id="EditContactInfo" name="EditContactInfo" required>
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

<div id="DivModalDeleteContact" class="modal">
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
                            <h3 class="title">Delete Contact Info?<span class="close" onclick="HideModalDeleteContact()">X</span></h3>
                            <form>
                                {{ csrf_field() }}
                                <input type="hidden" name="DeleteContactID" id="DeleteContactID" value="">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteContact()">Cancel</button>
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