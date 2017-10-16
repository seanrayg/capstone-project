var AddRowIndex;
var RemoveRowIndex;
var AvailableRooms = [];
var ChosenRooms = [];
var RemovedRows = "";
var SelectedRooms = "";
var ChosenRoomsData = "";
var tempTotal = 0;
var FeeIndex;
var RemovedFees = [];
var Fees = []; // object of fees

//Modal Controller

function ShowModalExceedGuest(){
    document.getElementById("DivModalExceedGuest").style.display = "block";
}

function HideModalExceedGuest(){
    document.getElementById("DivModalExceedGuest").style.display = "none";    
}

function ShowModalAddFee(){
    FilterFee();
    document.getElementById("DivModalAddFee").style.display = "block";
}

function HideModalAddFee(){
    document.getElementById("DivModalAddFee").style.display = "none";
}

function ShowModalPaymentChoice(){
    document.getElementById("DivModalPaymentChoice").style.display = "block";
}

function HideModalPaymentChoice(){
    document.getElementById("DivModalPaymentChoice").style.display = "none";
}

function ShowModalPayNow(){
    document.getElementById("DivModalPayNow").style.display = "block";
}

function HideModalPayNow(){
    document.getElementById("DivModalPayNow").style.display = "none";
}

//MISC
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

window.onload = function(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd='0'+dd
    } 

    if(mm<10) {
        mm='0'+mm
    } 

    today = mm+'/'+dd+'/'+yyyy;

    document.getElementById("CheckInDate").value = today;
}

function GoBack(OldHolder, NewHolder, OldList, NewList){
    $(OldHolder).removeClass('active');
    $(OldList).removeClass('active');
    $(NewList).addClass('active');
    $(NewHolder).addClass('active');
}

function SaveReservation(){
    //Get data from tables
    if(document.getElementById("Change").innerHTML != "Insufficient Payment"){
        
        var ChosenRooms = getRooms();
        var ChosenFees = getFees();
        
        var sGrandTotal = document.getElementById("p-GrandTotal").innerHTML;
        var sAmountTendered = document.getElementById("AmountTendered").value;
        
        TransferToForm(ChosenRooms, ChosenFees, sGrandTotal, sAmountTendered);
    }
    
}

function getRooms(){
    var pacRooms = document.getElementById('tblChosenRooms'), cellsRooms = pacRooms.getElementsByTagName('td');
    var pacRoomsCells = (document.getElementById('tblChosenRooms').getElementsByTagName("tr").length - 1) * 4;

    var ChosenRooms = "";
    for(var i = 0; i < pacRoomsCells; i += 4){             
      ChosenRooms += cellsRooms[i].innerHTML + "-" + cellsRooms[i + 1].innerHTML + "-" + cellsRooms[i + 2].innerHTML  + "-" + cellsRooms[i + 3].innerHTML;  
      if(!(i == (pacRoomsCells - 4))){                  
          ChosenRooms += ",";                  
      }     
    }
    
    return ChosenRooms;
}

function getFees(){
    var pacFees = document.getElementById('tblOtherFee'), cellsFees = pacFees.getElementsByTagName('td');
    var pacFeesCells = (document.getElementById('tblOtherFee').getElementsByTagName("tr").length - 1) * 5;

    var ChosenFees = "";
    for(var i = 0; i < pacFeesCells; i += 5){             
      ChosenFees += cellsFees[i].innerHTML + "-" + cellsFees[i + 1].innerHTML + "-" + cellsFees[i + 2].innerHTML  + "-" + cellsFees[i + 3].innerHTML;  
      if(!(i == (pacFeesCells - 5))){                  
          ChosenFees += ",";                  
      }          
    }
    return ChosenFees;
}

function TransferToForm(ChosenRooms, ChosenFees, GrandTotal, AmountTendered){
    document.getElementById("s-CheckInDate").value = document.getElementById("CheckInDate").value;
    document.getElementById("s-CheckOutDate").value = document.getElementById("CheckOutDate").value;
    document.getElementById("s-NoOfAdults").value = document.getElementById("NoOfAdults").value;
    document.getElementById("s-NoOfKids").value = document.getElementById("NoOfKids").value;
    document.getElementById("s-ChosenRooms").value = ChosenRooms;
    document.getElementById("s-FirstName").value = document.getElementById("FirstName").value;
    document.getElementById("s-MiddleName").value = document.getElementById("MiddleName").value;
    document.getElementById("s-LastName").value = document.getElementById("LastName").value;
    document.getElementById("s-Address").value = document.getElementById("Address").value;
    document.getElementById("s-Contact").value = document.getElementById("ContactNumber").value;
    document.getElementById("s-Email").value = document.getElementById("Email").value;
    document.getElementById("s-Nationality").value = document.getElementById("Nationality").value;
    document.getElementById("s-DateOfBirth").value = document.getElementById("DateOfBirth").value;
    document.getElementById("s-Gender").value = document.getElementById("Gender").value;
    document.getElementById("s-Remarks").value = document.getElementById("Remarks").value;
    document.getElementById("s-OtherFees").value = ChosenFees;
    document.getElementById("s-AddFees").value = JSON.stringify(Fees);
    document.getElementById("s-GrandTotal").value = GrandTotal;
    document.getElementById("s-AmountTendered").value = AmountTendered;
    document.getElementById("WalkInForm").submit();
}

function SaveTransaction(){
    var ChosenRooms = getRooms();
    var ChosenFees = getFees();

    var sGrandTotal = document.getElementById("GrandTotal").innerHTML;
    var sAmountTendered = null;

    TransferToForm(ChosenRooms, ChosenFees, sGrandTotal, sAmountTendered);
}

/*------- Date Tab Controller ------*/

function CheckDate(){
    var CheckInDate = document.getElementById("CheckInDate");
    var CheckOutDate = document.getElementById("CheckOutDate");
    var NoOfKids = document.getElementById("NoOfKids");
    var NoOfAdults = document.getElementById("NoOfAdults");
    if((CheckInDate.value.trim() == "") || (CheckOutDate.value.trim() == "") || (NoOfKids.value.trim() == "") || (NoOfAdults.value.trim() == "")){
        $('.alert').show();
        document.getElementById("ErrorMessage").innerHTML = "Please fill out all the fields";
    }
    else if($('.form-group').hasClass('has-warning')){
        $('.alert').show();
        document.getElementById("ErrorMessage").innerHTML = "Invalid input on some fields";
    }
    else{
        document.getElementById("TotalGuests").innerHTML = parseInt(document.getElementById("NoOfAdults").value) + parseInt(document.getElementById("NoOfKids").value);
        getAvailableRooms();
        $('.alert').hide();
        $('#ReservationDate').removeClass('active');
        $('#DateList').removeClass('active');
        $('#RoomList').addClass('active');
        $('#ReservationRoom').addClass('active');
    }
    
}
//Check in/out date event listener
$( document ).ready(function() {
    $('#CheckInDate').on('changeDate', function(ev) {
        var CheckInDate = new Date(document.getElementById("CheckInDate").value);
        $('.alert').hide();
        $('#CheckInDateError').removeClass("has-warning");
        if(document.getElementById("CheckOutDate").value.trim() != ""){
            var CheckOutDate = new Date(document.getElementById("CheckOutDate").value);
            var InvalidDates = CheckDates(CheckInDate, CheckOutDate);
            if(InvalidDates){
                $('.alert').show();
                $('#CheckOutDateError').addClass("has-warning");
                document.getElementById("ErrorMessage").innerHTML = "Invalid Date!";
            }
            else{
                $('.alert').hide();
                $('#CheckOutDateError').removeClass("has-warning");
                document.getElementById("ErrorMessage").innerHTML = "";
            }
        }


    }).data('datepicker');

    $('#CheckOutDate').on('changeDate', function(ev) {
        CheckOutDate = new Date(document.getElementById("CheckOutDate").value);
        if(document.getElementById("CheckInDate").value.trim() != ""){
            var CheckInDate = new Date(document.getElementById("CheckInDate").value);
            var InvalidDates = CheckDates(CheckInDate, CheckOutDate);
            if(InvalidDates){
                $('.alert').show();
                $('#CheckOutDateError').addClass("has-warning");
                document.getElementById("ErrorMessage").innerHTML = "Invalid Date!";
            }
            else{
                $('.alert').hide();
                $('#CheckOutDateError').removeClass("has-warning");
                document.getElementById("ErrorMessage").innerHTML = "";
            }
        }
    }).data('datepicker');
});

function DateChecker(selectedDate){
    var today = new Date();
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

function InputSender(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if($(holder).hasClass('has-warning')){
        $('.alert').show();
        document.getElementById("ErrorMessage").innerHTML = "Invalid input on some fields";
    }
    else{
       $('.alert').hide(); 
    }
}

function HideAlert(){
    $('.alert').hide();
}

//get available rooms ajax
function getAvailableRooms(){
    var CheckInDate = document.getElementById("CheckInDate").value;
    var CheckOutDate = document.getElementById("CheckOutDate").value;

    var d = new Date(); // for now
    var TimeToday = d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();

    if(parseInt(d.getMinutes()) < 10 && parseInt(d.getSeconds()) < 10){
        var TimeToday = d.getHours()+":0"+d.getMinutes()+":0"+d.getSeconds();
    }
    else if(parseInt(d.getSeconds()) < 10){
        var TimeToday = d.getHours()+":"+d.getMinutes()+":0"+d.getSeconds();
    }
    else if(parseInt(d.getMinutes()) < 10){
        var TimeToday = d.getHours()+":0"+d.getMinutes()+":"+d.getSeconds();
    }
    var TimeExit;
    if(CheckInDate == CheckOutDate){
        TimeExit = "23:59:59";
    }
    else{
        TimeExit = TimeToday;
    }
   
    $.ajax({
        type:'get',
        url:'/Reservation/Rooms',
        data:{CheckInDate:CheckInDate +" "+TimeToday,
              CheckOutDate:CheckOutDate +" "+TimeExit},
        success:function(data){
            console.log('success');
            $('#tblAvailableRooms tbody').empty();
            $('#tblChosenRooms tbody').empty();
            RemovedRows = "";
            var tableRef = document.getElementById('tblAvailableRooms').getElementsByTagName('tbody')[0];

            console.log(data);

            for(var x = 0; x < data.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3 = newRow.insertCell(2);
                var newCell4 = newRow.insertCell(3);

                newCell1.innerHTML = data[x].strRoomType;
                newCell2.innerHTML = data[x].intRoomTCapacity;
                newCell3.innerHTML = data[x].dblRoomRate;
                newCell4.innerHTML = data[x].TotalRooms;

            }
        },
        error:function(response){
            console.log(response);
            alert("error");
        }
    });   
}



/*---------- ROOMS -----------------*/


function CheckRooms(){
    var ErrorMessage = document.getElementById("RoomError");
    var NoOfKids = document.getElementById("NoOfKids").value;
    var NoOfAdults = document.getElementById("NoOfAdults").value;
    var TotalGuests = parseInt(NoOfKids) + parseInt(NoOfAdults);
    var TotalRoomCapacity = 0;

    $("#tblChosenRooms tr").each(function(){
        if(($(this).find("td:nth-child(2)").text())!=""){
            TotalRoomCapacity += (parseInt($(this).find("td:nth-child(2)").text()) * parseInt($(this).find("td:nth-child(4)").text()));
        }
    });
    var rowCount = $('#tblChosenRooms >tbody >tr').length;
    if(rowCount == 0){
        ErrorMessage.innerHTML = "Please choose a room to reserve";
    }
    else if(!(TotalGuests <= TotalRoomCapacity)){
        ErrorMessage.innerHTML = "Total number of guests exceeds total capacity of selected rooms!";
        ShowModalExceedGuest();
    }
    else{
        ErrorMessage.innerHTML = "";
        $('.alert').hide();
        $('#ReservationRoom').removeClass('active');
        $('#RoomList').removeClass('active');
        $('#InfoList').addClass('active');
        $('#ReservationInfo').addClass('active');
    }
}

function ExceedContinue(){
    $('.alert').hide();
    $('#ReservationRoom').removeClass('active');
    $('#RoomList').removeClass('active');
    $('#InfoList').addClass('active');
    $('#ReservationInfo').addClass('active');
    HideModalExceedGuest();
}

//table row clicked

$(document).ready(function(){
    $('#tblAvailableRooms').on('click', 'tbody tr', function(){
        HighlightRow(this);
        AddRowIndex = $(this).index();
    });
    
    $('#tblChosenRooms').on('click', 'tbody tr', function(){
        HighlightRow(this);
        RemoveRowIndex = $(this).index();
    });
    
});

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
            document.getElementById("AddRoomError").innerHTML = "Room Quantity exceeded total number of available rooms";
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
        var x = document.getElementsByClassName("ErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="Please choose a room";
        }
    }
}

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



/*---------- INFO ---------------*/


function CheckReservationInfo(){
    var CustomerAge = "";
    if(document.getElementById("DateOfBirth").value != ""){
        CustomerAge = getAge(document.getElementById("DateOfBirth").value);
    }


    if((document.getElementById("FirstName").value == "")||(document.getElementById("MiddleName").value == "") ||           (document.getElementById("LastName").value == "")||(document.getElementById("ContactNumber").value == "") || (document.getElementById("Nationality").value == "")||(document.getElementById("DateOfBirth").value == "") || (document.getElementById("Address").value == "")||(document.getElementById("Email").value == "")){
        $('.alert').show();
        document.getElementById("InfoErrorMessage").innerHTML = "Please fill out all fields";
    }
    else if(($(".form-group").hasClass("has-warning")) || ($(".form-group").hasClass("has-error"))){
        $('.alert').show();
        document.getElementById("InfoErrorMessage").innerHTML = "Invalid input on some fields";
    }
    else if(parseInt(CustomerAge)<18){
        $('.alert').show();
        document.getElementById("InfoErrorMessage").innerHTML = "Customers only 18 years old and above are allowed to book a reservation";
    }
    else{
        var FirstName = document.getElementById("FirstName").value;
        var MiddleName = document.getElementById("MiddleName").value;
        var LastName = document.getElementById("LastName").value;
        var Birthday = document.getElementById("DateOfBirth").value;
        var Gender = document.getElementById("Gender").value;

        $.ajax({
            type:'get',
            url:'/Reservation/Customers',
            data:{FirstName:FirstName,
                  MiddleName:MiddleName,
                  LastName:LastName,
                  Gender:Gender,
                  Birthday: Birthday},
            success:function(data){
                var dataError = false;
                if(data.blockError == true){
                    dataError = true;
                    $('.alert').show();
                    document.getElementById("InfoErrorMessage").innerHTML = "Customer is currently blocked and cannot book a reservation";
                }

                else if(data.existingError == true){
                    dataError = true;
                    $('.alert').show();
                    document.getElementById("InfoErrorMessage").innerHTML = "The customer still has an active reservation. Cannot book a reservation";
                }
                if(!dataError){
                    $('.alert').hide();
                    document.getElementById("InfoErrorMessage").innerHTML = "";
                    FillDataSummary();
                    getEntranceFee();
                    $('#ReservationInfo').removeClass('active');
                    $('#InfoList').removeClass('active');
                    $('#BillList').addClass('active');
                    $('#ReservationBill').addClass('active');
                }
            },
            error:function(response){
                console.log(response);
                alert(response.status);
            }
        });   
    }
}

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())){
        age--;
    }
    return age;
}


/*------------- Reservation Bill controller -------*/



//displays customer info
function FillDataSummary(){
    var tempHour = document.getElementById("PickUpTime");
    var tempMinute = document.getElementById("PickUpMinute");
    var tempMerridean = document.getElementById("PickUpMerridean");

    document.getElementById("i-CheckInDate").innerHTML = document.getElementById("CheckInDate").value;
    document.getElementById("i-CheckOutDate").innerHTML = document.getElementById("CheckOutDate").value;
    document.getElementById("i-TotalAdults").innerHTML = document.getElementById("NoOfAdults").value;
    document.getElementById("i-TotalKids").innerHTML = document.getElementById("NoOfKids").value;
    document.getElementById("i-FullName").innerHTML = document.getElementById("FirstName").value +" "+ document.getElementById("MiddleName").value +" "+ document.getElementById("LastName").value;
    document.getElementById("i-Address").innerHTML = document.getElementById("Address").value;
    document.getElementById("i-Contact").innerHTML = document.getElementById("ContactNumber").value;
    document.getElementById("i-Email").innerHTML = document.getElementById("Email").value;
    document.getElementById("i-Nationality").innerHTML = document.getElementById("Nationality").value;
    document.getElementById("i-DateOfBirth").innerHTML = document.getElementById("DateOfBirth").value;
    document.getElementById("i-Gender").innerHTML = document.getElementById("Gender").value;
    document.getElementById("i-Remarks").innerHTML = document.getElementById("Remarks").value;
}

//gets entrance fee value
function getEntranceFee(){
    $.ajax({
        type:'get',
        url:'/Reservation/Fees',
        success:function(data){
            FillInitialBill(data);
        },
        error:function(response){
            console.log(response);
            alert("error");
        }
    });   
}

//displays bill info
function FillInitialBill(data){
    var RentTotal = 0;
    var EntranceFee = 0;
    if(data.length >= 1){
        EntranceFee = data[0].dblFeeAmount;
    }
    else{
        EntranceFee = 0;
    }
    var checker = "";
    var NoOfKids = document.getElementById("NoOfKids").value;
    var NoOfAdults = document.getElementById("NoOfAdults").value;

    var TotalGuests = parseInt(NoOfKids) + parseInt(NoOfAdults);
    $('#tblBill tbody').empty();
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
    
    ChosenRoomsInfo = ChosenRoomsData.split(",");
        for(var x = 0; x <ChosenRoomsInfo.length; x++){
            var ChosenRoom = ChosenRoomsInfo[x].split("-");
            var tableRef = document.getElementById('tblBill').getElementsByTagName('tbody')[0];

                      var newRow   = tableRef.insertRow(tableRef.rows.length);

                      var newCell1  = newRow.insertCell(0);
                      var newCell2  = newRow.insertCell(1);
                      var newCell3  = newRow.insertCell(2);
                      var newCell4 = newRow.insertCell(3);

                      newCell1.innerHTML = ChosenRoom[0];
                      newCell2.innerHTML = ChosenRoom[2];
                      newCell3.innerHTML = ChosenRoom[3];
                      newCell4.innerHTML = ChosenRoom[2] * ChosenRoom[3];
                      RentTotal+= ChosenRoom[2]*ChosenRoom[3];
        }
    
    
    //Number of days reserved
    document.getElementById("b-TotalRoomFee").innerHTML = RentTotal;
    var oneDay = 24*60*60*1000; 
    var firstDate = new Date(document.getElementById("CheckInDate").value);
    var secondDate = new Date(document.getElementById("CheckOutDate").value);

    var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
    
    if(diffDays == 0){
        diffDays = 1;
    }
    document.getElementById("b-DaysOfStay").innerHTML = diffDays;
    
    //Accomodation Fee
    document.getElementById("TotalAccomodationFee").innerHTML = diffDays * RentTotal;
    document.getElementById("AccomodationFee").innerHTML = document.getElementById("TotalAccomodationFee").innerHTML;
    
    //Total adult guests
    document.getElementById("b-TotalAdults").innerHTML = NoOfAdults;
    document.getElementById("EntranceFee").innerHTML = EntranceFee;
    document.getElementById("TotalEntranceFee").innerHTML = parseInt(NoOfAdults) * parseInt(EntranceFee);
    
    
    //Miscellaneous Fee
    document.getElementById("TotalMiscellaneousFee").innerHTML = parseInt(document.getElementById("TotalEntranceFee").innerHTML);
    
    document.getElementById("MiscellaneousFee").innerHTML = document.getElementById("TotalMiscellaneousFee").innerHTML;
    
    //Grand Total
    
    document.getElementById("GrandTotal").innerHTML = parseInt(document.getElementById("MiscellaneousFee").innerHTML) + parseInt(document.getElementById("AccomodationFee").innerHTML);
    
}

//resets fee and manages display in fee modal
function FilterFee(){
    document.getElementById("FeeName").value = "";
    document.getElementById("FeeAmount").value = "";
    document.getElementById("FeeQuantity").value = "";
    $(".form-group").removeClass('has-warning');
    var x = document.getElementsByClassName("ErrorLabel");
    for(var i = 0; i < x.length; i++){
        x[i].innerText="";
    }
    var SelectedFee = document.getElementById("SelectFees").value;
    if(SelectedFee == "Other"){
        document.getElementById("OtherInput").style.display = "block";
        document.getElementById("FeeAmount").readOnly = false;
    }
    else{
        getFeeAmount();
        document.getElementById("OtherInput").style.display = "none";
    }
}

//ajax to get amount of fee
function getFeeAmount(){
    var SelectedFee = document.getElementById("SelectFees").value;
    $.ajax({
        type:'get',
        url:'/Walkin/Fees',
        data:{SelectedFee: SelectedFee},
        success:function(data){
            document.getElementById("FeeAmount").value = data[0].dblFeeAmount;
            document.getElementById("FeeAmount").readOnly = true;
        },
        error:function(response){
            console.log(response);
            alert("error");
        }
    });   
}

//tblotherfee click listener
$(document).ready(function(){
        $('#tblOtherFee').on('click', 'tbody tr', function(){
            FeeIndex = $(this).index();
            RemoveFee($(this).find("td:first-child").text(), $(this).find("td:nth-child(4)").text());
        });

    });

//add fee to table
function AddFee(){
    var SelectedFee = document.getElementById("SelectFees").value;
    var EmptyError = false;
    var FeeName = "";
    var FeeAmount;
    var FeeQuantity;
    if(SelectedFee == "Other"){
        FeeName = document.getElementById("FeeName").value;
        FeeAmount = document.getElementById("FeeAmount").value;
        FeeQuantity = document.getElementById("FeeQuantity").value;
        if(FeeName == "" || FeeAmount == "" || FeeQuantity == ""){
            EmptyError = true;
        }
    }
    else{
        FeeAmount = document.getElementById("FeeAmount").value;
        FeeQuantity = document.getElementById("FeeQuantity").value;
        if(FeeQuantity == "" || FeeAmount == ""){
            EmptyError = true;
        }
    }
    
    if(EmptyError){
        var x = document.getElementsByClassName("ErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="All fields are required!";
        }
    }
    else{
        if(!($(".form-group").hasClass('has-warning'))){
            var FeeExists = false;
            for (var i=0; i<document.getElementById('SelectFees').options.length; i++){ 
                if (document.getElementById('SelectFees').options[i].text == FeeName){ 
                    FeeExists = true;
                    break;
                } 
            }
            if(!FeeExists){
                var e = document.getElementById("SelectFees");
                var tempFeeName = e.options[e.selectedIndex].value;
                if(tempFeeName != "Other"){
                    RemovedFees[RemovedFees.length] = document.getElementById("SelectFees").value;
                    e.remove(e.selectedIndex);
                }


                var tableRef = document.getElementById('tblOtherFee').getElementsByTagName('tbody')[0];

                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3 = newRow.insertCell(2);
                var newCell4 = newRow.insertCell(3);
                var newCell5 = newRow.insertCell(4);

                if(SelectedFee == "Other"){
                   newCell1.innerHTML = FeeName; 
                }
                else{
                    newCell1.innerHTML = SelectedFee;
                }
         
                newCell2.innerHTML = FeeAmount;
                newCell3.innerHTML = FeeQuantity;
                newCell4.innerHTML = parseInt(FeeAmount) * parseInt(FeeQuantity);
                newCell5.innerHTML = "<button type='button' rel='tooltip' title='Remove' class='btn btn-danger btn-simple btn-xs btn-remove' value='" +newCell1.innerHTML+ "'><i class='material-icons'>close</i></button>";
                
                var TotalMiscellaneousFee = parseInt(document.getElementById("TotalMiscellaneousFee").innerHTML);
                TotalMiscellaneousFee = parseInt(TotalMiscellaneousFee) + parseInt(FeeAmount) * parseInt(FeeQuantity);
                document.getElementById("TotalMiscellaneousFee").innerHTML = TotalMiscellaneousFee;
                var GrandTotal = parseInt(document.getElementById("GrandTotal").innerHTML);
                GrandTotal += parseInt(FeeAmount) * parseInt(FeeQuantity);
                document.getElementById("MiscellaneousFee").innerHTML = TotalMiscellaneousFee;
                document.getElementById("GrandTotal").innerHTML = GrandTotal;

                if(SelectedFee == "Other"){
                    if(document.getElementById("CheckSaveFee").checked){            
                        Fees.push({
                            FeeName: FeeName,
                            FeeAmount: FeeAmount});
                    }    
                }

                HideModalAddFee();  
            }
            
            else{
                var x = document.getElementsByClassName("ErrorLabel");
                for(var i = 0; i < x.length; i++){
                    x[i].innerText="Entered fee already exists!";
                }
            }
        }
    }
}

//remove fee to table
function RemoveFee(field, deductAmount){
    var FeeFound = false;
    for(var x = 0; x < RemovedFees.length; x++){
        if(RemovedFees[x] == field){
            FeeFound = true;
            break;
        }
    }
    
    if(FeeFound){
        document.getElementById("SelectFees").insertBefore(new Option(field, field), document.getElementById("SelectFees").firstChild);
    }
    
    var TotalMiscellaneousFee = parseInt(document.getElementById("TotalMiscellaneousFee").innerHTML);
    TotalMiscellaneousFee = parseInt(TotalMiscellaneousFee) - parseInt(deductAmount);
    document.getElementById("TotalMiscellaneousFee").innerHTML = TotalMiscellaneousFee;
    var GrandTotal = parseInt(document.getElementById("GrandTotal").innerHTML);
    GrandTotal -= parseInt(deductAmount);
    document.getElementById("GrandTotal").innerHTML = GrandTotal;
    
    document.getElementById("tblOtherFee").deleteRow(FeeIndex+1);

}

//modal for pay now
function ProcessPayment(){
    HideModalPaymentChoice();
    ShowModalPayNow();
    document.getElementById("p-GrandTotal").innerHTML = document.getElementById("GrandTotal").innerHTML;
}

//listener for pay now inputs, validates the input
function SendInput(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    var GrandTotal = document.getElementById("p-GrandTotal").innerHTML;
    if(!($(holder).hasClass('has-warning'))){
        var tempValue = parseInt(field.value);
        var Change = tempValue - GrandTotal;
        if(Change < 0){
            document.getElementById("Change").innerHTML = "Insufficient Payment";
        }
        else{
            document.getElementById("Change").innerHTML = Change;
        }
    }
    
}

function ShowInvoice() {

    var intDaysOfStay = document.getElementById("b-DaysOfStay").innerHTML;

    var tblRoomInfo = GetTableInfo("tblBill");
    var tblFeeInfo = GetTableInfo("tblOtherFee");

    var intTotalAdults = document.getElementById("b-TotalAdults").innerHTML;

    var strCustomerName = document.getElementById("i-FullName").innerHTML;
    var strCustomerAddress = document.getElementById("i-Address").innerHTML;

    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    // $.ajax({

    //     type: 'POST',
    //     url: '/Reservation/Invoice',
    //     data: {

    //         InvoiceType: "WalkIn",
    //         tblRoomInfo: tblRoomInfo,
    //         strCustomerName: strCustomerName,
    //         strCustomerAddress: strCustomerAddress,
    //         intTotalAdults: intTotalAdults

    //     },
    //     success: function(data) {



    //     },
    //     error: function(jqXHR, exception){
    //         var msg = '';
    //         if (jqXHR.status === 0) {
    //             msg = 'Not connect.\n Verify Network.';
    //         } else if (jqXHR.status == 404) {
    //             msg = 'Requested page not found. [404]';
    //         } else if (jqXHR.status == 500) {
    //             msg = 'Internal Server Error [500].';
    //         } else if (exception === 'parsererror') {
    //             msg = 'Requested JSON parse failed.';
    //         } else if (exception === 'timeout') {
    //             msg = 'Time out error.';
    //         } else if (exception === 'abort') {
    //             msg = 'Ajax request aborted.';
    //         } else {
    //             msg = 'Uncaught Error.\n' + jqXHR.responseText;
    //         }
    //         alert(msg);
    //     }

    // });

}

function SetInvoiceInfo() {

    var tblRoomInfo = GetTableInfo("tblBill");
    var tblFeeInfo = GetTableInfo("tblOtherFee");

    document.getElementById("DaysOfStay").value = document.getElementById("b-DaysOfStay").innerHTML;
    $('#tblRoomInfo').val(JSON.stringify(tblRoomInfo));
    $('#tblFeeInfo').val(JSON.stringify(tblFeeInfo));
    document.getElementById("iCustomerName").value = document.getElementById("i-FullName").innerHTML;
    document.getElementById("iCustomerAddress").value = document.getElementById("i-Address").innerHTML;
    document.getElementById("iTotalAdults").value = document.getElementById("b-TotalAdults").innerHTML;
    document.getElementById("iAmountTendered").value = document.getElementById("AmountTendered").value;

}

function GetTableInfo(TableName) {

    var tblInfo = [];

    //gets table
    var oTable = document.getElementById(TableName);

    //gets rows of table
    var rowLength = oTable.rows.length;

    //loops through rows    
    for (i = 0; i < rowLength; i++){

        tblInfo[i] = [];

       //gets cells of current row
       var oCells = oTable.rows.item(i).cells;

       //gets amount of cells of current row
       var cellLength = oCells.length;

       //loops through each cell in current row
       for(var j = 0; j < cellLength; j++){
          /* get your cell info here */
          /* var cellVal = oCells.item(j).innerHTML; */

          tblInfo[i][j] = oCells.item(j).innerHTML;

       }
    }

    return tblInfo;

}
