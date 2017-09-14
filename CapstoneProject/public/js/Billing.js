var BillInfo = [];

function ShowModalReservationInfo(){
    document.getElementById("DivModalReservationInfo").style.display = "block";
}

function HideModalReservationInfo(){
    document.getElementById("DivModalReservationInfo").style.display = "none";
}

function ShowModalBillBreakdown(){
    document.getElementById("DivModalBillBreakdown").style.display = "block";
}

function HideModalBillBreakdown(){
    document.getElementById("DivModalBillBreakdown").style.display = "none";
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
    BillInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML];
    getReservationInfo();
    getBillBreakdown();
}

function getReservationInfo(){
   $.ajax({
        type:'get',
        url:'/Reservation/Info',
        data:{id:BillInfo[0]},
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
            document.getElementById("i-CheckInDate").innerHTML = BillInfo[2];
            document.getElementById("i-CheckOutDate").innerHTML =  BillInfo[3];
            document.getElementById("i-PickUpTime").innerHTML = PickUpTime;
            document.getElementById("i-NoOfAdults").innerHTML = data.ReservationInfo[0].intResDNoOfAdults;
            document.getElementById("i-NoOfKids").innerHTML = data.ReservationInfo[0].intResDNoOfKids;
            document.getElementById("i-Remarks").innerHTML = data.ReservationInfo[0].strResDRemarks;
            document.getElementById("i-Name").innerHTML = BillInfo[1];
            document.getElementById("i-Address").innerHTML = data.ReservationInfo[0].strCustAddress;
            document.getElementById("i-ContactNumber").innerHTML = data.ReservationInfo[0].strCustContact;
            document.getElementById("i-Email").innerHTML = data.ReservationInfo[0].strCustEmail;
            document.getElementById("i-Age").innerHTML = getAge(data.ReservationInfo[0].dtmCustBirthday);
            document.getElementById("i-Nationality").innerHTML = data.ReservationInfo[0].strCustNationality;
            
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

function getBillBreakdown(){
    $.ajax({
        type:'get',
        url:'/Billing/Info',
        data:{id:BillInfo[0]},
        success:function(data){
            $('#tblBillPackage tbody').empty();
            $('#tblBillAccommodation tbody').empty();
            $('#tblBillItem tbody').empty();
            $('#tblBillBoat tbody').empty();
            $('#tblBillActivity tbody').empty();
            $('#tblBillFee tbody').empty();
            $('#tblBillMiscellaneous tbody').empty();
            $('#tblBillAdditional tbody').empty();
            $('#tblBillUpgrade tbody').empty();
            
            var tableRef = document.getElementById('tblBillAccommodation').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.RoomInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3  = newRow.insertCell(2);

                newCell1.innerHTML = data.RoomInfo[x].strRoomType;
                newCell2.innerHTML = data.RoomInfo[x].strRoomName;
                newCell3.innerHTML = data.RoomInfo[x].dblRoomRate;

            }
            
            tableRef = document.getElementById('tblBillAdditional').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.AdditionalRooms.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3  = newRow.insertCell(2);

                newCell1.innerHTML = data.AdditionalRooms[x].strRoomType;
                newCell2.innerHTML = data.AdditionalRooms[x].strRoomName;
                newCell3.innerHTML = data.AdditionalRooms[x].dblRoomRate;

            }
            
            tableRef = document.getElementById('tblBillPackage').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.PackageInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                
                newCell1.innerHTML = data.PackageInfo[x].strPackageName;
                newCell2.innerHTML = data.PackageInfo[x].intPackagePax;

            }
            
            tableRef = document.getElementById('tblBillUpgrade').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.UpgradeRooms.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                
                newCell1.innerHTML = data.UpgradeRooms[x].strPaymentRemarks;
                newCell2.innerHTML = data.UpgradeRooms[x].dblPayAmount;

            }
            
            tableRef = document.getElementById('tblBillItem').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.ItemInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3  = newRow.insertCell(2);
                var newCell4  = newRow.insertCell(3);

                newCell1.innerHTML = data.ItemInfo[x].strItemName;
                newCell2.innerHTML = data.ItemInfo[x].intRentedIQuantity;
                newCell3.innerHTML = data.ItemInfo[x].intRentedIDuration;
                newCell4.innerHTML = data.ItemInfo[x].dblItemRate;
            }
            
            tableRef = document.getElementById('tblBillActivity').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.ActivityInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3  = newRow.insertCell(2);

                newCell1.innerHTML = data.ActivityInfo[x].strBeachAName;
                newCell2.innerHTML = data.ActivityInfo[x].intAvailBAQuantity;
                newCell3.innerHTML = data.ActivityInfo[x].dblBeachARate;
            }
            
            tableRef = document.getElementById('tblBillFee').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.FeeInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3  = newRow.insertCell(2);

                newCell1.innerHTML = data.FeeInfo[x].strFeeName;
                newCell2.innerHTML = data.FeeInfo[x].intResFQuantity;
                newCell3.innerHTML = data.FeeInfo[x].dblFeeAmount;
            }
            
            tableRef = document.getElementById('tblBillMiscellaneous').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.MiscellaneousInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3  = newRow.insertCell(2);

                newCell1.innerHTML = data.MiscellaneousInfo[x].strPaymentType;
                var MiscellaneousObject = $.parseJSON('[' + data.MiscellaneousInfo[x].strPaymentRemarks + ']');
                newCell2.innerHTML = MiscellaneousObject[0].Description + " for " + MiscellaneousObject[0].ItemName;
                newCell3.innerHTML = data.MiscellaneousInfo[x].dblPayAmount;
            }
        },
        error:function(response){
            console.log(response);
            alert(response.status);
        }
    });
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