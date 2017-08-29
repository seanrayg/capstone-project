var FeeInfo = [];

function ShowModalAddFees(){
    document.getElementById("DivModalAddFees").style.display = "block";
}

function HideModalAddFees(){
    document.getElementById("DivModalAddFees").style.display = "none";
}

function ShowModalViewFees(){
    document.getElementById("DivModalViewFees").style.display = "block";
}

function HideModalViewFees(){
    document.getElementById("DivModalViewFees").style.display = "none";
}

function run(event){
    event = event || window.event; 
    var target = event.target || event.srcElement;
    while (target && target.nodeName != 'TR') {
        target = target.parentElement;
    }
    
    cells = target.cells;
    if (!cells.length || target.parentNode.nodeName == 'THEAD') {
        return;
    }


    FeeInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML];
    fillAddFeeData();
}

function fillAddFeeData(){
    document.getElementById("AddCustomerName").value = FeeInfo[2] +" "+ FeeInfo[3] +" "+ FeeInfo[4];
    document.getElementById("AddReservationID").value = FeeInfo[1];
}