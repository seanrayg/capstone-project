var AvailActivityInfo = [];

/*------------ MODAL CONTROLLER ----------*/

function ShowModalAvailActivityPackage(ActivityName, CustomerName, ActivityQuantity, ActivityType, ActivityID, ReservationID){
    document.getElementById("PackageReservationID").value = ReservationID;
    document.getElementById("PackageActivityID").value = ActivityID;
    document.getElementById("PackageActivityType").value = ActivityType;
    document.getElementById("PackageQuantityIncluded").value = ActivityQuantity;
    document.getElementById("PackageActivityName").value = ActivityName;
    document.getElementById("PackageCustomerName").value = CustomerName;
    if(ActivityType == 1){
        document.getElementById("DivPackageWaterActivity").style.display = "block";
    }
    else{
        document.getElementById("DivPackageWaterActivity").style.display = "none";
    }
    document.getElementById("DivModalAvailActivityPackage").style.display = "block";
}

function HideModalAvailActivityPackage(){
    document.getElementById("DivModalAvailActivityPackage").style.display = "none";
}

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


function ShowModalAvailableBoat(sender){
    if(sender == "Package"){
        if(!($('#PackageGuestQuantityError').hasClass('has-warning'))){
            if(document.getElementById("PackageGuestQuantity").value != "0"){
                var input, filter, table, tr, td, i;
                input = document.getElementById("PackageGuestQuantity");
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
        document.getElementById("DivModalAvailableBoat").style.display = "block";
    }
    else{
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

function ValidatePackageQuantity(field, dataType, holder){
    if(!($(holder).hasClass('has-warning'))){
        var IncludedQuantity = document.getElementById("PackageQuantityIncluded").value;
        if(parseInt(field.value) > parseInt(IncludedQuantity)){
            $(holder).addClass('has-warning');
            document.getElementById("PackageError").innerHTML = "Quantity to avail exceeds quantity included in the package!";
        }
        else{
            $(holder).removeClass('has-warning');
            document.getElementById("PackageError").innerHTML = "";
        }
    }
}

function SendGuestPackageInput(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($('#PackageGuestQuantityError').hasClass('has-warning'))){
        document.getElementById("PackageAvailBoat").value = "Please choose a boat";
    }
}

function ChooseBoat(field){
    document.getElementById("AvailBoat").value = field;
    document.getElementById("PackageAvailBoat").value = field;
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

function CheckAvailPackageForm(){
    if(!($('.form-group').hasClass('has-warning'))){
        if(document.getElementById("PackageAvailBoat").value != "Please avail a boat"){
            var DurationTime = document.getElementById("PackageDurationTime").value;
            var DurationMinute = document.getElementById("PackageDurationMinute").value;
            if(DurationTime == "0" && DurationMinute == "00"){
                return false;
            }
            else{
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