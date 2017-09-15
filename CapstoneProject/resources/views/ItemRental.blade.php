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
                                <a href="#BrokenItems" data-toggle="tab">
                                    <i class="material-icons">inbox</i>
                                    Broken/Lost Items
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
                                        @foreach($RentalItems as $Item)
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
                                <table class="table" onclick="run(event, 'Return')" id="tblReturnItem">
                                    <thead class="text-primary">
                                        <th>Name</th>
                                        <th>Rented By</th>
                                        <th>Time Rented</th>
                                        <th>Return Time</th>
                                        <th>Quantity Availed</th>
                                        <th>Rental Status</th>
                                        <th>Excess Time</th>
                                        <th style="display:none">Rate</th>
                                        <th style="display:none">ID</th>
                                        <th style="display:none">Reservation ID</th>
                                        <th style="display:none">Rent ID</th>
                                    </thead>
                                    <tbody>
                                        @foreach($RentedItems as $Item)
                                            <tr onclick="HighlightRow(this)">
                                                <td>{{$Item->strItemName}}</td>
                                                <td>{{$Item->Name}}</td>
                                                <td>{{$Item->tmsCreated}}</td>
                                                <td>{{$Item->intRentedIDuration}}</td>
                                                <td>{{$Item->intRentedIQuantity}}</td>
                                                <td>{{$Item->RentalStatus}}</td>
                                                <td>{{$Item->ExcessTime}}</td>
                                                <td style="display:none">{{$Item->dblItemRate}}</td>
                                                <td style="display:none">{{$Item->strItemID}}</td>
                                                <td style="display:none">{{$Item->strReservationID}}</td>
                                                <td style="display:none">{{$Item->strRentedItemID}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-info pull-right" onclick="ShowModalExtendRent()"><i class="material-icons">alarm_add</i> Extend</button>
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalUndertime()"><i class="material-icons">swap_horiz</i> Return Item</button>
                            </div> 
                        </div>  
                    </div>
                    
                    <div class="tab-pane" id="BrokenItems">
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
                                <table class="table" onclick="run(event, 'Broken')" id="tblBrokenItem">
                                    <thead class="text-primary">
                                        <th>Item</th>
                                        <th>Rented By</th>
                                        <th>Quantity</th>
                                        <th>Date Reported</th>
                                        <th style="display:none">ID</th>
                                        <th style="display:none">Reservation ID</th>
                                        <th style="display:none">Rent ID</th>
                                    </thead>
                                    <tbody>
                                        @foreach($BrokenItems as $Item)
                                            <tr onclick="HighlightRow(this)">
                                                <td>{{$Item->strItemName}}</td>
                                                <td>{{$Item->Name}}</td>
                                                <td>{{$Item->intRentedIBrokenQuantity}}</td>
                                                <td>{{Carbon\Carbon::parse($Item -> tmsCreated)->format('M j, Y g:i A')}}</td>
                                                <td style="display:none">{{$Item->strItemID}}</td>
                                                <td style="display:none">{{$Item->strReservationID}}</td>
                                                <td style="display:none">{{$Item->strRentedItemID}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalRestoreItem()"><i class="material-icons">unarchive</i>Restore Item</button>
                                <button type="button" class="btn btn-danger pull-right" onclick="ShowModalDeleteItem()"><i class="material-icons">delete_sweep</i>Delete Item</button>
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
                                <table class="table" id='tblPackageItems'>
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'tblPackageItems', 'string')">Item</th>
                                        <th onclick="sortTable(1, 'tblPackageItems', 'string')">Customer</th>
                                        <th onclick="sortTable(2, 'tblPackageItems', 'int')">Quantity included</th>
                                        <th onclick="sortTable(3, 'tblPackageItems', 'int')">Duration</th>
                                        <th onclick="sortTable(4, 'tblPackageItems', 'int')">Quantity Left</th>
                                        <th style="display: none">Item ID</th>
                                        <th style="display: none">Reservation ID</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($PackageItems as $Item)
                                            <tr>
                                                <td>{{$Item->strItemName}}</td>
                                                <td>{{$Item->Name}}</td>
                                                <td>{{$Item->intPackageIQuantity}}</td>
                                                <td>{{$Item->flPackageIDuration}}</td>
                                                <td>{{$Item->intItemQuantity}}</td>
                                                <td style="display:none">{{$Item->strItemID}}</td>
                                                <td style="display:none">{{$Item->strReservationID}}</td>
                                                <td>
                                                    <button type="button" rel="tooltip" title="Rent Item" class="btn btn-success btn-simple btn-xs" onclick="ShowModalRentPackageItem('{{$Item->strItemName}}', '{{$Item->Name}}', '{{$Item->intPackageIQuantity}}', '{{$Item->flPackageIDuration}}', '{{$Item->intItemQuantity}}', '{{$Item->strItemID}}', '{{$Item->strReservationID}}')">
                                                        <i class="material-icons">playlist_add_check</i>
                                                    </button>
                                                </td>
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
                        <form method="POST" action="/ItemRental/Rent" onsubmit="return CheckForm()">
                            {{ csrf_field() }}
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
                                        <input type="text" class="form-control" onkeyup="SendQuantityInput(this, 'int', '#RentDurationError')"
                                        onchange="SendQuantityInput(this, 'int', '#RentDurationError')" id="RentDuration" name="RentDuration" required>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Price</label>
                                        <input type="text" class="form-control" rel="tooltip" title="Please enter quantity to rent and for how long to see the price" id="RentItemPrice" name="RentItemPrice" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="ErrorLabel"></p>
                                </div>
                            </div>

                            <br><br>
                            <div class = "row">
                                <div class="col-xs-6">
                                    <button type="button" class="btn btn-success pull-left" onclick="ShowModalRentPayNow()"><i class="material-icons">done</i> Pay now</button>
                                </div> 
                                <div class="col-xs-6">
                                    <button type="submit" class="btn btn-success pull-right" onclick="#"><i class="material-icons">done</i> Pay at check out</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalRentPackageItem" class="modal">
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
                            <h3 class="title">Rent Item<span class="close" onclick="HideModalRentPackageItem()">X</span></h3>
                        </div>
                        <form method="POST" action="/ItemRental/Rent/Package" onsubmit="return CheckForm()">
                            {{ csrf_field() }}
                            <input type="hidden" name="RentPackageReservationID" id="RentPackageReservationID">
                            <input type="hidden" name="RentPackageItemID" id="RentPackageItemID">
                            <input type="hidden" name="RentPackageQuantityLeft" id="RentPackageQuantityLeft">
                            
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Item</label>
                                        <input type="text" class="form-control" id="RentPackageItemName" name="RentPackageItemName" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Name</label>
                                        <input type="text" class="form-control" id="RentPackageCustomerName" name="RentPackageCustomerName" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class = "row">
                                <div class="col-md-6">
                                    <div class="form-group label-static">
                                        <label class="control-label">Quantity Included</label>
                                        <input type="text" class="form-control" id="RentPackageQuantityIncluded" name="RentPackageQuantityIncluded" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-static">
                                        <label class="control-label">Duration</label>
                                        <input type="text" class="form-control" id="RentPackageDuration" name="RentPackageDuration" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating" id="RentPackageQuantityError">
                                        <label class="control-label">Quantity to rent</label>
                                        <input type="text" class="form-control" onkeyup="SendPackageQuantityInput(this, 'int', '#RentPackageQuantityError')"
                                        onchange="SendPackageQuantityInput(this, 'int', '#RentPackageQuantityError')" id="RentPackageQuantity" name="RentPackageQuantity" required>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="ErrorLabel"></p>
                                </div>
                            </div>

                            <br><br>
                            <div class = "row">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-success pull-right" onclick="#"><i class="material-icons">done</i>Rent Item</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalReturnItem" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">swap_horiz</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Return Item<span class="close" onclick="HideModalReturnItem()">X</span></h3>
                            </div>
                            <form method="POST" action="/ItemRental/Return" onsubmit="return CheckReturnForm()" id="formReturnItem" name="formReturnItem">
                                {{ csrf_field() }}
                                <input type="hidden" name="ReturnItemRate" id="ReturnItemRate">
                                <input type="hidden" name="ReturnItemID" id="ReturnItemID">
                                <input type="hidden" name="ReturnReservationID" id="ReturnReservationID">
                                <input type="hidden" name="ReturnRentedItemID" id="ReturnRentedItemID">
                                <input type="hidden" name="ReturnTotalQuantity" id="ReturnTotalQuantity">
                                <div class = "row">
                                    <div class="col-md-6">
                                        <div class="form-group label-static">
                                            <label class="control-label">Item Name</label>
                                            <input type="text" class="form-control" id="ReturnItemName" name="ReturnItemName" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-static">
                                            <label class="control-label">Guest</label>
                                            <input type="text" class="form-control" id="ReturnGuestName" name="ReturnGuestName" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-static">
                                            <label class="control-label">Rental Status</label>
                                            <input type="text" class="form-control" id="ReturnRentalStatus" name="ReturnRentalStatus" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-static">
                                            <label class="control-label">Excess Time</label>
                                            <input type="text" class="form-control" id="ReturnExcessTime" name="ReturnExcessTime" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static" id="ReturnQuantityError">
                                            <label class="control-label">Quantity to return</label>
                                            <input type="text" class="form-control" onkeyup="SendQuantityReturn(this, 'int', '#ReturnQuantityError')"
                                            onchange="SendQuantityReturn(this, 'int', '#ReturnQuantityError')" id="ReturnQuantityAvailed" name="ReturnQuantityAvailed">
                                        </div>
                                    </div>
                                </div>

                                <div id="DivExcessTime" style="display:none">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="ReturnTimePenaltyError">
                                                <label class="control-label">Excess Time Penalty</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double2', '#ReturnTimePenaltyError')" onchange="ValidateInput(this, 'double2', '#ReturnTimePenaltyError')" id="ReturnTimePenalty" rel="tooltip" title="Please enter quantity of rental item to return to see the suggested penalty amount" name="ReturnTimePenalty" value="0" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Item Status</label>
                                            <div class="selectBox" onchange="ControlBrokenContent()">
                                                <select name="ReturnItemStatus" id="ReturnItemStatus">
                                                    <option>Good</option>
                                                    <option>Broken/Lost</option>
                                                </select>
                                              </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="DivBrokenItem" style="display:none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-static" id="BrokenQuantityError">
                                                <label class="control-label">No. of Broken/Lost Items</label>
                                                <input type="text" class="form-control" onkeyup="SendQuantityReturn(this, 'int', '#BrokenQuantityError')" onchange="SendQuantityReturn(this, 'int', '#BrokenQuantityError')" id="ReturnBrokenQuantity" name="ReturnBrokenQuantity" value="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-static" id="BrokenPenaltyError">
                                                <label class="control-label">Penalty due to broken/lost item</label>
                                                <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#BrokenPenaltyError')" onchange="ValidateInput(this, 'double', '#BrokenPenaltyError')" id="ReturnBrokenPenalty" name="ReturnBrokenPenalty" value="0" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="ErrorLabel"></p>
                                    </div>
                                </div>

                                <br><br>
                                <div class = "row">
                                    <div class="col-xs-6">
                                        <button type="button" class="btn btn-success pull-left" id="btnReturnNow" onclick="ShowModalReturnPayNow()"><i class="material-icons">done</i> Pay now</button>
                                    </div> 
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-success pull-right" id="btnReturnOut"><i class="material-icons">done</i> Pay at check out</button>
                                    </div> 
                                </div>
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalExtendRent" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="blue">
                        <i class="material-icons">alarm_add</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title">Extend Rent<span class="close" onclick="HideModalExtendRent()">X</span></h3>
                        </div>
                        <form method="POST" action="/ItemRental/Extend" onsubmit="return CheckForm()">
                            {{ csrf_field() }}
                            <!--<input type="hidden" name="ExtendItemRate" id="ExtendItemRate">-->
                            <input type="hidden" name="ExtendItemID" id="ExtendItemID">
                            <input type="hidden" name="ExtendReservationID" id="ExtendReservationID">
                            <input type="hidden" name="ExtendRentedItemID" id="ExtendRentedItemID">
                            <input type="hidden" name="ExtendTotalQuantity" id="ExtendTotalQuantity">
                            <div class = "row">
                                <div class="col-md-6">
                                    <div class="form-group label-static">
                                        <label class="control-label">Item Name</label>
                                        <input type="text" class="form-control" id="ExtendItemName" name="ExtendItemName" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-static">
                                        <label class="control-label">Guest</label>
                                        <input type="text" class="form-control" id="ExtendGuestName" name="ExtendGuestName" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-6">
                                    <div class="form-group label-static" id="ExtendQuantityError">
                                        <label class="control-label">No. of items to extend</label>
                                        <input type="text" class="form-control" onkeyup="SendQuantityExtend(this, 'int', '#ExtendQuantityError')" onchange="SendQuantityExtend(this, 'int', '#ExtendQuantityError')" id="ExtendQuantity" name="ExtendQuantity" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-static" id="ExtendTimeError">
                                        <label class="control-label">Extend Time</label>
                                        <input type="text" class="form-control" onkeyup="SendQuantityExtend(this, 'int', '#ExtendTimeError')" onchange="SendQuantityExtend(this, 'int', '#ExtendTimeError')"  id="ExtendTime" name="ExtendTime" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Price to pay</label>
                                        <input type="text" class="form-control" rel="tooltip" title="Please enter quantity of items to extend and for how long to see the price" name="ExtendPrice" id="ExtendPrice" value ="0" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="ErrorLabel"></p>
                                </div>
                            </div>

                            <br><br>
                            <div class = "row">
                                <div class="col-xs-6">
                                    <button type="button" class="btn btn-success pull-left" onclick="ShowModalExtendPayNow()"><i class="material-icons">done</i> Pay now</button>
                                </div> 
                                <div class="col-xs-6">
                                    <button type="submit" class="btn btn-success pull-right" onclick="#"><i class="material-icons">done</i> Pay at check out</button>
                                </div> 
                            </div>
                        </form>
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
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Rent Item<span class="close" onclick="HideModalRentPackagedItem()">X</span></h3>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalUndertime" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="orange">
                        <i class="material-icons">alarm_off</i>
                    </div>
                    <div class="card-content">
                        <h4><span class="close" onclick="HideModalUndertime()" style="color: black; font-family: Roboto Thin">X</span></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <h5 class="title text-center">There is still remaining time. Are you sure you want to return the item?</h5>
                            </div>
                        </div>
                        
                        <br>
                        <div class = "row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success" onclick="ShowModalReturnItem()">Yes</button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success" onclick="HideModalUndertime()">No</button>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalRestoreItem" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">unarchive</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title">Restore Item<span class="close" onclick="HideModalRestoreItem()">X</span></h3>
                        </div>
                        <form method="POST" action="/ItemRental/Restore" onsubmit="return CheckForm()">
                            {{ csrf_field() }}
                            <input type="hidden" name="BrokenItemID" id="BrokenItemID">
                            <input type="hidden" name="BrokenReservationID" id="BrokenReservationID">
                            <input type="hidden" name="BrokenRentedItemID" id="BrokenRentedItemID">
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Item Name</label>
                                        <input type="text" class="form-control" id="BrokenItemName" name="BrokenItemName" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Number of items broken/lost</label>
                                        <input type="text" class="form-control" id="BrokenItemQuantity" name="BrokenItemQuantity" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating" id="RestoreQuantityError">
                                        <label class="control-label">Number of items to restore</label>
                                        <input type="text" class="form-control" id="BrokenRestoreQuantity" name="BrokenRestoreQuantity" onkeyup="SendQuantityRestore(this, 'int', '#RestoreQuantityError')" onchange="SendQuantityRestore(this, 'int', '#RestoreQuantityError')" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="ErrorLabel"></p>
                                </div>
                            </div>
                            
                            <div class = "row">
                                <div class="col-xs-6">
                                    <button type="button" class="btn btn-info pull-left" onclick="HideModalRestoreItem()">Cancel</button>
                                </div> 
                                <div class="col-xs-6">
                                    <button type="submit" class="btn btn-success pull-right">Restore</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<div id="DivModalDeleteItem" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="red">
                        <i class="material-icons">delete</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title">Delete Item<span class="close" onclick="HideModalDeleteItem()">X</span></h3>
                        </div>
                        <form method="POST" action="/ItemRental/Delete" onsubmit="return CheckForm()">
                            {{ csrf_field() }}
                            <input type="hidden" name="DeleteItemID" id="DeleteItemID">
                            <input type="hidden" name="DeleteReservationID" id="DeleteReservationID">
                            <input type="hidden" name="DeleteRentedItemID" id="DeleteRentedItemID">
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Item Name</label>
                                        <input type="text" class="form-control" id="DeleteItemName" name="DeleteItemName" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Number of items broken/lost</label>
                                        <input type="text" class="form-control" id="DeleteItemQuantity" name="DeleteItemQuantity" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating" id="DeleteQuantityError">
                                        <label class="control-label">Number of items to delete</label>
                                        <input type="text" class="form-control" id="DeleteQuantity" name="DeleteQuantity" onkeyup="SendQuantityRestore(this, 'int', '#DeleteQuantityError')" onchange="SendQuantityRestore(this, 'int', '#DeleteQuantityError')"  required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="ErrorLabel"></p>
                                </div>
                            </div>
                            
                            <div class = "row">
                                <div class="col-xs-6">
                                    <button type="button" class="btn btn-info pull-left" onclick="HideModalDeleteItem()">Cancel</button>
                                </div> 
                                <div class="col-xs-6">
                                    <button type="submit" class="btn btn-danger pull-right">Delete</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<div id="DivModalRentPayNow" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">monetization_on</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title">Payment<span class="close" onclick="HideModalRentPayNow()">X</span></h3>
                        </div>
                        <form method="POST" action="/ItemRental/RentPay" onsubmit="return CheckForm()">
                            <input type="hidden" id="RentPayItemID" name="RentPayItemID">
                            <input type="hidden" id="RentPayQuantity" name="RentPayQuantity">
                            <input type="hidden" id="RentPayDuration" name="RentPayDuration">
                            <input type="hidden" id="RentPayGuest" name="RentPayGuest">
                            {{ csrf_field() }}
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Total Amount</label>
                                        <input type="text" class="form-control" id="RentPayTotal" name="RentPayTotal" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static" id="RentPayPaymentError">
                                        <label class="control-label">Payment</label>
                                        <input type="text" class="form-control" onkeyup="SendPayment(this, 'double', '#RentPayPaymentError')" onchange="SendPayment(this, 'double', '#RentPayPaymentError')" id="RentPayPayment" name="RentPayPayment" required>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Change</label>
                                        <input type="text" class="form-control" id="RentPayChange" name="RentPayChange">
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class = "row">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-success pull-right" onclick="#"><i class="material-icons">done</i>Continue</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalReturnPayNow" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">monetization_on</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title">Payment<span class="close" onclick="HideModalReturnPayNow()">X</span></h3>
                        </div>
                        <form method="POST" action="/ItemRental/ReturnPay" onsubmit="return CheckForm()">
                            {{ csrf_field() }}
                            <input type="hidden" name="ReturnPayItemRate" id="ReturnPayItemRate">
                            <input type="hidden" name="ReturnPayItemID" id="ReturnPayItemID">
                            <input type="hidden" name="ReturnPayReservationID" id="ReturnPayReservationID">
                            <input type="hidden" name="ReturnPayRentedItemID" id="ReturnPayRentedItemID">
                            <input type="hidden" name="ReturnPayTotalQuantity" id="ReturnPayTotalQuantity">
                            <input type="hidden" id="ReturnPayItemName" name="ReturnPayItemName">
                            <input type="hidden" id="ReturnPayGuestName" name="ReturnPayGuestName">
                            <input type="hidden" id="ReturnPayRentalStatus" name="ReturnPayRentalStatus">
                            <input type="hidden" id="ReturnPayExcessTime" name="ReturnPayExcessTime">
                            <input type="hidden" id="ReturnPayQuantityAvailed" name="ReturnPayQuantityAvailed">
                            <input type="hidden" id="ReturnPayTimePenalty" name="ReturnPayTimePenalty">
                            <input type="hidden" id = "ReturnPayItemStatus" name="ReturnPayItemStatus">
                            <input type="hidden" id="ReturnPayBrokenQuantity" name="ReturnPayBrokenQuantity">
                            <input type="hidden" id="ReturnPayBrokenPenalty" name="ReturnPayBrokenPenalty">

                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Total Amount</label>
                                        <input type="text" class="form-control" id="ReturnPayTotal" name="ReturnPayTotal" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static" id="ReturnPayPaymentError">
                                        <label class="control-label">Payment</label>
                                        <input type="text" class="form-control" onkeyup="SendReturnPayment(this, 'double', '#ReturnPayPaymentError')" onchange="SendReturnPayment(this, 'double', '#ReturnPayPaymentError')" id="ReturnPayPayment" name="ReturnPayPayment" required>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Change</label>
                                        <input type="text" class="form-control" id="ReturnPayChange" name="ReturnPayChange">
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class = "row">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-success pull-right" onclick="#"><i class="material-icons">done</i>Continue</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalExtendPayNow" class="modal">
    <div class="Modal-content" style="width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="blue">
                        <i class="material-icons">alarm_add</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <p class="category"></p>
                            <h3 class="title">Extend Rent<span class="close" onclick="HideModalExtendPayNow()">X</span></h3>
                        </div>
                        <form method="POST" action="/ItemRental/ExtendPay" onsubmit="return CheckForm()">
                            {{ csrf_field() }}
                            <!--<input type="hidden" name="ExtendItemRate" id="ExtendItemRate">-->
                            <input type="hidden" name="ExtendPayItemID" id="ExtendPayItemID">
                            <input type="hidden" name="ExtendPayReservationID" id="ExtendPayReservationID">
                            <input type="hidden" name="ExtendPayRentedItemID" id="ExtendPayRentedItemID">
                            <input type="hidden" name="ExtendPayTotalQuantity" id="ExtendPayTotalQuantity">
                            <input type="hidden" id="ExtendPayItemName" name="ExtendPayItemName">      
                            <input type="hidden" id="ExtendPayGuestName" name="ExtendPayGuestName">
                            <input type="hidden" id="ExtendPayQuantity" name="ExtendPayQuantity">     
                            <input type="hidden" id="ExtendPayTime" name="ExtendPayTime"> 
      
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Total Amount</label>
                                        <input type="text" class="form-control" id="ExtendPayTotal" name="ExtendPayTotal" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static" id="ExtendPayPaymentError">
                                        <label class="control-label">Payment</label>
                                        <input type="text" class="form-control" onkeyup="SendExtendPayment(this, 'double', '#ExtendPayPaymentError')" onchange="SendExtendPayment(this, 'double', '#ExtendPayPaymentError')" id="ExtendPayPayment" name="ExtendPayPayment" required>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Change</label>
                                        <input type="text" class="form-control" id="ExtendPayChange" name="ExtendPayChange">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="ErrorLabel"></p>
                                </div>
                            </div>

                            <br><br>
                            <div class = "row">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-success pull-right" onclick="#"><i class="material-icons">done</i>Continue</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection