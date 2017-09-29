@extends('layout')

@section('WebpageTitle')
    <title>Upgrade Room</title>
@endsection

@section('scripts')
    <script src="/js/UpgradeRoom.js"></script>
    <script src="/js/input-validator.js"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-md-3 dropdown">
        <h5 id="TitlePage">Upgrade Room</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="material-icons">file_upload</i>
            </div>
            <div class="card-content">
                <h4 class="title">Room to upgrade</h4>
            </div>
            <div class="card-content">
                <br>
                <p class="paragraphText text-success">Room Type:</p> <p class="paragraphText" id="i-RoomType"></p><br>
                <p class="paragraphText text-success">Room Name:</p> <p class="paragraphText" id="i-RoomName"></p><br>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="card card-stats">

                    <div class="card-header" data-background-color="blue">
                        <i class="material-icons">bookmark</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Available</p>
                        <h5 class="title">Accomodations</h5>
                    </div>
                    <div class="card-content">
                        <table class="table" style="font-family: 'Roboto'" id="tblAccomodations">
                            <thead class="text-info">
                                <th>Room Type</th>
                            </thead>
                            <tbody>
                                @foreach($Rooms as $Room)
                                    <tr>
                                        <td onclick="showRooms('{{$Room->strRoomType}}')" id="{{$Room->strRoomType}}">{{$Room->strRoomType}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
      
                    </div>

        </div>
    </div>

    <div class="col-sm-6">
        <div class="card card-stats">

                    <div class="card-header" data-background-color="blue">
                        <i class="material-icons">beenhere</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Available</p>
                        <h5 class="title">Rooms</h5>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table" style="font-family: 'Roboto'" id="tblRooms">
                            <thead class="text-info">
                                <th>Room Name</th>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalUpgradeRoom()">Upgrade</button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

        </div>
    </div>

</div>


@endsection

@section('modals')

<div id="DivModalUpgradeRoom" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">monetization_on</i>
                    </div>
                    <div class="card-content">
                        <h4><span class="close" onclick="HideModalUpgradeRoom()" style="color: black; font-family: Roboto Thin">X</span></h4>
                        <h3 class="title">Pay now?</h3>
                        <br>
                        <p class="category text-center" style="font-family: Roboto; color:black" id="AdditionalPayment"></p>
                        <br><br>
                        <div class = "row">
                            <button type="button" class="btn btn-success push-left pull-left" onclick="ShowModalPayNow()">Pay Now</button>
                            <button type="button" class="btn btn-success push-right pull-right" onclick="SaveUpgradeInfo()">Pay at Checkout</button>
                            <form method="POST" action="/Upgrade/Save" id="UpgradePayLaterForm">
                                {{ csrf_field() }}
                                <input type="hidden" id="ReservationID" name="ReservationID">
                                <input type="hidden" id="RoomName" name="RoomName">
                                <input type="hidden" id="NewRoomName" name="NewRoomName">
                                <input type="hidden" id="TotalAmount" name="TotalAmount">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalPayNow" class="modal">
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
                            <h3 class="title">Extend Rent<span class="close" onclick="HideModalPayNow()">X</span></h3>
                        </div>
                        <form method="POST" action="/Upgrade/Pay" onsubmit="return CheckForm()">
                            {{ csrf_field() }}
                            <input type="hidden" id="PayReservationID" name="PayReservationID">
                            <input type="hidden" id="PayRoomName" name="PayRoomName">
                            <input type="hidden" id="PayNewRoomName" name="PayNewRoomName">
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Total Amount</label>
                                        <input type="text" class="form-control" id="PayTotal" name="PayTotal" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static" id="PayPaymentError">
                                        <label class="control-label">Payment</label>
                                        <input type="text" class="form-control" onkeyup="SendPayment(this, 'double', '#PayPaymentError')" onchange="SendPayment(this, 'double', '#PayPaymentError')" id="PayPayment" name="PayPayment" required>
                                    </div>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-group label-static">
                                        <label class="control-label">Change</label>
                                        <input type="text" class="form-control" id="PayChange" name="PayChange">
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
                                    <button type="button" class="btn btn-success pull-left push-left" onclick="#"><i class="material-icons">done</i>Print Invoice</button>
                                    <button type="submit" class="btn btn-success pull-right push-right" onclick="#"><i class="material-icons">done</i>Continue</button>
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