var FeeInfo = [];
var DatesInfo = [];
var ContactInfo = [];

//Fee Modals
function ShowModalAddFee(){
    document.getElementById("DivModalAddFee").style.display = "block";
}
function HideModalAddFee(){
    document.getElementById("DivModalAddFee").style.display = "none";
}
function ShowModalEditFee(){     
    document.getElementById("DivModalEditFee").style.display = "block";
}
function HideModalEditFee(){
    document.getElementById("DivModalEditFee").style.display = "none";
}
function ShowModalDeleteFee(){
    document.getElementById("DivModalDeleteFee").style.display = "block";
}
function HideModalDeleteFee(){
    document.getElementById("DivModalDeleteFee").style.display = "none";
}

//Date Modals
function ShowModalAddDate(){
    document.getElementById("DivModalAddDate").style.display = "block";
}
function HideModalAddDate(){
    document.getElementById("DivModalAddDate").style.display = "none";
}
function ShowModalEditDate(){     
    document.getElementById("DivModalEditDate").style.display = "block";
}
function HideModalEditDate(){
    document.getElementById("DivModalEditDate").style.display = "none";
}
function ShowModalDeleteDate(){
    document.getElementById("DivModalDeleteDate").style.display = "block";
}
function HideModalDeleteDate(){
    document.getElementById("DivModalDeleteDate").style.display = "none";
}

//Contact Modals
function ShowModalAddContact(){
    document.getElementById("DivModalAddContact").style.display = "block";
}
function HideModalAddContact(){
    document.getElementById("DivModalAddContact").style.display = "none";
}
function ShowModalEditContact(){     
    document.getElementById("DivModalEditContact").style.display = "block";
}
function HideModalEditContact(){
    document.getElementById("DivModalEditContact").style.display = "none";
}
function ShowModalDeleteContact(){
    document.getElementById("DivModalDeleteContact").style.display = "block";
}
function HideModalDeleteContact(){
    document.getElementById("DivModalDeleteContact").style.display = "none";
}


// Table Function
function run(event, sender){

    var cells;
    event = event || window.event; 
    var target = event.target || event.srcElement;
    while (target && target.nodeName != 'TR') {
        target = target.parentElement;
    }

    cells = target.cells;
    if (!cells.length || target.parentNode.nodeName == 'THEAD') {
        return;
    }

    if(sender == "Fee"){

        FeeInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML];
        FillFeeData();
    }
    if(sender == "Dates"){
        DatesInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML];
    }
    if(sender == "Contact"){
        ContactInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML];
    }
}

//MISC

function FillFeeData(){
    document.getElementById("EditFeeID").value = FeeInfo[0];
    document.getElementById("EditFeeName").value = FeeInfo[1];
    document.getElementById("EditFeeAmount").value = FeeInfo[3];
    document.getElementById("EditFeeStatus").value = FeeInfo[2];
    document.getElementById("EditFeeDescription").value = FeeInfo[4];

    document.getElementById("OldFeeID").value = FeeInfo[0];
    document.getElementById("OldFeeName").value = FeeInfo[1];
    document.getElementById("OldFeeAmount").value = FeeInfo[3];

    document.getElementById("DeleteFeeID").value = FeeInfo[0];
}