var RentItemInfo = [];

function ShowModalRentItem(){
    document.getElementById("DivModalRentItem").style.display = "block";
}

function HideModalRentItem(){
    document.getElementById("DivModalRentItem").style.display = "none";
}

function ShowModalReturnItem(){
    document.getElementById("DivModalReturnItem").style.display = "block";
}

function HideModalReturnItem(){
    document.getElementById("DivModalReturnItem").style.display = "none";
}

function ShowModalExtendRent(){
    document.getElementById("DivModalExtendRent").style.display = "block";
}

function HideModalExtendRent(){
    document.getElementById("DivModalExtendRent").style.display = "none";
}

function ShowModalRentPackagedItem(){
    document.getElementById("DivModalRentPackagedItem").style.display = "block";
}

function HideModalRentPackagedItem(){
    document.getElementById("DivModalRentPackagedItem").style.display = "none";
}

function run(event, sender){
    event = event || window.event; 
    var target = event.target || event.srcElement;
    while (target && target.nodeName != 'TR') {
        target = target.parentElement;
    }
    
    cells = target.cells;
    if (!cells.length || target.parentNode.nodeName == 'THEAD') {
        return;
    }

    if(sender == "Rent"){
        RentItemInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML];
        fillRentItem();
    }
}

function fillRentItem(){
    document.getElementById("RentItemID").value = RentItemInfo[0];
    document.getElementById("RentItemName").value = RentItemInfo[1];
    document.getElementById("RentQuantityLeft").value = RentItemInfo[2];
    document.getElementById("RentItemRate").value = RentItemInfo[3];
}

function SendQuantityInput(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    
}