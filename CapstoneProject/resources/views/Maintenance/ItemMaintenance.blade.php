@extends('layout')

@section('WebpageTitle')
    <title>Item Maintenance</title>
@endsection

@section('scripts')

    <script src="/js/ItemMaintenance.js" type="text/javascript"></script>
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
        <h5 id="TitlePage">Item Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/Room">Room Maintenance</a></li>
            <li><a href="/Maintenance/RoomType">Room Type Maintenance</a></li>
            <li><a href="/Maintenance/Boat">Boat Maintenance</a></li>
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
            <label class="control-label">Search Items</label>
            <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('ItemTable' , '1')">
        </div>
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeleteItem()"><i class="material-icons">delete</i> Delete</button>
        <button type="button" class="btn btn-info pull-right" onclick="ShowModalEditItem()"><i class="material-icons">create</i> Edit</button>
        <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddItem()"><i class="material-icons">add</i> Add</button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Items</h4>
                <p class="category"></p>
            </div>
            <div class="card-content table-responsive scrollable-table" id="style-1">
                <table class="table" id="ItemTable" onclick="run(event)">
                    <thead class="text-primary">
                        <th onclick="sortTable(0, 'ItemTable', 'string')">ID</th>
                        <th onclick="sortTable(1, 'ItemTable', 'string')">Name</th>
                        <th onclick="sortTable(2, 'ItemTable', 'int')">Quantity</th>
                        <th onclick="sortTable(3, 'ItemTable', 'double')">Rate</th>
                        <th onclick="sortTable(4, 'ItemTable', 'string')">Description</th>
                    </thead>
                    <tbody>
                        @foreach ($Items as $Item)
                        <tr onclick="HighlightRow(this)">
                            <td>{{$Item -> strItemID}}</td>
                            <td>{{$Item -> strItemName}}</td>
                            <td>{{$Item -> intItemQuantity}}</td>
                            <td>{{$Item -> dblItemRate}}</td>
                            <td>{{$Item -> strItemDescription}}</td>
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
<div id="DivModalAddItem" class="modal">
        <div class="Modal-content">
            <div class="row">
	                    <div class="col-md-12">
                                <div class="card card-stats">

                                        <div class="card-header" data-background-color="green">
                                            <i class="material-icons">add</i>
                                        </div>
                                        <div class="card-content">
                                            <p class="category"></p>
                                            <h3 class="title">Add Item<span class="close" onclick="HideModalAddItem()">X</span></h3>
                                            <form id="ItemForm" onsubmit="return CheckForm()" method="post" action="/Maintenance/Item">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating" id="ItemIDError">
                                                            <label class="control-label">Item ID</label>
                                                            @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#ItemIDError')" onchange="ValidateInput(this, 'string', '#ItemIDError')" name="ItemID" value="{{old('ItemID')}}" required>
                                                            @else
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#ItemIDError')" onchange="ValidateInput(this, 'string', '#ItemIDError')" name="ItemID" value="{{$ItemID}}" required>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-floating" id="ItemNameError">
                                                            <label class="control-label">Item Name</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#ItemNameError')" onchange="ValidateInput(this, 'string', '#ItemNameError')" name="ItemName" value="{{old('ItemName')}}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group label-floating" id="ItemQuantityError">
                                                            <label class="control-label">Item Quantity</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int2', '#ItemQuantityError')" onchange="ValidateInput(this, 'int2', '#ItemQuantityError')" name="ItemQuantity" value="{{old('ItemQuantity')}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group label-floating" id="ItemRateError">
                                                            <label class="control-label">Item Rate</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#ItemRateError')" onchange="ValidateInput(this, 'double', '#ItemRateError')" name="ItemRate" value="{{old('ItemRate')}}" required>
                                                       </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">

                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Item Description</label>
                                                                <textarea class="form-control" name="ItemDescription" value="{{old('ItemDescription')}}" rows="5"></textarea>
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


    <div id="DivModalEditItem" class="modal">
        <div class="Modal-content">
            <div class="row">
	                    <div class="col-md-12">
                                <div class="card card-stats">

                                        <div class="card-header" data-background-color="blue">
                                            <i class="material-icons">create</i>
                                        </div>
                                        <div class="card-content">
                                            <p class="category"></p>
                                            <h3 class="title">Edit Item<span class="close" onclick="HideModalEditItem()">X</span></h3>
                                            <form id="EditItemForm" onsubmit="return CheckForm()" method="post" action="/Maintenance/Item/Edit">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="OldItemID" id="OldItemID" value = "{{old('OldItemID')}}">
                                                <input type="hidden" name="OldItemName" id="OldItemName" value = "{{old('OldItemName')}}">
                                                <input type="hidden" name="OldItemRate" id="OldItemRate" value = "{{old('OldItemRate')}}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-static" id="EditItemIDError">
                                                            <label class="control-label">Item ID</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditItemIDError')" onchange="ValidateInput(this, 'string', '#EditItemIDError')" name="EditItemID" id="EditItemID" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group label-static" id="EditItemNameError">
                                                            <label class="control-label">Item Name</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#EditItemNameError')" onchange="ValidateInput(this, 'string', '#EditItemNameError')" name="EditItemName" id="EditItemName" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group label-static" id="EditItemQuantityError">
                                                            <label class="control-label">Item Quantity</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int2', '#EditItemQuantityError')" onchange="ValidateInput(this, 'int2', '#EditItemQuantityError')" name="EditItemQuantity" id="EditItemQuantity" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group label-static" id="EditItemRateError">
                                                            <label class="control-label">Item Rate</label>
                                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#EditItemRateError')" onchange="ValidateInput(this, 'double', '#EditItemRateError')" name="EditItemRate" id="EditItemRate" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">

                                                            <div class="form-group label-static">
                                                                <label class="control-label">Item Description</label>
                                                                <textarea class="form-control" name="EditItemDescription" id="EditItemDescription" rows="5"></textarea>
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

    <div id="DivModalDeleteItem" class="modal">
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
                                <h3 class="title">Delete Item?<span class="close" onclick="HideModalDeleteItem()">X</span></h3>
                                <form method="post" action="/Maintenance/Item/Delete">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="DeleteItemID" id="DeleteItemID" value="">
                                    <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteItem()">Cancel</button>
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