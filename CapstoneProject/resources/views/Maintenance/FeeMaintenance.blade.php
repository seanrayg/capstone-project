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
        <h5 id="TitlePage">Fee Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/Room">Room Maintenance</a></li>
            <li><a href="/Maintenance/RoomType">Room Type Maintenance</a></li>
            <li><a href="/Maintenance/Boat">Boat Maintenance</a></li>
            <li><a href="/Maintenance/Item">Item Maintenance</a></li>
            <li><a href="/Maintenance/Activity">Activity Maintenance</a></li>
            <li><a href="/Maintenance/Website">Website Maintenance</a></li>
            <li><a href="/Maintenance/Package">Package Maintenance</a></li>
            <li><a href="/Maintenance/Operations">Operations Maintenance</a></li>
        </ul>
    </div>
</div>


<div class = "row">
   <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">Fees</h4>
            </div>
            <div class="card-content table-responsive scrollable-table" id="style-1">
                <table class="table" id="FeeTable" onclick="run(event, 'Fee')">
                    <thead class="text-success">
                        <th onclick="sortTable(0, 'FeeTable', 'string')">ID</th>
                        <th onclick="sortTable(1, 'FeeTable', 'string')">Name</th>
                        <th onclick="sortTable(2, 'FeeTable', 'string')">Status</th>
                        <th onclick="sortTable(3, 'FeeTable', 'double')">Amount</th>
                        <th onclick="sortTable(4, 'FeeTable', 'string')">Description</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($Fees as $Fee)
                        <tr onclick="HighlightRow(this)">
                            <td>{{$Fee -> strFeeID}}</td>
                            <td>{{$Fee -> strFeeName}}</td>
                            <td>{{$Fee -> strFeeStatus}}</td>
                            <td>{{$Fee -> dblFeeAmount}}</td>
                            <td>{{$Fee -> strFeeDescription}}</td>
                            <td class="td-actions text-right">
                                <button type="button" rel="tooltip" title="Edit" class="btn btn-primary btn-simple btn-xs" value="{{$Fee -> strFeeName}}" onclick="ShowModalEditFee()">
                                    <i class="material-icons">edit</i>
                                </button>
                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs" value="{{$Fee -> strFeeName}}" onclick="ShowModalDeleteFee()">
                                    <i class="material-icons">close</i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddFee()">Add</button>
            </div>
        </div>
    </div>
</div>





@endsection

@section('modals')


<div id="DivModalAddFee" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">add</i>
                            </div>
                            <div class="card-content">
                                <p class="category"></p>
                                <h3 class="title">Add Fee<span class="close" onclick="HideModalAddFee()">X</span></h3>
                                <form onsubmit="return CheckForm()" method="post" action="/Maintenance/Fee">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating" id="FeeIDError">
                                                <label class="control-label">Fee ID</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#FeeIDError')" onchange="ValidateInput(this, 'string', '#FeeIDError')" value="{{$FeeID}}" id="FeeID" name="FeeID" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating" id="FeeNameError">
                                                <label class="control-label">Fee Name</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#FeeNameError')" onchange="ValidateInput(this, 'string', '#FeeNameError')" id="FeeName" name="FeeName" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating" id="FeeAmountError">
                                                <label class="control-label">Fee Amount</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#FeeAmountError')" onchange="ValidateInput(this, 'double', '#FeeAmountError')" id="FeeAmount" name="FeeAmount" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <div class="form-group label-floating">
                                                    <label class="control-label">Fee Description</label>
                                                    <textarea class="form-control" name="FeeDescription" id="FeeDescription" rows="5"></textarea>
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

<div id="DivModalEditFee" class="modal">
    <div class="Modal-content" style="max-width: 500px;">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">create</i>
                            </div>
                            <div class="card-content">
                                <p class="category"></p>
                                <h3 class="title">Edit Fee<span class="close" onclick="HideModalEditFee()">X</span></h3>
                                <form onsubmit="return CheckForm()" method="post" action="/Maintenance/Fee/Edit">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="OldFeeID" id="OldFeeID" value="{{old('OldFeeID')}}">
                                    <input type="hidden" name="OldFeeName" id="OldFeeName" value="{{old('OldFeeName')}}">
                                    <input type="hidden" name="OldFeeAmount" id="OldFeeAmount" value="{{old('OldFeeAmount')}}">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="EditFeeIDError">
                                                <label class="control-label">Fee ID</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditFeeIDError')" onchange="ValidateInput(this, 'string', '#EditFeeIDError')" id="EditFeeID" name="EditFeeID" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="EditFeeNameError">
                                                <label class="control-label">Fee Name</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditFeeNameError')" onchange="ValidateInput(this, 'string', '#EditFeeNameError')" id="EditFeeName" name="EditFeeName" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="EditFeeAmountError">
                                                <label class="control-label">Fee Amount</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#EditFeeAmountError')" onchange="ValidateInput(this, 'double', '#EditFeeAmountError')" id="EditFeeAmount" name="EditFeeAmount" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class = "row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static">
                                                <label class="control-label">Fee Status</label>
                                                <div class="selectBox">
                                                    <select id="EditFeeStatus" name="EditFeeStatus">
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
                                                    <label class="control-label">Fee Description</label>
                                                    <textarea class="form-control" name="EditFeeDescription" id="EditFeeDescription" rows="5"></textarea>
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

<div id="DivModalDeleteFee" class="modal">
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
                            <h3 class="title">Delete Fee?<span class="close" onclick="HideModalDeleteFee()">X</span></h3>
                            <form method="post" action="/Maintenance/Fee/Delete">
                                {{ csrf_field() }}
                                <input type="hidden" name="DeleteFeeID" id="DeleteFeeID" value="">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteFee()">Cancel</button>
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