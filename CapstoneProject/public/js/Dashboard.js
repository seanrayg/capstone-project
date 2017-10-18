function ShowModalArrivingGuests(){
    document.getElementById("DivModalArrivingGuests").style.display = "block";
}

function HideModalArrivingGuests(){
    document.getElementById("DivModalArrivingGuests").style.display = "none";
}

function ShowModalDepartingGuests(){
    document.getElementById("DivModalDepartingGuests").style.display = "block";
}

function HideModalDepartingGuests(){
    document.getElementById("DivModalDepartingGuests").style.display = "none";
}

function ShowModalNewReservations(){
    document.getElementById("DivModalNewReservations").style.display = "block";
}

function HideModalNewReservations(){
    document.getElementById("DivModalNewReservations").style.display = "none";
}

function ShowModalResort(){
    document.getElementById("DivModalResort").style.display = "block";
}

function HideModalResort(){
    document.getElementById("DivModalResort").style.display = "none";
}

function ShowModalReservationInfo(ReservationID){
    
    document.getElementById("DivModalReservationInfo").style.display = "block";
    
    $.ajax({
        type:'get',
        url:'/Reservation/Info',
        data:{id:ReservationID},
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
            document.getElementById("i-ReservationCode").innerHTML = data.ReservationInfo[0].strReservationCode;
            document.getElementById("i-CheckInDate").innerHTML = data.ReservationInfo[0].dtmResDArrival;
            document.getElementById("i-CheckOutDate").innerHTML =  data.ReservationInfo[0].dtmResDDeparture;
            document.getElementById("i-NoOfAdults").innerHTML = data.ReservationInfo[0].intResDNoOfAdults;
            document.getElementById("i-NoOfKids").innerHTML = data.ReservationInfo[0].intResDNoOfKids;
            document.getElementById("i-Remarks").innerHTML = data.ReservationInfo[0].strResDRemarks;
            document.getElementById("i-Name").innerHTML = data.ReservationInfo[0].Name;
            document.getElementById("i-Address").innerHTML = data.ReservationInfo[0].strCustAddress;
            document.getElementById("i-ContactNumber").innerHTML = data.ReservationInfo[0].strCustContact;
            document.getElementById("i-Email").innerHTML = data.ReservationInfo[0].strCustEmail;
            document.getElementById("i-Age").innerHTML = getAge(data.ReservationInfo[0].dtmCustBirthday);
            document.getElementById("i-Nationality").innerHTML = data.ReservationInfo[0].strCustNationality;
            document.getElementById("i-PaymentDueDate").innerHTML = data.ReservationInfo[0].PaymentDueDate;
            document.getElementById("i-DateBooked").innerHTML = data.ReservationInfo[0].dteResDBooking;
            document.getElementById("i-InitialBill").innerHTML = data.InitialBill[0].dblPayAmount;
            document.getElementById("i-RequiredDownpayment").innerHTML = Math.ceil(parseFloat(data.InitialBill[0].dblPayAmount) * .20);
            
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

function HideModalReservationInfo(){
    document.getElementById("DivModalReservationInfo").style.display = "none";
}

function ShowModalSendEmail(CustomerName, DownPayment, CustomerEmail, PaymentDueDate){
    document.getElementById("DivModalSendEmail").style.display = "block";
    var ContactNumber = document.getElementById("ContactNumber").value;
    
    document.getElementById("MessageTo").value = CustomerName;
    document.getElementById("MessageEmail").value = CustomerEmail;
    
    document.getElementById("MessageBody").value = "The Il Sogno Beach Resort would like to remind you to pay the downpayment amounting to "+DownPayment+" until " +PaymentDueDate +" for your reservation. For any inquiries you may call us at " + ContactNumber + " or visit our website as www.IlSognoBeachResort.com. This is a system generated message. Please do not reply.";

}

function HideModalSendEmail(){
    document.getElementById("DivModalSendEmail").style.display = "none";
}

function ShowModalCancelReservation(ReservationID){
    document.getElementById("CancelReservationID").value = ReservationID;
    document.getElementById("DivModalCancelReservation").style.display = "block";
}

function HideModalCancelReservation(ReservationID){
    document.getElementById("DivModalCancelReservation").style.display = "none";
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

function SetCustomerEmail() {

    document.getElementById("CustomerEmail").value = document.getElementById("MessageEmail").value;
    document.getElementById("EmailMessage").value =document.getElementById("MessageBody").value;

}