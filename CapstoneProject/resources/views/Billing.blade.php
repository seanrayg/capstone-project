@extends('layout')

@section('WebpageTitle')
    <title>Payment</title>
@endsection

@section('content')
<h5 id="TitlePage">Billing</h5>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-stats">  
            <div class="card-header" data-background-color="teal">
                <i class="material-icons">monetization_on</i>
            </div>
            <div class="card-content">
                <div class="row">
                    <p class="category"></p>
                    <h4 class="title">Customer Bills</h4>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Search</label>
                            <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('tblBill', '1')">
                        </div>
                    </div>
                </div>
                <table class="table" id="tblBill">
                    <thead class="text-success">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Check In Date</th>
                            <th class="text-center">Check Out Date</th>
                            <th class="text-center">Total Bill</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>Reservation ID</td>
                            <td>Name</td>
                            <td>Check In Date</td>
                            <td>Check Out Date</td>
                            <td>Total Bill</td>
                            <td>
                                <button type="button" rel="tooltip" title="Show reservation info" class="btn btn-info btn-simple btn-xs">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <button type="button" rel="tooltip" title="Show bill breakdown" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">format_indent_increase</i>
                                </button>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>Reservation ID</td>
                            <td>Name</td>
                            <td>Check In Date</td>
                            <td>Check Out Date</td>
                            <td>Total Bill</td>
                            <td>
                                <button type="button" rel="tooltip" title="Show reservation info" class="btn btn-info btn-simple btn-xs">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <button type="button" rel="tooltip" title="Show bill breakdown" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">format_indent_increase</i>
                                </button>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>Reservation ID</td>
                            <td>Name</td>
                            <td>Check In Date</td>
                            <td>Check Out Date</td>
                            <td>Total Bill</td>
                            <td>
                                <button type="button" rel="tooltip" title="Show reservation info" class="btn btn-info btn-simple btn-xs">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <button type="button" rel="tooltip" title="Show bill breakdown" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">format_indent_increase</i>
                                </button>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>Reservation ID</td>
                            <td>Name</td>
                            <td>Check In Date</td>
                            <td>Check Out Date</td>
                            <td>Total Bill</td>
                            <td>
                                <button type="button" rel="tooltip" title="Show reservation info" class="btn btn-info btn-simple btn-xs">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <button type="button" rel="tooltip" title="Show bill breakdown" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">format_indent_increase</i>
                                </button>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>Reservation ID</td>
                            <td>Name</td>
                            <td>Check In Date</td>
                            <td>Check Out Date</td>
                            <td>Total Bill</td>
                            <td>
                                <button type="button" rel="tooltip" title="Show reservation info" class="btn btn-info btn-simple btn-xs">
                                    <i class="material-icons">assignment</i>
                                </button>
                                <button type="button" rel="tooltip" title="Show bill breakdown" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">format_indent_increase</i>
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons text-danger"></i><a href="#pablo"></a>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection