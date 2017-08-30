var BoatInfo = [];

function run(event, table){

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
