@extends('layout')

@section('WebpageTitle')
    <title>Sales Report</title>
@endsection

@section('scripts')
    <script>
       function DisplayFields(field){
           document.getElementById("DailyReport").style.display = "none";
           document.getElementById("MonthlyReport").style.display = "none";
           document.getElementById("QuarterlyReport").style.display = "none";
           document.getElementById("AnnuallyReport").style.display = "none";
           
           var chosenReport = field.value+"Report";
           document.getElementById(chosenReport).style.display = "block";
       }
        
        window.onload = function(){
            var tempDate = new Date();
            var yearNow = parseInt(tempDate.getFullYear());

            var x = document.getElementById("SelectMonthlyYear");
            for(var y = yearNow; y < (yearNow+50); y++){
                var option = document.createElement("option");
                option.text = y;
                x.add(option);
            }
            
            x = document.getElementById("SelectQuarterlyYear");
            for(var y = yearNow; y < (yearNow+50); y++){
                var option = document.createElement("option");
                option.text = y;
                x.add(option);
            }
            
            x = document.getElementById("SelectAnnuallyYear");
            for(var y = yearNow; y < (yearNow+50); y++){
                var option = document.createElement("option");
                option.text = y;
                x.add(option);
            }
            
        }

    </script>
    <script src="js/reports.js" type="text/javascript"></script>
    <script src="js/SalesReport.js" type="text/javascript"></script>
@endsection

@section('content')
<h5 id="TitlePage">Reports</h5>

<div class="row">                      
    <div class="col-lg-8">
        <div class="card card-stats">
            <div class="card-header" data-background-color="purple">
                <i class="material-icons">assignment</i>
            </div>
            <div class="card-content">
                <div class="row">
                    <p class="category">Please fill out all the fields</p>
                    <h3 class="title">Sales Report</h3>
                </div>

                <div class = "row">
                    <div class="col-md-12">
                        <div class="form-group label-static">
                            <label class="control-label">Type</label>
                            <div class="selectBox">
                                <select id="ReportType" onchange="SwitchTotalSalesPanel()">
                                    <option>Payment Summary</option>
                                    <option>Breakdown</option>
                                </select>
                              </div>
                        </div>
                    </div>
                </div>

                <div class = "row">
                    <div class="col-md-12">
                        <div class="form-group label-static">
                            <label class="control-label">Report</label>
                            <div class="selectBox">
                                <select name="SelectQuery" id="SelectQuery" onchange="DisplayFields(this)">
                                    <option>Daily</option>
                                    <option>Monthly</option>
                                    <option>Quarterly</option>
                                    <option>Annually</option>
                                </select>
                              </div>
                        </div>
                    </div>
                </div>
                
                <div id="DailyReport">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group label-static">
                                <label class="control-label">Date</label>
                                <input type="text" id="DailyDate" class="datepicker form-control" readonly/>
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
                                    <select id="Month">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
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
                
                <div id="QuarterlyReport" style="display: none">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-static">
                                <label class="control-label">Quarter</label>
                                <div class="selectBox">
                                    <select id="Quarter">
                                        <option value="1">1st Quarter (January - March)</option>
                                        <option value="2">2nd Quarter (April - June)</option>
                                        <option value="3">3rd Quarter (July - September)</option>
                                        <option value="4">4th Quarter (October - December)</option>
                                    </select>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-static">
                                <label class="control-label">Year</label>
                                <div class="selectBox">
                                    <select id="SelectQuarterlyYear">
                                    </select>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="AnnuallyReport" style="display: none">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-static">
                                <label class="control-label">Year</label>
                                <div class="selectBox">
                                    <select id="SelectAnnuallyYear">
                                    </select>
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
    <div class="col-lg-4">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="material-icons">assignments</i>
            </div>
            <div class="card-content" style="height: 370px;">
                <div class="row">
                    <p class="category"></p>
                    <h3 class="title">Total Sales</h3>
                </div>

                <div id="s-total" class="row">
                    <div class="col-sm-12">
                        <div class="form-group label-static">
                            <label class="control-label">TOTAL</label>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group label-static">
                            <label class="control-label" style="font-size: 40px;" id="s-totalamount">₱ &nbsp;</label>
                        </div>
                    </div>
                </div>

                <div id="b-total" class="row" style="display: none;">
                    <div class="col-sm-6">
                        <div class="form-group label-static">
                            <label class="control-label">Rooms</label>
                            <input type="text" id="roomtypesales" class="form-control" readonly/>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group label-static">
                            <label class="control-label">Items</label>
                            <input type="text" id="itemsales" class="form-control" readonly/>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group label-static">
                            <label class="control-label">Beach Activities</label>
                            <input type="text" id="beachactivitysales" class="form-control" readonly/>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group label-static">
                            <label class="control-label">Boats</label>
                            <input type="text" id="boatsales" class="form-control" readonly/>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group label-static">
                            <label class="control-label">TOTAL</label>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group label-static">
                            <label class="control-label" style="font-size: 40px;" id="b-totalamount">₱ &nbsp;</label>
                        </div>
                    </div>
                </div>
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
                <br>
                <table class="table" id="RoomTable">
                    <thead class="text-info">

                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <br>
                <table class="table" id="ItemTable">
                    <thead class="text-info">

                    </thead>
                    <tbody>
                        
                    </tbody>
                </table> 
                <br>
                <table class="table" id="BeachActivityTable">
                    <thead class="text-info">

                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <br>
                <table class="table" id="BoatTable">
                    <thead class="text-info">

                    </thead>
                    <tbody>
                        
                    </tbody>
                </table> 
            </div>
            <form method="POST" action="/SalesReport/Print" target="_blank" onsubmit="return SetSalesReportData()">
                {{ csrf_field() }}
                <input type="hidden" name="SalesReportType" id="SalesReportType" value="1">
                <input type="hidden" name="sSalesReportTimeRange" id="sSalesReportTimeRange">
                <input type="hidden" name="PaymentSummary" id="PaymentSummary">
                <input type="hidden" name="tblRoomInfo" id="tblRoomInfo">
                <input type="hidden" name="tblItemInfo" id="tblItemInfo">
                <input type="hidden" name="tblBeachActivityInfo" id="tblBeachActivityInfo">
                <input type="hidden" name="tblBoatInfo" id="tblBoatInfo">
                <input type="hidden" name="sDailyDate" id="sDailyDate">
                <input type="hidden" name="sMonthlyMonth" id="sMonthlyMonth">
                <input type="hidden" name="sMonthlyYear" id="sMonthlyYear">
                <input type="hidden" name="sQuarterlyQuarter" id="sQuarterlyQuarter">
                <input type="hidden" name="sQuarterlyYear" id="sQuarterlyYear">
                <input type="hidden" name="sAnnualYear" id="sAnnualYear">
                <button type="submit" class="btn btn-success pull-right">Print</button>
            </form>
        </div>
    </div>
</div>

@endsection
