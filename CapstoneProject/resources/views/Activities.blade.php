@extends('layout')

@section('WebpageTitle')
    <title>Activities</title>
@endsection

@section('scripts')

    <script src="/js/Activities.js" type="text/javascript"></script>
    <script src="/js/input-validator.js" type="text/javascript"></script>

@endsection

@section('content')
<h5 id="TitlePage">Activities</h5>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#AvailableActivities" data-toggle="tab">
                                    <i class="material-icons">local_activity</i>
                                    Available Activities
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#AvailedActivities" data-toggle="tab">
                                    <i class="material-icons">beach_access</i>
                                    Availed Activities
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#PackagedActivities" data-toggle="tab">
                                    <i class="material-icons">pages</i>
                                    Packaged Activities
                                <div class="ripple-container"></div></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="AvailableActivities">

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search Activities</label>
                                    <input type="text" class="form-control" id="SearchBar" onkeyup="SearchTable('tblAvailableActivities', '1')">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table" id="tblAvailableActivities">
                                    <thead class="text-primary">
                                        <th onclick="sortTable(0, 'tblAvailableActivities', 'string')">ID</th>
                                        <th onclick="sortTable(1, 'tblAvailableActivities', 'string')">Name</th>
                                        <th onclick="sortTable(2, 'tblAvailableActivities', 'double')">Rate</th>
                                        <th onclick="sortTable(3, 'tblAvailableActivities', 'string')">Is boat needed?</th>
                                        <th onclick="sortTable(4, 'tblAvailableActivities', 'string')">Description</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($Activities as $Activity)
                                        <tr onclick="HighlightRow(this)">
                                            <td>{{$Activity -> strBeachActivityID}}</td>
                                            <td>{{$Activity -> strBeachAName}}</td>
                                            <td>{{$Activity -> dblBeachARate}}</td>
                                            <td>{{$Activity -> intBeachABoat}}</td>
                                            <td>{{$Activity -> strBeachADescription}}</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Avail Activity" class="btn btn-success btn-simple btn-xs" onclick="ShowModalAvailActivity()">
                                                    <i class="material-icons">playlist_add_check</i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>                            
                    </div>

                    <div class="tab-pane" id="AvailedActivities">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search</label>
                                    <input type="text" class="form-control" >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Activity</th>
                                        <th>Availed by</th>
                                        <th>Boat Used</th>
                                        <th>Time Availed</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Availed by</td>
                                            <td>Boat Used</td>
                                            <td>Time Availed</td>
                                            <td>Status</td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Availed by</td>
                                            <td>Boat Used</td>
                                            <td>Time Availed</td>
                                            <td>Status</td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Availed by</td>
                                            <td>Boat Used</td>
                                            <td>Time Availed</td>
                                            <td>Status</td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Availed by</td>
                                            <td>Boat Used</td>
                                            <td>Time Availed</td>
                                            <td>Status</td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Availed by</td>
                                            <td>Boat Used</td>
                                            <td>Time Availed</td>
                                            <td>Status</td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Availed by</td>
                                            <td>Boat Used</td>
                                            <td>Time Availed</td>
                                            <td>Status</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-xs-12">

                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalActivityDone()"><i class="material-icons">done</i> Done</button>
                            </div> 
                        </div>  
                    </div>

                    <div class="tab-pane" id="PackagedActivities">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Search</label>
                                    <input type="text" class="form-control" >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive scrollable-table" id="style-1">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Activity</th>
                                        <th>Customer</th>
                                        <th>Quantity included</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>Customer</td>
                                            <td>Quantity included</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-xs-12">
                                <button type="button" class="btn btn-success pull-right" onclick="ShowModalAvailPackagedActivity()"><i class="material-icons">done</i> Avail</button>
                            </div> 
                        </div>  
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modals')
<div id="DivModalAvailActivity" class="modal">
    <div class="Modal-content" style="max-width: 500px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">rowing</i>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <p class="category"></p>
                                <h3 class="title">Avail Activity<span class="close" onclick="HideModalAvailActivity()">X</span></h3>
                            </div>
                            <form>
                                {{ csrf_field() }}
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="form-group label-static">
                                            <label class="control-label">Activity to avail</label>
                                            <input type="text" class="form-control" id="AvailActivityName" name="AvailActivityName" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                     <p style="font-family: 'Roboto'">Rented By:</p>
                                        <input list="GuestsList" class="inputlist" id="AvailActivityName" name="AvailActivityName">
                                        <datalist id="GuestsList">
                                          @foreach($Guests as $Guest)
                                            <option id="{{$Guest -> strReservationID}}">{{$Guest -> Name}}</option>
                                          @endforeach
                                        </datalist> 
                                    </div>
                                </div>
                                <div class="DivLandActivity">
                                   <div class = "row">
                                        <div class="col-md-12">
                                            <div class="form-group label-static">
                                                <label class="control-label">Quantity</label>
                                                <input type="text" class="form-control" id="AvailLandQuantity" name="AvailLandQuantity" value="0" required>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="DivWaterActivity">
                                    <div class = "row">
                                        <div class="col-md-6">
                                            <div class="form-group label-static">
                                                <label class="control-label">No. of guests to avail</label>
                                                <input type="text" class="form-control" id="AvailGuestQuantity" name="AvailGuestQuantity" value="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-static">
                                                <label class="control-label">No. of guests to avail</label>
                                                <input type="text" class="form-control" id="AvailGuestQuantity" name="AvailGuestQuantity" value="0" required>
                                            </div>
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
                                    <div class="col-xs-6">
                                        <button type="button" class="btn btn-success pull-left" onclick="#"><i class="material-icons">done</i> Pay now</button>
                                    </div> 
                                    <div class="col-xs-6">
                                        <button type="submit" class="btn btn-success pull-right" onclick="#"><i class="material-icons">done</i> Pay at check out</button>
                                    </div> 
                                </div>
                                
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalActivityDone" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">done</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title">Activity Done<span class="close" onclick="HideModalActivityDone()">X</span></h3>

                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
    
<div id="DivModalAvailPackagedActivity" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">

                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">rowing</i>
                        </div>
                        <div class="card-content">
                            <p class="category"></p>
                            <h3 class="title">Activity Done<span class="close" onclick="HideModalAvailPackagedActivity()">X</span></h3>

                        </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection