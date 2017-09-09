@extends('layout')

@section('WebpageTitle')
    <title>Rooms</title>
@endsection

@section('scripts')
    <script src="/js/Rooms.js" type="text/javascript"></script>
@endsection


@section('content')

<!-- Add success -->
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


<h5 id="TitlePage">Rooms</h5>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#AvailableRooms" data-toggle="tab">
                                    <i class="material-icons">beenhere</i>
                                    Available Rooms
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#OccupiedRooms" data-toggle="tab">
                                    <i class="material-icons">local_hotel</i>
                                    Occupied Rooms
                                <div class="ripple-container"></div></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="AvailableRooms">

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Rooms</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Room Type</th>
                                        <th>Room</th>
                                        <th>Capacity</th>
                                        <th>Rate</th>
                                        <th>Description</th>
                                        <th>Available Until</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Room Type</td>
                                            <td>Room</td>
                                            <td>Capacity</td>
                                            <td>Rate</td>
                                            <td>Description</td>
                                            <td>Available Until</td>
                                        </tr>
                                        <tr>
                                            <td>Room Type</td>
                                            <td>Room</td>
                                            <td>Capacity</td>
                                            <td>Rate</td>
                                            <td>Description</td>
                                            <td>Available Until</td>
                                        </tr>
                                        <tr>
                                            <td>Room Type</td>
                                            <td>Room</td>
                                            <td>Capacity</td>
                                            <td>Rate</td>
                                            <td>Description</td>
                                            <td>Available Until</td>
                                        </tr>
                                        <tr>
                                            <td>Room Type</td>
                                            <td>Room</td>
                                            <td>Capacity</td>
                                            <td>Rate</td>
                                            <td>Description</td>
                                            <td>Available Until</td>
                                        </tr>
                                        <tr>
                                            <td>Room Type</td>
                                            <td>Room</td>
                                            <td>Capacity</td>
                                            <td>Rate</td>
                                            <td>Description</td>
                                            <td>Available Until</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-warning pull-right" onclick="#"><i class="material-icons">class</i> Book a Reservation</button>
                                <button type="button" class="btn btn-primary pull-right" onclick="#"><i class="material-icons">class</i> Rent for Walk in</button>
                            </div> 
                        </div>                             
                    </div>

                    <div class="tab-pane" id="OccupiedRooms">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Customer</label>
                                    <input type="text" class="form-control" id="SearchBar2" onkeyup="SearchTable2('tblOccupiedRooms', '3')">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="tblOccupiedRooms" onclick="run(event, 'Occupied')">
                                    <thead class="text-primary">
                                        <th style="display:none">Reservation ID</th>
                                        <th onclick="sortTable(1, 'tblOccupiedRooms', 'string')">Room Type</th>
                                        <th onclick="sortTable(2, 'tblOccupiedRooms', 'string')">Room Name</th>
                                        <th onclick="sortTable(3, 'tblOccupiedRooms', 'string')">Guest</th>
                                        <th onclick="sortTable(4, 'tblOccupiedRooms', 'string')">Guest's Contact #</th>
                                        <th onclick="sortTable(5, 'tblOccupiedRooms', 'string')">Check In Date</th>
                                        <th onclick="sortTable(6, 'tblOccupiedRooms', 'string')">Check Out Date</th>
                                        <th style="display:none">Check In Date 2</th>
                                        <th style="display:none">Check Out Date 2</th>
                                        <th class="text-center">Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($RoomDetails as $Detail)
                                            <tr>
                                                <td style="display:none">{{$Detail->strReservationID}}</td>
                                                <td>{{$Detail->strRoomType}}</td>
                                                <td>{{$Detail->strRoomName}}</td>
                                                <td>{{$Detail->Name}}</td>
                                                <td>{{$Detail->strCustContact}}</td>
                                                <td>{{Carbon\Carbon::parse($Detail -> dtmResDArrival)->format('M j, Y')}}</td>
                                                <td>{{Carbon\Carbon::parse($Detail -> dtmResDDeparture)->format('M j, Y')}}</td>
                                                <td style="display:none">{{Carbon\Carbon::parse($Detail -> dtmResDArrival)->format('m/d/Y')}}</td>
                                                <td style="display:none">{{Carbon\Carbon::parse($Detail -> dtmResDDeparture)->format('m/d/Y')}}</td>
                                                <td>
                                                    <button type="button" rel="tooltip" title="Check Out" class="btn btn-info btn-simple btn-xs">
                                                        <i class="material-icons">done_all</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Transfer Room" class="btn btn-success btn-simple btn-xs" onclick="TransferRoom('{{$Detail->strReservationID}}')">
                                                        <i class="material-icons">compare_arrows</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Upgrade Room" class="btn btn-primary btn-simple btn-xs" onclick="UpgradeRoom('{{$Detail->strReservationID}}', '{{$Detail->strRoomType}}', '{{$Detail->strRoomName}}')">
                                                        <i class="material-icons">file_upload</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Extend Stay" class="btn btn-warning btn-simple btn-xs">
                                                        <i class="material-icons">alarm_add</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection