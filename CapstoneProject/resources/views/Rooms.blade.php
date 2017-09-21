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
                                <table class="table" id="tblAvailableRooms">
                                    <thead class="text-primary">
                                        <th class="text-center" onclick="sortTable(0, 'tblAvailableRooms', 'string')">Accomodation</th>
                                        <th class="text-center" onclick="sortTable(1, 'tblAvailableRooms', 'string')">Room/Cottage Type</th>
                                        <th class="text-center" onclick="sortTable(2, 'tblAvailableRooms', 'string')">Name</th>
                                        <th class="text-center" onclick="sortTable(3, 'tblAvailableRooms', 'int')">Capacity</th>
                                        <th class="text-center" onclick="sortTable(4, 'tblAvailableRooms', 'double')">Rate</th>
                                        <th class="text-center" onclick="sortTable(5, 'tblAvailableRooms', 'string')">Availability</th>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($RoomsAvailable as $Rooms)
                                            <tr>
                                                <td>{{$Rooms->intRoomTCategory}}</td>
                                                <td>{{$Rooms->strRoomType}}</td>
                                                <td>{{$Rooms->strRoomName}}</td>
                                                <td>{{$Rooms->intRoomTCapacity}}</td>
                                                <td>{{$Rooms->dblRoomRate}}</td>
                                                <td>{{$Rooms->Availability}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                                        <th onclick="sortTable(1, 'tblOccupiedRooms', 'string')" class="text-center">Room Type</th>
                                        <th onclick="sortTable(2, 'tblOccupiedRooms', 'string')" class="text-center">Room Name</th>
                                        <th onclick="sortTable(3, 'tblOccupiedRooms', 'string')" class="text-center">Guest</th>
                                        <th onclick="sortTable(4, 'tblOccupiedRooms', 'string')" class="text-center">Guest's Contact #</th>
                                        <th onclick="sortTable(5, 'tblOccupiedRooms', 'string')" class="text-center">Check In Date</th>
                                        <th onclick="sortTable(6, 'tblOccupiedRooms', 'string')" class="text-center">Check Out Date</th>
                                        <th style="display:none">Check In Date 2</th>
                                        <th style="display:none">Check Out Date 2</th>
                                        <th class="text-center">Action</th>
                                    </thead>
                                    <tbody class="text-center">
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
                                                    <button type="button" rel="tooltip" title="Transfer Room" class="btn btn-success btn-simple btn-xs" onclick="TransferRoom('{{$Detail->strReservationID}}')">
                                                        <i class="material-icons">compare_arrows</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Upgrade Room" class="btn btn-primary btn-simple btn-xs" onclick="UpgradeRoom('{{$Detail->strReservationID}}', '{{$Detail->strRoomType}}', '{{$Detail->strRoomName}}')">
                                                        <i class="material-icons">file_upload</i>
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