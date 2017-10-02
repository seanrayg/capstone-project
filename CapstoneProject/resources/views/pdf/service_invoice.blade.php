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
                <th style="width: 25%">Rate</th>
                <th style="width: 15%">Remaining Days</th>
                <th style="width: 15%">Amount</th>
            </tr>
        @elseif($InvoiceType == 'Fees')
            <tr>
                <th style="width: 45%">Description</th>
                <th style="width: 25%">Price</th>
                <th style="width: 15%">Quantity</th>
                <th style="width: 15%">Amount</th>
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
        @endif

        @for($i = $TableRows; $i <= 5; $i++)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endfor
    </table>

    <label class="total-amount">{{ $total }}</label>
    <label class="total">TOTAL Due:</label>

    <div class="footer">
        <p class="greetings">Thankyou for your business</p>
    </div>
</body>
</html>
