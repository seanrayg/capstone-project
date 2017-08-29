@extends('layout')

@section('WebpageTitle')
    <title>Fees</title>
@endsection

@section('scripts')

    <script src="/js/Fees.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>

@endsection

@section('content')
<h5 id="TitlePage">Fees</h5>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="green">
                <h4 class="title">Customers</h4>
                <p class="category"></p>
            </div>

            <div class="card-content">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group label-static">
                            <label class="control-label">Search Customer</label>
                            <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('tblResortCustomers', '4')" placeholder="Please enter last name">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                        <table class="table" id="tblResortCustomers" onclick="run(event)">
                            <thead class="text-success">
                                <th style="display:none" class="text-center">Customer ID</th>
                                <th style="display:none" class="text-center">Reservation ID</th>
                                <th onclick="sortTable(3, 'tblResortCustomers', 'string')" class="text-center">Firstname</th>
                                <th onclick="sortTable(4, 'tblResortCustomers', 'string')" class="text-center">Middlename</th>
                                <th onclick="sortTable(5, 'tblResortCustomers', 'string')" class="text-center">Lastname</th>
                                <th onclick="sortTable(6, 'tblResortCustomers', 'string')" class="text-center">Contact #</th>
                                <th onclick="sortTable(7, 'tblResortCustomers', 'string')" class="text-center">Email</th>
                                <th class="text-center">Action</th>
                            </thead>
                            <tbody>
                                @foreach($CustomerResort as $Customer)
                                <tr onclick="HighlightRow(this)" class="text-center">
                                    <td style="display:none">{{$Customer->strCustomerID}}</td>
                                    <td style="display:none">{{$Customer->strReservationID}}</td>
                                    <td>{{$Customer->strCustFirstName}}</td>
                                    <td>{{$Customer->strCustMiddleName}}</td>
                                    <td>{{$Customer->strCustLastName}}</td>
                                    <td>{{$Customer->strCustContact}}</td>
                                    <td>{{$Customer->strCustEmail}}</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Add Fee" class="btn btn-warning btn-simple btn-xs" onclick="ShowModalAddFees()">
                                            <i class="material-icons">monetization_on</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="View Fees" class="btn btn-info btn-simple btn-xs">
                                            <i class="material-icons">content_paste</i>
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

@endsection
    
@section('modals')
<div id="DivModalAddFees" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">monetization_on</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Add Fee<span class="close" onclick="HideModalAddFees()">X</span></h3>
                            </div>
                            <form method="POST" action="/Fee/Add" onsubmit="return CheckForm()">
                                {{ csrf_field() }}
                                <input type="hidden" name="AddReservationID" id="AddReservationID">
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" id="AddCustomerName" name="AddCustomerName" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Fee</label>
                                            <div class="selectBox">
                                                <select name="AddFeeID" id="AddFeeID">
                                                    @foreach($Fees as $Fee)
                                                        <option value="{{$Fee->strFeeID}}">{{$Fee->strFeeName}}</option>
                                                    @endforeach
                                                </select>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static" id="AddFeeQuantityError">
                                            <label class="control-label">Quantity</label>
                                            <input type="text" class="form-control" onkeyup="ValidateInput(this, 'int', '#AddFeeQuantityError')" onchange="ValidateInput(this, 'int', '#AddFeeQuantityError')" id="AddFeeQuantity" name="AddFeeQuantity" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="ErrorLabel"></p>
                                    </div>
                                </div>
                                <br>
                                <div class = "row">
                                    <div class="col-xs-6">
                                        <button type="button" class="btn btn-success pull-left"><i class="material-icons">done</i> Pay now</button>
                                    </div> 
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-success pull-right"><i class="material-icons">done</i> Pay at check out</button>
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