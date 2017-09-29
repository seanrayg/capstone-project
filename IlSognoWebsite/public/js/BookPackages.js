var PackageInfo = [];

//submit reservation dates
function CheckInput(){
    var CheckInDate = document.getElementById("CheckInDate");
    var TimeError = CheckTime();
    if(TimeError){
        $('.alert').show();
        document.getElementById("ErrorMessage").innerHTML = "Valid pick up time is only between 6AM to 5PM";
    }
    else{
        $('.alert').hide();
        if(CheckInDate.value.trim() == ""){
            $('.alert').show();
            document.getElementById("ErrorMessage").innerHTML = "Please fill out all the fields";
        }
        else if($('.form-group').hasClass('has-danger')){
            $('.alert').show();
            document.getElementById("ErrorMessage").innerHTML = "Invalid input on some fields";
        }
        else{
            var tempHour = document.getElementById("PickUpTime").value;
            var tempMinute = document.getElementById("PickUpMinute").value;
            var tempMerridean = document.getElementById("PickUpMerridean").value;
            var ChosenHour = 0;
            var tempCheckInDate = document.getElementById("CheckInDate").value.split("/");
            if(tempMerridean == "PM"){
                ChosenHour = parseInt(tempHour) + 12;
            }
            else{
                ChosenHour = tempHour;
            }

            var CheckInDate = tempCheckInDate[2] + "/" + tempCheckInDate[0] + "/" + tempCheckInDate[1] + " " +ChosenHour+":"+tempMinute+":00";
         
            $('.alert').hide();
            $.ajax({
                type:'get',
                url:'/Reservation/Packages/Availability',
                data:{CheckInDate: CheckInDate},
                success:function(data){
                    $('#tblPackages tbody').empty();

                    var tableRef = document.getElementById('tblPackages').getElementsByTagName('tbody')[0];

                    for(var x = 0; x < data.length; x++){
                        var newRow   = tableRef.insertRow(tableRef.rows.length);

                        var newCell1  = newRow.insertCell(0);
                        var newCell2  = newRow.insertCell(1);
                        var newCell3 = newRow.insertCell(2);
                        var newCell4 = newRow.insertCell(3);
                        var newCell5 = newRow.insertCell(4);
                        var newCell6 = newRow.insertCell(5);
                        
                        newCell1.innerHTML = data[x].strPackageName;
                        newCell2.innerHTML = data[x].dblPackagePrice;
                        newCell3.innerHTML = data[x].intPackagePax;
                        newCell4.innerHTML = data[x].intPackageDuration;
                        newCell5.innerHTML = data[x].strPackageDescription;
                        newCell6.innerHTML = data[x].intBoatFee;

                    }
             
                    document.getElementById("DivPackage").style.display = "block";
                },
                error:function(response){
                    console.log(response);
                    alert(response.status);
                }
            });  
        }
    }
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

    PackageInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML];
    $('#PackageError').hide();
    Date.prototype.addDays = function(days) {
      var dat = new Date(this.valueOf());
      dat.setDate(dat.getDate() + days);
      return dat;    
    }

    var CheckInDate = document.getElementById("CheckInDate").value;

    var dat = new Date(CheckInDate);
    var DaysToAdd = parseInt(PackageInfo[3]);
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
}


$(document).ready(function(){
    $('#tblPackages').on('click', 'tbody tr', function(){
        HighlightRow(this);
    });
});

function CheckPackage(){
    var tableChecker = CheckTable('#tblPackages tr');
    if(tableChecker){
        $("#ReservationDate").removeClass("active");
        $("#ReservationInfo").addClass("active");
        $("#DateList").removeClass("active");
        $("#InfoList").addClass("active");
        $('.alert').hide();
    }
    else{
        $('#PackageError').show();
    }
}

function ValidateGuests(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-danger'))){
            if(document.getElementById("NoOfAdults").value != "" && document.getElementById("NoOfKids").value != ""){
                var NoOfAdults = parseInt(document.getElementById("NoOfAdults").value);
                var NoOfKids = parseInt(document.getElementById("NoOfKids").value);
                
                var TotalGuests = NoOfKids + NoOfAdults;
                
                if(parseInt(PackageInfo[2]) >= parseInt(TotalGuests)){
                    $('#NoOfKidsError').removeClass('has-danger');
                    $('#NoOfAdultsError').removeClass('has-danger');
                    $("#InfoError").hide();
                }
                else{
                    $('#NoOfKidsError').addClass('has-danger');
                    $('#NoOfAdultsError').addClass('has-danger');
                    
                    document.getElementById("InfoErrorMessage").innerHTML = "Number of guests exceeds pax of the package!";
                    $("#InfoError").show();
                }
            }
       }
}

function CheckInfo(){
    var CustomerAge = "";
    if(document.getElementById("DateOfBirth").value != ""){
        CustomerAge = getAge(document.getElementById("DateOfBirth").value);
    }
    
    if((document.getElementById("FirstName").value == "")||(document.getElementById("MiddleName").value == "") || (document.getElementById("LastName").value == "")||(document.getElementById("ContactNumber").value == "") || (document.getElementById("Nationality").value == "")||(document.getElementById("DateOfBirth").value == "") || (document.getElementById("Address").value == "")||(document.getElementById("Email").value == "")||(document.getElementById("NoOfAdults").value == "")||(document.getElementById("NoOfKids").value == "")){
        document.getElementById("InfoErrorMessage").innerHTML = "Please fill out all fields!";
        $("#InfoError").show();
    }
    else if(($(".form-group").hasClass("has-warning")) || ($(".form-group").hasClass("has-error"))){
        document.getElementById("InfoErrorMessage").innerHTML = "Invalid input on some fields!";
        $("#InfoError").show();
    }
    else if(parseInt(CustomerAge)<18){
        document.getElementById("InfoErrorMessage").innerHTML = "Customers only 18 years old and above are allowed to book a reservation";
        $("#InfoError").show();
    }
    else{
        $("#ReservationInfo").removeClass("active");
        $("#ReservationBill").addClass("active");
        $("#InfoList").removeClass("active");
        $("#BillList").addClass("active");
        $('.alert').hide();
        getEntranceFee();
    }
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

function CheckInfoInput(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if($('.form-group').hasClass('has-danger')){
        $("#InfoError").show();
        document.getElementById("InfoErrorMessage").innerHTML = "Invalid input on some fields";
    }
    else{
        $("#InfoError").hide();
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
    
    var tempHour = document.getElementById("PickUpTime").value;
    var tempMinute = document.getElementById("PickUpMinute").value;
    var tempMerridean = document.getElementById("PickUpMerridean").value;
    
    document.getElementById("i-CheckInDate").innerHTML = document.getElementById("CheckInDate").value;
    document.getElementById("i-CheckOutDate").innerHTML = document.getElementById("CheckOutDate").value;
    document.getElementById("i-ArrivalTime").innerHTML = tempHour + ":" + tempMinute + " " +tempMerridean;
    document.getElementById("i-PackageName").innerHTML = PackageInfo[1];
    document.getElementById("i-PackagePrice").innerHTML = PackageInfo[2];
    document.getElementById("i-GuestName").innerHTML = document.getElementById("FirstName").value + " " + document.getElementById("LastName").value;
    document.getElementById("i-Address").innerHTML = document.getElementById("Address").value;
    document.getElementById("i-Email").innerHTML = document.getElementById("Email").value;
    document.getElementById("i-ContactNumber").innerHTML = document.getElementById("ContactNumber").value;
    document.getElementById("i-Nationality").innerHTML = document.getElementById("Nationality").value;
    document.getElementById("i-DateOfBirth").innerHTML = document.getElementById("DateOfBirth").value;
    document.getElementById("i-Gender").innerHTML = document.getElementById("SelectGender").value;
    document.getElementById("i-Remarks").innerHTML = document.getElementById("Remarks").value;
    document.getElementById("i-NoOfAdults").innerHTML = document.getElementById("NoOfAdults").value;
    document.getElementById("i-NoOfKids").innerHTML = document.getElementById("NoOfKids").value;
    
    document.getElementById("p-PackageName").innerHTML = PackageInfo[0];
    document.getElementById("p-PackagePrice").innerHTML = PackageInfo[1];
    
    document.getElementById("p-GrandTotal").innerHTML = PackageInfo[1];
    
    document.getElementById("p-EntranceFee").innerHTML = EntranceFee;
    document.getElementById("p-NoOfAdults").innerHTML = document.getElementById("NoOfAdults").value;
    
    if(EntranceFound){
        document.getElementById("p-TotalEntranceFee").innerHTML = "0";
    }
    else{
        document.getElementById("p-TotalEntranceFee").innerHTML = parseInt(EntranceFee) * parseInt(document.getElementById("NoOfAdults").value);
    }
    
    document.getElementById("p-AccomodationFee").innerHTML = PackageInfo[1];
    document.getElementById("p-MiscellaneousFee").innerHTML = document.getElementById("p-TotalEntranceFee").innerHTML;
    document.getElementById("p-GrandTotal").innerHTML = parseInt(document.getElementById("p-TotalEntranceFee").innerHTML) + parseInt(PackageInfo[1]);
    
    document.getElementById("s-CheckInDate").value = document.getElementById("CheckInDate").value;
    document.getElementById("s-CheckOutDate").value = document.getElementById("CheckOutDate").value;
    document.getElementById("s-PickUpTime").value = tempHour + ":" + tempMinute + " " +tempMerridean;
    document.getElementById("s-InitialBill").value = parseInt(document.getElementById("p-TotalEntranceFee").innerHTML) + parseInt(PackageInfo[1]);
    document.getElementById("s-BoatsUsed").value = null;
    document.getElementById("s-FirstName").value = document.getElementById("FirstName").value;
    document.getElementById("s-MiddleName").value = document.getElementById("MiddleName").value;
    document.getElementById("s-LastName").value = document.getElementById("LastName").value;
    document.getElementById("s-Address").value = document.getElementById("Address").value;
    document.getElementById("s-Email").value = document.getElementById("Email").value;
    document.getElementById("s-Contact").value = document.getElementById("ContactNumber").value;
    document.getElementById("s-Nationality").value = document.getElementById("Nationality").value;
    document.getElementById("s-DateOfBirth").value = document.getElementById("DateOfBirth").value;
    document.getElementById("s-Gender").value = document.getElementById("SelectGender").value;
    document.getElementById("s-Remarks").value = document.getElementById("Remarks").value;
    document.getElementById("s-NoOfKids").value = document.getElementById("NoOfKids").value;
    document.getElementById("s-NoOfAdults").value = document.getElementById("NoOfAdults").value;
    document.getElementById("s-PackageName").value = PackageInfo[0];
}