<!DOCTYPE html>
<html>
<head>
    <title>Query Report</title>

    <link rel="stylesheet" type="text/css" href="css/reports.css">
</head>
<body>
    <div class="header">
        <div class="column-left">
            <p class="title">Sales Report</p>
        </div>
        <div class="column-right">
            <p class="resort">
                Il Sogno Beach Resort<br>
                Nagkaan Locloc, Bauan, Batangas<br>
                OLIVIA R. VILLANUEVA - Prop.
            </p>
        </div>
    </div>

    <br>

    <div class="info">
        <div class="column-left">
            <div style="padding-left: 20px;">
                <br><br>
                <label id="CustomerName">{{ $salesreportdate }}</label>
            </div>
        </div>
        <div class="column-right-date">
            <label class="parent">Date Of Issue</label><br>
            <label id="CustomerName">{{ $date }}</label>
        </div>
    </div>

    <br>
    <br>
    <br>
    <br>
    <hr style="clear: both;">

    <label style="margin-left: 680px;">Total Amount: </label>
    <label style="float: right; font-size: 30px; margin-right: 20px;">P {{$total}}</label>

    <br>

    <table>
        @if($mode == 1)
            <tr>
                <th>Category</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
        @endif
        <tbody>
            @if($mode == 1)
                @foreach($sales as $sale)
                    <tr>
                        <td>{{$sale->category}}</td>
                        <td style="text-align: center;">{{$sale->quantity}}</td>
                        <td style="text-align: center;">{{$sale->amount}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    @if($mode == 2)
        @if(sizeof($rooms) != 0)
            <table>
                <tr>
                    <th>Room Type</th>
                    <th>Availed</th>
                    <th>Rate</th>
                    <th>Total Amount</th>
                </tr>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{$room->name}}</td>
                            <td style="text-align: center;">{{$room->quantity}}</td>
                            <td style="text-align: center;">{{$room->rate}}</td>
                            <td style="text-align: center;">{{$room->amount}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if(sizeof($items) != 0)
            <table>
                <tr>
                    <th>Item Name</th>
                    <th>Availed</th>
                    <th>Rate</th>
                    <th>Total Amount</th>
                </tr>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td style="text-align: center;">{{$item->quantity}}</td>
                            <td style="text-align: center;">{{$item->rate}}</td>
                            <td style="text-align: center;">{{$item->amount}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if(sizeof($beachactivities) != 0)
            <table>
                <tr>
                    <th>Beach Activity</th>
                    <th>Availed</th>
                    <th>Rate</th>
                    <th>Total Amount</th>
                </tr>
                <tbody>
                    @foreach($beachactivities as $ba)
                        <tr>
                            <td>{{$ba->name}}</td>
                            <td style="text-align: center;">{{$ba->quantity}}</td>
                            <td style="text-align: center;">{{$ba->rate}}</td>
                            <td style="text-align: center;">{{$ba->amount}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if(sizeof($boats) != 0)
            <table>
                <tr>
                    <th>Boat Name</th>
                    <th>Availed</th>
                    <th>Rate</th>
                    <th>Total Amount</th>
                </tr>
                <tbody>
                    @foreach($boats as $boat)
                        <tr>
                            <td>{{$boat->name}}</td>
                            <td style="text-align: center;">{{$boat->quantity}}</td>
                            <td style="text-align: center;">{{$boat->rate}}</td>
                            <td style="text-align: center;">{{$boat->amount}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

</body>
</html>
