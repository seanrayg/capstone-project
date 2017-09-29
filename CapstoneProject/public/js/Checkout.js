function SendInput(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    
    if(!($(holder).hasClass('has-warning'))){
        var Total = parseInt(document.getElementById("PayTotal").value);
        var Payment = parseInt(field.value);
        var Change = Payment - Total;
        if(Change < 0){
            document.getElementById("PayChange").value = "Insufficient Payment";
        }
        else{
            document.getElementById("PayChange").value = Change;
        }
    }
}
