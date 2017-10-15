var PendingReservationInfo = [];
var ActiveReservationInfo = [];
var AvailableBoatInfo = [];
var InitialBill = 0;
var bReservationID;
var bCheckInDate;
var bCheckOutDate;
var bPickUpTime; 
var bTotalGuests = 0;
var bNoOfKids = 0;
var bNoOfAdults = 0;

function ShowModalManageBoats(){
    

    var TableChecker = CheckTable('#PendingReservationTable tr');
    var TableChecker2 = CheckTable('#ConfirmedReservationTable tr');
    if(TableChecker){
        bReservationID = PendingReservationInfo[0];
    }
    else if(TableChecker2){
        bReservationID = ActiveReservationInfo[0];
    }
    $.ajax({
        type:'get',
        url:'/Reservation/Dates',
        data:{ReservationID:bReservationID},
        success:function(data){
            bPickUpTime = data[0].PickUpTime;
            bCheckInDate = data[0].dtmResDArrival;
            bCheckOutDate = data[0].dtmResDDeparture;
            bNoOfKids = data[0].intResDNoOfKids;
            bNoOfAdults = data[0].intResDNoOfAdults;
            bTotalGuests = parseInt(bNoOfKids) + parseInt(bNoOfAdults);
            $.ajax({
                type:'get',
                url:'/Reservation/Boats',
                data:{CheckInDate:bCheckInDate,
                      CheckOutDate:bCheckOutDate,
                      TotalGuests:bTotalGuests,
                      PickUpTime:bPickUpTime},
                success:function(data){

                    $('#tblAvailableBoats tbody').empty();

                    var tableRef = document.getElementById('tblAvailableBoats').getElementsByTagName('tbody')[0];

                    for(var x = 0; x < data.length; x++){
                        var newRow   = tableRef.insertRow(tableRef.rows.length);

                        var newCell1  = newRow.insertCell(0);
                        var newCell2  = newRow.insertCell(1);
                        var newCell3  = newRow.insertCell(2);
                        var newCell4  = newRow.insertCell(3);
                        var newCell5  = newRow.insertCell(4);

                        newCell1.innerHTML = data[x].strBoatID;
                        newCell2.innerHTML = data[x].strBoatName;
                        newCell3.innerHTML = data[x].intBoatCapacity;
                        newCell4.innerHTML = data[x].dblBoatRate;
                        newCell5.innerHTML = data[x].strBoatDescription;
                    }
                },
                error:function(response){
                    console.log(response);
                    alert(response.status);
                }
            }); 
        },
        error:function(response){
            console.log(response);
            alert(response.status);
        }
    }); 
    document.getElementById("DivModalManageBoats").style.display = "block";
}

function HideModalManageBoats(){
    document.getElementById("DivModalManageBoats").style.display = "none";
}

function ShowModalPaidDepositSlip(){
    HideModalPaidDownpayment();
    $.ajax({
        type:'get',
        url:'/Reservation/DepositSlip',
        data:{id:ActiveReservationInfo[0]},
        success:function(data){
            if(data[0].strResDDepositSlip != null){
                document.getElementById("DepositSlip").src=data[0].strResDDepositSlip;
                HideModalPaidReservation();
                document.getElementById("DivModalDepositSlip").style.display = "block";
            }
            else{
                HideModalPaidReservation();
                document.getElementById("DivModalNoDepositSlip").style.display = "block";
            }
        },
        error:function(response){
            console.log(response);
            alert(response.status);
        }
    });  
}

function ShowModalPaidDownpayment(){
    var TableChecker = CheckTable('#ConfirmedReservationTable tr');
    if(TableChecker){
         $.ajax({
            type:'get',
            url:'/Reservation/Downpayment',
            data:{ReservationID:ActiveReservationInfo[0]},
            success:function(data){
                document.getElementById("PaidDownpayment").value = data[0].dblPayAmount;
                document.getElementById("DivModalPaidDownpayment").style.display = "block";
                document.getElementById("EditDownReservationID").value = ActiveReservationInfo[0];

            },
            error:function(response){
                console.log(response);
                alert(response.status);
            }
        });  
        
    }
}

function HideModalPaidDownpayment(){
    document.getElementById("DivModalPaidDownpayment").style.display = "none";
}

function ShowModalPayNow(){
    HideModalPayment();
    document.getElementById("PayTotal").value = ActiveReservationInfo[9];
    document.getElementById("PayReservationID").value = ActiveReservationInfo[0];
    document.getElementById("DivModalPayNow").style.display = "block";
}

function HideModalPayNow(){
    document.getElementById("DivModalPayNow").style.display = "none";
}

function ShowModalReservationOptions(){
    document.getElementById("DivModalReservationOptions").style.display = "block";
}

function HideModalReservationOptions(){
    document.getElementById("DivModalReservationOptions").style.display = "none";
}

function ShowModalReservationInfo(){
    var TableChecker = CheckTable('#PendingReservationTable tr');
    var TableChecker2 = CheckTable('#ConfirmedReservationTable tr');
    if(TableChecker){
        document.getElementById("DivModalReservationInfo").style.display = "block";
        getReservationInfo();
    }
    else if(TableChecker2){
        document.getElementById("DivModalReservationInfo").style.display = "block";
        getConfirmedReservationInfo();
    }
}

function HideModalReservationInfo(){
    document.getElementById("DivModalReservationInfo").style.display = "none";
}

function ShowModalCancelReservation(){
    var TableChecker = CheckTable('#PendingReservationTable tr');
    var TableChecker2 = CheckTable('#ConfirmedReservationTable tr');
    
    if(TableChecker){
        document.getElementById("CancelReservationID").value = PendingReservationInfo[0];
        document.getElementById("WarningMessage").innerHTML = "Delete reservation of "+PendingReservationInfo[1]+"?";
        document.getElementById("DivModalCancelReservation").style.display = "block";
    }
    else if(TableChecker2){
        document.getElementById("CancelReservationID").value = ActiveReservationInfo[0];
        document.getElementById("WarningMessage").innerHTML = "Delete reservation of "+ActiveReservationInfo[1]+"?";
        document.getElementById("DivModalCancelReservation").style.display = "block";
    }
}

function HideModalCancelReservation(){
    document.getElementById("DivModalCancelReservation").style.display = "none";
}

function ShowModalPaidReservation(){
    var TableChecker = CheckTable('#PendingReservationTable tr');
    if(TableChecker){
        $.ajax({
            type:'get',
            url:'/Reservation/Info',
            data:{id:PendingReservationInfo[0]},
            success:function(data){
                document.getElementById("d-Name").innerHTML = PendingReservationInfo[1];
                document.getElementById("d-Address").innerHTML = data.ReservationInfo[0].strCustAddress;
                document.getElementById("d-ContactNumber").innerHTML = PendingReservationInfo[6];
                document.getElementById("d-Email").innerHTML = PendingReservationInfo[7];
                document.getElementById("d-PaymentDueDate").innerHTML = PendingReservationInfo[3];
                document.getElementById("d-DateBooked").innerHTML = PendingReservationInfo[2];
                document.getElementById("d-InitialBill").innerHTML = data.InitialBill[0].dblPayAmount;
                InitialBill = data.InitialBill[0].dblPayAmount;
                document.getElementById("d-RequiredDownpayment").innerHTML = Math.ceil(parseFloat(data.InitialBill[0].dblPayAmount) * .20);
                document.getElementById("DivModalPaidReservation").style.display = "block";
            },
            error:function(response){
                console.log(response);
                alert(response.status);
            }
        });  
    }
}

function HideModalPaidReservation(){
    document.getElementById("DivModalPaidReservation").style.display = "none";
}

function ShowModalDepositSlip(){
    $.ajax({
        type:'get',
        url:'/Reservation/DepositSlip',
        data:{id:PendingReservationInfo[0]},
        success:function(data){
            if(data[0].strResDDepositSlip != null){
                document.getElementById("DepositSlip").src=data[0].strResDDepositSlip;
                HideModalPaidReservation();
                document.getElementById("DivModalDepositSlip").style.display = "block";
            }
            else{
                HideModalPaidReservation();
                document.getElementById("DivModalNoDepositSlip").style.display = "block";
            }
        },
        error:function(response){
            console.log(response);
            alert(response.status);
        }
    });  
}

function HideModalDepositSlip(){
    ShowModalPaidReservation();
    document.getElementById("DivModalDepositSlip").style.display = "none";
}

function ShowModalNoDepositSlip(){
    document.getElementById("DivModalNoDepositSlip").style.display = "block";
}

function HideModalNoDepositSlip(field){
    document.getElementById("DivModalNoDepositSlip").style.display = "none";
    if(field == "continue"){
        ShowModalPaidReservation();
    }
}

function ShowModalCheckIn(){
    var TableChecker = CheckTable('#ConfirmedReservationTable tr');
    if(TableChecker){
        var tempToday = new Date();
        var monthToday = parseInt(tempToday.getMonth())+1;
        if(monthToday >= 10){
            var DateToday = (tempToday.getMonth() + 1) + "/" + tempToday.getDate() + "/" + tempToday.getFullYear();
        }
        else{
            var DateToday = "0"+(tempToday.getMonth() + 1) + "/" + tempToday.getDate() + "/" + tempToday.getFullYear();
        }
        var TimeToday = tempToday.getHours() + ":" + tempToday.getMinutes() + ":" + tempToday.getSeconds();
        var arrDateInfo = ActiveReservationInfo[7].split(" ");
        if(DateToday >= arrDateInfo[0]){
            document.getElementById("CheckInReservationID").value = ActiveReservationInfo[0];
            document.getElementById("DivModalCheckIn").style.display = "block";
        }
        else{
            document.getElementById("CheckInError").innerHTML = "The reservation date of the guest is not today!";
        }
    }
}

function HideModalCheckIn(){
    document.getElementById("DivModalCheckIn").style.display = "none";
}

function ShowModalPayment(){
    HideModalCheckIn();
    document.getElementById("DivModalPayment").style.display = "block";
}

function HideModalPayment(){
    document.getElementById("DivModalPayment").style.display = "none";
}

//MISC

function EditPendingReservation(){
    var TableChecker = CheckTable('#PendingReservationTable tr');
    if(TableChecker){        
        window.location.href = '/EditReservations/'+PendingReservationInfo[0];
    }
}

function EditConfirmedReservation(){
    var TableChecker = CheckTable('#ConfirmedReservationTable tr');
    if(TableChecker){        
        window.location.href = '/EditReservations/'+ActiveReservationInfo[0];
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
        document.getElementById("CheckInError").innerHTML = "";
        ActiveReservationInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML, cells[7].innerHTML, cells[8].innerHTML, cells[9].innerHTML];
        document.getElementById("iReservationID").value = cells[0].innerHTML;
    }
    else if(sender == "AvailableBoats"){
       AvailableBoatInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML];
    }
}

function ManageRooms(){
    var TableChecker = CheckTable('#PendingReservationTable tr');
    var TableChecker2 = CheckTable('#ConfirmedReservationTable tr');
    if(TableChecker){
        localStorage.setItem("ReservationID", PendingReservationInfo[0]);
        window.location.href = '/ChooseRooms/'+PendingReservationInfo[0];
    }
    else if(TableChecker2){
        localStorage.setItem("ReservationID", ActiveReservationInfo[0]);
        window.location.href = '/ChooseRooms/'+ActiveReservationInfo[0];
    }
}

function ManageBoats(){
    if(parseInt(document.getElementById("tblChosenBoats").rows.length) != 1){
        ShowModalManageBoats();
    }
}

function SaveBoat(){
    var TableChecker = CheckTable('#PendingReservationTable tr');
    if(TableChecker){
        document.getElementById("EditBoatID").value = AvailableBoatInfo[0];
        document.getElementById("BoatReservationID").value = bReservationID;
        document.getElementById("BoatCheckInDate").value = bCheckInDate;
        document.getElementById("BoatCheckOutDate").value = bCheckOutDate;
        document.getElementById("BoatPickUpTime").value = bPickUpTime;
        document.getElementById("ChangeBoatForm").submit();
    }
}
//Table row clicked
$(document).ready(function(){
    $('#tblAvailableBoats').on('click', 'tbody tr', function(){
        HighlightRow(this);
    });
});

function ProcessDownPayment(){
    if((!($(".form-group").hasClass("has-warning"))) && (document.getElementById("DownpaymentAmount").value != "")){
        var DownPayment = parseInt(document.getElementById("DownpaymentAmount").value);
        var RequiredAmount = Math.ceil(parseFloat(InitialBill) * .20);
        if(DownPayment > InitialBill){
            $("#DownPaymentError").addClass("has-warning");
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="Downpayment exceeds the initial bill";
            }
        }
        else if(DownPayment >= RequiredAmount){
            /*--- Check here if there is an existing deposit slip ----*/
            //HideModalPaidReservation();
            //ShowModalNoDepositSlip();
            
            document.getElementById("d-ReservationID").value = PendingReservationInfo[0];
            document.getElementById("d-DownpaymentAmount").value = DownPayment;
            document.getElementById("DownpaymentForm").submit();
        }
        else{
            $("#DownPaymentError").addClass("has-warning");
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="Insufficient downpayment! Downpayment must be 20% of the initial bill (Php"+RequiredAmount+")";
            }
        }
    }
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
            
            if(data.ReservationPackage.length != 0){
                document.getElementById("i-PackageAvailed").innerHTML = data.ReservationPackage[0].strPackageName;
            }
            else{
                document.getElementById("i-PackageAvailed").innerHTML = "None";
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

        },
        error:function(response){
            console.log(response);
            alert(response.status);
        }
    });  
}

function getConfirmedReservationInfo(){
    $.ajax({
        type:'get',
        url:'/Reservation/Info',
        data:{id:ActiveReservationInfo[0]},
        success:function(data){
            var PickUpTime = "";
            var tempPickUpTime = data.ReservationInfo[0].dtmResDArrival.split(" ");
            alert(tempPickUpTime);
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
            document.getElementById("i-ReservationCode").innerHTML = ActiveReservationInfo[6];
            document.getElementById("i-CheckInDate").innerHTML = ActiveReservationInfo[2];
            document.getElementById("i-CheckOutDate").innerHTML =  ActiveReservationInfo[3];
            document.getElementById("i-PickUpTime").innerHTML = PickUpTime;
            document.getElementById("i-NoOfAdults").innerHTML = data.ReservationInfo[0].intResDNoOfAdults;
            document.getElementById("i-NoOfKids").innerHTML = data.ReservationInfo[0].intResDNoOfKids;
            document.getElementById("i-Remarks").innerHTML = data.ReservationInfo[0].strResDRemarks;
            document.getElementById("i-Name").innerHTML = ActiveReservationInfo[1];
            document.getElementById("i-Address").innerHTML = data.ReservationInfo[0].strCustAddress;
            document.getElementById("i-ContactNumber").innerHTML = ActiveReservationInfo[4];
            document.getElementById("i-Email").innerHTML = ActiveReservationInfo[5];
            document.getElementById("i-Age").innerHTML = getAge(data.ReservationInfo[0].dtmCustBirthday);
            document.getElementById("i-Nationality").innerHTML = data.ReservationInfo[0].strCustNationality;
            document.getElementById("i-PaymentDueDate").innerHTML = "N/A";
            document.getElementById("i-DateBooked").innerHTML = "N/A";
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

function SendPayment(field, dataType, holder){
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

function setReservationID() {

    document.getElementById("ReservationID").value = document.getElementById("i-ReservationID").innerHTML;

    if(document.getElementById("i-PackageAvailed").innerHTML == 'None' || document.getElementById("i-PackageAvailed").innerHTML == '') {

        document.getElementById("IsPackaged").value = 0;

    }else {

        document.getElementById("IsPackaged").value = 1;

    }

}


function PrintInvoice() {

    document.getElementById("iTotalAmount").value = document.getElementById("PayTotal").value;
    document.getElementById("InvoiceForm").submit();

}
function EditDownpayment(){
    document.getElementById("PaidDownpayment").disabled = false;
    document.getElementById("btnEditDownPayment").style.display = "none";
    document.getElementById("btnSaveDownPayment").style.display = "block";

}

