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

    <?php
        if($name == 'Accomodations') {
            echo "
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
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strRoomTypeID</td>
                        <td>$query->strRoomType</td>
                        <td>$query->intRoomTCategory</td>
                        <td>$query->intRoomTCapacity</td>
                        <td>$query->dblRoomRate</td>
                        <td>$query->intRoomTNoOfBeds</td>
                        <td>$query->intRoomTNoOfBathrooms</td>
                        <td>$query->intRoomTAirconditioned</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Beach Activities") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Is Boat Needed?</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strBeachActivityID</td>
                        <td>$query->strBeachAName</td>
                        <td>$query->dblBeachARate</td>
                        <td>$query->intBeachABoat</td>
                        <td>$query->strBeachAStatus</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Boats") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Capacity</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strBoatID</td>
                        <td>$query->strBoatName</td>
                        <td>$query->dblBoatRate</td>
                        <td>$query->intBoatCapacity</td>
                        <td>$query->strBoatDescription</td>
                        <td>$query->strBoatStatus</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Cottages Only") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strRoomID</td>
                        <td>$query->strRoomType</td>
                        <td>$query->strRoomName</td>
                        <td>$query->strRoomStatus</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Cottage Types Only") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Amenity Type</th>
                    <th>Capacity</th>
                    <th>Rate</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strRoomTypeID</td>
                        <td>$query->strRoomType</td>
                        <td>$query->intRoomTCategory</td>
                        <td>$query->intRoomTCapacity</td>
                        <td>$query->dblRoomRate</td>
                        <td>$query->intRoomTDeleted</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Customers") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Birthday</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strCustomerID</td>
                        <td>$query->strCustLastName</td>
                        <td>$query->strCustFirstName</td>
                        <td>$query->strCustAddress</td>
                        <td>$query->strCustContact</td>
                        <td>$query->strCustEmail</td>
                        <td>$query->strCustGender</td>
                        <td>$query->dtmCustBirthday</td>
                        <td>$query->intCustStatus</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Fees") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strFeeID</td>
                        <td>$query->strFeeName</td>
                        <td>$query->strFeeStatus</td>
                        <td>$query->dblFeeAmount</td>
                        <td>$query->strFeeDescription</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Rental Items") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strItemID</td>
                        <td>$query->strItemName</td>
                        <td>$query->intItemQuantity</td>
                        <td>$query->dblItemRate</td>
                        <td>$query->strItemDescription</td>
                        <td>$query->intItemDeleted</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Rooms & Cottages") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Accomodation Type</th>
                    <th>Room/Cottage Type</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strRoomID</td>
                        <td>$query->strRoomType</td>
                        <td>$query->intRoomTCategory</td>
                        <td>$query->strRoomName</td>
                        <td>$query->strRoomStatus</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Rooms Only") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strRoomID</td>
                        <td>$query->strRoomType</td>
                        <td>$query->strRoomName</td>
                        <td>$query->strRoomStatus</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Room Types Only") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Amenity Type</th>
                    <th>Capacity</th>
                    <th>Rate</th>
                    <th>No. of Beds</th>
                    <th>No. of Bathrooms</th>
                    <th>Airconditioned</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strRoomTypeID</td>
                        <td>$query->strRoomType</td>
                        <td>$query->intRoomTCategory</td>
                        <td>$query->intRoomTCapacity</td>
                        <td>$query->dblRoomRate</td>
                        <td>$query->intRoomTNoOfBeds</td>
                        <td>$query->intRoomTNoOfBathrooms</td>
                        <td>$query->intRoomTAirconditioned</td>
                        <td>$query->intRoomTDeleted</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Inoperational Dates") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Description</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strDateID</td>
                        <td>$query->strDateTitle</td>
                        <td>$query->dteStartDate</td>
                        <td>$query->dteEndDate</td>
                        <td>$query->intDateStatus</td>
                        <td>$query->strDateDescription</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Packages") {
            echo "
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Duration</th>
                    <th>Pax</th>
                    <th>Transportation Fee</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->strPackageID</td>
                        <td>$query->strPackageName</td>
                        <td>$query->strPackageStatus</td>
                        <td>$query->intPackageDuration</td>
                        <td>$query->intPackagePax</td>
                        <td>$query->intBoatFee</td>
                        <td>$query->strPackageDescription</td>
                        <td>$query->dblPackagePrice</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }else if($name == "Reservations") {
            echo "
            <table>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                </tr>";
                foreach ($queries as $query) {
                    echo "
                    <tr>
                        <td>$query->Name</td>
                        <td>$query->strCustAddress</td>
                        <td>$query->strCustContact</td>
                        <td>$query->strCustEmail</td>
                        <td>$query->dtmResDArrival</td>
                        <td>$query->dtmResDDeparture</td>
                        <td>$query->intResDStatus</td>
                    </tr>
                    ";
                }
            echo "
            </table>
            ";
        }
    ?>
</body>
</html>
