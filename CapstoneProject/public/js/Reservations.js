var PendingReservationInfo = [];
var ActiveReservationInfo = [];

function ShowModalReservationOptions(){
    document.getElementById("DivModalReservationOptions").style.display = "block";
}

function HideModalReservationOptions(){
    document.getElementById("DivModalReservationOptions").style.display = "none";
}

function ShowModalReservationInfo(){
    var TableChecker = CheckTable('#PendingReservationTable tr');

    if(TableChecker){
        document.getElementById("DivModalReservationInfo").style.display = "block";
        getReservationInfo();
    }
}

function HideModalReservationInfo(){
    document.getElementById("DivModalReservationInfo").style.display = "none";
}

function ShowModalCancelReservation(){
    var TableChecker = CheckTable('#PendingReservationTable tr');
    if(TableChecker){
        document.getElementById("CancelReservationID").value = PendingReservationInfo[0];
        document.getElementById("WarningMessage").innerHTML = "Delete reservation of "+PendingReservationInfo[1]+"?";
        document.getElementById("DivModalCancelReservation").style.display = "block";
    }
}

function HideModalCancelReservation(){
    document.getElementById("DivModalCancelReservation").style.display = "none";
}

function getReservationInfo(){
    $.ajax({
        type:'get',
        url:'/Reservation/Info',
        data:{id:PendingReservationInfo[0]},
        success:function(data){
            var PickUpTime = "";
            var tempPickUpTime = data.ReservationInfo[0].dtmResDArrival.split(" ");
            var arrPickUpTime = tempPickUpTime[1].split(":");
            if(parseInt(arrPickUpTime[0]) > 12){
                arrPickUpTime[0] = parseInt(arrPickUpTime[0]) - 12;
                PickUpTime = arrPickUpTime[0] + ":" + arrPickUpTime[1] + ":" + arrPickUpTime[2] + " PM";
            }
            else{
                arrPickUpTime[0] = parseInt(arrPickUpTime[0]) - 12;
                PickUpTime = tempPickUpTime[1] + " AM";
            }
            
            document.getElementById("i-ReservationID").innerHTML = data.ReservationInfo[0].strReservationID;
            document.getElementById("i-ReservationCode").innerHTML = PendingReservationInfo[8];
            document.getElementById("i-CheckInDate").innerHTML = PendingReservationInfo[4];
            document.getElementById("i-CheckOutDate").innerHTML =  PendingReservationInfo[5];
            document.getElementById("i-PickUpTime").innerHTML = PickUpTime;
            document.getElementById("i-NoOfAdults").innerHTML = data.ReservationInfo[0].intResDNoOfAdults;
            document.getElementById("i-NoOfKids").innerHTML = data.ReservationInfo[0].intResDNoOfKids;
            document.getElementById("i-Remarks").innerHTML = data.ReservationInfo[0].strResDRemarks;
            document.getElementById("i-Name").innerHTML = PendingReservationInfo[1];
            document.getElementById("i-Address").innerHTML = data.ReservationInfo[0].strCustAddress;
            document.getElementById("i-ContactNumber").innerHTML = PendingReservationInfo[6];
            document.getElementById("i-Email").innerHTML = PendingReservationInfo[7];
            document.getElementById("i-Age").innerHTML = getAge(data.ReservationInfo[0].dtmCustBirthday);
            document.getElementById("i-Nationality").innerHTML = data.ReservationInfo[0].strCustNationality;
            document.getElementById("i-PaymentDueDate").innerHTML = PendingReservationInfo[3];
            document.getElementById("i-DateBooked").innerHTML = PendingReservationInfo[2];
            
            if(data.ReservationInfo[0].strCustGender == "M"){
                document.getElementById("i-Gender").innerHTML = "Male";
            }
            else{
                document.getElementById("i-Gender").innerHTML = "Female";
            }

            $('#tblChosenRooms tbody').empty();
            $('#tblChosenBoats tbody').empty();
            
            var tableRef = document.getElementById('tblChosenRooms').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.ChosenRooms.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);

                newCell1.innerHTML = data.ChosenRooms[x].strRoomType;
                newCell2.innerHTML = data.ChosenRooms[x].TotalRooms;

            }

            tableRef = document.getElementById('tblChosenBoats').getElementsByTagName('tbody')[0];
            if(data.ChosenBoats.length != 0){
                for(var x = 0; x < data.ChosenBoats.length; x++){
                    var newRow   = tableRef.insertRow(tableRef.rows.length);

                    var newCell1  = newRow.insertCell(0);

                    newCell1.innerHTML = data.ChosenBoats[x].strBoatName;

                }
            }

            else{
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);

                newCell1.innerHTML = "None";
            }
        },
        error:function(response){
            console.log(response);
            alert(response.status);
        }
    });  
}


//MISC

function EditPendingReservation(){
    var TableChecker = CheckTable('#PendingReservationTable tr');
    if(TableChecker){        
        window.location.href = '/EditReservations/'+PendingReservationInfo[0];
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

    if(sender == "Pending"){
        PendingReservationInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML, cells[7].innerHTML, cells[8].innerHTML];
    }
    else if(sender == "Active"){
        //RoomTypeInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML, cells[7].innerHTML, cells[8].innerHTML];
    }

}