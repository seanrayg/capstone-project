@extends('layout')

@section('WebpageTitle')
    <title>Checkout</title>
@endsection

@section('scripts')
    <script src="/js/Checkout.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>
@endsection

@section('content')
<h5 id="TitlePage">Checkout</h5>

<div class="row">
    <div class="col-lg-5">
        <div class="card card-stats">  
            <div class="card-header" data-background-color="blue">
                <i class="material-icons">perm_identity</i>
            </div>
            <div class="card-content">
                <div class="row">
                    <p class="category"></p>
                    <h4 class="title">Customer</h4>
                    @foreach($ReservationInfo as $Info)
                        <h5 class="descriptionText text-info">{{$Info->Name}}</h5>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-stats">  
            <div class="card-header" data-background-color="green">
                <i class="material-icons">payment</i>
            </div>
            <div class="card-content">
                <div class="row">
                    <p class="category"></p>
                    <h4 class="title">Bill Summary</h4>
                    <br><br><br>
                    <div class="col-md-10">
                        <h4 class="title text-success">Initial Bill Summary</h4><br>
                        @foreach($ReservationInfo as $Info)
                            <p class="paragraphText text-success">Check in date:</p> <p class="paragraphText">{{Carbon\Carbon::parse($Info->dtmResDArrival)->format('M j, Y')}}</p><br>
                            <p class="paragraphText text-success">Check out date:</p> <p class="paragraphText">{{Carbon\Carbon::parse($Info->dtmResDDeparture)->format('M j, Y')}}</p><br>
                            <p class="paragraphText text-success">Total Days of Stay:</p> <p class="paragraphText">{{$DaysOfStay}}</p><br>
                            @if(sizeof($PackageInfo) > 0)
                                @foreach($PackageInfo as $PInfo)
                                    <p class="paragraphText text-success">Package Availed:</p> <p class="paragraphText">{{$PInfo->strPackageName}}</p><br>
                                @endforeach
                            @endif
                        @endforeach
                        <p class="paragraphText text-success">Initial Bill:</p> <p class="paragraphText">{{$InitialBill}}</p><br>
                        <p class="paragraphText text-success">Downpayment:</p> <p class="paragraphText">{{$DownPayment}}</p><br>
                        <p class="paragraphText text-success">Initial Payment:</p> <p class="paragraphText">{{$InitialPayment}}</p><br>
                        
                        <strong><h5 class="paragraphText text-success">Total Remaining Bill:</h5> <h5 class="paragraphText">{{$Payment}}</h5></strong><br>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    @if(sizeof($RoomInfo) > 0)
                        <div class="col-lg-6" style="min-height:200px">
                            <h4 class="title text-success">Reserved Rooms</h4><br>
                            <table class="table table-responsive">
                                <thead class="text-success">
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Rate Per Day</th>
                                </thead>
                                <tbody class="text-center">
                                    @foreach($RoomInfo as $Info)
                                        <tr>
                                            <td>{{$Info->strRoomType}}</td>
                                            <td>{{$Info->strRoomName}}</td>
                                            <td>{{$Info->dblRoomRate}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if(sizeof($ItemInfo) > 0)
                    <div class="col-lg-6" style="min-height:200px">
                        <h4 class="title text-success">Rented Items</h4><br>
                        <table class="table table-responsive">
                            <thead class="text-success">
                                <th class="text-center">Item</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Rate per hour</th>
                                <th class="text-center">Hour(s) used</th>
                            </thead>
                            <tbody class="text-center">
                                @foreach($ItemInfo as $Info)
                                    <tr>
                                        <td>{{$Info->strItemName}}</td>
                                        <td>{{$Info->intRentedIQuantity}}</td>
                                        <td>{{$Info->dblItemRate}}</td>
                                        <td>{{$Info->intRentedIDuration}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(sizeof($ActivityInfo) > 0)
                    <div class="col-md-6" style="min-height:200px">
                        <h4 class="title text-success">Availed Activities</h4><br>
                        <table class="table table-responsive">
                            <thead class="text-success">
                                <th class="text-center">Activity</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Rate</th>
                            </thead>
                            <tbody class="text-center">
                                @foreach($ActivityInfo as $Info)
                                    <tr>
                                        <td>{{$Info->strBeachAName}}</td>
                                        <td>{{$Info->intAvailBAQuantity}}</td>
                                        <td>{{$Info->dblBeachARate}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(sizeof($FeeInfo) > 0)
                    <div class="col-md-6" style="min-height:200px">
                        <h4 class="title text-success">Fees</h4><br>
                        <table class="table table-responsive">
                            <thead class="text-success">
                                <th class="text-center">Fee</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Rate</th>
                            </thead>
                            <tbody class="text-center">
                                @foreach($FeeInfo as $Info)
                                    <tr>
                                        <td>{{$Info->strFeeName}}</td>
                                        <td>{{$Info->intResFQuantity}}</td>
                                        <td>{{$Info->dblFeeAmount}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(sizeof($MiscellaneousInfo) > 0)
                    <div class="col-md-6" style="min-height:200px">
                        <h4 class="title text-success">Miscellaneous</h4><br>
                        <table class="table table-responsive">
                            <thead class="text-success">
                                <th class="text-center">Title</th>
                                <th class="text-center">Remarks</th>
                                <th class="text-center">Amount</th>
                            </thead>
                            <tbody class="text-center">
                                @foreach($MiscellaneousInfo as $Info)
                                    <tr>
                                        <td>{{$Info->strPaymentType}}</td>
                                        <td>{{$Info->strPaymentRemarks}}</td>
                                        <td>{{$Info->dblPayAmount}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(sizeof($AdditionalRooms) > 0)
                    <div class="col-md-6" style="min-height:200px">
                        <h4 class="title text-success">Additional Rooms</h4><br>
                        <table class="table table-responsive">
                            <thead class="text-success">
                                <th class="text-center">Type</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Payment Needed</th>
                            </thead>
                            <tbody class="text-center">
                                @foreach($AdditionalRooms as $Info)
                                    <tr>
                                        <td>{{$Info->strRoomType}}</td>
                                        <td>{{$Info->strRoomName}}</td>
                                        <td>{{$Info->dblRoomRate}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(sizeof($UpgradeRooms) > 0)
                    <div class="col-md-6" style="min-height:200px">
                        <h4 class="title text-success">Upgrade Rooms</h4><br>
                        <table class="table table-responsive">
                            <thead class="text-success">
                                <th class="text-center">Room</th>
                                <th class="text-center">Amount</th>
                            </thead>
                            <tbody class="text-center">
                                @foreach($UpgradeRooms as $Info)
                                    <tr>
                                        <td>{{$Info->strPaymentRemarks}}</td>
                                        <td>{{$Info->dblPayAmount}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(sizeof($ExtendStay) > 0)
                    <div class="col-md-6" style="min-height:200px">
                        <h4 class="title text-success">Extend Stay</h4><br>
                        <table class="table table-responsive">
                            <thead class="text-success">
                                <th class="text-center">Days Extended</th>
                                <th class="text-center">Amount</th>
                            </thead>
                            <tbody class="text-center">
                                @foreach($ExtendStay as $Info)
                                    <tr>
                                        <td>{{$Info->strPaymentRemarks}}</td>
                                        <td>{{$Info->dblPayAmount}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div><br>
                <div class="row">
                    <h4 class="title text-success">Grand Total</h4><br>
                    @if($TotalPenalties != 0)
                        <p class="paragraphText text-success">Total Miscellaneous Fee:</p> <p class="paragraphText">{{$TotalPenalties}}</p><br>
                    @endif
                    @if($TotalFee != 0)
                        <p class="paragraphText text-success">Total Fees:</p> <p class="paragraphText">{{$TotalFee}}</p><br>
                    @endif
                    @if($TotalActivity != 0)
                        <p class="paragraphText text-success">Total Activities:</p> <p class="paragraphText">{{$TotalActivity}}</p><br>
                    @endif
                    @if($TotalItem != 0)
                        <p class="paragraphText text-success">Total Items:</p> <p class="paragraphText">{{$TotalItem}}</p><br>
                    @endif
                    @if($TotalRoom != 0)
                        <p class="paragraphText text-success">Total Rooms:</p> <p class="paragraphText">{{$TotalRoom}}</p><br>
                    @endif
                    @if($AdditionalRoomAmount != 0)
                        <p class="paragraphText text-success">Total Additional Rooms:</p> <p class="paragraphText">{{$AdditionalRoomAmount}}</p><br>
                    @endif
                    @if($UpgradeRoomAmount != 0)
                        <p class="paragraphText text-success">Total Upgrade Rooms:</p> <p class="paragraphText">{{$UpgradeRoomAmount}}</p><br>
                    @endif
                    @if($ExtendStayAmount != 0)
                        <p class="paragraphText text-success">Total Extend Days:</p> <p class="paragraphText">{{$ExtendStayAmount}}</p><br>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@section('modals')

@endsection