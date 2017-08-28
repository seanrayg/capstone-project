var RentItemInfo = [];
var ReturnItemInfo = [];
var BrokenItemInfo = [];


/*----------- MODAL CONTROLLER ------------*/

function ShowModalRentItem(){
    document.getElementById("DivModalRentItem").style.display = "block";
}

function HideModalRentItem(){
    document.getElementById("DivModalRentItem").style.display = "none";
}

function ShowModalReturnItem(){
    var TableChecker = CheckTable('#tblReturnItem tr');
    HideModalUndertime();
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

        if(ReturnItemInfo[6] != "None"){
            document.getElementById("DivExcessTime").style.display = "block";
        }
        else{
            document.getElementById("btnReturnOut").innerHTML = "Return Item";
            document.getElementById("btnReturnNow").style.display = "none";
            document.getElementById("DivExcessTime").style.display = "none";
        }
        document.getElementById("DivModalReturnItem").style.display = "block";
    }
    
}

function HideModalReturnItem(){
    document.getElementById("DivModalReturnItem").style.display = "none";
}

function ShowModalExtendRent(){
    var TableChecker = CheckTable('#tblReturnItem tr');
    if(TableChecker){
        document.getElementById("ExtendItemName").value = ReturnItemInfo[0];
        document.getElementById("ExtendGuestName").value = ReturnItemInfo[1];
        document.getElementById("ExtendItemID").value = ReturnItemInfo[8];
        document.getElementById("ExtendReservationID").value = ReturnItemInfo[9];
        document.getElementById("ExtendRentedItemID").value = ReturnItemInfo[10];
        document.getElementById("ExtendTotalQuantity").value = ReturnItemInfo[4];
        
        document.getElementById("DivModalExtendRent").style.display = "block";
    }
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

function ShowModalUndertime(){
    var TableChecker = CheckTable('#tblReturnItem tr');
    if(TableChecker){
        if(ReturnItemInfo[5] != "Overtime"){
            document.getElementById("DivModalUndertime").style.display = "block";
        }
        else{
            ShowModalReturnItem();
            document.getElementById("DivExcessTime").style.display = "block";
        }
        
    }
}

function HideModalUndertime(){
    document.getElementById("DivModalUndertime").style.display = "none";
}

function ShowModalRestoreItem(){
    var TableChecker = CheckTable('#tblBrokenItem tr');
    if(TableChecker){
        document.getElementById("BrokenItemName").value = BrokenItemInfo[0];
        document.getElementById("BrokenItemQuantity").value = BrokenItemInfo[2];
        document.getElementById("BrokenItemID").value = BrokenItemInfo[4];
        document.getElementById("BrokenReservationID").value = BrokenItemInfo[5];
        document.getElementById("BrokenRentedItemID").value = BrokenItemInfo[6];
        document.getElementById("DivModalRestoreItem").style.display = "block";    
    }
}

function HideModalRestoreItem(){
        document.getElementById("DivModalRestoreItem").style.display = "none";
}

function ShowModalDeleteItem(){
    var TableChecker = CheckTable('#tblBrokenItem tr');
    if(TableChecker){
        document.getElementById("DeleteItemName").value = BrokenItemInfo[0];
        document.getElementById("DeleteItemQuantity").value = BrokenItemInfo[2];
        document.getElementById("DeleteItemID").value = BrokenItemInfo[4];
        document.getElementById("DeleteReservationID").value = BrokenItemInfo[5];
        document.getElementById("DeleteRentedItemID").value = BrokenItemInfo[6];
        document.getElementById("DivModalDeleteItem").style.display = "block";
    }
}

function HideModalDeleteItem(){
        document.getElementById("DivModalDeleteItem").style.display = "none";
}

/*------------- RENT ITEM ------------------*/

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
    if(sender == "Broken"){
       BrokenItemInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML]; 
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
    if(holder == "#RentQuantityError"){
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
    
    if(document.getElementById("RentQuantity").value != "" && document.getElementById("RentDuration").value != ""){
        if(!($('.form-group').hasClass('has-warning'))){
            var RentQuantity = parseInt(document.getElementById("RentQuantity").value);
            var RentDuration = parseInt(document.getElementById("RentDuration").value);
            var ItemRate = parseFloat(RentItemInfo[3]);
            var TotalRentPrice = (RentQuantity * ItemRate) * RentDuration;
            document.getElementById("RentItemPrice").value = TotalRentPrice;
        }
        else{
            document.getElementById("RentItemPrice").value = "Please enter valid inputs";
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
    
    if(holder == "#ReturnQuantityError"){
        if(!($(holder).hasClass('has-warning'))){
            var ExcessTime = ReturnItemInfo[6].split(" ");
            var SuggestedPenalty = (parseInt(ExcessTime[0]) * parseInt(ReturnItemInfo[7])) * parseInt(field.value);
            SuggestedPenalty += ((parseInt(ExcessTime[2]) / 60) * parseInt(ReturnItemInfo[7])) * parseInt(field.value);

            SuggestedPenalty = Math.ceil(SuggestedPenalty);

            $("#ReturnTimePenalty").attr('title', "Suggested penalty is PHP" + SuggestedPenalty).tooltip('fixTitle').tooltip('show');
        }
        else{
            $("#ReturnTimePenalty").attr('title', "Please enter a valid quantity").tooltip('fixTitle').tooltip('show');
        }
    }
    
    var BrokenQuantity = parseInt(document.getElementById("ReturnBrokenQuantity").value);
    var ReturnQuantity = parseInt(document.getElementById("ReturnQuantityAvailed").value);
    
    if(((BrokenQuantity != 0) || (BrokenQuantity != null)) && ((ReturnQuantity != 0) || (ReturnQuantity != null))){
        if((!($('#ReturnBrokenQuantity').hasClass('has-warning'))) && (!($('#ReturnQuantityAvailed').hasClass('has-warning')))){
            if(BrokenQuantity > ReturnQuantity){
                $('#ReturnBrokenQuantity').addClass('has-warning');
                var x = document.getElementsByClassName("ErrorLabel");
                for(var i = 0; i < x.length; i++){
                    x[i].innerText="Input exceeds quantity of item to return";
                }
            }
            else{
                $('#ReturnBrokenQuantity').removeClass('has-warning');
                var x = document.getElementsByClassName("ErrorLabel");
                for(var i = 0; i < x.length; i++){
                    x[i].innerText="";
                }
            }
        }
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


/*-------------- RESTORE ITEM -------------*/

function SendQuantityRestore(field, dataType, holder){
    var QuantityBroken = BrokenItemInfo[2];
    if(!(parseInt(QuantityBroken) >= parseInt(field.value))){
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

/*----------- EXTEND ITEM ------------*/

function SendQuantityExtend(field, dataType, holder){
    if(holder == "#ExtendQuantityError"){
        var ItemQuantity = ReturnItemInfo[4];
        if(!(parseInt(ItemQuantity) >= parseInt(field.value))){
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
    else{
        ValidateInput(field, dataType, holder);
    }
    
    var ItemRate = parseFloat(ReturnItemInfo[7]);
    if(!($('.form-group').hasClass('has-warning'))){
        if(document.getElementById("ExtendQuantity").value != "" && document.getElementById("ExtendTime").value != ""){
            var ExtendQuantity = parseInt(document.getElementById("ExtendQuantity").value);
            var ExtendTime = parseInt(document.getElementById("ExtendTime").value);
            document.getElementById("ExtendPrice").value = (ExtendQuantity * ItemRate) * ExtendTime;
        }
    }
    else{
        document.getElementById("ExtendPrice").value = "Please enter valid values";
    }
    
}

