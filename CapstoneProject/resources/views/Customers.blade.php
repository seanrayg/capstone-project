@extends('layout')

@section('WebpageTitle')
    <title>Customers</title>
@endsection

@section('content')
<h5 id="TitlePage">Customers</h5>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#CustomerResort" data-toggle="tab">
                                    <i class="material-icons">beach_access</i>
                                    Customer on resort
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#CustomerRecord" data-toggle="tab">
                                    <i class="material-icons">assignment</i>
                                    All Customer records
                                <div class="ripple-container"></div></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="CustomerResort">

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Search Customer</label>
                                    <input type="text" class="form-control" id="SearchBar2" onkeyup="SearchTable2('tblResortCustomers', '4')" placeholder="Please enter last name">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="tblResortCustomers">
                                    <thead class="text-primary">
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
                                                <button type="button" rel="tooltip" title="View Reservation Info" class="btn btn-primary btn-simple btn-xs" onclick="ShowModalAvailActivity()">
                                                    <i class="material-icons">assignment</i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Add Fee" class="btn btn-info btn-simple btn-xs" onclick="ShowModalAvailActivity()">
                                                    <i class="material-icons">monetization_on</i>
                                                </button>
                                                <button type="button" rel="tooltip" title="View Bill Summary" class="btn btn-success btn-simple btn-xs" onclick="ShowModalAvailActivity()">
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

                    <div class="tab-pane" id="CustomerRecord">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Search Customer</label>
                                    <input type="text" class="form-control" placeholder="Please enter last name" id="SearchBar" onkeyup="SearchTable('tblCustomer', '3')">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger pull-right" onclick="#"><i class="material-icons">delete</i> Delete</button>
                                <button type="submit" class="btn btn-info pull-right" onclick="#"><i class="material-icons">create</i> Edit</button>
                                <button type="submit" class="btn btn-warning pull-right" onclick="#"><i class="material-icons">history</i> History</button>
                            </div>             
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">

                                <table class="table" id="tblCustomer">
                                    <thead class="text-primary">
                                        <th style="display:none">Customer ID</th>
                                        <th onclick="sortTable(1, 'tblCustomer', 'string')">Firstname</th>
                                        <th onclick="sortTable(2, 'tblCustomer', 'string')">Middlename</th>
                                        <th onclick="sortTable(3, 'tblCustomer', 'string')">Lastname</th>
                                        <th onclick="sortTable(4, 'tblCustomer', 'string')">Address</th>
                                        <th onclick="sortTable(5, 'tblCustomer', 'string')">Contact #</th>
                                        <th onclick="sortTable(6, 'tblCustomer', 'string')">Email</th>
                                        <th onclick="sortTable(7, 'tblCustomer', 'string')">Nationality</th>
                                        <th onclick="sortTable(8, 'tblCustomer', 'string')">Gender</th>
                                        <th onclick="sortTable(9, 'tblCustomer', 'string')">Date of birth</th>
                                    </thead>
                                    <tbody>
                                        @foreach($CustomerDetails as $Customer)
                                        <tr onclick="HighlightRow(this)">
                                            <td style="display:none">{{$Customer->strCustomerID}}</td>
                                            <td>{{$Customer->strCustFirstName}}</td>
                                            <td>{{$Customer->strCustMiddleName}}</td>
                                            <td>{{$Customer->strCustLastName}}</td>
                                            <td>{{$Customer->strCustAddress}}</td>
                                            <td>{{$Customer->strCustContact}}</td>
                                            <td>{{$Customer->strCustEmail}}</td>
                                            <td>{{$Customer->strCustNationality}}</td>
                                            <td>{{$Customer->strCustGender}}</td>
                                            <td>{{Carbon\Carbon::parse($Customer->dtmCustBirthday)->format('M j, Y')}}</td>
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