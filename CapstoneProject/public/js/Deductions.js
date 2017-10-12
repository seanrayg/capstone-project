var OldDeduction = 0;

function ShowModalAddDeduction(){
    document.getElementById("DivModalAddDeduction").style.display = "block";
}
function HideModalAddDeduction(){
    document.getElementById("DivModalAddDeduction").style.display = "none";
}
function ShowModalEditDeduction(PaymentID, Remarks, Amount){
    document.getElementById("EditRemarks").value = Remarks;
    document.getElementById("EditDeductAmount").value = Amount;
    document.getElementById("EditPaymentID").value = PaymentID;
    OldDeduction = Amount;
    document.getElementById("DivModalEditDeduction").style.display = "block";
}
function HideModalEditDeduction(){
    document.getElementById("DivModalEditDeduction").style.display = "none";
}
function ShowModalDeleteDeduction(PaymentID){
    document.getElementById("DeletePaymentID").value = PaymentID;
    document.getElementById("DivModalDeleteDeduction").style.display = "block";
}
function HideModalDeleteDeduction(){
    document.getElementById("DivModalDeleteDeduction").style.display = "none";
}


function SendValidateInput(field, dataType, holder, sender){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        var TotalBill = 0;
        var Amount = parseInt(field.value);
        if(sender == "Add"){
            TotalBill = parseInt(document.getElementById("h-TotalBill").value) + parseInt(OldDeduction);
        }
        else if(sender == "Edit"){
            TotalBill = parseInt(document.getElementById("h-TotalBill").value) + parseInt(OldDeduction);
        }

        if(!(TotalBill >= Amount)){
            $(holder).addClass('has-warning');
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="Amount to be deducted exceeds customer's total bill";
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
}
