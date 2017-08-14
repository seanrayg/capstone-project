@extends('layout')

@section('WebpageTitle')
    <title>Customers</title>
@endsection

@section('content')
<h5 id="TitlePage">Customers</h5>
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
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Customers</h4>
                <p class="category"></p>
            </div>
            <div class="card-content table-responsive">
                <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                    <table class="table" id="tblCustomer">
                        <thead class="text-primary">
                            <th onclick="sortTable(0, 'tblCustomer', 'string')">Customer ID</th>
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
                            <tr>
                                <td>{{$Customer->strCustomerID}}</td>
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

@endsection