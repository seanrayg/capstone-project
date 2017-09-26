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
                                <input type="text" class="datepicker form-control" readonly/>
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
                                    <select>
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
                
                <div id="QuarterlyReport" style="display: none">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-static">
                                <label class="control-label">Year</label>
                                <div class="selectBox">
                                    <select>
                                        <option>1st Quarter (January - March)</option>
                                        <option>2nd Quarter (April - June)</option>
                                        <option>3rd Quarter (July - September)</option>
                                        <option>4th Quarter (October - December)</option>
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
