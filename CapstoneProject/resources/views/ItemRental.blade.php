@extends('layout')

@section('WebpageTitle')
    <title>Item Rental</title>
@endsection

@section('scripts')

<script src="/js/ItemRental.js" type="text/javascript"></script>
<script src="/js/input-validator.js" type="text/javascript"></script>
<script src="/js/MainJavascript.js" type="text/javascript"></script>

@endsection

@section('content')
<h5 id="TitlePage">Item Rental</h5>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#AvailableItems" data-toggle="tab">
                                    <i class="material-icons">loyalty</i>
                                    Available Items
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#RentedItems" data-toggle="tab">
                                    <i class="material-icons">rowing</i>
                                    Rented Items
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#PackagedItems" data-toggle="tab">
                                    <i class="material-icons">pages</i>
                                    Packaged Items
                                <div class="ripple-container"></div></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="AvailableItems">

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Items</label>
                                    <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('tblAvailableItems', '1')">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="tblAvailableItems" onclick="run(event, 'Rent')">
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'tblAvailableItems', 'string')">Item ID</th>
                                        <th onclick="sortTable(1, 'tblAvailableItems', 'string')">Item Name</th>
                                        <th onclick="sortTable(2, 'tblAvailableItems', 'int')">Quantity Left</th>
                                        <th onclick="sortTable(3, 'tblAvailableItems', 'double')">Rate per hour</th>
                                        <th onclick="sortTable(4, 'tblAvailableItems', 'string')">Description</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($Items as $Item)
                                        <tr onclick="HighlightRow(this)">
                                            <td>{{$Item -> strItemID}}</td>
                                            <td>{{$Item -> strItemName}}</td>
                                            <td>{{$Item -> intItemQuantity}}</td>
                                            <td>{{$Item -> dblItemRate}}</td>
                                            <td>{{$Item -> strItemDescription}}</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Rent Item" class="btn btn-success btn-simple btn-xs" onclick="ShowModalRentItem()">
                                                    <i class="material-icons">playlist_add_check</i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalRentItem()"><i class="material-icons">check_box</i> Rent</button>
                            </div> 
                        </div>                             
                    </div>

                    <div class="tab-pane" id="RentedItems">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Items</label>
                                    <input type="text" class="form-control" >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Name</th>
                                        <th>Rented By</th>
                                        <th>Time Rented</th>
                                        <th>Return Time</th>
                                        <th>Quantity Availed</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>Rented By</td>
                                            <td>Time Rented</td>
                                            <td>Return Time</td>
                                            <td>Quantity Availed</td>
                                            <td>Status</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Rented By</td>
                                            <td>Time Rented</td>
                                            <td>Return Time</td>
                                            <td>Quantity Availed</td>
                                            <td>Status</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Rented By</td>
                                            <td>Time Rented</td>
                                            <td>Return Time</td>
                                            <td>Quantity Availed</td>
                                            <td>Status</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Rented By</td>
                                            <td>Time Rented</td>
                                            <td>Return Time</td>
                                            <td>Quantity Availed</td>
                                            <td>Status</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Rented By</td>
                                            <td>Time Rented</td>
                                            <td>Return Time</td>
                                            <td>Quantity Availed</td>
                                            <td>Status</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>Rented By</td>
                                            <td>Time Rented</td>
                                            <td>Return Time</td>
                                            <td>Quantity Availed</td>
                                            <td>Status</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-info pull-right" onclick="ShowModalExtendRent()"><i class="material-icons">alarm_add</i> Extend</button>
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalReturnItem()"><i class="material-icons">swap_horiz</i> Return Item</button>
                            </div> 
                        </div>  
                    </div>

                    <div class="tab-pane" id="PackagedItems">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search</label>
                                    <input type="text" class="form-control" >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Item</th>
                                        <th>Customer</th>
                                        <th>Quantity included</th>
                                        <th>Duration</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Item</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                            <td>Duration</td>
                                        </tr>
                                        <tr>
                                            <td>Item</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                            <td>Duration</td>
                                        </tr>
                                        <tr>
                                            <td>Item</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                            <td>Duration</td>
                                        </tr>
                                        <tr>
                                            <td>Item</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                            <td>Duration</td>
                                        </tr>
                                        <tr>
                                            <td>Item</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                            <td>Duration</td>
                                        </tr>
                                        <tr>
                                            <td>Item</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                            <td>Duration</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalRentPackagedItem()"><i class="material-icons">done</i> Avail</button>
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

<div id="DivModalRentItem" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">loyalty</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title">Rent Item<span class="close" onclick="HideModalRentItem()">X</span></h3>
                        </div>
                        <div class = "row">
                            <div class="col-md-6">
                                <div class="form-group label-static">
                                    <label class="control-label">ID</label>
                                    <input type="text" class="form-control" id="RentItemID" name="RentItemID" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Item</label>
                                    <input type="text" class="form-control" id="RentItemName" name="RentItemName" readonly>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-md-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Quantity Left</label>
                                    <input type="text" class="form-control" id="RentQuantityLeft" name="RentQuantityLeft" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Rate per hour</label>
                                    <input type="text" class="form-control" id="RentItemRate" name="RentItemRate" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-static">
                                    <label class="control-label">Guest to rent</label>
                                    <div class="selectBox">
                                        <select name="SelectGuests" id="SelectGuests">
                                            @foreach($Guests as $Guest)
                                                <option>{{$Guest->Name}}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-md-6">
                                <div class="form-group label-floating" id="RentQuantityError">
                                    <label class="control-label">Quantity to rent</label>
                                    <input type="text" class="form-control" onkeyup="SendQuantityInput(this, 'int', '#RentQuantityError')"
                                    onchange="SendQuantityInput(this, 'int', '#RentQuantityError')" id="RentQuantity" name="RentQuantity" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group label-floating" id="RentDurationError">
                                    <label class="control-label">Duration (hours)</label>
                                    <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int', '#RentDurationError')"
                                    onchange="ValidateInput(this, 'int', '#RentDurationError')" id="RentDuration" name="RentDuration" required>
                                </div>
                            </div>
                        </div>
                        
                        <br><br>
                        <div class = "row">
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-success pull-left" onclick="#"><i class="material-icons">done</i> Pay now</button>
                            </div> 
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-success pull-right" onclick="#"><i class="material-icons">done</i> Pay at check out</button>
                            </div> 
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalReturnItem" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">swap_horiz</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title">Return Item<span class="close" onclick="HideModalReturnItem()">X</span></h3>

                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalExtendRent" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">alarm_add</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title">Extend Rent<span class="close" onclick="HideModalExtendRent()">X</span></h3>

                        </div>

                </div>
            </div>
        </div>
    </div>
</div> 

<div id="DivModalRentPackagedItem" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">loyalty</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title">Rent Item<span class="close" onclick="HideModalRentPackagedItem()">X</span></h3>

                        </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection