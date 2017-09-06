var AvailActivityInfo = [];

/*------------ MODAL CONTROLLER ----------*/

function ShowModalAvailActivity(){
    document.getElementById("DivModalAvailActivity").style.display = "block";
}

function HideModalAvailActivity(){
    document.getElementById("DivModalAvailActivity").style.display = "none";
}

function ShowModalActivityDone(){
    document.getElementById("DivModalActivityDone").style.display = "block";
}

function HideModalActivityDone(){
    document.getElementById("DivModalActivityDone").style.display = "none";
}

function ShowModalAvailPackagedActivity(){
    document.getElementById("DivModalAvailPackagedActivity").style.display = "block";
}

function HideModalAvailPackagedActivity(){
    document.getElementById("DivModalAvailPackagedActivity").style.display = "none";
}


function ShowModalAvailableBoat(){
    if(!($('#AvailGuestQuantityError').hasClass('has-warning'))){
        if(document.getElementById("AvailGuestQuantity").value != "0"){
            var input, filter, table, tr, td, i;
            input = document.getElementById("AvailGuestQuantity");
            filter = input.value.toUpperCase();
            table = document.getElementById("tblAvailBoat");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                  if (parseInt(td.innerHTML) >= parseInt(filter)) {
                    tr[i].style.display = "";
                  } else {
                    tr[i].style.display = "none";
                  }
                }       
            }
            document.getElementById("DivModalAvailableBoat").style.display = "block";
        }
    }
}

function HideModalAvailableBoat(){
    document.getElementById("DivModalAvailableBoat").style.display = "none";
}

function ShowModalPayActivity(){
    if(!($('.form-group').hasClass('has-warning'))){
        if(document.getElementById("AvailBoat").value != "Please avail a boat"){
            var DurationTime = document.getElementById("DurationTime").value;
            var DurationMinute = document.getElementById("DurationMinute").value;
            if(DurationTime == "0" && DurationMinute == "00"){
                
            }
            else{
                document.getElementById("PayActivityID").value = AvailActivityInfo[0];
                document.getElementById("PayReservationID").value = document.getElementById("AvailCustomerName").value;
                document.getElementById("PayLandQuantity").value = document.getElementById("AvailLandQuantity").value;
                document.getElementById("PayLandActivityRate").value = document.getElementById("LandActivityRate").value;
                document.getElementById("PayWaterActivityRate").value = AvailActivityInfo[2];
                document.getElementById("PayDurationTime").value = document.getElementById("DurationTime").value;
                document.getElementById("PayDurationMinute").value = document.getElementById("DurationMinute").value;
                document.getElementById("PayAvailBoat").value = document.getElementById("AvailBoat").value;
                if(AvailActivityInfo[3] == "Yes"){
                    document.getElementById("PayActivityType").value = "Water";
                    document.getElementById("ActivityTotalPrice").value = document.getElementById("PayWaterActivityRate").value;
                }
                else{
                    document.getElementById("PayActivityType").value = "Land";
                    document.getElementById("ActivityTotalPrice").value = document.getElementById("PayLandActivityRate").value;
                }

                document.getElementById("DivModalPayActivity").style.display = "block";
            }
        }
    }
}

function HideModalPayActivity(){
    document.getElementById("DivModalPayActivity").style.display = "none";
}

/*--------- MISC ----------*/

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

    if(sender == "Avail"){
        AvailActivityInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML];
        fillAvailActivity();
    }
    
    else if(sender == "Done"){
        DoneActivityInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML];
        fillDoneActivity();
    }

}


/*----------- AVAIL ACTIVITY ------------*/

function fillAvailActivity(){
    document.getElementById("AvailActivityForm").reset();
    document.getElementById("AvailActivityName").value = AvailActivityInfo[1];
    document.getElementById("AvailActivityID").value = AvailActivityInfo[0];
    if(AvailActivityInfo[3] == "Yes"){
        document.getElementById("AvailActivityType").value = "Water";
        document.getElementById("DivLandActivity").style.display = "none";
        document.getElementById("DivWaterActivity").style.display = "block";
    }
    else{
        document.getElementById("AvailActivityType").value = "Land";
        
        document.getElementById("DivLandActivity").style.display = "block";
        document.getElementById("DivWaterActivity").style.display = "none";
    }
}

function SendGuestInput(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($('#AvailGuestQuantityError').hasClass('has-warning'))){
        document.getElementById("AvailBoat").value = "Please choose a boat";
    }
}

function ChooseBoat(field){
    document.getElementById("AvailBoat").value = field;
    HideModalAvailableBoat();
}

function CheckAvailForm(){
    if(!($('.form-group').hasClass('has-warning'))){
        if(document.getElementById("AvailBoat").value != "Please avail a boat"){
            var DurationTime = document.getElementById("DurationTime").value;
            var DurationMinute = document.getElementById("DurationMinute").value;
            if(DurationTime == "0" && DurationMinute == "00"){
                return false;
            }
            else{
                if(AvailActivityInfo[3] == "Yes"){
                    document.getElementById("AvailActivityTotalPrice").value = AvailActivityInfo[2];
                }
                else{
                    document.getElementById("AvailActivityTotalPrice").value = document.getElementById("LandActivityRate").value;
                }
                return true;
            }
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}

function ComputePrice(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        var ActivityRate = parseInt(AvailActivityInfo[2]);
        var ActivityQuantity = parseInt(document.getElementById("AvailLandQuantity").value);
        document.getElementById("LandActivityRate").value = ActivityRate * ActivityQuantity;
    }
}

function SendPayment(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        
        var ActivityTotal = parseInt(document.getElementById("ActivityTotalPrice").value);
        var ActivityPayment = parseInt(field.value);
        var Change = ActivityPayment - ActivityTotal;
        if(Change < 0){
            document.getElementById("ActivityChange").value = "Insufficient Payment";
        }
        else{
            document.getElementById("ActivityChange").value = Change;
        }
        
    }
}

/*-------- ACTIVITY DONE -----------*/

function fillDoneActivity(){
    document.getElementById("DoneBoatSchedID").value = DoneActivityInfo[5];
}

function SubmitActivityForm(){
    document.getElementById("FormDoneActivity").submit();
}