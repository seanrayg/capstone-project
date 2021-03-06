@extends('layout')

@section('WebpageTitle')
    <title>Query Reports</title>
@endsection

@section('scripts')
    <script src="js/QueryReports.js" type="text/javascript"></script>
    <script src="js/reports.js" type="text/javascript"></script>
@endsection

@section('content')
<h5 id="TitlePage">Reports</h5>

<div class="row">                      
    <div class="col-lg-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="material-icons">assignment</i>
            </div>
            <div class="card-content">
                <div class="row">
                    <p class="category">Please fill out all the fields</p>
                    <h3 class="title">Query Report</h3>
                </div>
                <div class = "row">
                    <div class="col-md-12">
                        <div class="form-group label-static">
                            <label class="control-label">Report</label>
                            <div class="selectBox">
                                <select name="SelectQuery" id="SelectQuery" onchange="SelectPrintAction()">
                                    <option>Accomodations</option>
                                    <option>Beach Activities</option>
                                    <option>Boats</option>
                                    <option>Cottages Only</option>
                                    <option>Cottage Types Only</option>
                                    <option>Customers</option>
                                    <option>Fees</option>
                                    <option>Inoperational Dates</option>
                                    <option>Packages</option>
                                    <option>Rental Items</option>
                                    <option>Reservations</option>
                                    <option>Rooms &amp; Cottages</option>
                                    <option>Rooms Only</option>
                                    <option>Room Types Only</option>
                                    <option>Availed Amenities</option>
                                </select>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" id="IncludedDeletedHolder">
                            <label>
                                <input type="checkbox" id="CheckIncludeDeleted">
                                Included deleted records?
                            </label>
                        </div>
                    </div>
                </div>
                <div id="AmenitiesReport" style = "display:none">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-static">
                                <label class="control-label">Amenity</label>
                                <div class="selectBox">
                                    <select name="SelectAmenityType" id="SelectAmenityType" onchange="GenerateAmenity()">
                                        <option>Rooms/Cottages</option>
                                        <option>Items</option>
                                        <option>Activities</option>
                                        <option>Packages</option>
                                        <option>Boats</option>
                                    </select>
                                  </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-static">
                                <label class="control-label">Please Choose</label>
                                <div class="selectBox">
                                    <select name="GeneratedAmenity" id="GeneratedAmenity">

                                    </select>
                                  </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-static">
                                <label class="control-label">Report</label>
                                <div class="selectBox">
                                    <select name="SelectAmenityReport" id="SelectAmenityReport" onchange="DisplayAmenityFields(this)">
                                        <option>Daily</option>
                                        <option>Monthly</option>
                                    </select>
                                  </div>
                            </div>
                        </div>
                    </div>

                    <div id="DailyAmenityReport">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group label-static">
                                    <label class="control-label">Date</label>
                                    <input type="text" class="datepicker form-control" id="DailyAmenity" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="MonthlyAmenityReport" style="display: none">
                        <div class = "row">
                            <div class="col-md-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Month</label>
                                    <div class="selectBox">
                                        <select id="AmenityMonth">
                                            <option>January</option>
                                            <option>February</option>
                                            <option>March</option>
                                            <option>April</option>
                                            <option>May</option>
                                            <option>June</option>
                                            <option>July</option>
                                            <option>August</option>
                                            <option>September</option>
                                            <option>October</option>
                                            <option>November</option>
                                            <option>December</option>
                                        </select>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Year</label>
                                    <div class="selectBox">
                                        <select id="AmenityMonthlyYear">
                                        </select>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="ReservationReport" style = "display:none">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-static">
                                <label class="control-label">Report</label>
                                <div class="selectBox">
                                    <select name="SelectReservationReport" id="SelectReservationReport" onchange="DisplayFields(this)">
                                        <option>Daily</option>
                                        <option>Monthly</option>
                                    </select>
                                  </div>
                            </div>
                        </div>
                    </div>

                    <div id="DailyReport" style="display:none">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group label-static">
                                    <label class="control-label">Date</label>
                                    <input type="text" class="datepicker form-control" id="DailyReservation" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="MonthlyReport" style="display: none">
                        <div class = "row">
                            <div class="col-md-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Month</label>
                                    <div class="selectBox">
                                        <select id="ReservationMonth">
                                            <option>January</option>
                                            <option>February</option>
                                            <option>March</option>
                                            <option>April</option>
                                            <option>May</option>
                                            <option>June</option>
                                            <option>July</option>
                                            <option>August</option>
                                            <option>September</option>
                                            <option>October</option>
                                            <option>November</option>
                                            <option>December</option>
                                        </select>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group label-static">
                                    <label class="control-label">Year</label>
                                    <div class="selectBox">
                                        <select id="SelectMonthlyYear">
                                        </select>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-success pull-right" onclick="GenerateReport()">Generate Report</button>
            </div>
        </div>
    </div> 
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Report Generated</h4>
                <p class="category"></p>
            </div>
            <div class="card-content table-responsive scrollable-table" id="style-1">
                <table class="table" id="QueryTable">
                    <thead class="text-info">
                    
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>    
            </div>
            <form method="POST" action="/QueryReports/Print" target="_blank" onsubmit="IncludeDeleted()">
                {{ csrf_field() }}
                <input type="hidden" name="PrintSelectedReport" id="PrintSelectedReport" value="Accomodations">
                <input type="hidden" name="PrintIncludeDeleted" id="PrintIncludeDeleted">
                <input type="hidden" name="rReservationReport" id="rReservationReport">
                <input type="hidden" name="rReservationMonth" id="rReservationMonth">
                <input type="hidden" name="rReservationYear" id="rReservationYear">
                <input type="hidden" name="rDailyReservation" id="rDailyReservation">
                <button type="submit" class="btn btn-success pull-right">Print</button>
            </form>
        </div>
    </div>
</div>

@endsection
