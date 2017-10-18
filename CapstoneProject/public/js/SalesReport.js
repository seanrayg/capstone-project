function GenerateReport() {

	var ReportType = document.getElementById("ReportType").value;

	if(ReportType == 'Payment Summary') {

		var SalesReportTimeRange = document.getElementById("SelectQuery").value;
		var dtmDailyDate = document.getElementById("DailyDate").value;

		var e = document.getElementById("Month");
		var intMonthlyMonth = e.options[e.selectedIndex].value;
		var intMonthlyYear = document.getElementById("SelectMonthlyYear").value;

		var x = document.getElementById("Quarter");
		var intQuarter = x.options[x.selectedIndex].value;
		var intQuarterYear = document.getElementById("SelectQuarterlyYear").value;

		var intYearlyYear = document.getElementById("SelectAnnuallyYear").value;

		$.ajax({
		    type:'get',
		    url:'/Reports/Sales',
		    data:{

		    	ReportType: ReportType,
		    	SalesReportTimeRange: SalesReportTimeRange,
		    	dtmDailyDate: dtmDailyDate,
		    	intMonthlyMonth: intMonthlyMonth,
		    	intMonthlyYear: intMonthlyYear,
		    	intQuarter: intQuarter,
		    	intQuarterYear: intQuarterYear,
		    	intYearlyYear: intYearlyYear

		    },
		    success:function(data){

		    	fillTable(data, ReportType);

		    },
		    error:function(response){
		        console.log(response);
		        alert(response.status);
		    }
		}); 

	}else if(ReportType == 'Breakdown') {

		var SalesReportTimeRange = document.getElementById("SelectQuery").value;

		var intYearlyYear = document.getElementById("SelectAnnuallyYear").value;

		var x = document.getElementById("Quarter");
		var intQuarter = x.options[x.selectedIndex].value;
		var intQuarterYear = document.getElementById("SelectQuarterlyYear").value;

		var e = document.getElementById("Month");
		var intMonthlyMonth = e.options[e.selectedIndex].value;
		var intMonthlyYear = document.getElementById("SelectMonthlyYear").value;

		var dtmDailyDate = document.getElementById("DailyDate").value;

		$.ajax({
		    type:'get',
		    url:'/Reports/Sales',
		    data:{

		    	ReportType: ReportType,
		    	SalesReportTimeRange: SalesReportTimeRange,
		    	intYearlyYear: intYearlyYear,
		    	intQuarter: intQuarter,
		    	intQuarterYear: intQuarterYear,
		    	intMonthlyMonth: intMonthlyMonth,
		    	intMonthlyYear: intMonthlyYear,
		    	dtmDailyDate: dtmDailyDate

		    },
		    success:function(data){

		    	fillTable(data, ReportType);

		    },
		    error:function(response){
		        console.log(response);
		        alert(response.status);
		    }
		}); 

	}

}

function fillTable(data, type) {

	if(type == 'Payment Summary') {

		var total = 0;

		var category = [
			"Downpayments",
			"Initial Bill Payments",
			"Extended Stays",
			"Upgraded Rooms",
			"Added Rooms",
			"Rented Boats",
			"Fees",
			"Rented Items",
			"Extended Items",
			"Overtime Items",
			"Availed Activities",
			"Check Out Payments"
		];

		$('#QueryTable tr').remove();
		$('#RoomTable tr').remove();
		$('#ItemTable tr').remove();
		$('#BeachActivityTable tr').remove();
		$('#BoatTable tr').remove();

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

		    total += data[x].total;

		}

		document.getElementById("s-totalamount").innerHTML = '₱ ' + total;

	}else if(type == 'Breakdown') {

		$('#QueryTable tr').remove();
		$('#RoomTable tr').remove();
		$('#ItemTable tr').remove();
		$('#BeachActivityTable tr').remove();
		$('#BoatTable tr').remove();

		//Room Table
		var RoomTotal = 0;
		var tableRef = document.getElementById('RoomTable').getElementsByTagName('thead')[0];
		var newRow = tableRef.insertRow(tableRef.rows.length);

		if(data[0].length != 0) {

			var newCell1  = newRow.insertCell(0);
			var newCell2  = newRow.insertCell(1);
			var newCell3  = newRow.insertCell(2);
			var newCell4  = newRow.insertCell(3);

			newCell1.innerHTML = "Room Type";
			newCell2.innerHTML = "Availed";
			newCell3.innerHTML = "Rate";
			newCell4.innerHTML = "Total Amount";

		}

		tableRef = document.getElementById('RoomTable').getElementsByTagName('tbody')[0];
		for(var x = 0; x < data[0].length; x++) {
		   
		    newRow = tableRef.insertRow(tableRef.rows.length);

		    var newCell1  = newRow.insertCell(0);
		    var newCell2  = newRow.insertCell(1);
		    var newCell3  = newRow.insertCell(2);
		    var newCell4  = newRow.insertCell(3);

		    newCell1.innerHTML = data[0][x].description;
		    newCell2.innerHTML = data[0][x].quantity;
		    newCell3.innerHTML = data[0][x].rate;
		    newCell4.innerHTML = data[0][x].total;

		    RoomTotal += data[0][x].total;

		}

		//Item Table
		var ItemTotal = 0;
		var tableRef = document.getElementById('ItemTable').getElementsByTagName('thead')[0];
		var newRow = tableRef.insertRow(tableRef.rows.length);

		if(data[1].length != 0) {

			var newCell1  = newRow.insertCell(0);
			var newCell2  = newRow.insertCell(1);
			var newCell3  = newRow.insertCell(2);
			var newCell4  = newRow.insertCell(3);

			newCell1.innerHTML = "Item Name";
			newCell2.innerHTML = "Availed";
			newCell3.innerHTML = "Rate";
			newCell4.innerHTML = "Total Amount";

		}

		tableRef = document.getElementById('ItemTable').getElementsByTagName('tbody')[0];
		for(var x = 0; x < data[1].length; x++) {
		   
		    newRow = tableRef.insertRow(tableRef.rows.length);

		    var newCell1  = newRow.insertCell(0);
		    var newCell2  = newRow.insertCell(1);
		    var newCell3  = newRow.insertCell(2);
		    var newCell4  = newRow.insertCell(3);

		    newCell1.innerHTML = data[1][x].description;
		    newCell2.innerHTML = data[1][x].quantity;
		    newCell3.innerHTML = data[1][x].rate;
		    newCell4.innerHTML = data[1][x].total;

		    ItemTotal += data[1][x].total;

		}

		//Beach Activity Table
		var BATotal = 0;
		var tableRef = document.getElementById('BeachActivityTable').getElementsByTagName('thead')[0];
		var newRow = tableRef.insertRow(tableRef.rows.length);

		if(data[2].length != 0) {

			var newCell1  = newRow.insertCell(0);
			var newCell2  = newRow.insertCell(1);
			var newCell3  = newRow.insertCell(2);
			var newCell4  = newRow.insertCell(3);

			newCell1.innerHTML = "Beach Activity";
			newCell2.innerHTML = "Availed";
			newCell3.innerHTML = "Rate";
			newCell4.innerHTML = "Total Amount";

		}

		tableRef = document.getElementById('BeachActivityTable').getElementsByTagName('tbody')[0];
		for(var x = 0; x < data[2].length; x++) {
		   
		    newRow = tableRef.insertRow(tableRef.rows.length);

		    var newCell1  = newRow.insertCell(0);
		    var newCell2  = newRow.insertCell(1);
		    var newCell3  = newRow.insertCell(2);
		    var newCell4  = newRow.insertCell(3);

		    newCell1.innerHTML = data[2][x].description;
		    newCell2.innerHTML = data[2][x].quantity;
		    newCell3.innerHTML = data[2][x].rate;
		    newCell4.innerHTML = data[2][x].total;

		    BATotal += data[2][x].total;

		}

		//Boat Table
		var BoatTotal = 0;
		var tableRef = document.getElementById('BoatTable').getElementsByTagName('thead')[0];
		var newRow = tableRef.insertRow(tableRef.rows.length);

		if(data[3].length != 0) {

			var newCell1  = newRow.insertCell(0);
			var newCell2  = newRow.insertCell(1);
			var newCell3  = newRow.insertCell(2);
			var newCell4  = newRow.insertCell(3);

			newCell1.innerHTML = "Boat Name";
			newCell2.innerHTML = "Availed";
			newCell3.innerHTML = "Rate";
			newCell4.innerHTML = "Total Amount";

		}

		tableRef = document.getElementById('BoatTable').getElementsByTagName('tbody')[0];
		for(var x = 0; x < data[3].length; x++) {
		   
		    newRow = tableRef.insertRow(tableRef.rows.length);

		    var newCell1  = newRow.insertCell(0);
		    var newCell2  = newRow.insertCell(1);
		    var newCell3  = newRow.insertCell(2);
		    var newCell4  = newRow.insertCell(3);

		    newCell1.innerHTML = data[3][x].description;
		    newCell2.innerHTML = data[3][x].quantity;
		    newCell3.innerHTML = data[3][x].rate;
		    newCell4.innerHTML = data[3][x].total;

		    BoatTotal += data[3][x].total;

		}

		document.getElementById("roomtypesales").value = RoomTotal;
		document.getElementById("itemsales").value = ItemTotal;
		document.getElementById("beachactivitysales").value = BATotal;
		document.getElementById("boatsales").value = BoatTotal;

		var bTotalSales = RoomTotal + ItemTotal + BATotal + BoatTotal;

		document.getElementById("b-totalamount").innerHTML = '₱ ' + bTotalSales;

	}

}

function SwitchTotalSalesPanel() {

	if(document.getElementById("ReportType").value == "Payment Summary") {

		document.getElementById("s-totalamount").innerHTML = '₱';

		document.getElementById("s-total").style.display = 'block';
		document.getElementById("b-total").style.display = 'none';

		document.getElementById("SalesReportType").value = 1;

	}else {

		document.getElementById("b-totalamount").innerHTML = '₱';
		document.getElementById("roomtypesales").value = '';
		document.getElementById("itemsales").value = '';
		document.getElementById("beachactivitysales").value = '';
		document.getElementById("boatsales").value = '';

		document.getElementById("s-total").style.display = 'none';
		document.getElementById("b-total").style.display = 'block';

		document.getElementById("SalesReportType").value = 2;

	}

}

function SetSalesReportData() {

	var tblPaymentSummary = GetTableInfo("QueryTable");

	var tblRoomInfo = GetTableInfo("RoomTable");
    var tblItemInfo = GetTableInfo("ItemTable");
	var tblBeachActivityInfo = GetTableInfo("BeachActivityTable");
    var tblBoatInfo = GetTableInfo("BoatTable");

    $('#PaymentSummary').val(JSON.stringify(tblPaymentSummary));

    $('#tblRoomInfo').val(JSON.stringify(tblRoomInfo));
    $('#tblItemInfo').val(JSON.stringify(tblItemInfo));
    $('#tblBeachActivityInfo').val(JSON.stringify(tblBeachActivityInfo));
    $('#tblBoatInfo').val(JSON.stringify(tblBoatInfo));

    document.getElementById("sSalesReportTimeRange").value = document.getElementById("SelectQuery").value;

    document.getElementById("sDailyDate").value = document.getElementById("DailyDate").value;
    var e = document.getElementById("Month");
    document.getElementById("sMonthlyMonth").value = e.options[e.selectedIndex].text;
    document.getElementById("sMonthlyYear").value = document.getElementById("SelectMonthlyYear").value;
    var x = document.getElementById("Quarter");
    document.getElementById("sQuarterlyQuarter").value = x.options[e.selectedIndex].text;
    document.getElementById("sQuarterlyYear").value = document.getElementById("SelectQuarterlyYear").value;
    document.getElementById("sAnnualYear").value = document.getElementById("SelectAnnuallyYear").value;

}

function GetTableInfo(TableName) {

    var tblInfo = [];

    //gets table
    var oTable = document.getElementById(TableName);

    //gets rows of table
    var rowLength = oTable.rows.length;

    //loops through rows    
    for (i = 0; i < rowLength; i++){

        tblInfo[i] = [];

       //gets cells of current row
       var oCells = oTable.rows.item(i).cells;

       //gets amount of cells of current row
       var cellLength = oCells.length;

       //loops through each cell in current row
       for(var j = 0; j < cellLength; j++){
          /* get your cell info here */
          /* var cellVal = oCells.item(j).innerHTML; */

          tblInfo[i][j] = oCells.item(j).innerHTML;

       }
    }

    return tblInfo;

}