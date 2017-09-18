var ResortInfo = [];
var AvailableRooms = [];
var ChosenRooms = [];
var ReservationID;
var ArrivalDate;
var DepartureDate;
var tempTotal = 0;
var diffDays;
var strChosenRooms;
var TotalRoomCost = 0;
var today;
var ExtendTotal = 0;
var CustomerInfo = [];


//Modal controller
function ShowModalUnavailableRooms(){
    document.getElementById("DivModalUnavailableRooms").style.display = "block";
}

function HideModalUnavailableRooms(){
    document.getElementById("DivModalUnavailableRooms").style.display = "none";
}

function ShowModalExtendStayPayment(){
    var daysToExtend = parseInt(document.getElementById("ExtendNight").value);
    $.ajax({
        type:'get',
        url:'/Customer/Extend/Availability',
        data:{ExtendReservationID: ReservationID,
              ExtendNight: daysToExtend},
        success:function(data){
            if(data.UnavailableRooms != undefined){
                $('#UnavailableList').empty();
                HideModalExtendStay();
                ShowModalUnavailableRooms();
                for(var x = 0; x < data.UnavailableRooms.length; x++){
                    var ul = document.getElementById("UnavailableList");
                    var li = document.createElement("li");
                    li.appendChild(document.createTextNode(data.UnavailableRooms[x]));
                    ul.appendChild(li);
                }
            }
            else{
                ExtendTotal = 0;
                for(var x = 0; x < data.ReservedRooms.length; x++){
                    ExtendTotal += parseInt(data.ReservedRooms[x].dblRoomRate);
                }
                
                ExtendTotal = parseInt(ExtendTotal) * parseInt(daysToExtend);
                document.getElementById("ExtendTotalAmount").innerHTML = "Additional payment amounting PHP" + ExtendTotal +" is needed to extend the stay";
                HideModalExtendStay();
                document.getElementById("ExtendLaterReservationID").value = ReservationID;
                document.getElementById("ExtendLaterNight").value = daysToExtend;
                document.getElementById("ExtendLaterAmount").value = ExtendTotal;
                document.getElementById("DivModalExtendStayPayment").style.display = "block";
            }
        },
        error:function(response){
            console.log(response);
            alert(response.status);
        }
    });
    //
}

function HideModalExtendStayPayment(){
    document.getElementById("DivModalExtendStayPayment").style.display = "none";
}

function ShowModalExtendStay(ArrivalDate, tempReservationID){
    ReservationID = tempReservationID;
    document.getElementById("DivModalExtendStay").style.display = "block";
}

function HideModalExtendStay(){
    document.getElementById("DivModalExtendStay").style.display = "none";
}

function ShowModalExtendStayPayNow(){
    document.getElementById("ExtendPayTotal").value = ExtendTotal;
    document.getElementById("ExtendNowReservationID").value = ReservationID;
    document.getElementById("ExtendNowNight").value = document.getElementById("ExtendLaterNight").value;
    document.getElementById("DivModalExtendStayPayNow").style.display = "block";
}

function HideModalExtendStayPayNow(){
    document.getElementById("DivModalExtendStayPayNow").style.display = "none";
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
    var TableChecker = CheckTable("#tblCustomer tr");
    if(TableChecker){
        document.getElementById("EditCustomerID").value = CustomerInfo[0];
        document.getElementById("CustFirstName").value = CustomerInfo[1];
        document.getElementById("CustMiddleName").value = CustomerInfo[2];
        document.getElementById("CustLastName").value = CustomerInfo[3];
        document.getElementById("CustAddress").value = CustomerInfo[4];
        document.getElementById("CustContact").value = CustomerInfo[5];
        document.getElementById("CustEmail").value = CustomerInfo[6];
        document.getElementById("CustNationality").value = CustomerInfo[7];
        document.getElementById("CustGender").value = CustomerInfo[8];
        document.getElementById("CustBirthday").value = CustomerInfo[9];
        document.getElementById("DivModalEditCustomer").style.display = "block";
    }
}

function HideModalEditCustomer(){
    document.getElementById("DivModalEditCustomer").style.display = "none";
}

function ShowModalDeleteCustomer(){
    var TableChecker = CheckTable("#tblCustomer tr");
    if(TableChecker){
        document.getElementById("DeleteCustomerID").value = CustomerInfo[0];
        document.getElementById("DivModalDeleteCustomer").style.display = "block";
    }
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
    var RoomChecker = CheckRooms();
    if(RoomChecker){
        var date1 = new Date();
        var date2 = new Date(DepartureDate);
        diffDays = date2.getDate() - date1.getDate();
        if(diffDays == 0){
            diffDays = 1;
        } 
        //Get data from tables
        var pacRooms = document.getElementById('tblChosenRooms'), cellsRooms = pacRooms.getElementsByTagName('td');
        var pacRoomsCells = (document.getElementById('tblChosenRooms').getElementsByTagName("tr").length - 1) * 4;

        strChosenRooms = "";
        TotalRoomCost = 0;
        for(var i = 0; i < pacRoomsCells; i += 4){             
          strChosenRooms += cellsRooms[i].innerHTML + "-" + cellsRooms[i + 1].innerHTML + "-" + cellsRooms[i + 2].innerHTML  + "-" + cellsRooms[i + 3].innerHTML;
          TotalRoomCost += (parseInt(cellsRooms[i + 2].innerHTML) * parseInt(cellsRooms[i + 3].innerHTML)) * diffDays;
          if(!(i == (pacRoomsCells - 4))){                  
              strChosenRooms += ",";                  
          }          
        }
        
        document.getElementById("AddChosenRooms").value = strChosenRooms;
        document.getElementById("AddReservationID").value = ReservationID;
        document.getElementById("AddRoomAmount").value = TotalRoomCost;
        document.getElementById("AddToday").value = today;
        document.getElementById("AddDeparture").value = DepartureDate;
        document.getElementById("AddTotalAmount").innerHTML = "Total cost is PHP" + Math.abs(TotalRoomCost);
        
        document.getElementById("DivModalAddRoomPayment").style.display = "block";
    }
}

function HideModalAddRoomPayment(){
    document.getElementById("DivModalAddRoomPayment").style.display = "none";
}

function ShowModalAddRoomPayNow(){
    HideModalAddRoomPayment();
    document.getElementById("AddPayTotal").value = TotalRoomCost;
    document.getElementById("AddPayReservationID").value = ReservationID;
    document.getElementById("AddPayChosenRooms").value = strChosenRooms;
    document.getElementById("AddPayToday").value = today;
    document.getElementById("AddPayDeparture").value = DepartureDate;
    document.getElementById("DivModalAddRoomPayNow").style.display = "block";
}

function HideModalAddRoomPayNow(){
    ShowModalAddRoomPayment();
    document.getElementById("DivModalAddRoomPayNow").style.display = "none";
}


//misc
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
        ReservationID = ResortInfo[1];
        ArrivalDate = ResortInfo[7];
        DepartureDate = ResortInfo[8];

        getAvailableRooms();
    }
    
    if(sender == "Record"){
        CustomerInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML, cells[7].innerHTML, cells[8].innerHTML, cells[9].innerHTML];
    }
    
    if(sender == "AvailableRooms"){
        AvailableRooms = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML];
    }
    
    if(sender == "ChosenRooms"){
        ChosenRooms = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML];
    }   

}

/*------------- ADD ROOM ----------------*/

function getAvailableRooms(){
    var tempDate  = new Date();
    var DateTimeToday = tempDate.getFullYear() + "/" + (parseInt(tempDate.getMonth())+1) + "/" + tempDate.getDate() + " " + tempDate.getHours() + ":" + tempDate.getMinutes() + ":" + tempDate.getSeconds();
    alert();
    today = DateTimeToday;
    $.ajax({
        type:'get',
        url:'/Customers/GetRooms',
        data:{ArrivalDate: DateTimeToday,
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

//check if tblchosenroom is empty
function CheckRooms(){
    var TableLength = document.getElementById("tblChosenRooms").getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
    if(TableLength == 0){
        return false;
    }
    else{
        return true;
    }
}

//validates amount to be paid
function SendPayment(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        
        var AddTotal = parseInt(document.getElementById("AddPayTotal").value);
        var AddPayment = parseInt(field.value);
        var Change = AddPayment - AddTotal;
        if(Change < 0){
            document.getElementById("AddPayChange").value = "Insufficient Payment";
        }
        else{
            document.getElementById("AddPayChange").value = Change;
        }
        
    }
}

/*---------- EXTEND STAY ---------------*/

function SendExtendPayment(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        
        var ExtendTotal = parseInt(document.getElementById("ExtendPayTotal").value);
        var ExtendPayment = parseInt(field.value);
        var Change = ExtendPayment - ExtendTotal;
        if(Change < 0){
            document.getElementById("ExtendPayChange").value = "Insufficient Payment";
        }
        else{
            document.getElementById("ExtendPayChange").value = Change;
        }
        
    }
}