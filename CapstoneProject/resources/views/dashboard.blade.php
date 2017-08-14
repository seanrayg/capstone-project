@extends('layout')

@section('WebpageTitle')
    <title>Dashboard</title>
@endsection


@section('content')
<h5 id="TitlePage">Dashboard</h5>

<div class="row">
    
    <div class="col-lg-3 col-md-6 col-sm-6">
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
    
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="material-icons">local_hotel</i>
            </div>
            <div class="card-content">
                <p class="category">Guests In Resort</p>
                <h3 class="title">19</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6">
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
    
    <div class="col-lg-3 col-md-6 col-sm-6">
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
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
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
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
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
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
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
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
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
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
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
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
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
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
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
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
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
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
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
                                        <button type="button" rel="tooltip" title="Reservation Info" class="btn btn-info btn-simple btn-xs">
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