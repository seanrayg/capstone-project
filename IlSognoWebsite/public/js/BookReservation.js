var RemovedRows = "";
var AvailableRooms = [];
var RemovedRows = "";
var AddRowIndex;
var BoatsUsed = "";
var TotalCapacity = 0;
var BoatList;
/*---------------Reservation Date Functions-----------*/

//submit reservation dates
function CheckInput(){
    var CheckInDate = document.getElementById("CheckInDate");
    var CheckOutDate = document.getElementById("CheckOutDate");
    var NoOfKids = document.getElementById("NoOfKids");
    var NoOfAdults = document.getElementById("NoOfAdults");
    var TimeError = CheckTime();
    if(TimeError){
        $('.alert').show();
        document.getElementById("ErrorMessage").innerHTML = "Valid pick up time is only between 6AM to 5PM";
    }
    else{
        $('.alert').hide();
        if((CheckInDate.value.trim() == "") || (CheckOutDate.value.trim() == "") || (NoOfKids.value.trim() == "") || (NoOfAdults.value.trim() == "")){
            $('.alert').show();
            document.getElementById("ErrorMessage").innerHTML = "Please fill out all the fields";
        }
        else if($('.form-group').hasClass('has-danger')){
            $('.alert').show();
            document.getElementById("ErrorMessage").innerHTML = "Invalid input on some fields";
        }
        else{
            $('#ModalAvailBoat').modal('show');
            $('#BtnAvailBoat').click(function () {
                if (this.id == 'BtnAvailBoat') {
                    $('#ModalAvailBoat').modal('hide');
                    getAvailableBoats();
                }
            });
            $('#BtnAvailNoBoat').click(function () {
                if (this.id == 'BtnAvailNoBoat') {
                    $('#ModalAvailBoat').modal('hide');
                    switchTab('WithoutBoats');
                }
            });

        }
    }
}

//switch tab controller for reservation dates
function switchTab(GuestChoice){
    if(GuestChoice == "WithoutBoats"){
        BoatsUsed = "";
    }
    getAvailableRooms();
    $('.alert').hide();
    $('#ReservationDate').removeClass('active');
    $('#DateList').removeClass('active');
    $('#RoomList').addClass('active');
    $('#ReservationRoom').addClass('active');
}

//available boats ajax
function getAvailableBoats(){
    var CheckInDate = document.getElementById("CheckInDate").value;
    var CheckOutDate = document.getElementById("CheckOutDate").value;

    var NoOfKids = document.getElementById("NoOfKids").value;
    var NoOfAdults = document.getElementById("NoOfAdults").value;
    var TotalGuests = parseInt(NoOfAdults) + parseInt(NoOfKids);

    var tempHour = document.getElementById("PickUpTime");
    var tempMinute = document.getElementById("PickUpMinute");
    var tempMerridean = document.getElementById("PickUpMerridean");
    var ChosenHour;
    if(tempMerridean.value == "PM"){
      ChosenHour = parseInt(tempHour.value) + 12;
    }
    else{
      ChosenHour = tempHour.value;
    }
    var PickUpTime = ChosenHour + ":" + tempMinute.value + ":00";
    $.ajax({
        type:'get',
        url:'/Reservation/Boats',
        data:{CheckInDate:CheckInDate,
              CheckOutDate:CheckOutDate,
              TotalGuests:TotalGuests,
              PickUpTime:PickUpTime},
        success:function(data){
            processBoat(data, TotalGuests);
        },
        error:function(response){
            console.log(response);
            alert(response.status);
        }
    });   
}

//boat modals
function processBoat(data, TotalGuests){
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
            $('#ModalMultipleBoats').modal('show');
            $('#BtnMultipleBoats, #BtnWithoutBoats2').click(function () {
                if (this.id == 'BtnMultipleBoats') {
                    $('#ModalMultipleBoats').modal('hide');
                    BoatsUsed = "";
                    TotalCapacity = 0;
                    MultipleBoatsFound = false;
                    var NoOfKids = document.getElementById("NoOfKids").value;
                    var NoOfAdults = document.getElementById("NoOfAdults").value;
                    var TotalGuests2 = parseInt(NoOfAdults) + parseInt(NoOfKids);
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
                        $('#ModalNoMultipleBoats').modal('show');
                        $('#BtnWithoutBoats3').click(function () {
                            if (this.id == 'BtnWithoutBoats3') {
                                $('#ModalNoMultipleBoats').modal('hide');
                                switchTab('WithoutBoats');
                            }
                        });
                    }//!Multiple Boats found
                    else{            
                        switchTab('WithBoats');
                    }
                }//Button Avail Multiple Boats
                else if (this.id == 'BtnWithoutBoats2') {
                    $('#ModalMultipleBoats').modal('hide');
                    switchTab('WithoutBoats');
                }
            });
        }//!BoatFound
        else{
            switchTab('WithBoats');
        }
    }//data length != 0*/
    else{
        $('#ModalNoBoats').modal('show');
        $('#BtnWithoutBoats1').click(function () {
            if (this.id == 'BtnWithoutBoats1') {
                $('#ModalNoBoats').modal('hide');
                switchTab('WithoutBoats');
            }
        });
    }

}

//get Rooms based on the given dates ajax
function getAvailableRooms(){
    var CheckInDate = document.getElementById("CheckInDate").value;
    var CheckOutDate = document.getElementById("CheckOutDate").value;
    var NoOfKids = document.getElementById("NoOfKids").value;
    var NoOfAdults = document.getElementById("NoOfAdults").value;
    var TotalGuests = parseInt(NoOfAdults) + parseInt(NoOfKids);

    var tempHour = document.getElementById("PickUpTime");
    var tempMinute = document.getElementById("PickUpMinute");
    var tempMerridean = document.getElementById("PickUpMerridean");
    var ChosenHour;
    var PickOutTime;
    if(tempMerridean.value == "PM"){
      ChosenHour = parseInt(tempHour.value) + 12;
    }
    else{
      ChosenHour = tempHour.value;
    }
    var PickUpTime = ChosenHour + ":" + tempMinute.value + ":00";
    
    if(CheckInDate == CheckOutDate){
        PickOutTime = PickUpTime;
    }
    else{
        PickOutTime = "23:59:59";
    }
    
    $.ajax({
        type:'get',
        url:'/Reservation/Rooms',
        data:{CheckInDate:CheckInDate+" "+PickUpTime,
              CheckOutDate:CheckOutDate+" "+PickOutTime},
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
                var newCell5 = newRow.insertCell(4);

                newCell1.innerHTML = data[x].strRoomType;
                newCell2.innerHTML = data[x].intRoomTCapacity;
                newCell3.innerHTML = data[x].dblRoomRate;
                newCell4.innerHTML = data[x].TotalRooms;
                newCell5.innerHTML = '<span data-toggle="tooltip" data-placement="top" title="Show more info"><button class="btn btn-neutral remove-padding" value='+data[x].strRoomType+' data-toggle="modal" data-target="#ModalRoomInfo" onclick="GetRoomInfo(this)"><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button></span>';


            }
        },
        error:function(response){
            console.log(response);
            alert("error");
        }
    });   
}

//Check in/out date event listener
$( document ).ready(function() {
    $('#CheckInDate').on('changeDate', function(ev) {
        var CheckInDate = new Date(document.getElementById("CheckInDate").value);
        var DateError = DateChecker(CheckInDate);
        if(DateError){
            $('.alert').show();
            $('#CheckInDateError').addClass("has-danger");
            document.getElementById("ErrorMessage").innerHTML = "Please choose a date 7 days from today";
        }
        else{
            $('.alert').hide();
            $('#CheckInDateError').removeClass("has-danger");
            if(document.getElementById("CheckOutDate").value.trim() != ""){
                var CheckOutDate = new Date(document.getElementById("CheckOutDate").value);
                var InvalidDates = CheckDates(CheckInDate, CheckOutDate);
                if(InvalidDates){
                    $('.alert').show();
                    $('#CheckOutDateError').addClass("has-danger");
                    document.getElementById("ErrorMessage").innerHTML = "Invalid Date!";
                }
            }
        }

    }).data('datepicker');

    $('#CheckOutDate').on('changeDate', function(ev) {
        CheckOutDate = new Date(document.getElementById("CheckOutDate").value);
        var DateError = DateChecker(CheckOutDate);
        if(DateError){
            $('.alert').show();
            $('#CheckOutDateError').addClass("has-danger");
            document.getElementById("ErrorMessage").innerHTML = "Please choose a date 7 days from today";
        }
        else{
            $('.alert').hide();
            $('#CheckOutDateError').removeClass("has-danger");
            if(document.getElementById("CheckInDate").value.trim() != ""){
                var CheckInDate = new Date(document.getElementById("CheckInDate").value);
                var InvalidDates = CheckDates(CheckInDate, CheckOutDate);
                if(InvalidDates){
                    $('.alert').show();
                    $('#CheckOutDateError').addClass("has-danger");
                    document.getElementById("ErrorMessage").innerHTML = "Invalid Date!";
                }
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

function CheckTime(){
      var tempHour = document.getElementById("PickUpTime");
      var tempMinute = document.getElementById("PickUpMinute");
      var tempMerridean = document.getElementById("PickUpMerridean");
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

function InputSender(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if($(holder).hasClass('has-danger')){
        $('.alert').show();
        document.getElementById("ErrorMessage").innerHTML = "Invalid input on some fields";
    }
    else{
       $('.alert').hide(); 
    }
}


/*---------------Reservation Room Functions-----------*/

function GetRoomInfo(field){
    $.ajax({
        type:'get',
        url:'/Package/RoomInfo',
        data:{RoomName:field.value},
        success:function(data){
            console.log('success');
            document.getElementById("RoomTypeName").innerHTML = field.value;
            document.getElementById("RoomCategory").innerHTML = data[0].intRoomTCategory;
            document.getElementById("RoomRate").innerHTML = data[0].dblRoomRate;
            document.getElementById("RoomCapacity").innerHTML = data[0].intRoomTCapacity;
            document.getElementById("NoOfBeds").innerHTML = data[0].intRoomTNoOfBeds;
            document.getElementById("NoOfBathrooms").innerHTML = data[0].intRoomTNoOfBathrooms;
            document.getElementById("RoomAircondition").innerHTML = data[0].intRoomTAirconditioned;
            document.getElementById("RoomDescription").innerHTML = data[0].strRoomDescription;
        },
        error:function(response){
            console.log(response);
        }
    });
}

//check room quantity
function CheckQuantity(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if($(holder).hasClass('has-danger')){
        document.getElementById("QuantityError").innerHTML = "Invalid input";
    }
    else{
        document.getElementById("QuantityError").innerHTML = "";
    }
}

//submit rooms
function CheckRooms(){
    var ErrorMessage = document.getElementById("RoomErrorMessage");
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
        $('.alert').show();
        ErrorMessage.innerHTML = "Please choose a room to reserve";
    }
    else if(!(TotalGuests <= TotalRoomCapacity)){
        $('.alert').show();
        ErrorMessage.innerHTML = "Total number of guests exceeds total capacity of selected rooms!";
    }
    else{
        $('.alert').hide();
        $('#ReservationRoom').removeClass('active');
        $('#RoomList').removeClass('active');
        $('#InfoList').addClass('active');
        $('#ReservationInfo').addClass('active');
    }
}

//table row clicked
$(document).ready(function(){
    $('#tblAvailableRooms').on('click', 'tbody tr', function(){
        HighlightRow(this);
        AddRowIndex = $(this).index();
    });

    $('#tblChosenRooms').on('click', 'tbody tr', function(){
        HighlightRow(this);
    });

});

//add room
function AddRoom(){
    var TotalRooms = document.getElementById("RoomQuantity").value;
    var TableChecker = CheckTable('#tblAvailableRooms tr');
    if(TableChecker){
        $('.alert').hide();
        if(TotalRooms == ""){
            $('#RoomQuantityError').addClass('has-danger');
            document.getElementById("QuantityError").innerHTML = "Please specify the number of rooms to avail";
        }
        else if(parseInt(TotalRooms) > parseInt(AvailableRooms[3])){
           $('#RoomQuantityError').addClass('has-danger');
            document.getElementById("QuantityError").innerHTML = "There are no enough rooms, please lower the room quantity";
        }
        else if(!($('#RoomQuantityError').hasClass('has-danger'))){
            RemovedRows += AvailableRooms[0]+"@"+AvailableRooms[1]+"@"+AvailableRooms[2]+"@"+AvailableRooms[3]+",";
            document.getElementById("tblAvailableRooms").deleteRow(AddRowIndex+1);
            var tableRef = document.getElementById('tblChosenRooms').getElementsByTagName('tbody')[0];

            var newRow   = tableRef.insertRow(tableRef.rows.length);


            var newCell1  = newRow.insertCell(0);
            var newCell2  = newRow.insertCell(1);
            var newCell3  = newRow.insertCell(2);
            var newCell4 = newRow.insertCell(3);
            var newCell5 = newRow.insertCell(4);

            newCell1.innerHTML = AvailableRooms[0];
            newCell2.innerHTML = AvailableRooms[1];
            newCell3.innerHTML = AvailableRooms[2];
            newCell4.innerHTML = TotalRooms;
            newCell5.innerHTML = '<span data-toggle="tooltip" data-placement="top" title="Remove"><button class="btn btn-neutral remove-padding" value='+AvailableRooms[0]+' onclick="RemoveRoom(this)"><i class="fa fa-remove text-primary cursor-pointer"></i></button></span>';


            document.getElementById("RoomQuantity").value = "";
        }

    }

    else{
        $('.alert').show();
        document.getElementById("RoomErrorMessage").innerHTML = "Please choose a room to avail";
    }
}

//remove room
function RemoveRoom(field){
    var RemoveRowIndex = $(field).closest('tr').index();
    var temp = RemovedRows.split(',');
    for(var x = 0; x < temp.length; x++){
       if (temp[x].indexOf(field.value) > -1)
            {
                  var tableRef = document.getElementById('tblAvailableRooms').getElementsByTagName('tbody')[0];

                  var newRow   = tableRef.insertRow(tableRef.rows.length);

                  var newCell1  = newRow.insertCell(0);
                  var newCell2  = newRow.insertCell(1);
                  var newCell3  = newRow.insertCell(2);
                  var newCell4 = newRow.insertCell(3);
                  var newCell5 = newRow.insertCell(4);

                  var ReturnRoom = temp[x].split("@");

                  newCell1.innerHTML = ReturnRoom[0];
                  newCell2.innerHTML = ReturnRoom[1];
                  newCell3.innerHTML = ReturnRoom[2];
                  newCell4.innerHTML = ReturnRoom[3];
                  newCell5.innerHTML = '<span data-toggle="tooltip" data-placement="top" title="Remove"><button class="btn btn-neutral remove-padding" value='+ReturnRoom[0]+' onclick="RemoveRoom(this)"><i class="fa fa-remove text-primary cursor-pointer"></i></button></span>';

                  break;
            }
   }
   document.getElementById("tblChosenRooms").deleteRow(RemoveRowIndex+1);


}


/*---------------Reservation Info Functions-----------*/

//Validates input for textfields

function CheckInfoInput(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if($('.form-group').hasClass('has-danger')){
        $('.alert').show();
        document.getElementById("InfoErrorMessage").innerHTML = "Invalid input on some fields";
    }
    else{
        $('.alert').hide();
        document.getElementById("InfoErrorMessage").innerHTML = "";
    }
}

//Submit Reservation Info

function CheckReservationInfo(){
    var CustomerAge = "";
    if(document.getElementById("DateOfBirth").value != ""){
        CustomerAge = getAge(document.getElementById("DateOfBirth").value);
    }
    if((document.getElementById("FirstName").value == "")||(document.getElementById("MiddleName").value == "") ||           (document.getElementById("LastName").value == "")||(document.getElementById("ContactNumber").value == "") || (document.getElementById("Nationality").value == "")||(document.getElementById("DateOfBirth").value == "") || (document.getElementById("Address").value == "")||(document.getElementById("Email").value == "")){
        $('.alert').show();
        document.getElementById("InfoErrorMessage").innerHTML = "Please fill out all fields";
    }
    else if($(".form-group").hasClass("has-danger")){
        $('.alert').show();
        document.getElementById("InfoErrorMessage").innerHTML = "Invalid input on some fields";
    }
    else if(parseInt(CustomerAge)<18){
        $('.alert').show();
        document.getElementById("InfoErrorMessage").innerHTML = "Only customers 18 years old and above are allowed to book a reservation";
    }
    else{
        var FirstName = document.getElementById("FirstName").value;
        var MiddleName = document.getElementById("MiddleName").value;
        var LastName = document.getElementById("LastName").value;
        var Birthday = document.getElementById("DateOfBirth").value;
        var Gender = document.getElementById("SelectGender").value;

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

function FillDataSummary(){
    var tempHour = document.getElementById("PickUpTime");
    var tempMinute = document.getElementById("PickUpMinute");
    var tempMerridean = document.getElementById("PickUpMerridean");

    var FirstName = document.getElementById("FirstName").value;
    var MiddleName = document.getElementById("MiddleName").value;
    var LastName = document.getElementById("LastName").value;

    document.getElementById("i-CheckInDate").innerHTML = document.getElementById("CheckInDate").value;
    document.getElementById("i-CheckOutDate").innerHTML = document.getElementById("CheckOutDate").value;
    document.getElementById("i-ArrivalTime").innerHTML = tempHour.value + ":" + tempMinute.value + " " + tempMerridean.value;
    document.getElementById("i-NoOfAdults").innerHTML = document.getElementById("NoOfAdults").value;
    document.getElementById("i-NoOfKids").innerHTML = document.getElementById("NoOfKids").value;
    document.getElementById("i-Remarks").innerHTML = document.getElementById("Remarks").value;
    document.getElementById("i-GuestName").innerHTML = FirstName + " " + MiddleName + " " + LastName;
    document.getElementById("i-Address").innerHTML = document.getElementById("Address").value;;
    document.getElementById("i-ContactNumber").innerHTML = document.getElementById("ContactNumber").value;
    document.getElementById("i-Email").innerHTML = document.getElementById("Email").value;
    document.getElementById("i-Gender").innerHTML = document.getElementById("SelectGender").value;
    document.getElementById("i-Nationality").innerHTML = document.getElementById("Nationality").value;
    document.getElementById("i-DateOfBirth").innerHTML = document.getElementById("DateOfBirth").value;
}

function FillInitialBill(data){

    var RentTotal = 0;
    var TransportationFee = 0;
    var EntranceFee = data[0].dblFeeAmount;
    var checker = "";
    var NoOfKids = document.getElementById("NoOfKids").value;
    var NoOfAdults = document.getElementById("NoOfAdults").value;

    var TotalGuests = parseInt(NoOfKids) + parseInt(NoOfAdults);
    $('#tblBill tbody').empty();
    var SelectedRooms = "";
    var ChosenRoomsData = "";
    var ChosenRooms = document.getElementById('tblChosenRooms'), cellsChosenRoom = ChosenRooms.getElementsByTagName('td');

    var ChosenRoomsCells = (document.getElementById('tblChosenRooms').getElementsByTagName("tr").length - 1) * 5;


    //Reserved rooms info
    for(var i = 0; i < ChosenRoomsCells; i += 5){
      SelectedRooms += cellsChosenRoom[i].innerHTML + ",";
      ChosenRoomsData += cellsChosenRoom[i].innerHTML + "-" + cellsChosenRoom[i + 1].innerHTML + "-" + cellsChosenRoom[i + 2].innerHTML + "-" + cellsChosenRoom[i + 3].innerHTML ;

      if(!(i == (ChosenRoomsCells - 5))){
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
    document.getElementById("b-DaysOfStay").innerHTML = diffDays;

    //Accomodation Fee
    document.getElementById("TotalAccomodationFee").innerHTML = diffDays * RentTotal;
    document.getElementById("AccomodationFee").innerHTML = document.getElementById("TotalAccomodationFee").innerHTML;

    //Total adult guests
    document.getElementById("b-TotalAdults").innerHTML = NoOfAdults;
    document.getElementById("EntranceFee").innerHTML = EntranceFee;
    document.getElementById("TotalEntranceFee").innerHTML = parseInt(NoOfAdults) * parseInt(EntranceFee);

    //Boats Used
    document.getElementById("BoatsUsed").innerHTML = BoatsUsed;
    var arrBoatUsed = BoatsUsed.split(",");

    for(var y = 0; y<(arrBoatUsed.length-1); y++){
        for(var x = 0; x<BoatList.length; x++){
            if(BoatList[x].strBoatName == arrBoatUsed[y]){
                TransportationFee += BoatList[x].dblBoatRate;
                checker += BoatList[x].dblBoatRate;
            }
        }
    }
    //Transportation Fee
    document.getElementById("TransportationFee").innerHTML = TransportationFee;

    //Miscellaneous Fee
    document.getElementById("TotalMiscellaneousFee").innerHTML = parseInt(document.getElementById("TotalEntranceFee").innerHTML) + TransportationFee;

    document.getElementById("MiscellaneousFee").innerHTML = document.getElementById("TotalMiscellaneousFee").innerHTML;

    //Grand Total

    document.getElementById("GrandTotal").innerHTML = parseInt(document.getElementById("MiscellaneousFee").innerHTML) + parseInt(document.getElementById("AccomodationFee").innerHTML);
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
        document.getElementById("QuantityError").innerHTML = "";
        document.getElementById("RoomQuantity").value = "";
        AvailableRooms = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML];
    }

    if(sender == "ChosenRooms"){
        ChosenRooms = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML];
    }   
}

function HideAlert(){
    $('.alert').hide();
}

function GoBack(OldHolder, NewHolder, OldList, NewList){
    $(OldHolder).removeClass('active');
    $(OldList).removeClass('active');
    $(NewList).addClass('active');
    $(NewHolder).addClass('active');
}


function SaveReservation(){
    var tempHour = document.getElementById("PickUpTime");
    var tempMinute = document.getElementById("PickUpMinute");
    var tempMerridean = document.getElementById("PickUpMerridean");
    var ChosenHour;
    if(tempMerridean.value == "PM"){
      ChosenHour = parseInt(tempHour.value) + 12;
    }
    else{
      ChosenHour = tempHour.value;
    }
    var PickUpTime = "01/01/2017 " + ChosenHour + ":" + tempMinute.value + ":00";
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
    
    document.getElementById("s-CheckInDate").value = document.getElementById("CheckInDate").value;
    document.getElementById("s-CheckOutDate").value = document.getElementById("CheckOutDate").value;
    document.getElementById("s-NoOfAdults").value = document.getElementById("NoOfAdults").value;
    document.getElementById("s-NoOfKids").value = document.getElementById("NoOfKids").value;
    document.getElementById("s-PickUpTime").value = PickUpTime;
    document.getElementById("s-BoatsUsed").value = BoatsUsed;
    document.getElementById("s-ChosenRooms").value = ChosenRooms;
    document.getElementById("s-FirstName").value = document.getElementById("FirstName").value;
    document.getElementById("s-MiddleName").value = document.getElementById("MiddleName").value;
    document.getElementById("s-LastName").value = document.getElementById("LastName").value;
    document.getElementById("s-Address").value = document.getElementById("Address").value;
    document.getElementById("s-Contact").value = document.getElementById("ContactNumber").value;
    document.getElementById("s-Email").value = document.getElementById("Email").value;
    document.getElementById("s-Nationality").value = document.getElementById("Nationality").value;
    document.getElementById("s-DateOfBirth").value = document.getElementById("DateOfBirth").value;
    document.getElementById("s-Gender").value = document.getElementById("SelectGender").value;
    document.getElementById("s-Remarks").value = document.getElementById("Remarks").value;
    document.getElementById("s-InitialBill").value = parseInt(document.getElementById("MiscellaneousFee").innerHTML) + parseInt(document.getElementById("AccomodationFee").innerHTML);
    return true;
}