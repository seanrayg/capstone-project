<!DOCTYPE html>
<html class="service">
<head>
    <title>
        <title>Invoice</title>

        <link rel="stylesheet" type="text/css" href="css/service_invoice.css">
    </title>
</head>
<body>
    <div class="header">
        <div>
            <p class="resort">
                Il Sogno Beach Resort<br>
                Nagkaan Locloc, Bauan, Batangas<br>
                OLIVIA R. VILLANUEVA - Prop.
            </p>
        </div>
    </div>

    <div>
        <div class="column-left">
            <div style="padding-left: 20px;">
                <label class="parent">Billed To</label><br>
                <label id="CustomerName">
                    {{ $CustomerName }} <br>
                    {{ $CustomerAddress }}
                </label>
            </div>
        </div>
        <div class="column-right">
            <label class="parent">Invoice Number</label><br>
            <label id="CustomerName">{{ $InvoiceNumber }}</label><br>
            <label class="parent">Date Of Issue</label><br>
            <label id="CustomerName">{{ $date }}</label>
        </div>
    </div>

    <br>
    <br>
    <br>
    <br>

    <table>
        @if($InvoiceType == 'BoatRental')
            <tr>
                <th style="width: 45%">Description</th>
                <th style="width: 25%">Rate / 2 Hours</th>
                <th style="width: 15%">Hours</th>
                <th style="width: 15%">Amount</th>
            </tr>
        @elseif($InvoiceType == 'UpgradeRoom')
            <tr>
                <th style="width: 45%">Description</th>
                <th style="width: 15%">Rate</th>
                <th style="width: 28%">Remaining Days</th>
                <th style="width: 15%">Amount</th>
            </tr>
        @elseif($InvoiceType == 'Fees' || $InvoiceType == 'Activities')
            <tr>
                <th style="width: 45%">Description</th>
                <th style="width: 25%">Price</th>
                <th style="width: 15%">Quantity</th>
                <th style="width: 15%">Amount</th>
            </tr>
        @elseif($InvoiceType == 'ExtendStay')
            <tr>
                <th style="width: 40%">Room Name</th>
                <th style="width: 15%">Rate</th>
                <th style="width: 15%">Quantity</th>
                <th style="width: 20%">Days of Extend</th>
                <th style="width: 15%">Amount</th>
            </tr>
        @elseif($InvoiceType == 'AddRoom')
            <tr>
                <th style="width: 40%">Room Name</th>
                <th style="width: 15%">Rate</th>
                <th style="width: 15%">Quantity</th>
                <th style="width: 20%">Days</th>
                <th style="width: 15%">Amount</th>
            </tr>
        @elseif($InvoiceType == 'ItemRental' || $InvoiceType == 'ItemRentalExtend')
            <tr>
                <th style="width: 40%">Descriptions</th>
                <th style="width: 15%">Rate</th>
                <th style="width: 15%">Quantity</th>
                <th style="width: 15%">Hours</th>
                <th style="width: 15%">Amount</th>
            </tr>
        @elseif($InvoiceType == 'ItemRentalExcess')
            <tr>
                <th style="width: 45%">Description</th>
                <th style="width: 25%">Quantity</th>
                <th style="width: 15%">Penalty</th>
                <th style="width: 15%">Amount</th>
            </tr>
        @elseif($InvoiceType == 'CheckIn')
            <tr>
                <th style="width: 50%">Description</th>
                <th style="width: 25%">Amount</th>
            </tr>
        @endif

        @if($InvoiceType == 'BoatRental')
            @foreach($RentalBoats as $RentalBoat)
                <tr>
                    <td>{{ $RentalBoat->name }}</td>
                    <td style="text-align: center;">{{ $RentalBoat->price }}</td>
                    <td style="text-align: center;">{{ $RentalBoat->quantity }}</td>
                    <td style="text-align: right;">{{ $RentalBoat->amount }}</td>
                </tr>
            @endforeach
        @elseif($InvoiceType == 'UpgradeRoom')
            @foreach($UpgradeRooms as $UpgradeRoom)
                <tr>
                    <td>{{ $UpgradeRoom->name }}</td>
                    <td style="text-align: center;">{{ $UpgradeRoom->price }}</td>
                    <td style="text-align: center;">{{ $UpgradeRoom->quantity }}</td>
                    <td style="text-align: right;">{{ $UpgradeRoom->amount }}</td>
                </tr>
            @endforeach
        @elseif($InvoiceType == 'Fees')
            @foreach($Fees as $Fee)
                <tr>
                    <td>{{ $Fee->name }}</td>
                    <td style="text-align: center;">{{ $Fee->price }}</td>
                    <td style="text-align: center;">{{ $Fee->quantity }}</td>
                    <td style="text-align: right;">{{ $Fee->amount }}</td>
                </tr>
            @endforeach
        @elseif($InvoiceType == 'ExtendStay')
            @foreach($Rooms as $room)
                <tr>
                    <td>{{ $room->strRoomType }}</td>
                    <td style="text-align: center;">{{ $room->dblRoomRate }}</td>
                    <td style="text-align: center;">{{ $room->quantity }}</td>
                    <td style="text-align: center;">{{ $days }}</td>
                    <td style="text-align: right;">{{ $room->amount }}</td>
                </tr>
            @endforeach
        @elseif($InvoiceType == 'ItemRental' || $InvoiceType == 'ItemRentalExtend')
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td style="text-align: center;">{{ $item->price }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: center;">{{ $item->hours }}</td>
                    <td style="text-align: right;">{{ $item->amount }}</td>
                </tr>
            @endforeach
        @elseif($InvoiceType == 'ItemRentalExcess')
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: center;">{{ $item->penalty }}</td>
                    <td style="text-align: right;">{{ $item->amount }}</td>
                </tr>
            @endforeach
        @elseif($InvoiceType == 'AddRoom')
            @foreach($rooms as $room)
                <tr>
                    <td>{{ $room->name }}</td>
                    <td style="text-align: center;">{{ $room->price }}</td>
                    <td style="text-align: center;">{{ $room->quantity }}</td>
                    <td style="text-align: center;">{{ $room->days }}</td>
                    <td style="text-align: right;">{{ $room->amount }}</td>
                </tr>
            @endforeach
        @elseif($InvoiceType == 'Activities')
            @foreach($activity as $a)
                <tr>
                    <td>{{ $a->name }}</td>
                    <td style="text-align: center;">{{ $a->price }}</td>
                    <td style="text-align: center;">{{ $a->quantity }}</td>
                    <td style="text-align: right;">{{ $a->amount }}</td>
                </tr>
            @endforeach
        @elseif($InvoiceType == 'CheckIn')
            @foreach($bill as $b)
                <tr>
                    <td>{{ $b->name }}</td>
                    <td style="text-align: right;">{{ $b->price }}</td>
                </tr>
            @endforeach
        @endif

        @if($InvoiceType == 'CheckIn')
            @for($i = $TableRows; $i <= 5; $i++)
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        @else
            @for($i = $TableRows; $i <= 5; $i++)
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        @endif
    </table>

    <label class="total-amount">{{ $total }}</label>
    <label class="total">TOTAL Due:</label>

    <br style="clear: both;">

    <label class="total-amount">{{ $payment }}</label>
    <label class="payment">Amount Tendered:</label>

    <hr style="margin-left: 200px; margin-right: 20px; background-color: black;">

    <label class="total-amount">{{ $payment - $total }}</label>
    <label class="change">Change:</label>

    <div class="footer">
        <p class="greetings">Thankyou for your business</p>
    </div>
</body>
</html>
