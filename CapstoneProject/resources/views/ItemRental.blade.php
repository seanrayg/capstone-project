@extends('layout')

@section('WebpageTitle')
    <title>Item Rental</title>
@endsection

@section('scripts')
<script>  
        
    function ShowModalRentItem(){
        document.getElementById("DivModalRentItem").style.display = "block";
    }

    function HideModalRentItem(){
        document.getElementById("DivModalRentItem").style.display = "none";
    }

    function ShowModalReturnItem(){
        document.getElementById("DivModalReturnItem").style.display = "block";
    }

    function HideModalReturnItem(){
        document.getElementById("DivModalReturnItem").style.display = "none";
    }

    function ShowModalExtendRent(){
        document.getElementById("DivModalExtendRent").style.display = "block";
    }

    function HideModalExtendRent(){
        document.getElementById("DivModalExtendRent").style.display = "none";
    }

    function ShowModalRentPackagedItem(){
        document.getElementById("DivModalRentPackagedItem").style.display = "block";
    }

    function HideModalRentPackagedItem(){
        document.getElementById("DivModalRentPackagedItem").style.display = "none";
    }

</script>

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
                                    <input type="text" class="form-control" >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="tblAvailableItems">
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'tblAvailableItems', 'string')">Item ID</th>
                                        <th onclick="sortTable(1, 'tblAvailableItems', 'string')">Item Name</th>
                                        <th onclick="sortTable(2, 'tblAvailableItems', 'int')">Quantity Left</th>
                                        <th onclick="sortTable(3, 'tblAvailableItems', 'double')">Rate per hour</th>
                                        <th onclick="sortTable(4, 'tblAvailableItems', 'string')">Description</th>
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
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">loyalty</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title">Rent Item<span class="close" onclick="HideModalRentItem()">X</span></h3>

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