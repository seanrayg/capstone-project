var RentItemInfo = [];
var ReturnItemInfo = [];
var BrokenItemInfo = [];


/*----------- MODAL CONTROLLER ------------*/

function ShowModalRentPackageItem(ItemName, CustomerName, ItemQuantity, ItemDuration, QuantityLeft, ItemID, ReservationID){
 
    document.getElementById("RentPackageItemName").value = ItemName;
    document.getElementById("RentPackageItemID").value = ItemID;
    document.getElementById("RentPackageQuantityLeft").value = QuantityLeft;
    document.getElementById("RentPackageReservationID").value = ReservationID;
    document.getElementById("RentPackageCustomerName").value = CustomerName;
    document.getElementById("RentPackageQuantityIncluded").value = ItemQuantity;
    document.getElementById("RentPackageDuration").value = ItemDuration;
    document.getElementById("DivModalRentPackageItem").style.display = "block";
}

function HideModalRentPackageItem(){
    document.getElementById("DivModalRentPackageItem").style.display = "none";
}

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

function ShowModalRentPayNow(){
    document.getElementById("RentPayTotal").value = document.getElementById("RentItemPrice").value;
    document.getElementById("RentPayItemID").value = document.getElementById("RentItemID").value;
    document.getElementById("RentPayDuration").value = document.getElementById("RentDuration").value;
    document.getElementById("RentPayQuantity").value = document.getElementById("RentQuantity").value;
    document.getElementById("RentPayGuest").value = document.getElementById("SelectGuests").value;
    document.getElementById("DivModalRentPayNow").style.display = "block";
}

function HideModalRentPayNow(){
    document.getElementById("DivModalRentPayNow").style.display = "none";
}

function ShowModalReturnPayNow(){
    if(!($('.form-group').hasClass('has-warning'))){
        if(ReturnItemInfo[6] == "None"){
            document.getElementById("ReturnTimePenalty").value = "0";
        }
        var ExcessPenalty = 0;
        var BrokenPenalty = 0;
        if(document.getElementById("ReturnItemStatus").value != "Good"){
            BrokenPenalty = parseInt(document.getElementById("ReturnBrokenPenalty").value);
        }
        if(document.getElementById("ReturnRentalStatus").value == "Overtime"){
            ExcessPenalty = parseInt(document.getElementById("ReturnTimePenalty").value);
        }

        var TotalPayment = ExcessPenalty + BrokenPenalty;
        document.getElementById("ReturnPayTotal").value = TotalPayment;

        document.getElementById("ReturnPayItemName").value = ReturnItemInfo[0];
        document.getElementById("ReturnPayGuestName").value = ReturnItemInfo[1];
        document.getElementById("ReturnPayRentalStatus").value = ReturnItemInfo[5];
        document.getElementById("ReturnPayExcessTime").value = ReturnItemInfo[6];
        document.getElementById("ReturnPayItemRate").value = ReturnItemInfo[7];
        document.getElementById("ReturnPayItemID").value = ReturnItemInfo[8];
        document.getElementById("ReturnPayReservationID").value = ReturnItemInfo[9];
        document.getElementById("ReturnPayRentedItemID").value = ReturnItemInfo[10];
        document.getElementById("ReturnPayTotalQuantity").value = ReturnItemInfo[4];  

        document.getElementById("ReturnPayBrokenQuantity").value = document.getElementById("ReturnBrokenQuantity").value;
        document.getElementById("ReturnPayBrokenPenalty").value = document.getElementById("ReturnBrokenPenalty").value;

        document.getElementById("ReturnPayQuantityAvailed").value = document.getElementById("ReturnQuantityAvailed").value;
        document.getElementById("ReturnPayTimePenalty").value = document.getElementById("ReturnTimePenalty").value;

        document.getElementById("ReturnPayItemStatus").value = document.getElementById("ReturnItemStatus").value;

        document.getElementById("DivModalReturnPayNow").style.display = "block";
    }
}

function HideModalReturnPayNow(){
    document.getElementById("DivModalReturnPayNow").style.display = "none";
} 

function ShowModalExtendPayNow(){
    document.getElementById("ExtendPayItemName").value = ReturnItemInfo[0];
    document.getElementById("ExtendPayGuestName").value = ReturnItemInfo[1];
    document.getElementById("ExtendPayItemID").value = ReturnItemInfo[8];
    document.getElementById("ExtendPayReservationID").value = ReturnItemInfo[9];
    document.getElementById("ExtendPayRentedItemID").value = ReturnItemInfo[10];
    document.getElementById("ExtendPayTotalQuantity").value = ReturnItemInfo[4];
    document.getElementById("ExtendPayQuantity").value = document.getElementById("ExtendQuantity").value;
    document.getElementById("ExtendPayTime").value = document.getElementById("ExtendTime").value;
    
    document.getElementById("ExtendPayTotal").value = document.getElementById("ExtendPrice").value;
    document.getElementById("DivModalExtendPayNow").style.display = "block";
}

function HideModalExtendPayNow(){
    document.getElementById("DivModalExtendPayNow").style.display = "none";
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

//rent item payment
function SendPayment(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        
        var RentTotal = parseInt(document.getElementById("RentPayTotal").value);
        var RentPayment = parseInt(field.value);
        var Change = RentPayment - RentTotal;
        if(Change < 0){
            document.getElementById("RentPayChange").value = "Insufficient Payment";
        }
        else{
            document.getElementById("RentPayChange").value = Change;
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

function SendReturnPayment(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        
        var RentTotal = parseInt(document.getElementById("ReturnPayTotal").value);
        var RentPayment = parseInt(field.value);
        var Change = RentPayment - RentTotal;
        if(Change < 0){
            document.getElementById("ReturnPayChange").value = "Insufficient Payment";
        }
        else{
            document.getElementById("ReturnPayChange").value = Change;
        }
        
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

function SendExtendPayment(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        
        var RentTotal = parseInt(document.getElementById("ExtendPayTotal").value);
        var RentPayment = parseInt(field.value);
        var Change = RentPayment - RentTotal;
        if(Change < 0){
            document.getElementById("ExtendPayChange").value = "Insufficient Payment";
        }
        else{
            document.getElementById("ExtendPayChange").value = Change;
        }
        
    }
}


/*-------------- RENT PACKAGE ITEM ------------*/

function SendPackageQuantityInput(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    var InputError = false;
    if(!($(holder).hasClass('has-warning'))){
        var QuantityLeft = parseInt(document.getElementById("RentPackageQuantityLeft").value);
        if(parseInt(QuantityLeft) < parseInt(field.value)){
            InputError = true;
        }
        else{
            var QuantityIncluded = parseInt(document.getElementById("RentPackageQuantityIncluded").value);
            if(parseInt(QuantityIncluded) < parseInt(field.value)){
                InputError = true;
            }
        }
    }
    
    if(InputError){
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
    }
}

var CustomerID;

function PrintInvoice() {

    document.getElementByID("iCustomerID").value = CustomerID;
    document.getElementByID("iItemName").value = document.getElementByID("RentItemName").value;
    document.getElementByID("iItemQuantity").value = document.getElementByID("RentQuantity").value;
    document.getElementByID("iItemRate").value = document.getElementByID("RentItemRate").value;
    document.getElementByID("InvoiceForm").submit();

}

$(document).ready(function(){
    
    CustomerID = $('#SelectGuests').find(":selected").attr("id");

    $(function() {
      $('#SelectGuests').on('change',function() {

        CustomerID = $(this).children(":selected").attr("id");

      });
    });

});