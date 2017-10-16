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
                <button type="submit" class="btn btn-success pull-right">Print</button>
            </form>
        </div>
    </div>
</div>

@endsection
