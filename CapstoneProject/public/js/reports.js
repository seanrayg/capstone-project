function SelectPrintAction() {
	if(document.getElementById("SelectQuery").value == "Reservations"){
		document.getElementById("ReservationReport").style.display = "block";
		document.getElementById("DailyReport").style.display = "block";
		document.getElementById("IncludedDeletedHolder").style.display = "none";
	}
	else{
		document.getElementById("ReservationReport").style.display = "none";
		document.getElementById("DailyReport").style.display = "none";
		document.getElementById("IncludedDeletedHolder").style.display = "block";
	}
	document.getElementById('PrintSelectedReport').value = document.getElementById("SelectQuery").value;

}

function IncludeDeleted() {
    if(document.getElementById("CheckIncludeDeleted").checked){

        document.getElementById('PrintIncludeDeleted').value = 1;

    }else {

        document.getElementById('PrintIncludeDeleted').value = 0;

    }
}
