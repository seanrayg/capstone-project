var PackageInfo = [];
var BoatsUsed = "";
var TotalCapacity = 0;
var BoatList;
var tempTotal = 0;
var GrandTotal = 0;
var CheckInDate;
var CheckOutDate;
function ShowModalPaymentChoice(){
    document.getElementById("DivModalPaymentChoice").style.display = "block";
}

function HideModalPaymentChoice(){
    document.getElementById("DivModalPaymentChoice").style.display = "none";
}

function ShowModalPayNow(){
    HideModalPaymentChoice();
    document.getElementById("PayTotal").value = parseInt(document.getElementById("p-TotalEntranceFee").innerHTML) + parseInt(PackageInfo[2]);
    document.getElementById("pn-CheckInDate").value = CheckInDate;
    document.getElementById("pn-CheckOutDate").value = CheckOutDate;
    document.getElementById("pn-PackageID").value = PackageInfo[0];
    document.getElementById("pn-InitialBill").value = parseInt(document.getElementById("p-TotalEntranceFee").innerHTML) + parseInt(PackageInfo[2]);
    document.getElementById("pn-FirstName").value = document.getElementById("FirstName").value;
    document.getElementById("pn-MiddleName").value = document.getElementById("MiddleName").value;
    document.getElementById("pn-LastName").value = document.getElementById("LastName").value;
    document.getElementById("pn-Address").value = document.getElementById("Address").value;
    document.getElementById("pn-Email").value = document.getElementById("Email").value;
    document.getElementById("pn-Contact").value = document.getElementById("ContactNumber").value;
    document.getElementById("pn-Nationality").value = document.getElementById("Nationality").value;
    document.getElementById("pn-DateOfBirth").value = document.getElementById("DateOfBirth").value;
    document.getElementById("pn-Gender").value = document.getElementById("Gender").value;
    document.getElementById("pn-Remarks").value = document.getElementById("Remarks").value;
    document.getElementById("pn-NoOfKids").value = document.getElementById("NoOfKids").value;
    document.getElementById("pn-NoOfAdults").value = document.getElementById("NoOfAdults").value;
    document.getElementById("DivModalPayNow").style.display = "block";
}

function HideModalPayNow(){
    ShowModalPayNow();
    document.getElementById("DivModalPayNow").style.display = "none";
}


//MISC
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

function HideAlert(){
    $('.alert').hide();
}




function run(event){
    event = event || window.event; 
    var target = event.target || event.srcElement;
    while (target && target.nodeName != 'TR') {
        target = target.parentElement;
    }

    cells = target.cells;
    if (!cells.length || target.parentNode.nodeName == 'THEAD') {
        return;
    }

    PackageInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML];

    $.ajax({
        type:'get',
        url:'/Maintenance/Package/Info',
        data:{id:PackageInfo[0]},
        success:function(data){
            console.log('success');
            $('#tblIncludedItems tbody').empty();
            $('#tblIncludedRooms tbody').empty();
            $('#tblIncludedActivities tbody').empty();
            $('#tblIncludedFees tbody').empty();

            var tableRef = document.getElementById('tblIncludedItems').getElementsByTagName('tbody')[0];

            console.log(data);

            console.log(data.PackageRoomInfo.length);

            for(var x = 0; x < data.PackageItemInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3 = newRow.insertCell(2);

                newCell1.innerHTML = data.PackageItemInfo[x].strItemName;
                newCell2.innerHTML = data.PackageItemInfo[x].intPackageIQuantity;
                newCell3.innerHTML = data.PackageItemInfo[x].flPackageIDuration;

            }

            tableRef = document.getElementById('tblIncludedRooms').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.PackageRoomInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);

                newCell1.innerHTML = data.PackageRoomInfo[x].strRoomType;
                newCell2.innerHTML = data.PackageRoomInfo[x].intPackageRQuantity;
                
            }

            tableRef = document.getElementById('tblIncludedActivities').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.PackageActivityInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);

                newCell1.innerHTML = data.PackageActivityInfo[x].strBeachAName;
                newCell2.innerHTML = data.PackageActivityInfo[x].intPackageAQuantity;

            }
            
            tableRef = document.getElementById('tblIncludedFees').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.PackageFeeInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);

                newCell1.innerHTML = data.PackageFeeInfo[x].strFeeName;

            }
            
            Date.prototype.addDays = function(days) {
              var dat = new Date(this.valueOf());
              dat.setDate(dat.getDate() + days);
              return dat;    
            }

            var dat = new Date(CheckInDate);
            var DaysToAdd = parseInt(PackageInfo[4]);
            var tempDate = dat.addDays(DaysToAdd);
            var date = new Date(tempDate);
            var year=date.getFullYear();
            var tempmonth=date.getMonth()+1;
            var tempday=date.getDate();
            var month = "";
            var day = "";
            if(parseInt(tempmonth) < 10){
                month = "0" + tempmonth;
            }
            else{
                month = tempmonth;
            }

            if(parseInt(tempday) < 10){
                day = "0" + tempday;
            }
            else{
                day = tempday;
            }
            var formatted=month+"/"+day+"/"+year;
            document.getElementById("CheckOutDate").value = formatted;



        },
        error:function(response){
            console.log(response);
        }
    });   
}

//table row clicked

$(document).ready(function(){
    $('#PackageTable').on('click', 'tbody tr', function(){
        HighlightRow(this);
        AddRowIndex = $(this).index();
    });
    

});

function ChangeClass(sender, pageSender, newSender, newPageSender, action){
    var switchTab = false;
    if(action == "continue"){

        if(sender == "#ReservationDate"){
            var TableChecker = CheckTable('#PackageTable tr');
            if(TableChecker){
                switchTab = true;   
            }
            else{
                document.getElementById("ErrorMessage").innerHTML = "Please choose a package";
            }
                
        }// Reservation Date
        
        else if(sender == "#ReservationInfo"){
            var CustomerAge = "";
            if(document.getElementById("DateOfBirth").value != ""){
                CustomerAge = getAge(document.getElementById("DateOfBirth").value);
            }
            
            
            if((document.getElementById("FirstName").value == "")||(document.getElementById("MiddleName").value == "") ||           (document.getElementById("LastName").value == "")||(document.getElementById("ContactNumber").value == "") || (document.getElementById("Nationality").value == "")||(document.getElementById("DateOfBirth").value == "") || (document.getElementById("Address").value == "")||(document.getElementById("Email").value == "")||(document.getElementById("NoOfAdults").value == "")||(document.getElementById("NoOfKids").value == "")){
                switchTab = false;
                document.getElementById("ErrorMessage").innerHTML = "Please fill out all fields";
            }
            else if(($(".form-group").hasClass("has-warning")) || ($(".form-group").hasClass("has-error"))){
                switchTab = false;
                document.getElementById("ErrorMessage").innerHTML = "Invalid input on some fields";
            }
            else if(parseInt(CustomerAge)<18){
                switchTab = false;
                document.getElementById("ErrorMessage").innerHTML = "Customers only 18 years old and above are allowed to book a reservation";
            }
            else{
                getEntranceFee();
                switchTab = true;
            }
        }// Reservation Info
        
        
    }//continue

    if(action == "back"){
        switchTab = true;
        $('.alert').hide();
    }

    if(!switchTab){
        $('.alert').show();
    }
    else{
        $(sender).removeClass("active");
        $(newSender).addClass("active");
        $(pageSender).removeClass("active");
        $(newPageSender).addClass("active");
        $('.alert').hide();
    }

}


function getEntranceFee(){
    $.ajax({
        type:'get',
        url:'/Reservation/Fees',
        success:function(data){
            fillReservationSummary(data);
        },
        error:function(response){
            console.log(response);
            alert("error");
        }
    });   
}

function fillReservationSummary(data){
    var RentTotal = 0;
    var TransportationFee = 0;
    var EntranceFee = 0;
    var arrFeeContent = [];
    var EntranceFound = false;
    if(data.length >= 1){
        EntranceFee = data[0].dblFeeAmount;
    }
    else{
        EntranceFee = 0;
    }
    
  
    $('#tblIncludedFees tr').each(function() {
        if($(this).find("td:first").html() != null){
            arrFeeContent[arrFeeContent.length] = $(this).find("td:first").html();
        }
    });
    
    for(var x = 0; x < arrFeeContent.length; x++){
        if(arrFeeContent[x] == "Entrance Fee"){
            EntranceFound = true;
            break;
        }
    }
   
    var temp = new Date();
    CheckInDate = (parseInt(temp.getMonth()) + 1) + "/" + temp.getDate() + "/" + temp.getFullYear();
    
    Date.prototype.addDays = function(days) {
      var dat = new Date(this.valueOf());
      dat.setDate(dat.getDate() + days);
      return dat;    
    }

    var dat = new Date(CheckInDate);
    var DaysToAdd = parseInt(PackageInfo[4]);
    var tempDate = dat.addDays(DaysToAdd);
    var date = new Date(tempDate);
    var year=date.getFullYear();
    var tempmonth=date.getMonth()+1;
    var tempday=date.getDate();
    var month = "";
    var day = "";
    if(parseInt(tempmonth) < 10){
        month = "0" + tempmonth;
    }
    else{
        month = tempmonth;
    }

    if(parseInt(tempday) < 10){
        day = "0" + tempday;
    }
    else{
        day = tempday;
    }
    var formatted=month+"/"+day+"/"+year;
    CheckOutDate = formatted;
    
    document.getElementById("i-CheckInDate").innerHTML = CheckInDate;
    document.getElementById("i-CheckOutDate").innerHTML = CheckOutDate;
    document.getElementById("i-PackageName").innerHTML = PackageInfo[1];
    document.getElementById("i-PackagePrice").innerHTML = PackageInfo[2];
    document.getElementById("i-CustomerName").innerHTML = document.getElementById("FirstName").value + " " + document.getElementById("LastName").value;
    document.getElementById("i-Address").innerHTML = document.getElementById("Address").value;
    document.getElementById("i-Email").innerHTML = document.getElementById("Email").value;
    document.getElementById("i-Contact").innerHTML = document.getElementById("ContactNumber").value;
    document.getElementById("i-Nationality").innerHTML = document.getElementById("Nationality").value;
    document.getElementById("i-Birthday").innerHTML = document.getElementById("DateOfBirth").value;
    document.getElementById("i-Gender").innerHTML = document.getElementById("Gender").value;
    document.getElementById("i-Remarks").innerHTML = document.getElementById("Remarks").value;
    
    document.getElementById("p-PackageName").innerHTML = PackageInfo[1];
    document.getElementById("p-PackagePrice").innerHTML = PackageInfo[2];
    
    document.getElementById("p-GrandTotal").innerHTML = PackageInfo[2];
    
    document.getElementById("p-EntranceFee").innerHTML = EntranceFee;
    document.getElementById("p-NoOfAdults").innerHTML = document.getElementById("NoOfAdults").value;
    
    if(EntranceFound){
        document.getElementById("p-TotalEntranceFee").innerHTML = "0";
    }
    else{
        document.getElementById("p-TotalEntranceFee").innerHTML = parseInt(EntranceFee) * parseInt(document.getElementById("NoOfAdults").value);
    }
    
    document.getElementById("p-AccomodationFee").innerHTML = PackageInfo[2];
    document.getElementById("p-MiscellaneousFee").innerHTML = document.getElementById("p-TotalEntranceFee").innerHTML;
    document.getElementById("p-GrandTotal").innerHTML = parseInt(document.getElementById("p-TotalEntranceFee").innerHTML) + parseInt(PackageInfo[2]);
    
    document.getElementById("s-CheckInDate").value = CheckInDate;
    document.getElementById("s-CheckOutDate").value = CheckOutDate;
    document.getElementById("s-PackageID").value = PackageInfo[0];
    document.getElementById("s-InitialBill").value = parseInt(document.getElementById("p-TotalEntranceFee").innerHTML) + parseInt(PackageInfo[2]);
    document.getElementById("s-FirstName").value = document.getElementById("FirstName").value;
    document.getElementById("s-MiddleName").value = document.getElementById("MiddleName").value;
    document.getElementById("s-LastName").value = document.getElementById("LastName").value;
    document.getElementById("s-Address").value = document.getElementById("Address").value;
    document.getElementById("s-Email").value = document.getElementById("Email").value;
    document.getElementById("s-Contact").value = document.getElementById("ContactNumber").value;
    document.getElementById("s-Nationality").value = document.getElementById("Nationality").value;
    document.getElementById("s-DateOfBirth").value = document.getElementById("DateOfBirth").value;
    document.getElementById("s-Gender").value = document.getElementById("Gender").value;
    document.getElementById("s-Remarks").value = document.getElementById("Remarks").value;
    document.getElementById("s-NoOfKids").value = document.getElementById("NoOfKids").value;
    document.getElementById("s-NoOfAdults").value = document.getElementById("NoOfAdults").value;
}

function ValidateGuests(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
            if(document.getElementById("NoOfAdults").value != "" && document.getElementById("NoOfKids").value != ""){
                var NoOfAdults = parseInt(document.getElementById("NoOfAdults").value);
                var NoOfKids = parseInt(document.getElementById("NoOfKids").value);
                
                var TotalGuests = NoOfKids + NoOfAdults;
                
                if(parseInt(PackageInfo[3]) >= parseInt(TotalGuests)){
                    $('#NoOfKidsError').removeClass('has-warning');
                    $('#NoOfAdultsError').removeClass('has-warning');
                    var x = document.getElementsByClassName("ErrorLabel");
                    for(var i = 0; i < x.length; i++){
                        x[i].innerText="";
                    }
                }
                else{
                    $('#NoOfKidsError').addClass('has-warning');
                    $('#NoOfAdultsError').addClass('has-warning');
                    
                    var x = document.getElementsByClassName("ErrorLabel");
                    for(var i = 0; i < x.length; i++){
                        x[i].innerText="Number of guests exceeds pax of the package";
                    }
                }
                
    
            }
       }
}

function SaveTransaction(){
    document.getElementById("WalkInForm").submit();
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