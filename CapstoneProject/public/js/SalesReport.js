function GenerateReport() {

	var SalesReportTimeRange = document.getElementById("SelectQuery").value;
	var dtmDailyDate = document.getElementById("DailyDate").value;

	var e = document.getElementById("Month");
	var intMonthlyMonth = e.options[e.selectedIndex].value;
	var intMonthlyYear = document.getElementById("SelectMonthlyYear").value;

	var x = document.getElementById("Quarter");
	var intQuarter = x.options[x.selectedIndex].value;
	var intQuarterYear = document.getElementById("SelectQuarterlyYear").value;

	$.ajax({
	    type:'get',
	    url:'/Reports/Sales',
	    data:{

	    	SalesReportTimeRange: SalesReportTimeRange,
	    	dtmDailyDate: dtmDailyDate,
	    	intMonthlyMonth: intMonthlyMonth,
	    	intMonthlyYear: intMonthlyYear,
	    	intQuarter: intQuarter,
	    	intQuarterYear: intQuarterYear

	    },
	    success:function(data){

	    	fillTable(data);

	    },
	    error:function(response){
	        console.log(response);
	        alert(response.status);
	    }
	}); 

}

function fillTable(data) {

	var category = [
		"Downpayments",
		"Initial Bill Payments",
		"Extended Stays",
		"Upgraded Rooms",
		"Added Rooms",
		"Rented Boats",
		"Fees",
		"Rented Items",
		"Availed Activities"
	];

	$('#QueryTable tr').remove();

	var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
	var newRow = tableRef.insertRow(tableRef.rows.length);

	var newCell1  = newRow.insertCell(0);
	var newCell2  = newRow.insertCell(1);
	var newCell3  = newRow.insertCell(2);

	newCell1.innerHTML = "Category";
	newCell2.innerHTML = "Quantity";
	newCell3.innerHTML = "Total Amout";

	tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
	for(var x = 0; x < data.length; x++) {
	   
	    newRow = tableRef.insertRow(tableRef.rows.length);

	    newCell1  = newRow.insertCell(0);
	    newCell2  = newRow.insertCell(1);
	    newCell3  = newRow.insertCell(2);

	    newCell1.innerHTML = category[x];
	    newCell2.innerHTML = data[x].quantity;

	    if(data[x].total == null) {

	    	data[x].total = 0;

	    }

	    newCell3.innerHTML = data[x].total;

	}

}