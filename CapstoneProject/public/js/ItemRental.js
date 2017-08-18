var RentItemInfo = [];
var ReturnItemInfo = [];

/*------------- RENT ITEM ------------------*/
function ShowModalRentItem(){
    document.getElementById("DivModalRentItem").style.display = "block";
}

function HideModalRentItem(){
    document.getElementById("DivModalRentItem").style.display = "none";
}

function ShowModalReturnItem(){
    var TableChecker = CheckTable('#tblReturnItem tr');
    
    if(TableChecker){
        document.getElementById("ReturnItemName").value = ReturnItemInfo[0];
        document.getElementById("ReturnGuestName").value = ReturnItemInfo[1];
        document.getElementById("ReturnRentalStatus").value = ReturnItemInfo[5];
        document.getElementById("ReturnExcessTime").value = ReturnItemInfo[6];
        document.getElementById("ReturnItemRate").value = ReturnItemInfo[7];
        document.getElementById("ReturnItemID").value = ReturnItemInfo[8];
        document.getElementById("ReturnReservationID").value = ReturnItemInfo[9];
        document.getElementById("ReturnRentedItemID").value = ReturnItemInfo[10];
        document.getElementById("ReturnTotalQuantity").value = ReturnItemInfo[4];
        
        var ExcessTime = ReturnItemInfo[6].split(" ");
        var SuggestedPenalty = (parseInt(ExcessTime[0]) * parseInt(ReturnItemInfo[7])) * parseInt(ReturnItemInfo[4]);
        SuggestedPenalty += ((parseInt(ExcessTime[2]) / 60) * parseInt(ReturnItemInfo[7])) * parseInt(ReturnItemInfo[4]);
        
        SuggestedPenalty = Math.ceil(SuggestedPenalty);
       
        document.getElementById('ReturnTimePenalty').placeholder = "Suggested penalty is PHP" + SuggestedPenalty;
        
        if(ReturnItemInfo[6] != "None"){
            document.getElementById("DivExcessTime").style.display = "block";
        }
        else{
            document.getElementById("DivExcessTime").style.display = "none";
        }
        document.getElementById("DivModalReturnItem").style.display = "block";
    }
    
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
    if(sender == "Return"){
        ReturnItemInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML, cells[7].innerHTML, cells[8].innerHTML, cells[9].innerHTML, cells[10].innerHTML];
        
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
    if(!($('.form-group').hasClass('has-warning'))){
        var QuantityLeft = parseInt(document.getElementById("RentQuantityLeft").value);
        if(parseInt(QuantityLeft) < parseInt(field.value)){
            $(holder).addClass('has-warning');
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="Invalid input!";
            }
        }
        else{
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="";
            }
        }
    }
}


/*------------------ RETURN ITEM ---------------*/

//Div Broken/lost controller
function ControlBrokenContent(){
    if(document.getElementById("ReturnItemStatus").value != "Good"){
        document.getElementById("DivBrokenItem").style.display = "block";
    }
    else{
        document.getElementById("ReturnBrokenQuantity").value = "0";
        document.getElementById("ReturnBrokenPenalty").value = "0";
        document.getElementById("DivBrokenItem").style.display = "none";
    }
}

function SendQuantityReturn(field, dataType, holder){
    var QuantityLeft = ReturnItemInfo[4];
    if(!(parseInt(QuantityLeft) >= parseInt(field.value))){
        $(holder).addClass('has-warning');
        var x = document.getElementsByClassName("ErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="Invalid input!";
        }
    }
    else{
        $(holder).removeClass('has-warning');
        var x = document.getElementsByClassName("ErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="";
        }
        ValidateInput(field, dataType, holder);
    }

}

//on submit return form
function CheckReturnForm(){
    if(!($('.form-group').hasClass('has-warning'))){
        if(ReturnItemInfo[6] == "None"){
            document.getElementById("ReturnTimePenalty").value = "0";
        }

        
        return true;
    }
    else{
        return false;
    }
}

