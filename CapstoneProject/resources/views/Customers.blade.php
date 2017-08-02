@extends('layout')

@section('WebpageTitle')
    <title>Customers</title>
@endsection

@section('content')
<h5 id="TitlePage">Customers</h5>
<div class="row">
    <div class="col-md-6">
        <div class="form-group label-floating">
            <label class="control-label">Search Customer</label>
            <input type="text" class="form-control" >
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
                    <table class="table">
                        <thead class="text-primary">
                            <th>Customer ID</th>
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Lastname</th>
                            <th>Address</th>
                            <th>Contact #</th>
                            <th>Email</th>
                            <th>Nationality</th>
                            <th>Gender</th>
                            <th>Date of birth</th>
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