var ResortInfo = [];
var AvailableRooms = [];
var ChosenRooms = [];
var ReservationID;
var ArrivalDate;
var DepartureDate;
var tempTotal = 0;

function ShowModalExtendStay(){
    document.getElementById("DivModalExtendStay").style.display = "block";
}

function HideModalExtendStay(){
    document.getElementById("DivModalExtendStay").style.display = "none";
}

function ShowModalAddRoom(){
    document.getElementById("DivModalAddRoom").style.display = "block";
}

function HideModalAddRoom(){
    document.getElementById("DivModalAddRoom").style.display = "none";
}

function ShowModalCheckout(){
    document.getElementById("DivModalCheckout").style.display = "block";
}

function HideModalCheckout(){
    document.getElementById("DivModalCheckout").style.display = "none";
}

function ShowModalEditCustomer(){
    document.getElementById("DivModalEditCustomer").style.display = "block";
}

function HideModalEditCustomer(){
    document.getElementById("DivModalEditCustomer").style.display = "none";
}

function ShowModalDeleteCustomer(){
    document.getElementById("DivModalDeleteCustomer").style.display = "block";
}

function HideModalDeleteCustomer(){
    document.getElementById("DivModalDeleteCustomer").style.display = "none";
}

function ShowModalCustomerHistory(){
    document.getElementById("DivModalCustomerHistory").style.display = "block";
}

function HideModalCustomerHistory(){
    document.getElementById("DivModalCustomerHistory").style.display = "none";
}

function ShowModalReservationInfo(){
    document.getElementById("DivModalReservationInfo").style.display = "block";
}

function HideModalReservationInfo(){
    document.getElementById("DivModalReservationInfo").style.display = "none";
}

function ShowModalAddRoomPayment(){
    document.getElementById("DivModalAddRoomPayment").style.display = "block";
}

function HideModalAddRoomPayment(){
    document.getElementById("DivModalAddRoomPayment").style.display = "none";
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
    
    if(sender == "Resort"){
        ResortInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML, cells[7].innerHTML, cells[8].innerHTML];
        ReservationID = ResortInfo[0];
        ArrivalDate = ResortInfo[7];
        DepartureDate = ResortInfo[8];

        getAvailableRooms();
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

/*------------- ADD ROOM ----------------*/

function getAvailableRooms(){
    $.ajax({
        type:'get',
        url:'/Customers/GetRooms',
        data:{ArrivalDate: ArrivalDate,
              DepartureDate: DepartureDate},
        success:function(data){
            
            $('#tblAvailableRooms tbody').empty();
            $('#tblChosenRooms tbody').empty();
            var tableRef = document.getElementById('tblAvailableRooms').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3  = newRow.insertCell(2);
                var newCell4  = newRow.insertCell(3);

                newCell1.innerHTML = data[x].strRoomType;
                newCell2.innerHTML = data[x].intRoomTCapacity;
                newCell3.innerHTML = data[x].dblRoomRate;
                newCell4.innerHTML = data[x].TotalRooms;
                
            }
        },
        error:function(response){
            console.log(response);
            alert(response.status);
        }
    });
}

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
            $('#tblChosenRooms tr').removeClass("selected");
            document.getElementById("TotalRemoveRooms").value = "";
        }
    }
    
    else{
        document.getElementById("RemoveRoomError").innerHTML = "Please choose a room";
    }
    
}

//check input on add room
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

function CheckRooms(){
    var TableLength = document.getElementById("tblChosenRooms").getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
    alert(TableLength);
    if(TableLength == 0){
        return false;
    }
    else{
        return true;
    }
}