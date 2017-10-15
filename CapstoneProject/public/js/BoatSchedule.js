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
    var boolCustomerFound = CheckSelectedCustomer();

    if(boolCustomerFound) {
        var intHours = parseInt(document.getElementById('PickUpTime').value);
        var intHours = intHours / 2;

        var intBoatRate = parseInt(document.getElementById('BoatRate').value);

        var intPrice = intBoatRate * intHours;

        document.getElementById('BoatRentPrice').value = intPrice;

        document.getElementById("BoatRentChange").value = "Insufficient Payment";
        
        document.getElementById("DivModalPayBoatRent").style.display = "block";
    }
}

function HideModalPayBoatRent() {
    document.getElementById("DivModalPayBoatRent").style.display = "none";
}

function SendPayment(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        
        var BoatRentTotal = parseInt(document.getElementById("BoatRentPrice").value);
        var BoatRentPayment = parseInt(field.value);
        var Change = BoatRentPayment - BoatRentTotal;
        if(Change < 0){
            document.getElementById("BoatRentChange").value = "Insufficient Payment";
            document.getElementById("btnContinue").disabled = true;
        }
        else if(Change >= 0){
            document.getElementById("BoatRentChange").value = Change;
            document.getElementById("btnContinue").disabled = false;
        }
        
    }
}

function CheckSelectedCustomer(){

    var strCustomer = document.getElementById('CustomerName').value;
    var arrCustomer = document.getElementById('GuestsList').options;
    
    for(i = 0; i < arrCustomer.length; i++){
        if(strCustomer == arrCustomer[i].value){
            document.getElementById('CustomerErrorLabel').innerHTML = '';

            return true;
        }
    }

    document.getElementById('CustomerErrorLabel').innerHTML = 'Please check the customer name';

    return false;

}

function PrintInvoice() {

    document.getElementById("Amount").value = document.getElementById("BoatRentPrice").value;
    document.getElementById("Hours").value = document.getElementById("PickUpTime").value;
    document.getElementById("Rate").value = document.getElementById("BoatRate").value;
    document.getElementById("iCustomerID").value = document.getElementById("CustomerID").value;
    document.getElementById("boatAmountTendered").value = document.getElementById("ActivityPayment").value;
    document.getElementById("InvoiceForm").submit();

}
