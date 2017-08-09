@extends('layout')

@section('WebpageTitle')
    <title>Payment</title>
@endsection

@section('content')
<h5 id="TitlePage">Payment</h5>

<div class="row">
    <div class="col-lg-7">
        <div class="card card-stats">  
            <div class="card-header" data-background-color="teal">
                <i class="material-icons">monetization_on</i>
            </div>
            <div class="card-content">
                <div class="row">
                    <p class="category"></p>
                    <h4 class="title">Initial Invoice</h4>
                </div>
            
                <div class="row">
                    <div class="col-xs-1"></div>
                    <div class="col-xs-10">
                        <small><h3 class="text-primary">Accomodation Fee</h3></small>
                        <div class="row"></div>
                        <table class="table" id="tblBill">
                            <thead class="text-primary">
                                <th>Room</th>
                                <th>Quantity</th>
                                <th>Rate per day</th>
                                <th>Price</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table><br><br>
                        <p class="paragraphText">Total Room Fee:</p> <p class="paragraphText" id="b-TotalRoomFee"></p><br>
                        <p class="paragraphText">Days of Stay:</p><p class="paragraphText" id="b-DaysOfStay"></p><br><br>
                        <strong><p class="paragraphText">Total Accomodation Fee:</p> <p class="paragraphText" id="TotalAccomodationFee"></p></strong><br>

                        <small><h3 class="text-primary">Miscellaneous Fee</h3></small>
                        <p class="paragraphText">Total Adult Guests:</p> <p class="paragraphText" id="b-TotalAdults"></p><br>
                        <p class="paragraphText">Entrance Fee:</p> <p class="paragraphText" id="EntranceFee"></p><br>
                        <p class="paragraphText">Total Entrance Fee:</p> <p class="paragraphText" id="TotalEntranceFee"></p><br>
                        <small><h3 class="text-primary">Other Fees</h3></small>
                        <p class="paragraphText">Other Fees:</p> <p class="paragraphText" id="b-OtherFees"></p><br>
                        <br>

                        <strong><p class="paragraphText">Total Miscellaneous Fee:</p> <p class="paragraphText" id="TotalMiscellaneousFee"></p></strong><br>

                        <small><h3 class="text-primary">Grand Total</h3></small>
                        <p class="paragraphText">Accomodation Fee:</p> <p class="paragraphText" id="AccomodationFee"></p><br>
                        <p class="paragraphText">Miscellaneous Fee:</p> <p class="paragraphText" id="MiscellaneousFee"></p><br>
                        <strong><h5 class="paragraphText text-primary">Grand Total:</h5> <h5 class="paragraphText" id="GrandTotal"></h5></strong><br>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons text-danger"></i><a href="#pablo"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-stats">  
            <div class="card-header" data-background-color="green">
                <i class="material-icons">payment</i>
            </div>
            <div class="card-content">
                <div class="row">
                    <p class="category"></p>
                    <h4 class="title">Payment</h4>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>
                            <h5 class="paragraphText text-primary">Grand Total:</h5> <h5 class="paragraphText" id="GrandTotal"></h5>
                        </strong><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="paragraphText no-padding">Amount Tendered:</h5> <h5 class="paragraphText" id="Change"></h5><br>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group label-floating" id="AmountTenderedError">
                            <input type="text" class="form-control" onkeyup="SendInput(this, 'double', '#AmountTenderedError')" onchange="SendInput(this, 'double', '#AmountTenderedError')" id="AmountTendered" value = "0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="paragraphText">Change:</h5> <h5 class="paragraphText" id="Change">0</h5><br>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-success pull-right" onclick="#">Continue</button>
            </div>
        </div>
    </div>
</div>


@endsection