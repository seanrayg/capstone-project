@extends('layout')

@section('WebpageTitle')
    <title>Deductions</title>
@endsection

@section('scripts')
    <script src="/js/Deductions.js" type="text/javascript"></script>
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

<h5 class="Title">Bill Deductions</h5>

<div class="row">                      
    <div class="col-lg-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="blue">
                <i class="material-icons">assignment</i>
            </div>
            <div class="card-content">
                <div class="row">
                    <p class="category"></p>
                    <h3 class="title">Information</h3>
                </div>
                <h5 class="descriptionText"><span class="text-info">Name:</span> {{$CustomerName}}</h5>
                <h5 class="descriptionText"<span class="text-info">Total Bill:</span> {{$TotalBill}}</h5>
                <input type="hidden" id="h-TotalBill" value = "{{$TotalBill}}">
            </div>
        </div>
    </div> 
</div>

<div class = "row">
   <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">Deductions</h4>
            </div>
            <div class="row push-left">
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">Search Bill Deductions</label>
                        <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('FeeTable', '1')">
                    </div>
                </div>
            </div>
            <div class="card-content table-responsive scrollable-table" id="style-1">
                <table class="table" id="FeeTable">
                    <thead class="text-success">
                        <th onclick="sortTable(0, 'FeeTable', 'string')" class="text-center">Remarks</th>
                        <th onclick="sortTable(1, 'FeeTable', 'string')" class="text-center">Amount</th>
                        <th onclick="sortTable(2, 'FeeTable', 'string')" class="text-center">Date deducted</th>
                        <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                        @foreach($BillDeductions as $Bill)
                        <tr onclick="HighlightRow(this)" class="text-center">
                            <td>{{$Bill->strPaymentRemarks}}</td>
                            <td>{{$Bill->dblPayAmount}}</td>
                            <td>{{$Bill->dtePayDate}}</td>
                            <td>
                                <button type="button" rel="tooltip" title="Edit" class="btn btn-primary btn-simple btn-xs" onclick="ShowModalEditDeduction('{{$Bill->strPaymentID}}', '{{$Bill->strPaymentRemarks}}', '{{$Bill->dblPayAmount}}')">
                                    <i class="material-icons">edit</i>
                                </button>
                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs" onclick="ShowModalDeleteDeduction('{{$Bill->strPaymentID}}')">
                                    <i class="material-icons">close</i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-success pull-right" onclick="ShowModalAddDeduction()">Add</button>
            </div>
        </div>
    </div>
</div>





@endsection

@section('modals')


<div id="DivModalAddDeduction" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">add</i>
                            </div>
                            <div class="card-content">
                                <p class="category"></p>
                                <h3 class="title">Add Deduction<span class="close" onclick="HideModalAddDeduction()">X</span></h3>
                                <form onsubmit="return CheckForm()" method="post" action="/Billing/Deduction/Add">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="ReservationID" id="ReservationID" value="{{$id}}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <div class="form-group label-floating">
                                                    <label class="control-label">Remarks</label>
                                                    <textarea class="form-control" name="Remarks" id="Remarks" rows="5" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating" id="DeductAmountError">
                                                <label class="control-label">Amount</label>
                                                <input type="text" class="form-control" onkeyup="SendValidateInput(this, 'double', '#DeductAmountError', 'Add')" onchange="SendValidateInput(this, 'double', '#DeductAmountError', 'Add')" id="DeductAmount" name="DeductAmount" required>
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

<div id="DivModalEditDeduction" class="modal">
    <div class="Modal-content" style="max-width: 500px;">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">create</i>
                            </div>
                            <div class="card-content">
                                <p class="category"></p>
                                <h3 class="title">Edit Deduction<span class="close" onclick="HideModalEditDeduction()">X</span></h3>
                                <form onsubmit="return CheckForm()" method="post" action="/Billing/Deduction/Edit">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="EditPaymentID" id="EditPaymentID">
                                    <input type="hidden" name="EditReservationID" id="EditReservationID" value="{{$id}}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <div class="form-group label-static">
                                                    <label class="control-label">Remarks</label>
                                                    <textarea class="form-control" name="EditRemarks" id="EditRemarks" rows="5" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static" id="EditDeductAmountError">
                                                <label class="control-label">Amount</label>
                                                <input type="text" class="form-control" onkeyup="SendValidateInput(this, 'double', '#EditDeductAmountError', 'Edit')" onchange="SendValidateInput(this, 'double', '#EditDeductAmountError', 'Edit')" id="EditDeductAmount" name="EditDeductAmount" required>
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

<div id="DivModalDeleteDeduction" class="modal">
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
                            <h3 class="title">Delete?<span class="close" onclick="HideModalDeleteDeduction()">X</span></h3>
                            <form method="post" action="/Billing/Deduction/Delete">
                                {{ csrf_field() }}
                                <input type="hidden" name="DeletePaymentID" id="DeletePaymentID">
                                <input type="hidden" name="DeleteReservationID" id="DeleteReservationID" value="{{$id}}">
                                <button type="button" class="btn btn-info btn-sm pull-right" onclick="HideModalDeleteDeduction()">Cancel</button>
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