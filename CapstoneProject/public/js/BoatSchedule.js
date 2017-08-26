var BoatInfo = [];

function run(event){

	document.getElementById('RentButton').disabled = false;

	event = event || window.event; 
    var target = event.target || event.srcElement;
    while (target && target.nodeName != 'TR') {
        target = target.parentElement;
    }
    
    cells = target.cells;
    if (!cells.length || target.parentNode.nodeName == 'THEAD') {
        return;
    }

    document.getElementById('BoatName').value = cells[0].innerHTML;

}
