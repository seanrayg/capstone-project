@extends('layout')

@section('WebpageTitle')
    <title>Dashboard</title>
@endsection

@section('scripts')
    <script src="/js/Dashboard.js" type="text/javascript"></script>
@endsection

@section('content')
<h5 id="TitlePage">Dashboard</h5>

<div class="row">
    
    <div class="col-lg-3 col-md-6 col-sm-6 cursor-pointer" onclick="ShowModalArrivingGuests()">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="material-icons">supervisor_account</i>
            </div>
            <div class="card-content">
                <p class="category">Number of Arriving Guests</p>
                <h3 class="title">4</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6 cursor-pointer" onclick="ShowModalDepartingGuests()">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="material-icons">local_hotel</i>
            </div>
            <div class="card-content">
                <p class="category">Departing Guests</p>
                <h3 class="title">9</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6 cursor-pointer" onclick="ShowModalNewReservations()">
        <div class="card card-stats">
            <div class="card-header" data-background-color="blue">
                <i class="material-icons">event_available</i>
            </div>
            <div class="card-content">
                <p class="category">New Reservations</p>
                <h3 class="title">6</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6 cursor-pointer" onclick="ShowModalCancelledReservations()">
        <div class="card card-stats">
            <div class="card-header" data-background-color="red">
                <i class="material-icons">event_busy</i>
            </div>
            <div class="card-content">
                <p class="category">Cancelled Reservations</p>
                <h3 class="title">1</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="row">
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header card-chart" data-background-color="green">
                <div class="ct-chart" id="dailySalesChart"></div>
            </div>
            <div class="card-content">
                <h4 class="title">Daily Sales</h4>
                <p class="category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 55%  </span> increase in today sales.</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> updated 4 minutes ago
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header card-chart" data-background-color="orange">
                <div class="ct-chart" id="emailsSubscriptionChart"></div>
            </div>
            <div class="card-content">
                <h4 class="title">Monthly Reservations</h4>
                <p class="category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> updated 1 hour ago
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header card-chart" data-background-color="red">
                <div class="ct-chart" id="completedTasksChart"></div>
            </div>
            <div class="card-content">
                <h4 class="title">Income</h4>
                <p class="category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> updated 30 mins ago
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="row">
    
    <div class="col-lg-8 col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="teal">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <span class="nav-tabs-title">Unpaid Customers:</span>
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#profile" data-toggle="tab">
                                    <i class="material-icons">announcement</i>
                                    3rd Day
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="">
                                <a href="#messages" data-toggle="tab">
                                    <i class="material-icons">phonelink_erase</i>
                                    5th Day
                                <div class="ripple-container"></div></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Initial Bill</th>
                                    <th class="text-center">Required Downpayment</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>Bill</td>
                                    <td>Payment</td>
                                    <td>Email</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Send email" class="btn btn-success btn-simple btn-xs" onclick="ShowModalSendEmail()">
                                            <i class="material-icons">question_answer</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Cancel Reservation" class="btn btn-danger btn-simple btn-xs">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>Bill</td>
                                    <td>Payment</td>
                                    <td>Email</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Send email" class="btn btn-success btn-simple btn-xs" onclick="ShowModalSendEmail()">
                                            <i class="material-icons">question_answer</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Cancel Reservation" class="btn btn-danger btn-simple btn-xs">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>Bill</td>
                                    <td>Payment</td>
                                    <td>Email</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Send email" class="btn btn-success btn-simple btn-xs" onclick="ShowModalSendEmail()">
                                            <i class="material-icons">question_answer</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Cancel Reservation" class="btn btn-danger btn-simple btn-xs">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>Bill</td>
                                    <td>Payment</td>
                                    <td>Email</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Send email" class="btn btn-success btn-simple btn-xs" onclick="ShowModalSendEmail()">
                                            <i class="material-icons">question_answer</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Cancel Reservation" class="btn btn-danger btn-simple btn-xs">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>Bill</td>
                                    <td>Payment</td>
                                    <td>Email</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Send email" class="btn btn-success btn-simple btn-xs" onclick="ShowModalSendEmail()">
                                            <i class="material-icons">question_answer</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Cancel Reservation" class="btn btn-danger btn-simple btn-xs">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="messages">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Initial Bill</th>
                                    <th class="text-center">Required Downpayment</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>Bill</td>
                                    <td>Payment</td>
                                    <td>Email</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Send email" class="btn btn-success btn-simple btn-xs">
                                            <i class="material-icons">question_answer</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Cancel Reservation" class="btn btn-danger btn-simple btn-xs">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>Bill</td>
                                    <td>Payment</td>
                                    <td>Email</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Send email" class="btn btn-success btn-simple btn-xs">
                                            <i class="material-icons">question_answer</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Cancel Reservation" class="btn btn-danger btn-simple btn-xs">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>Bill</td>
                                    <td>Payment</td>
                                    <td>Email</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Send email" class="btn btn-success btn-simple btn-xs">
                                            <i class="material-icons">question_answer</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Cancel Reservation" class="btn btn-danger btn-simple btn-xs">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>Bill</td>
                                    <td>Payment</td>
                                    <td>Email</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Send email" class="btn btn-success btn-simple btn-xs">
                                            <i class="material-icons">question_answer</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Cancel Reservation" class="btn btn-danger btn-simple btn-xs">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>Bill</td>
                                    <td>Payment</td>
                                    <td>Email</td>
                                    <td>
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs" onclick="ShowModalReservationInfo()">
                                            <i class="material-icons">insert_invitation</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Send email" class="btn btn-success btn-simple btn-xs">
                                            <i class="material-icons">question_answer</i>
                                        </button>
                                        <button type="button" rel="tooltip" title="Cancel Reservation" class="btn btn-danger btn-simple btn-xs">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="orange">
                <h4 class="title">Employees Stats</h4>
                <p class="category">New employees on 15th September, 2016</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead class="text-warning">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Salary</th>
                        <th>Country</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Dakota Rice</td>
                            <td>$36,738</td>
                            <td>Niger</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Minerva Hooper</td>
                            <td>$23,789</td>
                            <td>Curaçao</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Sage Rodriguez</td>
                            <td>$56,142</td>
                            <td>Netherlands</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Philip Chaney</td>
                            <td>$38,735</td>
                            <td>Korea, South</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
				

@endsection

@section('modals')
<div id="DivModalArrivingGuests" class="modal">
    <div class="Modal-content" style="max-width:1000px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">
                            <div class="card-header" data-background-color="orange">
                                <i class="material-icons">supervisor_account</i>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <h3 class="title">Arriving Guests<span class="close" onclick="HideModalArrivingGuests()">X</span></h3>
                                    <p class="category paragraphText">As of today</p>
                                </div>
                                <br>
                                <table class="table table-hover" onclick="run(event)" style="font-family: Roboto">
                                <thead class="text-warning">
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>   
                                    <th class="text-center">Time of arrival</th>
                                    <th class="text-center">Check Out Date</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Contact Number</th>
                                    <th class="text-center">Action</th>
                                </thead>
                                <tbody>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td>ID</td>
                                            <td>Name</td>   
                                            <td>Time of arrival</td>
                                            <td>Check Out Date</td>
                                            <td>Email</td>
                                            <td>Contact Number</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Show more info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Check In" class="btn btn-success btn-simple btn-xs">
                                                    <i class="material-icons">done_all</i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td>ID</td>
                                            <td>Name</td>   
                                            <td>Time of arrival</td>
                                            <td>Check Out Date</td>
                                            <td>Email</td>
                                            <td>Contact Number</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Show more info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Check In" class="btn btn-success btn-simple btn-xs">
                                                    <i class="material-icons">done_all</i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td>ID</td>
                                            <td>Name</td>   
                                            <td>Time of arrival</td>
                                            <td>Check Out Date</td>
                                            <td>Email</td>
                                            <td>Contact Number</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Show more info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Check In" class="btn btn-success btn-simple btn-xs">
                                                    <i class="material-icons">done_all</i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td>ID</td>
                                            <td>Name</td>   
                                            <td>Time of arrival</td>
                                            <td>Check Out Date</td>
                                            <td>Email</td>
                                            <td>Contact Number</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Show more info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Check In" class="btn btn-success btn-simple btn-xs">
                                                    <i class="material-icons">done_all</i>
                                                </button>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<div id="DivModalDepartingGuests" class="modal">
    <div class="Modal-content" style="max-width: 1000px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">
                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">local_hotel</i>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <h3 class="title">Departing Guests<span class="close" onclick="HideModalDepartingGuests()">X</span></h3>
                                    <p class="category paragraphText">As of today</p>
                                </div>
                                <br>
                                <table class="table table-hover" onclick="run(event)" style="font-family: Roboto">
                                <thead class="text-success">
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>   
                                    <th class="text-center">Time of departure</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Contact Number</th>
                                    <th class="text-center">Bill Status</th>
                                    <th class="text-center">Action</th>
                                </thead>
                                <tbody>
                                    <tr onclick="HighlightRow(this)" class="text-center">
                                        <td class="text-center">ID</td>
                                        <td class="text-center">Name</td>   
                                        <td class="text-center">Time of departure</td>
                                        <td class="text-center">Email</td>
                                        <td class="text-center">Contact Number</td>
                                        <td class="text-center">Bill Status</td>
                                        <td>
                                            <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">insert_invitation</i>
                                            </button>
                                            <button type="button" rel="tooltip" title="Check Out" class="btn btn-success btn-simple btn-xs">
                                                <i class="material-icons">exit_to_app</i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr onclick="HighlightRow(this)" class="text-center">
                                        <td class="text-center">ID</td>
                                        <td class="text-center">Name</td>   
                                        <td class="text-center">Time of departure</td>
                                        <td class="text-center">Email</td>
                                        <td class="text-center">Contact Number</td>
                                        <td class="text-center">Bill Status</td>
                                        <td>
                                            <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">insert_invitation</i>
                                            </button>
                                            <button type="button" rel="tooltip" title="Check Out" class="btn btn-success btn-simple btn-xs">
                                                <i class="material-icons">exit_to_app</i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr onclick="HighlightRow(this)" class="text-center">
                                        <td class="text-center">ID</td>
                                        <td class="text-center">Name</td>   
                                        <td class="text-center">Time of departure</td>
                                        <td class="text-center">Email</td>
                                        <td class="text-center">Contact Number</td>
                                        <td class="text-center">Bill Status</td>
                                        <td>
                                            <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">insert_invitation</i>
                                            </button>
                                            <button type="button" rel="tooltip" title="Check Out" class="btn btn-success btn-simple btn-xs">
                                                <i class="material-icons">exit_to_app</i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr onclick="HighlightRow(this)" class="text-center">
                                        <td class="text-center">ID</td>
                                        <td class="text-center">Name</td>   
                                        <td class="text-center">Time of departure</td>
                                        <td class="text-center">Email</td>
                                        <td class="text-center">Contact Number</td>
                                        <td class="text-center">Bill Status</td>
                                        <td>
                                            <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">insert_invitation</i>
                                            </button>
                                            <button type="button" rel="tooltip" title="Check Out" class="btn btn-success btn-simple btn-xs">
                                                <i class="material-icons">exit_to_app</i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
        </div>
    </div>
</div>

<div id="DivModalNewReservations" class="modal">
    <div class="Modal-content" style="max-width: 1000px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">event_available</i>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <h3 class="title">New Reservations<span class="close" onclick="HideModalNewReservations()">X</span></h3>
                                    <p class="category paragraphText">As of today</p>
                                </div>
                                <br>
                                <table class="table table-hover" onclick="run(event)" style="font-family: Roboto">
                                    <thead class="text-info">
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Name</th>   
                                        <th class="text-center">Check In Date</th>
                                        <th class="text-center">Check Out Date</th>
                                        <th class="text-center">Contact Number</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Action</th>
                                    </thead>
                                    <tbody>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td class="text-center">ID</td>
                                            <td class="text-center">Name</td>   
                                            <td class="text-center">Check In Date</td>
                                            <td class="text-center">Check Out Date</td>
                                            <td class="text-center">Contact Number</td>
                                            <td class="text-center">Email</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td class="text-center">ID</td>
                                            <td class="text-center">Name</td>   
                                            <td class="text-center">Check In Date</td>
                                            <td class="text-center">Check Out Date</td>
                                            <td class="text-center">Contact Number</td>
                                            <td class="text-center">Email</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td class="text-center">ID</td>
                                            <td class="text-center">Name</td>   
                                            <td class="text-center">Check In Date</td>
                                            <td class="text-center">Check Out Date</td>
                                            <td class="text-center">Contact Number</td>
                                            <td class="text-center">Email</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td class="text-center">ID</td>
                                            <td class="text-center">Name</td>   
                                            <td class="text-center">Check In Date</td>
                                            <td class="text-center">Check Out Date</td>
                                            <td class="text-center">Contact Number</td>
                                            <td class="text-center">Email</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="/Reservations"><button type="button" class="btn btn-success pull-right">Manage Reservations</button></a>
                                    </div>    
                                </div>
                        </div>

                    </div>
                </div>
        </div>
    </div>
</div>

<div id="DivModalCancelledReservations" class="modal">
    <div class="Modal-content" style="max-width: 1000px">
        <div class="row">
            <div class="col-md-12">
                    <div class="card card-stats">

                            <div class="card-header" data-background-color="red">
                                <i class="material-icons">event_busy</i>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <h3 class="title">Cancelled Reservations<span class="close" onclick="HideModalCancelledReservations()">X</span></h3>
                                    <p class="category paragraphText">As of today</p>
                                </div>
                                <br>
                                <table class="table table-hover" onclick="run(event)" style="font-family: Roboto">
                                    <thead class="text-danger">
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Name</th>   
                                        <th class="text-center">Check In Date</th>
                                        <th class="text-center">Check Out Date</th>
                                        <th class="text-center">Contact Number</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Action</th>
                                    </thead>
                                    <tbody>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td class="text-center">ID</td>
                                            <td class="text-center">Name</td>   
                                            <td class="text-center">Check In Date</td>
                                            <td class="text-center">Check Out Date</td>
                                            <td class="text-center">Contact Number</td>
                                            <td class="text-center">Email</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td class="text-center">ID</td>
                                            <td class="text-center">Name</td>   
                                            <td class="text-center">Check In Date</td>
                                            <td class="text-center">Check Out Date</td>
                                            <td class="text-center">Contact Number</td>
                                            <td class="text-center">Email</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td class="text-center">ID</td>
                                            <td class="text-center">Name</td>   
                                            <td class="text-center">Check In Date</td>
                                            <td class="text-center">Check Out Date</td>
                                            <td class="text-center">Contact Number</td>
                                            <td class="text-center">Email</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr onclick="HighlightRow(this)" class="text-center">
                                            <td class="text-center">ID</td>
                                            <td class="text-center">Name</td>   
                                            <td class="text-center">Check In Date</td>
                                            <td class="text-center">Check Out Date</td>
                                            <td class="text-center">Contact Number</td>
                                            <td class="text-center">Email</td>
                                            <td>
                                                <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
                                                    <i class="material-icons">insert_invitation</i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                    </div>
                </div>
        </div>
    </div>
</div>

<div id="DivModalReservationInfo" class="modal">
    <div class="Modal-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="blue">
                        <i class="material-icons">insert_invitation</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <h3 class="title">Reservation Info<span class="close" onclick="HideModalReservationInfo()">X</span></h3>
                        </div>
                        <div class="row">
                            <div class="col-xs-1"></div>
                            <div class="col-xs-10">
                                <small><h4>Reservation Info:</h4></small>
                                <p class="paragraphText text-primary">Reservation ID:</p> <p class="paragraphText" id="i-ReservationID"></p><br>
                                <p class="paragraphText text-primary">Reservation Code:</p> <p class="paragraphText" id="i-ReservationCode"></p><br>
                                <p class="paragraphText text-primary">Check In Date:</p> <p class="paragraphText" id="i-CheckInDate"></p><br>
                                <p class="paragraphText text-primary">Check Out Date:</p> <p class="paragraphText" id="i-CheckOutDate"></p><br>
                                <p class="paragraphText text-primary">Pick Up Time:</p> <p class="paragraphText" id="i-PickUpTime"></p><br>
                                <p class="paragraphText text-primary">Number of adult guests:</p> <p class="paragraphText" id="i-NoOfAdults"></p><br>
                                <p class="paragraphText text-primary">Number of child guests:</p> <p class="paragraphText" id="i-NoOfKids"></p><br>
                                <p class="paragraphText text-primary">Remarks:</p> <p class="paragraphText" id="i-Remarks"></p><br>
                                <small><h4>Reserved Room(s):</h4></small>
                                <div class="row"></div>
                                <table class="table" id="tblChosenRooms" style="font-family: 'Roboto'">
                                    <thead class="text-primary">
                                        <th>Room</th>
                                        <th>Quantity</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table><br><br>
                                <small><h4>Reserved Boat(s):</h4></small>
                                <div class="row"></div>
                                <table class="table" id="tblChosenBoats" style="font-family: 'Roboto'">
                                    <thead class="text-primary">
                                        <th>Boat</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table><br><br>
                                <small><h4>Bill Information</h4></small>
                                <p class="paragraphText text-primary">Initial Bill:</p> <p class="paragraphText" id="i-InitialBill"></p><br>
                                <p class="paragraphText text-primary">Required Downpayment:</p> <p class="paragraphText" id="i-RequiredDownpayment"></p><br>
                                <p class="paragraphText text-primary">Date Booked:</p> <p class="paragraphText" id="i-DateBooked"></p><br>
                                <p class="paragraphText text-primary">Payment Due Date</p><p class="paragraphText" id="i-PaymentDueDate"></p><br><br>
                                <small><h4>Guest Information</h4></small>
                                <p class="paragraphText text-primary">Name:</p><p class="paragraphText" id="i-Name"></p><br>
                                <p class="paragraphText text-primary">Address:</p><p class="paragraphText" id="i-Address"></p><br>
                                <p class="paragraphText text-primary">Contact Number:</p><p class="paragraphText" id="i-ContactNumber"></p><br>
                                <p class="paragraphText text-primary">Email:</p><p class="paragraphText" id="i-Email"></p><br>
                                <p class="paragraphText text-primary">Age:</p><p class="paragraphText" id="i-Age"></p><br>
                                <p class="paragraphText text-primary">Gender:</p><p class="paragraphText" id="i-Gender"></p><br>
                                <p class="paragraphText text-primary">Nationality:</p><p class="paragraphText" id="i-Nationality"></p><br>
                                <br><br>

                                <button type="button" class="btn btn-info pull-right" onclick="HideModalReservationInfo()">Close</button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="DivModalSendEmail" class="modal">
    <div class="Modal-content" style="max-width:400px">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">question_answer</i>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <h3 class="title">Compose Email<span class="close" onclick="HideModalSendEmail()">X</span></h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-static">
                                    <label class="control-label">To:</label>
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-static">
                                    <label class="control-label">Email:</label>
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group label-static">
                                        <label class="control-label">Message</label>
                                        <textarea class="form-control" rows="5">The Il Sogno Beach Resort would like to remind you to pay the downpayment (PHP540) required for your reservation until September 4, 2017. For any inquiries you may call us at 8-7000 or visit our website at www.ilsognobeachresort.com
                                        This is a system generated message. Please do not reply</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success pull-right" onclick="">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection