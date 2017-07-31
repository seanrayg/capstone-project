@extends('layout')

@section('WebpageTitle')
    <title>Add Package</title>
@endsection

@section('scripts')

<script src="/js/input-validator.js"></script>
<script src="/js/AddPackage.js"></script>

@endsection

@section('content')

<!-- Duplicate Error -->
@if(Session::has('duplicate_message'))
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="alert alert-danger hide-on-click">
                <div class="container-fluid">
                  <div class="alert-icon">
                    <i class="material-icons">warning</i>
                  </div>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                  </button>
                  {{ Session::get('duplicate_message') }}
                </div>
            </div>
        </div>
    </div>
@endif


<!-- Misc Error -->
@if (count($errors) > 0)
    <div class="row">
            <div class="col-md-5 col-md-offset-7">
                <div class="alert alert-danger hide-on-click">
                    <div class="container-fluid">
                      <div class="alert-icon">
                        <i class="material-icons">warning</i>
                      </div>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                      </button>
                        <ul>
                            Cannot add package because of the following:<br>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
@endif



<div class="row">
    <div class="col-md-3 dropdown">
        <a href="#" class="btn-simple dropdown-toggle" data-toggle="dropdown">
        <h5 id="TitlePage">Package Maintenance</h5>
        <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/Maintenance/Room">Room Maintenance</a></li>
            <li><a href="/Maintenance/RoomType">Room Type Maintenance</a></li>
            <li><a href="/Maintenance/Boat">Boat Maintenance</a></li>
            <li><a href="/Maintenance/Item">Item Maintenance</a></li>
            <li><a href="/Maintenance/Activity">Activity Maintenance</a></li>
            <li><a href="/Maintenance/Operations">Operations Maintenance</a></li>
            <li><a href="/Maintenance/Fee">Fee Maintenance</a></li>
            <li><a href="/Maintenance/Package">Package Maintenance</a></li>
        </ul>
    </div>
</div>



<div class="row">
    <div class="col-md-2">
    </div>

    <div class="col-lg-8">
            <div class="card card-stats">

                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">info</i>
                    </div>
                    <div class="card-content">
                        <p class="category">Please fill out all the fields</p>
                        <h3 class="title">Package Information</h3>
                        <form onsubmit="return SavePackage()" method="post" action="/Maintenance/Package/Add" id="packageForm">
                            {{ csrf_field() }}
                            <input type="hidden" name="includedRooms" id="includedRooms" value="">
                            <input type="hidden" name="includedItems" id="includedItems" value="">
                            <input type="hidden" name="includedActivities" id="includedActivities" value="">
                            <input type="hidden" name="includedFees" id="includedFees" value="">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group label-floating" id="PackageIDError">
                                        <label class="control-label">*Package ID</label>                   
                                        @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                        <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#PackageIDError')" onchange="ValidateInput(this, 'string', '#PackageIDError')" id="PackageID" name="PackageID" value="{{old('PackageID')}}" required>
                                        @else
                                        <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#PackageIDError')" onchange="ValidateInput(this, 'string', '#PackageIDError')" id="PackageID" name="PackageID" value="{{$PackageID}}" required>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group label-floating" id="PackageNameError">
                                        <label class="control-label">*Package Name</label>
                                        <input type="text" class="form-control" onkeyup="ValidateInput(this, 'string', '#PackageNameError')" onchange="ValidateInput(this, 'string', '#PackageNameError')" id="PackageName" name="PackageName" value="{{old('PackageName')}}" required>
                                    </div>
                                </div>
                            </div>                 

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group label-floating" id="PackagePaxError">
                                        <label class="control-label">*Pax</label>
                                        <input type="text" class="form-control" onkeyup="PackagePaxEvent(this, 'int', '#PackagePaxError')" onchange="PackagePaxEvent(this, 'int', '#PackagePaxError')" id="PackagePax" name="PackagePax" value="{{old('PackagePax')}}" required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group label-floating" id="PackageDurationError">
                                        <label class="control-label">*Duration</label>
                                        <input type="text" class="form-control" onkeyup="PackageDurationEvent(this, 'int', '#PackageDurationError')" onkeydown="PressPreventDefault(event)" onkeypress="PressPreventDefault(event)" onblur="PressContinueDefault()" onchange="PackageDurationEvent(this, 'int', '#PackageDurationError')" id="PackageDuration" name="PackageDuration" value="{{old('PackageDuration')}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="checkbox">
                                        <label>
                                            @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                            <?php
                                                if(old('PackageDuration') == "on"){
                                                    echo "<input type='checkbox' name='PackageTransportation' id='PackageTransportation' checked>";
                                                    echo "Is the transportation fee free?";
                                                }  
                                            ?>
                                            @else
                                                <input type="checkbox" name="PackageTransportation" id="PackageTransportation">
                                                Is the transportation fee free?
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Description</label>
                                            <textarea class="form-control" name="PackageDescription" id="PackageDescription" rows="5">{{old('PackageDuration')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="ErrorLabel"></p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success pull-right" onclick="CheckPackageForm()">Continue</button>    
                        
                    </div>

            </div>
        </div>

</div>

<div id="packageTables">
    <div class="row">

        <div class="col-sm-6">
            <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">local_hotel</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category">Package</p>
                                <h5 class="title">Included Rooms</h5>
                            </div>
                        </div>
                        <div class="card-content">
                            <table class="table" id="PacRoomTable" onclick="run(event, 'RoomType')">
                                <thead class="text-success">
                                    <th>Room</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </thead>
                                <tbody>
                                @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                    <?php 
                                        if(Session::has('includedRooms')){
                                            $arrRoomTypeData = explode(",", Session::get('includedRooms'));
                                            $intRoomTypeDataLength = count($arrRoomTypeData);
                                            for($i = 0; $i < $intRoomTypeDataLength; $i++){
                                                $arrTemp = explode("-", $arrRoomTypeData[$i]);                  
                                                echo "<tr>";
                                                echo "<td>".$arrTemp[0]."</td>";
                                                echo "<td>".$arrTemp[1]."</td>";
                                                echo "<td>".$arrTemp[2]."</td>";
                                                echo "</tr>";
                                            }
                                        }
                                    ?>
                                @endif
                                </tbody>
                            </table>
                            <br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="paragraphText text-info">Package Pax:</p> <p class="paragraphText" id="i-PackagePax"></p><br>
                                    <p class="paragraphText text-info">Total Room Capacity:</p> <p class="paragraphText" id="TotalRoomCapacity">0</p><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p id="PaxError" class="ElementError"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger btn-sm pull-right" onclick="RemoveRoomType()">Remove</button>
                                    <button type="button" class="btn btn-success btn-sm pull-right" onclick="ShowModalRoomChoice()">Add</button>
                                </div>
                            </div>
                        </div>

            </div>
        </div>

        <div class="col-sm-6">
            <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">local_offer</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Package</p>
                            <h5 class="title">Included Items</h5>
                        </div>
                        <div class="card-footer">
                            <table class="table" id="PacItemTable" onclick="run(event, 'Item')">
                                <thead class="text-success">
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Duration(hours)</th>
                                    <th>Price</th>
                                </thead>
                                <tbody>
                                @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                    <?php 
                                        if(Session::has('includedItems')){
                                            $arrItemData = explode(",", Session::get('includedItems'));
                                            $intItemDataLength = count($arrItemData);
                                            for($i = 0; $i < $intItemDataLength; $i++){
                                                $arrTemp = explode("-", $arrItemData[$i]);                  
                                                echo "<tr>";
                                                echo "<td>".$arrTemp[0]."</td>";
                                                echo "<td>".$arrTemp[1]."</td>";
                                                echo "<td>".$arrTemp[2]."</td>";
                                                echo "<td>".$arrTemp[3]."</td>";
                                                echo "</tr>";
                                            }
                                        }
                                    ?>
                                @endif
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-danger btn-sm pull-right" onclick="RemoveItem()">Remove</button>
                            <button type="button" class="btn btn-success btn-sm pull-right" onclick="ShowModalItemChoice()">Add</button>
                            <div class="clearfix"></div>
                        </div>

            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-6">
            <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">map</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Package</p>
                            <h5 class="title">Included Activities</h5>
                        </div>
                        <div class="card-footer">
                            <table class="table" id="PacActivityTable" onclick="run(event, 'Activity')">
                                <thead class="text-success">
                                    <th>Activity</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </thead>
                                <tbody>
                                @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                    <?php 
                                        if(Session::has('includedActivities')){
                                            $arrActivityData = explode(",", Session::get('includedActivities'));
                                            $intActivityDataLength = count($arrActivityData);
                                            for($i = 0; $i < $intActivityDataLength; $i++){
                                                $arrTemp = explode("-", $arrActivityData[$i]);                  
                                                echo "<tr>";
                                                echo "<td>".$arrTemp[0]."</td>";
                                                echo "<td>".$arrTemp[1]."</td>";
                                                echo "<td>".$arrTemp[2]."</td>";
                                                echo "</tr>";
                                            }
                                        }
                                    ?>
                                @endif
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-danger btn-sm pull-right" onclick="RemoveActivity()">Remove</button>
                            <button type="button" class="btn btn-success btn-sm pull-right" onclick="ShowModalActivityChoice()">Add</button>
                        </div>

            </div>
        </div>

        <div class="col-sm-6">
            <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">local_atm</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Package</p>
                            <h5 class="title">Included Fees</h5>
                        </div>
                        <div class="card-footer">
                            <table class="table" id="PacFeeTable" onclick="run(event, 'Fee')">
                                <thead class="text-success">
                                    <th>Fee</th>
                                    <th>Cost</th>
                                </thead>
                                <tbody>
                                @if((Session::has('duplicate_message')) || (count($errors) > 0))
                                    <?php 
                                        if(Session::has('includedFees')){
                                            $arrFeeData = explode(",", Session::get('includedFees'));
                                            $intFeeDataLength = count($arrFeeData);
                                            for($i = 0; $i < $intFeeDataLength; $i++){
                                                $arrTemp = explode("-", $arrFeeData[$i]);                  
                                                echo "<tr>";
                                                echo "<td>".$arrTemp[0]."</td>";
                                                echo "<td>".$arrTemp[1]."</td>";
                                                echo "</tr>";
                                            }
                                        }
                                    ?>
                                @endif
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-danger btn-sm pull-right" onclick="RemoveFee()">Remove</button>
                            <button type="button" class="btn btn-success btn-sm pull-right" onclick="ShowModalFeeChoice()">Add</button>
                        </div>

            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header" data-background-color="green">
                    <h4 class="title">Total Amount</h4>
                    <p class="category">Calculated amount based on the included amenities</p>
                </div>
                <div class="card-content">
                    <h2 id="TotalAmount">0</h2>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header" data-background-color="green">
                    <h4 class="title">Package Price</h4>
                </div>
                <div class="card-content">
                    <div class="form-group label-floating" id="PackagePriceError">
                        <label class="control-label">Price</label>
                        <input type="text" class="form-control" onkeyup="ValidateInput(this, 'double', '#PackagePriceError')" onchange="ValidateInput(this, 'double', '#PackagePriceError')" id="PackagePrice" name="PackagePrice" value="{{old('PackagePrice')}}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p id="EmptyRoomError" class="ElementError"></p>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success pull-right">Create Package</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>



@endsection

@section('modals')

<div id="DivModalRoomChoice" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
                    <div class="col-md-12">
                            <div class="card card-stats">

                                    <div class="card-header" data-background-color="green">
                                        <i class="material-icons">add</i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">Package inclusion</p>
                                        <h3 class="title">Choose Room</h3>
                                        <div class = "row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Room Types</label>
                                                    <div class="selectBox">
                                                        <select name="SelectRoomType" id="SelectRoomType" onchange="GetRoomDetails()">
                                                            
                                                        </select>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="tim-typo">
                                                    <p class="paragraphText text-primary">Room Type ID:</p> <p class="paragraphText" id="RoomTypeID"></p><br>
                                                    <p class="paragraphText text-primary">Room Type Name:</p> <p class="paragraphText" id="RoomTypeName"></p><br>
                                                    <p class="paragraphText text-primary">Room Category:</p> <p class="paragraphText" id="RoomCategory"></p><br>
                                                    <p class="paragraphText text-primary">Room Capacity:</p> <p class="paragraphText" id="RoomCapacity"></p><br>
                                                    <p class="paragraphText text-primary">Rate per day:</p> <p class="paragraphText" id="RoomRate"></p><br>
                                                    <p class="paragraphText text-primary">No. of Beds:</p> <p class="paragraphText" id="NoOfBeds"></p><br>
                                                    <p class="paragraphText text-primary">No. of Bathrooms:</p> <p class="paragraphText" id="NoOfBathrooms"></p><br>
                                                    <p class="paragraphText text-primary">Room Aircondition:</p> <p class="paragraphText" id="RoomAircondition"></p><br>
                                                    <p class="paragraphText text-primary">Description:</p> <p class="paragraphText" id="RoomDescription"></p><br>
                                                    <p class="paragraphText text-primary">No. of Rooms Available:</p> <p class="paragraphText" id="RoomsAvailable"></p><br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group label-floating modal-input" id="PacRoomError">
                                                    <label class="control-label">Quantity</label>
                                                    <input type="text" class="form-control" onkeyup="ModalValidateInput(this, 'int', '#PacRoomError')" id="RoomQuantity" name="RoomQuantity">
                                                </div>
                                            </div>        
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="ModalErrorLabel"></p>
                                            </div>
                                        </div>
                                        
                                        
                                        <button type="button" class="btn btn-danger btn-sm pull-right" onclick="HideModalRoomChoice()">Close</button>
                                        <button type="button" class="btn btn-success btn-sm pull-right" onclick="addRoomType()">Choose</button>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

<div id="DivModalItemChoice" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
                    <div class="col-md-12">
                            <div class="card card-stats">

                                    <div class="card-header" data-background-color="green">
                                        <i class="material-icons">add</i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">Package inclusion</p>
                                        <h3 class="title">Choose Item</h3>
                                        <div class = "row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Items</label>
                                                    <div class="selectBox">
                                                        <select name="SelectItem" id="SelectItem" onchange="GetItemDetails()">
                                                            @foreach($Items as $Item)
                                                                <option>{{$Item}}</option>
                                                            @endforeach    
                                                        </select>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="tim-typo">
                                            <p class="paragraphText text-primary">Item ID:</p> <p class="paragraphText" id="ItemID"></p><br>
                                            <p class="paragraphText text-primary">Item Name:</p> <p class="paragraphText" id="ItemName"></p><br>
                                            <p class="paragraphText text-primary">Item Quantity:</p> <p class="paragraphText" id="ItemQuantity"></p><br>
                                            <p class="paragraphText text-primary">Rate per hour:</p> <p class="paragraphText" id="ItemRate"></p><br>
                                            <p class="paragraphText text-primary">Item Desription:</p> <p class="paragraphText" id="ItemDescription"></p><br>
								        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group label-floating modal-input" id="PacItemQuantityError">
                                                    <label class="control-label">Quantity</label>
                                                    <input type="text" class="form-control" onkeyup="ModalValidateInput(this, 'int', '#PacItemQuantityError')" id="pacItemQuantity" name="pacItemQuantity">
                                                </div>
                                            </div>  
                                            <div class="col-sm-6">
                                                <div class="form-group label-floating modal-input" id="PacItemDurationError">
                                                    <label class="control-label">Duration</label>
                                                    <input type="text" class="form-control" onkeyup="ModalValidateInput(this, 'int', '#PacItemDurationError')" id="pacItemDuration" name="pacItemDuration">
                                                </div>
                                            </div>  
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="ModalErrorLabel"></p>
                                            </div>
                                        </div>
                                        
                                        <button type="button" class="btn btn-danger btn-sm pull-right" onclick="HideModalItemChoice()">Close</button>
                                        <button type="button" class="btn btn-success btn-sm pull-right" onclick="addItem()">Choose</button>

                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

<div id="DivModalActivityChoice" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
                    <div class="col-md-12">
                            <div class="card card-stats">

                                    <div class="card-header" data-background-color="green">
                                        <i class="material-icons">add</i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">Package inclusion</p>
                                        <h3 class="title">Choose Activity</h3>
                                        <div class = "row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Activities</label>
                                                    <div class="selectBox">
                                                        <select name="SelectActivity" id="SelectActivity" onchange="GetActivityDetails()">
                                                            @foreach($Activities as $Activity)
                                                                <option>{{$Activity}}</option>
                                                            @endforeach
                                                        </select>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="tim-typo">
                                            <p class="paragraphText text-primary">Activity ID:</p> <p class="paragraphText" id="ActivityID"></p><br>
                                            <p class="paragraphText text-primary">Activity Name:</p> <p class="paragraphText" id="ActivityName"></p><br>
                                            <p class="paragraphText text-primary">Is boat needed?</p> <p class="paragraphText" id="ActivityBoat"></p><br>
                                            <p class="paragraphText text-primary">Activity Rate:</p> <p class="paragraphText" id="ActivityRate"></p><br>
                                            <p class="paragraphText text-primary">Activity Desription:</p> <p class="paragraphText" id="ActivityDescription"></p><br>
								        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group label-floating modal-input" id="PacActivityError">
                                                    <label class="control-label">Quantity</label>
                                                    <input type="text" class="form-control" onkeyup="ModalValidateInput(this, 'int', '#PacActivityError')" id="ActivityQuantity" name="ActivityQuantity">
                                                </div>
                                            </div>        
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="ModalErrorLabel"></p>
                                            </div>
                                        </div>
                                        
                                        <button type="button" class="btn btn-danger btn-sm pull-right" onclick="HideModalActivityChoice()">Close</button>
                                        <button type="button" class="btn btn-success btn-sm pull-right" onclick="addActivity()">Choose</button>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

<div id="DivModalFeeChoice" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
                    <div class="col-md-12">
                            <div class="card card-stats">

                                    <div class="card-header" data-background-color="green">
                                        <i class="material-icons">add</i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">Package inclusion</p>
                                        <h3 class="title">Choose Fee</h3>
                                        <div class = "row">
                                            <div class="col-md-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Fees</label>
                                                    <div class="selectBox">
                                                        <select name="SelectFee" id="SelectFee" onchange="GetFeeDetails()">
                                                            @foreach($Fees as $Fee)
                                                                <option>{{$Fee}}</option>
                                                            @endforeach
                                                        </select>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="tim-typo">
                                            <p class="paragraphText text-primary">Fee ID:</p> <p class="paragraphText" id="FeeID"></p><br>
                                            <p class="paragraphText text-primary">Fee Name:</p> <p class="paragraphText" id="FeeName"></p><br>
                                            <p class="paragraphText text-primary">Fee Amount:</p> <p class="paragraphText" id="FeeAmount"></p><br>
                                            <p class="paragraphText text-primary">Fee Desription:</p> <p class="paragraphText" id="FeeDescription"></p><br>
								        </div>
                                        
                                        <button type="button" class="btn btn-danger btn-sm pull-right" onclick="HideModalFeeChoice()">Close</button>
                                        <button type="button" class="btn btn-success btn-sm pull-right" onclick="addFee()">Choose</button>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

<div id="DivModalDuration" class="modal">
    <div class="Modal-contentChoice">
        <div class="row">
                    <div class="col-md-12">
                            <div class="card card-stats">
                                    <div class="card-content">
                                        <div class = "row">
                                            <div class="col-md-12">
                                                <p class="paragraphText">Changing the package duration will reset all the room inclusion of the package. Would you like to continue?</p>
                                            </div>
                                        </div>
                                        
                                        <button type="button" class="btn btn-danger btn-sm pull-right" onclick="HideModalDuration()" id="CancelButton">Cancel</button>
                                        <button type="button" class="btn btn-success btn-sm pull-right" id="ContinueButton">Continue</button>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

@endsection