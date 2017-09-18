<!DOCTYPE html>
<html>
<head>
    <title>Query Report</title>

    <link rel="stylesheet" type="text/css" href="css/reports.css">
</head>
<body>
    <div class="header">
        <div class="column-left">
            <p class="title">Query Report</p>
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
                <label id="CustomerName">List of {{ $name }}</label>
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
    <hr style="clear: left;">

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Amenity Type</th>
            <th>Capacity</th>
            <th>Rate</th>
            <th>Number of Beds</th>
            <th>Number of Bathrooms</th>
            <th>Aircondition</th>
        </tr>
    <tbody>
        @foreach($queries as $query)
            <tr>
                <td>{{ $query->strRoomTypeID }}</td>
                <td>{{ $query->strRoomType }}</td>
                <td>{{ $query->intRoomTCategory }}</td>
                <td>{{ $query->intRoomTCapacity }}</td>
                <td>{{ $query->dblRoomRate }}</td>
                <td>{{ $query->intRoomTNoOfBeds }}</td>
                <td>{{ $query->intRoomTNoOfBathrooms }}</td>
                <td>{{ $query->intRoomTAirconditioned }}</td>
            </tr>
        @endforeach
    </tbody>
    </table>
</body>
</html>
