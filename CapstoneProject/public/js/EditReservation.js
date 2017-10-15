var BoatsUsed = "";
var TotalCapacity = 0;
var AddRoomIndex;
var RemoveRowIndex;
var RemovedRows = "";
var SelectedRooms = "";
var ChosenRoomsData = "";
var AvailableRooms = [];
var ChosenRooms = [];
var tempTotal = 0;

var includeGuests = false;
var includeBoats = false;
var includeRooms = false;
var includeDate = false;

var guestSender = false;
var dateSender = false;

/*---------- Modal controller -------*/

function ShowModalReschedulePayment(TotalRoomAmount, OrigRoomAmount){
    document.getElementById("RescheduleAmount").innerHTML = "The total price of room(s) will be PHP" + TotalRoomAmount + " instead of " + OrigRoomAmount;
    document.getElementById("TotalRoomAmount").value = TotalRoomAmount;
    document.getElementById("OrigRoomAmount").value = OrigRoomAmount;
    document.getElementById("DivModalReschedulePayment").style.display = "block";
}

function HideModalReschedulePayment(){
    document.getElementById("DivModalReschedulePayment").style.display = "none";
}

function ShowModalAvailBoat(){
    document.getElementById("DivModalAvailBoat").style.display = "block";
}

function HideModalAvailBoat(){
    document.getElementById("DivModalAvailBoat").style.display = "none";
}

function ShowModalNoBoats(){
    document.getElementById("DivModalNoBoats").style.display = "block";
}

function HideModalNoBoats(){
    document.getElementById("DivModalNoBoats").style.display = "none";
    HideModalEditResInfo();
    ShowModalEditResDate();
}

function ShowModalMultipleBoats(){
    document.getElementById("DivModalMultipleBoats").style.display = "block";
}

function HideModalMultipleBoats(){
    document.getElementById("DivModalMultipleBoats").style.display = "none";
    HideModalEditResInfo();
    ShowModalEditResDate();
}

function ShowModalNoMultipleBoats(){
    document.getElementById("DivModalNoMultipleBoats").style.display = "block";
}

function HideModalNoMultipleBoats(){
    document.getElementById("DivModalNoMultipleBoats").style.display = "none";
    HideModalEditResInfo();
    ShowModalEditResDate();
}

function ShowModalEditResDate(){
    var tempArrivalDate = document.getElementById("h-CheckInDate").value;
    var tempDepartureDate = document.getElementById("h-CheckOutDate").value;
    var tempPickUpTime = document.getElementById("i-PickUpTime").innerHTML;
    
    var arrPickUpTime = tempPickUpTime.split(" ");
    var arrPickUpTime2 = arrPickUpTime[0].split(":");
    var arrArrivalDate = tempArrivalDate.split("/");
    var arrDepartureDate = tempDepartureDate.split("/");
    
    document.getElementById("SelectHour").value = arrPickUpTime2[0];
    document.getElementById("SelectMinute").value = arrPickUpTime2[1];
    document.getElementById("SelectMerridean").value = arrPickUpTime[1];
    $('#CheckInDate').datepicker('setValue', arrArrivalDate[1] + "/" + arrArrivalDate[2] + "/" + arrArrivalDate[0]);
    $('#CheckOutDate').datepicker('setValue', arrDepartureDate[1] + "/" + arrDepartureDate[2] + "/" + arrDepartureDate[0]);

    document.getElementById("DivModalEditResDate").style.display = "block";
}

function HideModalEditResDate(){
    document.getElementById("DivModalEditResDate").style.display = "none";
}

function ShowModalEditResRoom(sender){
    
    document.getElementById("ErrorMessage").innerHTML = "";
    document.getElementById("btnEditReschedRooms").style.display = "none";
    
    if(sender != "date"){
        if ($('#tblChosenRooms tbody').is(':empty')){
            var arrChosenRooms = ChosenRoomsData.split(",");
            for(var x = 0; x < arrChosenRooms.length; x++){
                var arrTempRooms = arrChosenRooms[x].split("-");
                
                var tableRef = document.getElementById('tblChosenRooms').getElementsByTagName('tbody')[0];
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3  = newRow.insertCell(2);
                var newCell4 = newRow.insertCell(3);

                newCell1.innerHTML = arrTempRooms[0];
                newCell2.innerHTML = arrTempRooms[1];
                newCell3.innerHTML = arrTempRooms[2];
                newCell4.innerHTML = arrTempRooms[3];
            }
        }
    }
    
    
    if(sender == "guest"){
        HideModalEditResInfo();
        if(!includeGuests){
            document.getElementById("TotalGuests").innerHTML = parseInt(document.getElementById("i-NoOfAdults").value) + parseInt(document.getElementById("i-NoOfKids").value);
        }
        else{
            document.getElementById("TotalGuests").innerHTML = parseInt(document.getElementById("NoOfAdults").value) + parseInt(document.getElementById("NoOfKids").value);
        }
    }
    
    if(sender == "date"){
        HideModalEditResDate();
        
        SelectedRooms = "";
        ChosenRoomsData = "";
        
        var ChosenRooms = document.getElementById('tblChosenRooms'), cellsChosenRoom = ChosenRooms.getElementsByTagName('td');

        var ChosenRoomsCells = (document.getElementById('tblChosenRooms').getElementsByTagName("tr").length - 1) * 4;


        //Reserved rooms info
        for(var i = 0; i < ChosenRoomsCells; i += 4){
          SelectedRooms += cellsChosenRoom[i].innerHTML + ",";
          ChosenRoomsData += cellsChosenRoom[i].innerHTML + "-" + cellsChosenRoom[i + 1].innerHTML + "-" + cellsChosenRoom[i + 2].innerHTML + "-" + cellsChosenRoom[i + 3].innerHTML ;

          if(!(i == (ChosenRoomsCells - 4))){
              ChosenRoomsData += ",";
          }

        }
        
        $('#tblChosenRooms tbody').empty();
        document.getElementById("TotalGuests").innerHTML = parseInt(document.getElementById("NoOfAdults").value) + parseInt(document.getElementById("NoOfKids").value);
    }
    
    
    tempTotal = 0;
    $("#tblChosenRooms tr").each(function(){
           if($(this).find("td:nth-child(2)").text() != "" && $(this).find("td:nth-child(4)").text() != ""){
              tempTotal += parseInt($(this).find("td:nth-child(2)").text()) * parseInt($(this).find("td:nth-child(4)").text()); 
           }
    });
    
    document.getElementById("TotalCapacity").innerHTML = tempTotal;
    document.getElementById("DivModalEditResRoom").style.display = "block";
}

function HideModalEditResRoom(){
    document.getElementById("DivModalEditResRoom").style.display = "none";
}

function ShowModalEditResInfo(){
    document.getElementById("NoOfAdults").value = document.getElementById("i-NoOfAdults").value;
    document.getElementById("NoOfKids").value = document.getElementById("i-NoOfKids").value;
    document.getElementById("InfoError").innerHTML = "";
    document.getElementById("btnEditRooms").style.display = "none";
    document.getElementById("DivModalEditResInfo").style.display = "block";
}

function HideModalEditResInfo(){
    document.getElementById("DivModalEditResInfo").style.display = "none";
}





/*--------- Reservation Info ----------*/

//Checks form
function CheckInfo(){
    var InputChecker = CheckForm();
    if(InputChecker){
        document.getElementById("InfoError").innerHTML = "";
        includeRooms = false;
        includeGuests = false;
        includeBoats = false;
        $.ajax({
            type:'get',
            url:'/Reservation/Info',
            data:{id:document.getElementById("info-ReservationID").value},
            success:function(data){
                var RoomCapacityError = false;
                var BoatCapacityError = false;
                var TotalRoomCapacity = 0;
                var TotalBoatCapacity = 0;
                var TotalGuests = parseInt(document.getElementById("NoOfAdults").value) + parseInt(document.getElementById("NoOfKids").value);

                for(var x = 0; x < data.ChosenRooms.length; x++){
                    TotalRoomCapacity += parseInt(data.ChosenRooms[x].intRoomTCapacity) * parseInt(data.ChosenRooms[x].TotalRooms);
                }

                for(var x = 0; x < data.ChosenBoats.length; x++){
                    TotalBoatCapacity += parseInt(data.ChosenBoats[x].intBoatCapacity);
                }
                
                
                if(!(TotalRoomCapacity >= TotalGuests)){
                    document.getElementById("InfoError").innerHTML += "Total number of guests exceeds total room capacity!" + "<br />";
                    RoomCapacityError = true;
                }
                
                if(!(TotalBoatCapacity >= TotalGuests) && (TotalBoatCapacity != 0)){
                    document.getElementById("InfoError").innerHTML += "Total number of guests exceeds total boat capacity!" + "<br />";
                    BoatCapacityError = true;
                }
                if(!RoomCapacityError && !BoatCapacityError){
                    document.getElementById("InfoError").innerHTML = "";
                    if(TotalBoatCapacity != 0){
                        getAvailableBoats("guests");
                    }
                    saveReservationInfo();      
                }
                else{
                    if(BoatCapacityError && !RoomCapacityError){
                        ShowModalAvailBoat();
                        $('#BtnAvailBoat').unbind("click").click(function () {
                            if (this.id == 'BtnAvailBoat') {
                                includeRooms = false;
                                HideModalAvailBoat();
                                getAvailableBoats("guests");
                            }
                        });
                        $('#BtnAvailNoBoat').unbind("click").click(function () {
                            if (this.id == 'BtnAvailNoBoat') {
                                HideModalAvailBoat();
                                //saveBoats('WithoutBoats');
                            }
                        });
                    }
                    else if(RoomCapacityError && !BoatCapacityError){
                        document.getElementById("btnEditRooms").style.display = "block";              
                    }
                    else if(BoatCapacityError && RoomCapacityError){
                        ShowModalAvailBoat();
                        $('#BtnAvailBoat').unbind("click").click(function(){
                            if (this.id == 'BtnAvailBoat') {
                                includeRooms = true;
                                HideModalAvailBoat();
                                getAvailableBoats("guests");
                            }
                        });
                        $('#BtnAvailNoBoat').unbind("click").click(function(){
                            if (this.id == 'BtnAvailNoBoat') {
                                HideModalAvailBoat();
                                includeGuests = true;
                                ShowModalEditResRoom("guest");
                            }
                        });
                    }
                }

            },
            error:function(response){
                console.log(response);
                alert(response.status);
            }
        });  
    }
}

function btnEditRoomsListener(){
    includeGuests = true;
    ShowModalEditResRoom("guest");
}

//submit form
function saveReservationInfo(){
    guestSender = false;
    dateSender = false;
    document.getElementById("info-BoatsUsed").value = BoatsUsed;
    var PickUpTime = "";
    var tempPickUpTime = document.getElementById("i-PickUpTime").innerHTML;
    var arrPickUpTime = tempPickUpTime.split(" ");
    
    if(arrPickUpTime[1]=="AM"){
        PickUpTime = arrPickUpTime[0];
    }
    else{
        var arrPickUpTime2 = arrPickUpTime[0].split(":");
        PickUpTime = (parseInt(arrPickUpTime2[0]) + 12)+":"+arrPickUpTime2[1]+":"+arrPickUpTime2[2];
    }

    document.getElementById("info-PickUpTime").value = PickUpTime;
    includeBoats = true;
    if(includeRooms){
        includeGuests = true;
        ShowModalEditResRoom("guest");
    }
    else{
        document.getElementById("frmEditReservationInfo").submit();
    }
}

//available boats ajax
function getAvailableBoats(sender){
    var ReservationID = document.getElementById("info-ReservationID").value;
    if(sender == "guests"){
        guestSender = true;
        dateSender = false;
        var CheckInDate = document.getElementById("h-CheckInDate").value;
        var CheckOutDate = document.getElementById("h-CheckOutDate").value;

        var NoOfKids = document.getElementById("NoOfKids").value;
        var NoOfAdults = document.getElementById("NoOfAdults").value;
        var TotalGuests = parseInt(NoOfAdults) + parseInt(NoOfKids);
        var PickUpTime = "";
        var tempPickUpTime = document.getElementById("i-PickUpTime").innerHTML;
        var arrPickUpTime = tempPickUpTime.split(" ");

        if(arrPickUpTime[1]=="AM"){
            PickUpTime = arrPickUpTime[0];
        }
        else{
            var arrPickUpTime2 = arrPickUpTime[0].split(":");
            PickUpTime = (parseInt(arrPickUpTime2[0]) + 12)+":"+arrPickUpTime2[1]+":"+arrPickUpTime2[2];
        }

        document.getElementById("info-PickUpTime").value = PickUpTime;
    }
    if(sender == "date"){
        dateSender = true;
        guestSender = false;
        var CheckInDate = document.getElementById("CheckInDate").value;
        var CheckOutDate = document.getElementById("CheckOutDate").value;
        var TotalGuests = parseInt(document.getElementById("i-NoOfAdults").value) + parseInt(document.getElementById("i-NoOfKids").value);
        var tempHour = document.getElementById("SelectHour");
        var tempMinute = document.getElementById("SelectMinute");
        var tempMerridean = document.getElementById("SelectMerridean");
        var ChosenHour;
        
        if(tempMerridean.value == "PM"){
          ChosenHour = parseInt(tempHour.value) + 12;
        }
        else{
          ChosenHour = tempHour.value;
        }
        
        var PickUpTime = ChosenHour + ":" + tempMinute.value + ":00";
    }
    

    $.ajax({
        type:'get',
        url:'/Reservation/Info/EditBoat',
        data:{CheckInDate:CheckInDate,
              CheckOutDate:CheckOutDate,
              TotalGuests:TotalGuests,
              PickUpTime:PickUpTime,
              ReservationID:ReservationID},
        success:function(data){
            alert(data.length);
            processBoat(data, TotalGuests, sender);
        },
        error:function(response){
            console.log(response);
            alert(response.status);
        }
    });   
}

//boat modals
function processBoat(data, TotalGuests, sender){
    BoatList = data;
    var BoatFound = false;
    var MultipleBoatsFound = false;
    if(data.length != 0){
        BoatsUsed = "";
        for(var x=0; x<data.length; x++){
            if(TotalGuests <= data[x].intBoatCapacity){
                BoatFound = true;
                BoatsUsed += data[x].strBoatName + ",";
                break;
            }
        }
        if(!BoatFound){
            ShowModalMultipleBoats();
            $('#BtnMultipleBoats, #BtnWithoutBoats2').unbind("click").click(function () {
                if (this.id == 'BtnMultipleBoats') {
                    HideModalMultipleBoats();
                    BoatsUsed = "";
                    TotalCapacity = 0;
                    MultipleBoatsFound = false;
                    if(sender == "guests"){
                        var NoOfKids = document.getElementById("NoOfKids").value;
                        var NoOfAdults = document.getElementById("NoOfAdults").value;
                        var TotalGuests2 = parseInt(NoOfAdults) + parseInt(NoOfKids);
                    }
                    if(sender == "date"){
                        var NoOfKids = document.getElementById("i-NoOfKids").value;
                        var NoOfAdults = document.getElementById("i-NoOfAdults").value;
                        var TotalGuests2 = parseInt(NoOfAdults) + parseInt(NoOfKids);
                    }
                    
                    for(var x=(data.length-1); x>=0; x--){
                        TotalCapacity += parseInt(data[x].intBoatCapacity);
                        BoatsUsed += data[x].strBoatName + ",";
                        if(TotalGuests2 <= TotalCapacity){
                            MultipleBoatsFound = true;
                            break;
                        }
                        else{
                            MultipleBoatsFound = false;
                        }
                    }
                    if(!MultipleBoatsFound){
                        ShowModalNoMultipleBoats();
                        $('#BtnWithoutBoats3').unbind("click").click(function () {
                            if (this.id == 'BtnWithoutBoats3') {
                                HideModalNoMultipleBoats();
                                saveBoats('WithoutBoats');
                            }
                        });
                    }//!Multiple Boats found
                    else{
                        alert(TotalGuests2);
                        saveBoats('WithBoats');
                    }
                }//Button Avail Multiple Boats
                else if (this.id == 'BtnWithoutBoats2') {
                    HideModalMultipleBoats();
                    saveBoats('WithoutBoats');
                }
            });
        }//!BoatFound
        else{
            saveBoats('WithBoats');
        }
    }//data length != 0*/
    else{
        ShowModalNoBoats();
        $('#BtnWithoutBoats1').unbind("click").click(function () {
            if (this.id == 'BtnWithoutBoats1') {
                HideModalNoBoats();
                saveBoats('WithoutBoats');
            }
        });
    }

}

//save new boats
function saveBoats(GuestChoice){
    if(GuestChoice == "WithoutBoats"){
        BoatsUsed = "";
    }
    if(guestSender){
        saveReservationInfo();
    }
    if(dateSender){
        includeBoats = true;
        RescheduleReservation();
    }
}



/*------- Reservation Room -----------*/


//Table row clicked
$(document).ready(function(){
    $('#tblAvailableRooms').on('click', 'tbody tr', function(){
        HighlightRow(this);
        AddRowIndex = $(this).index();
        $('#TotalRoomsError').removeClass('has-warning');
    });
    
    $('#tblChosenRooms').on('click', 'tbody tr', function(){
        HighlightRow(this);
        RemoveRowIndex = $(this).index();
        document.getElementById("TotalRemoveRooms").value = "";
        document.getElementById("RemoveRoomError").innerHTML = "";
        $('#RemoveRoomsError').removeClass('has-warning');
    });
    
});

//add room
function AddRoom(){
    var TotalRooms = document.getElementById("TotalRooms").value;
    var TableChecker = CheckTable('#tblAvailableRooms tr');
    if(TableChecker){
        document.getElementById("AddRoomError").innerHTML = "";
        if(TotalRooms == ""){
            $('#TotalRoomsError').addClass('has-warning');
            document.getElementById("AddRoomError").innerHTML = "Please specify the number of rooms to avail";
        }
        else if(parseInt(TotalRooms) > parseInt(AvailableRooms[3])){
           $('#TotalRoomsError').addClass('has-warning');
            document.getElementById("AddRoomError").innerHTML = "Room quantity exceeded!";
        }
        else if(!($('#TotalRoomsError').hasClass('has-warning'))){
            var boolAddRoom = false;
 
            $("#tblChosenRooms tr").each(function(){
                   if($(this).find("td:first").text() == AvailableRooms[0]){
                       var temp = parseInt($(this).find("td:nth-child(4)").text()) + parseInt(TotalRooms); 
                       $(this).find("td:nth-child(4)").text(temp);
                       boolAddRoom = false;
                       tempTotal += parseInt(AvailableRooms[1]) * parseInt(TotalRooms);
                       return false;
                   }
                   else{
                       boolAddRoom = true;
                   }
            });
            
            if(boolAddRoom){
                var tableRef = document.getElementById('tblChosenRooms').getElementsByTagName('tbody')[0];
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3  = newRow.insertCell(2);
                var newCell4 = newRow.insertCell(3);

                newCell1.innerHTML = AvailableRooms[0];
                newCell2.innerHTML = AvailableRooms[1];
                newCell3.innerHTML = AvailableRooms[2];
                newCell4.innerHTML = TotalRooms;
                
                tempTotal += parseInt(AvailableRooms[1]) * parseInt(TotalRooms);
            }
            
            $("#tblAvailableRooms tr").each(function(){
                   if($(this).find("td:first").text() == AvailableRooms[0]){
                       var temp = parseInt($(this).find("td:nth-child(4)").text()) - parseInt(TotalRooms);
                       if(temp == 0){
                           document.getElementById("tblAvailableRooms").deleteRow(AddRowIndex+1);
                       }
                       else{
                           $(this).find("td:nth-child(4)").text(temp);
                       }
                       return false;
                   }
            });
            
            document.getElementById("TotalCapacity").innerHTML = tempTotal;
            $('#tblAvailableRooms tr').removeClass("selected");
            document.getElementById("TotalRooms").value = "";
        }
    }
    
    else{
        document.getElementById("AddRoomError").innerHTML = "Please choose a room";
    }
}

//remove room
function RemoveRoom(){
    
    var TotalRooms = document.getElementById("TotalRemoveRooms").value;
    var TableChecker = CheckTable('#tblChosenRooms tr');
    if(TableChecker){
        document.getElementById("RemoveRoomError").innerHTML = "";
        if(TotalRooms == ""){
            $('#RemoveRoomsError').addClass('has-warning');
            document.getElementById("RemoveRoomError").innerHTML = "Please specify the number of rooms to avail";
        }
        else if(parseInt(TotalRooms) > parseInt(ChosenRooms[3])){
           $('#RemoveRoomsError').addClass('has-warning');
            document.getElementById("RemoveRoomError").innerHTML = "Room quantity exceeded!";
        }
        else if(!($('#RemoveRoomsError').hasClass('has-warning'))){
            var boolRemoveRoom = false;
 
            $("#tblAvailableRooms tr").each(function(){
                   if($(this).find("td:first").text() == ChosenRooms[0]){
                       var temp = parseInt($(this).find("td:nth-child(4)").text()) + parseInt(TotalRooms); 
                       $(this).find("td:nth-child(4)").text(temp);
                       tempTotal -= parseInt(ChosenRooms[1]) * parseInt(TotalRooms);
                       boolRemoveRoom = false;
                       return false;
                   }
                   else{
                       boolRemoveRoom = true;
                   }
            });
            
            if(boolRemoveRoom){
                var tableRef = document.getElementById('tblAvailableRooms').getElementsByTagName('tbody')[0];
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3  = newRow.insertCell(2);
                var newCell4 = newRow.insertCell(3);

                newCell1.innerHTML = ChosenRooms[0];
                newCell2.innerHTML = ChosenRooms[1];
                newCell3.innerHTML = ChosenRooms[2];
                newCell4.innerHTML = TotalRooms;
                
                tempTotal -= parseInt(ChosenRooms[1]) * parseInt(TotalRooms);
            }
            
            $("#tblChosenRooms tr").each(function(){
                   if($(this).find("td:first").text() == ChosenRooms[0]){
                       var temp = parseInt($(this).find("td:nth-child(4)").text()) - parseInt(TotalRooms);
                       if(temp == 0){
                           document.getElementById("tblChosenRooms").deleteRow(RemoveRowIndex+1);
                       }
                       else{
                           $(this).find("td:nth-child(4)").text(temp);
                       }
                       return false;
                   }
            });
            document.getElementById("TotalCapacity").innerHTML = tempTotal;
            $('#tblChosenRooms tr').removeClass("selected");
            document.getElementById("TotalRemoveRooms").value = "";
        }
    }
    
    else{
        document.getElementById("RemoveRoomError").innerHTML = "Please choose a room";
    }
    
}

//get table values
function run(event, sender){
    $('.alert').hide();
    event = event || window.event; 
    var target = event.target || event.srcElement;
    while (target && target.nodeName != 'TR') {
        target = target.parentElement;
    }

    cells = target.cells;
    if (!cells.length || target.parentNode.nodeName == 'THEAD') {
        return;
    }
    
    if(sender == "AvailableRooms"){
        var x = document.getElementsByClassName("ErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="";
        }
        document.getElementById("TotalRooms").value = "";
        AvailableRooms = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML];
    }
    
    if(sender == "ChosenRooms"){
        ChosenRooms = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML];
    }   
}

//validates the input
function CheckInput(field, errorHolder, holder){
    inputError = CheckInteger(field.value);
    if(inputError){
        $(holder).addClass("has-warning");
    }
    else{
        $(holder).removeClass("has-warning");
    }
    
    if($(holder).hasClass("has-warning")){
        document.getElementById(errorHolder).innerHTML = "Invalid input!";
    }

    else{
        document.getElementById(errorHolder).innerHTML = "";
    }
}

//check the value
function CheckInteger(temp){
    if(/^[0-9]*$/.test(temp) == false) {
        return true;
    }
    else if(temp == 0){
        return true;
    }
    else{
        return false;
    }
}

//submit rooms
function CheckRooms(){
    var TotalGuests = document.getElementById("TotalGuests").innerHTML;
    var TotalCapacity = document.getElementById("TotalCapacity").innerHTML;
    if(parseInt(TotalGuests) <= parseInt(TotalCapacity)){
        //Get data from tables
        var pacRooms = document.getElementById('tblChosenRooms'), cellsRooms = pacRooms.getElementsByTagName('td');
        var pacRoomsCells = (document.getElementById('tblChosenRooms').getElementsByTagName("tr").length - 1) * 4;

        var ChosenRooms = "";
        for(var i = 0; i < pacRoomsCells; i += 4){             
          ChosenRooms += cellsRooms[i].innerHTML + "-" + cellsRooms[i + 1].innerHTML + "-" + cellsRooms[i + 2].innerHTML  + "-" + cellsRooms[i + 3].innerHTML;  
          if(!(i == (pacRoomsCells - 4))){                  
              ChosenRooms += ",";                  
          }          
        }
        
        if(BoatsUsed != null){
            document.getElementById("r-BoatsUsed").value = BoatsUsed;
        }
        
        if(includeDate){
            document.getElementById("r-CheckInDate").value = document.getElementById("CheckInDate").value;
            document.getElementById("r-CheckOutDate").value = document.getElementById("CheckOutDate").value;
            
            var PickUpHour = document.getElementById("SelectHour").value;
            var PickUpMinute = document.getElementById("SelectMinute").value;
            var PickUpMerridean = document.getElementById("SelectMerridean").value;
            
            var PickUpTime = "";
            
            if(PickUpMerridean == "PM"){
                PickUpTime = (parseInt(PickUpHour) + 12) + ":" + PickUpMinute + ":00";
            }
            else{
                PickUpTime = PickUpHour + ":" + PickUpMinute + ":00";
            }
            
            
            document.getElementById("r-PickUpTime").value = PickUpTime;
        }
        
        if(!includeDate){
            
            document.getElementById("r-CheckInDate").value = document.getElementById("h-CheckInDate").value;
            document.getElementById("r-CheckOutDate").value = document.getElementById("h-CheckOutDate").value;
            var tempPickUpTime = document.getElementById("i-PickUpTime").innerHTML;
            var arrPickUpTime = tempPickUpTime.split(" ");
            var arrTimeDetails = arrPickUpTime[0].split(":");
            if(arrPickUpTime[1] == "PM"){
                PickUpTime = (parseInt(arrTimeDetails[0]) + 12) + ":" + arrTimeDetails[1] + ":" + arrTimeDetails[2];
            }
            else{
                PickUpTime = arrPickUpTime[0];
            }
            
            document.getElementById("r-PickUpTime").value = PickUpTime;
        }
        
        document.getElementById("r-NoOfAdults").value = document.getElementById("NoOfAdults").value;
        document.getElementById("r-NoOfKids").value = document.getElementById("NoOfKids").value;
        
        document.getElementById("r-ReservationID").value = document.getElementById("h-ReservationID").value;
        document.getElementById("ChosenRooms").value = ChosenRooms;
        return true;
    }
    else{
        document.getElementById("RoomError").innerHTML = "Total number of guests exceed total capacity of room(s)";
        return false;
    }
}


/*--------- Reservation Date ----------*/


//Check in/out date event listener
$( document ).ready(function() {
    $('#CheckInDate').on('changeDate', function(ev) {
        document.getElementById("ErrorMessage").innerHTML = "";
        document.getElementById("btnEditReschedRooms").style.display = "none";
        var CheckInDate = new Date(document.getElementById("CheckInDate").value);
        var DateError = DateChecker(CheckInDate);
        if(DateError){
            $('#CheckInDateError').addClass("has-warning");
            document.getElementById("ErrorMessage").innerHTML = "Please choose a date 7 days from the day the guest booked";
        }
        else{
            document.getElementById("ErrorMessage").innerHTML = "";
            $('#CheckInDateError').removeClass("has-warning");
            if(document.getElementById("CheckOutDate").value.trim() != ""){
                var CheckOutDate = new Date(document.getElementById("CheckOutDate").value);
                var InvalidDates = CheckDates(CheckInDate, CheckOutDate);
                if(InvalidDates){
                    $('#CheckOutDateError').addClass("has-warning");
                    document.getElementById("ErrorMessage").innerHTML = "Invalid Date!";
                }
                else{
                    $('#CheckOutDateError').removeClass("has-warning");
                    document.getElementById("ErrorMessage").innerHTML = "";
                }
            }
        }

    }).data('datepicker');

    $('#CheckOutDate').on('changeDate', function(ev) {
        document.getElementById("ErrorMessage").innerHTML = "";
        document.getElementById("btnEditReschedRooms").style.display = "none";
        CheckOutDate = new Date(document.getElementById("CheckOutDate").value);
        var DateError = DateChecker(CheckOutDate);
        if(DateError){
            $('#CheckOutDateError').addClass("has-warning");
            document.getElementById("ErrorMessage").innerHTML = "Please choose a date 7 days from the day the guest booked";
        }
        else{
            document.getElementById("ErrorMessage").innerHTML = "";
            $('#CheckOutDateError').removeClass("has-warning");
            if(document.getElementById("CheckInDate").value.trim() != ""){
                var CheckInDate = new Date(document.getElementById("CheckInDate").value);
                var InvalidDates = CheckDates(CheckInDate, CheckOutDate);
                if(InvalidDates){
                    $('#CheckOutDateError').addClass("has-warning");
                    document.getElementById("ErrorMessage").innerHTML = "Invalid Date!";
                }
                else{
                    $('#CheckOutDateError').removeClass("has-warning");
                    document.getElementById("ErrorMessage").innerHTML = "";
                }
            }
        }


    }).data('datepicker');
});


function DateChecker(selectedDate){
    var today = new Date(document.getElementById("h-DateBooked").value);
    var nextWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate()+7);
    if(!(selectedDate >= nextWeek)){
       return true;
    }
    return false;
}

function CheckDates(CheckInDate, CheckOutDate){
    if(CheckInDate <= CheckOutDate){
        return false;
    }
    return true;
}

function CheckTime(){
      var tempHour = document.getElementById("SelectHour");
      var tempMinute = document.getElementById("SelectMinute");
      var tempMerridean = document.getElementById("SelectMerridean");
      var ChosenHour;
      if(tempMerridean.value == "PM"){
          ChosenHour = parseInt(tempHour.value) + 12;
      }
      else{
          ChosenHour = tempHour.value;
      }
      var PickUpTime = "01/01/2017 " + ChosenHour + ":" + tempMinute.value + ":00";

      if((Date.parse(PickUpTime) >= Date.parse('01/01/2017 6:00:00')) && (Date.parse(PickUpTime) <= Date.parse('01/01/2017 17:00:00'))) {
         return false;
      }
      else{      
         return true;
      }
}

function SaveDate(){
    
    var CheckInDate = document.getElementById("CheckInDate");
    var CheckOutDate = document.getElementById("CheckOutDate");
    var TimeError = CheckTime();
    if(TimeError){
        document.getElementById("ErrorMessage").innerHTML = "Valid pick up time is only between 6AM to 5PM";
    }
    else{
        document.getElementById("ErrorMessage").innerHTML = "";
        if((CheckInDate.value.trim() == "") || (CheckOutDate.value.trim() == "")){
            document.getElementById("ErrorMessage").innerHTML = "Please fill out all the fields";
        }
        else if($('.form-group').hasClass('has-warning')){
            document.getElementById("ErrorMessage").innerHTML = "Invalid input on some fields";
        }
        else{
            CheckReservedAmenities();
        }
    }
}

function CheckReservedAmenities(){
    var TotalGuests = parseInt(document.getElementById("i-NoOfAdults").value) + parseInt(document.getElementById("i-NoOfKids").value);
    var tempHour = document.getElementById("SelectHour");
    var tempMinute = document.getElementById("SelectMinute");
    var tempMerridean = document.getElementById("SelectMerridean");
    var OriginalCheckInDate = document.getElementById("h-CheckInDate").value;
    var OriginalCheckOutDate = document.getElementById("h-CheckOutDate").value;
    var ChosenHour;
    if(tempMerridean.value == "PM"){
      ChosenHour = parseInt(tempHour.value) + 12;
    }
    else{
      ChosenHour = tempHour.value;
    }
    var tempPickUpTime = ChosenHour + ":" + tempMinute.value + ":00";
    $.ajax({
            type:'get',
            url:'/Reservation/Info/Dates',
            data:{id:document.getElementById("info-ReservationID").value,
                  CheckInDate:document.getElementById("CheckInDate").value,
                  CheckOutDate:document.getElementById("CheckOutDate").value,
                  PickUpTime:tempPickUpTime,
                  TotalGuests:TotalGuests},
            success:function(data){
                var TotalRoomAmount = 0;
                var OrigRoomAmount = 0;
                var date1 = new Date(document.getElementById("CheckInDate").value);
                var date2 = new Date(document.getElementById("CheckOutDate").value);
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
      
                if(diffDays == 0){
                    diffDays = 1;
                }
                
                var date3 = new Date(OriginalCheckInDate);
                var date4 = new Date(OriginalCheckOutDate);
                var OrigTimeDiff = Math.abs(date4.getTime() - date3.getTime());
                var OrigDiffDays = Math.ceil(OrigTimeDiff / (1000 * 3600 * 24)); 
                
                if(OrigDiffDays == 0){
                    OrigDiffDays = 1;
                }
                
                for(var x = 0; x < data.ChosenRooms.length; x++){
                    TotalRoomAmount += (parseInt(data.ChosenRooms[x].TotalRooms) * parseInt(data.ChosenRooms[x].dblRoomRate)) * parseInt(diffDays);
                    OrigRoomAmount += (parseInt(data.ChosenRooms[x].TotalRooms) * parseInt(data.ChosenRooms[x].dblRoomRate)) * parseInt(OrigDiffDays);
                }
               
                if(data.ChosenBoats.length != 0){
                    if(data.errorBoat && !data.errorRoom){
                        ShowModalAvailBoat();
                        $('#BtnAvailBoat').unbind("click").click(function(){
                            if (this.id == 'BtnAvailBoat') {
                                HideModalAvailBoat();
                                getAvailableBoats("date");
                            }
                        });
                        $('#BtnAvailNoBoat').unbind("click").click(function(){
                            if (this.id == 'BtnAvailNoBoat') {
                                HideModalAvailBoat();
                            }
                        });
                    }
                    
                    else if(!data.errorBoat && data.errorRoom){
                        document.getElementById("ErrorMessage").innerHTML = "Selected room(s) is not available based on the given date.";
                        document.getElementById("btnEditReschedRooms").style.display = "block";
                        
                    }
                    
                    else if(!data.errorBoat && !data.errorRoom){
                        document.getElementById("d-ReservationID").value = document.getElementById("info-ReservationID").value;
                        ShowModalReschedulePayment(TotalRoomAmount, OrigRoomAmount);
                        //document.getElementById("frmReschedule").submit();
                    }
                    
                    else if(data.errorBoat && data.errorRoom){
                        document.getElementById("ErrorMessage").innerHTML = "Selected room(s) is not available based on the given date.";
                        dateSender = true;
                        ShowModalAvailBoat();
                        $('#BtnAvailBoat').unbind("click").click(function(){
                            if (this.id == 'BtnAvailBoat') {
                                includeRooms = true;
                                HideModalAvailBoat();
                                getAvailableBoats("date");
                            }
                        });
                        $('#BtnAvailNoBoat').unbind("click").click(function(){
                            if (this.id == 'BtnAvailNoBoat') {
                                HideModalAvailBoat();
                                includeDate = true;
                                ShowModalEditResRoom("date");
                            }
                        });
                    }
                }
                else{
                    if(data.errorRoom){
                        document.getElementById("ErrorMessage").innerHTML = "Selected room(s) is not available based on the given date.";
                        document.getElementById("btnEditReschedRooms").style.display = "block";
                    }
                    else{
                        document.getElementById("d-ReservationID").value = document.getElementById("info-ReservationID").value;
                        ShowModalReschedulePayment(TotalRoomAmount, OrigRoomAmount);
                        //document.getElementById("frmReschedule").submit();
                    }
                }
                

            },
            error:function(response){
                console.log(response);
                var errors = response.responseJSON;
                console.log(errors);
            }
        });  
}

function RescheduleReservation(){
    guestSender = false;
    dateSender = false;
    if(includeBoats){
        document.getElementById("d-BoatsUsed").value = BoatsUsed;
    }
    if(includeRooms){
        ShowModalEditResRoom("date");
    }
    if(includeBoats && !includeRooms){
        document.getElementById("d-ReservationID").value = document.getElementById("info-ReservationID").value;
        document.getElementById("frmReschedule").submit();
    }
}

function btnEditReschedRoomsListener(){
    includeDate = true;
    ShowModalEditResRoom("date");
}

function SubmitRescheduleForm(){
    document.getElementById("frmReschedule").submit();
}