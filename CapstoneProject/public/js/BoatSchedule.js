var BoatInfo = [];

function run(event, table) {

	event = event || window.event; 
    var target = event.target || event.srcElement;
    while (target && target.nodeName != 'TR') {
        target = target.parentElement;
    }
    
    cells = target.cells;
    if (!cells.length || target.parentNode.nodeName == 'THEAD') {
        return;
    }

    if(table == 'AvailableBoats'){
        document.getElementById('RentButton').disabled = false;

        document.getElementById('BoatName').value = cells[0].innerHTML;
        document.getElementById('BoatRate').value = cells[3].innerHTML;
    }else if(table == 'RentedBoats'){
        document.getElementById('TripDoneButton').disabled = false;
        
        document.getElementById('BoatScheduleID').value = cells[0].innerHTML;
    }

}

function ShowModalPayBoatRent() {
    var intHours = parseInt(document.getElementById('PickUpTime').value);
    var intHours = intHours / 2;

    var intBoatRate = parseInt(document.getElementById('BoatRate').value);

    var intPrice = intBoatRate * intHours;

    document.getElementById('BoatRentPrice').value = intPrice;
    
    document.getElementById("DivModalPayBoatRent").style.display = "block";
}

function HideModalPayBoatRent() {
    document.getElementById("DivModalPayBoatRent").style.display = "none";
}

function SendPayment(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        
        var ActivityTotal = parseInt(document.getElementById("ActivityTotalPrice").value);
        var ActivityPayment = parseInt(field.value);
        var Change = ActivityPayment - ActivityTotal;
        if(Change < 0){
            document.getElementById("ActivityChange").value = "Insufficient Payment";
        }
        else{
            document.getElementById("ActivityChange").value = Change;
        }
        
    }
}
