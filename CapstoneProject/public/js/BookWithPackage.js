
//Tab Controller

function ChangeClass(sender, pageSender, newSender, newPageSender, action){
    var switchTab = false;
    if(action == "continue"){
        /*if(sender == "#ReservationPackage"){
            var TableChecker = CheckTable('#PackageTable tr');
            if(TableChecker){
                switchTab = true;
            }
            else{
                document.getElementById("ErrorMessage").innerHTML = "Please choose a package";
            }
        }//Reservation Package*/

        if(sender == "#ReservationDate"){
            switchTab = true;
                
        }// Reservation Date
        
        else if(sender == "#ReservationInfo"){
            var CustomerAge = "";
            if(document.getElementById("DateOfBirth").value != ""){
                CustomerAge = getAge(document.getElementById("DateOfBirth").value);
            }
            
            
            if((document.getElementById("FirstName").value == "")||(document.getElementById("MiddleName").value == "") ||           (document.getElementById("LastName").value == "")||(document.getElementById("ContactNumber").value == "") || (document.getElementById("Nationality").value == "")||(document.getElementById("DateOfBirth").value == "") || (document.getElementById("Address").value == "")||(document.getElementById("Email").value == "")){
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

//Validators

function CheckReservationInput(){
    var showDivPackage = true;

    var TimeError = CheckTime();
            
    if((document.getElementById("NoOfKids").value == "")||(document.getElementById("NoOfAdults").value == "") || (document.getElementById("CheckInDate").value == "")){
        showDivPackage = false;
        document.getElementById("ErrorMessage").innerHTML = "Please fill out all fields";
    }

    else if(($(".form-group").hasClass("has-warning"))){
        showDivPackage = false;
        document.getElementById("ErrorMessage").innerHTML = "Invalid input on some fields";
    }

    else if(TimeError){
        showDivPackage = false;
        document.getElementById("ErrorMessage").innerHTML = "Valid time is only between 6am to 5pm";
    }
    
    if(showDivPackage){
        $('.alert').hide();
        document.getElementById("PackageHolder").style.display = "block";
    }
    else{
        $('.alert').show();
    }
}

function CheckValue(field, sender){
    if(sender == 'kids'){
        ValidateInput(field, 'int2', '#NoOfKidsError');
    }
    else if(sender == 'adults'){
        ValidateInput(field, 'int', '#NoOfAdultsError');
    }
    
    if(($(".form-group").hasClass("has-warning"))){
        document.getElementById("ErrorMessage").innerHTML = "Invalid input";
        $('.alert').show();
    }
    else{
        $('.alert').hide();
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

function CheckDate(tempDate){
    var PastError = false;
    var WeekError = false;
    var selectedDate = new Date(tempDate);
    var today = new Date();
    var nextWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate()+7);
    if (selectedDate < today){
       $('#CheckInDateError').addClass("has-warning");
       $('.alert').show();
       document.getElementById("ErrorMessage").innerHTML = "Invalid Date";
       PastError = true;
    }
    else if(!(selectedDate >= nextWeek)){
       $('.alert').show();
       document.getElementById("ErrorMessage").innerHTML = "Please choose a date 7 days from now";
       $('#CheckInDateError').addClass("has-warning");
       WeekError = true;
    }
    
    if((!(WeekError)) && (!(PastError))){
        $('.alert').hide();
        $('#CheckInDateError').removeClass("has-warning");
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

function HideAlert(){
    $('.alert').hide();
}

//Check in date event listener
$( document ).ready(function() {
    $('#CheckInDate').on('changeDate', function(ev) {
        CheckInDate = document.getElementById("CheckInDate").value;
        CheckDate(CheckInDate);

        /*Date.prototype.addDays = function(days) {
          var dat = new Date(this.valueOf());
          dat.setDate(dat.getDate() + days);
          return dat;    
        }

        var dat = new Date(CheckInDate);
        var DaysToAdd = parseInt(PackageInfo[5]);
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
        document.getElementById("CheckOutDate").value = formatted;*/
    }).data('datepicker');
});


/*var cells;
var PackageInfo=[];
var CheckInDate;

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

            var tableRef = document.getElementById('tblIncludedItems').getElementsByTagName('tbody')[0];

            console.log(data);

            console.log(data.PackageRoomInfo.length);

            for(var x = 0; x < data.PackageItemInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3 = newRow.insertCell(2);
                var newCell4 = newRow.insertCell(3);

                newCell1.innerHTML = data.PackageItemInfo[x].strItemName;
                newCell2.innerHTML = data.PackageItemInfo[x].intPackageIQuantity;
                newCell3.innerHTML = data.PackageItemInfo[x].flPackageIDuration;
                newCell4.innerHTML = data.PackageItemInfo[x].ItemProduct;

            }

            tableRef = document.getElementById('tblIncludedRooms').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.PackageRoomInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3 = newRow.insertCell(2);

                newCell1.innerHTML = data.PackageRoomInfo[x].strRoomType;
                newCell2.innerHTML = data.PackageRoomInfo[x].intPackageRQuantity;
                newCell3.innerHTML = data.PackageRoomInfo[x].RoomProduct;

            }

            tableRef = document.getElementById('tblIncludedActivities').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.PackageActivityInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3 = newRow.insertCell(2);

                newCell1.innerHTML = data.PackageActivityInfo[x].strBeachAName;
                newCell2.innerHTML = data.PackageActivityInfo[x].intPackageAQuantity;
                newCell3.innerHTML = data.PackageActivityInfo[x].ActivityProduct;

            }



        },
        error:function(response){
            console.log(response);
        }
    });   

}

function ChangeClass(sender, pageSender, newSender, newPageSender, action){
    var switchTab = false;
    if(action == "continue"){
        if(sender == "#ReservationPackage"){
            var TableChecker = CheckTable('#PackageTable tr');
            if(TableChecker){
                switchTab = true;
            }
            else{
                document.getElementById("ErrorMessage").innerHTML = "Please choose a package";
            }
        }//Reservation Package

        else if(sender == "#ReservationDate"){
            
                
        }// Reservation Date
        else if(sender == "#ReservationInfo"){
            var CustomerAge = "";
            if(document.getElementById("DateOfBirth").value != ""){
                CustomerAge = getAge(document.getElementById("DateOfBirth").value);
            }
            
            
            if((document.getElementById("FirstName").value == "")||(document.getElementById("MiddleName").value == "") ||           (document.getElementById("LastName").value == "")||(document.getElementById("ContactNumber").value == "") || (document.getElementById("Nationality").value == "")||(document.getElementById("DateOfBirth").value == "") || (document.getElementById("Address").value == "")||(document.getElementById("Email").value == "")){
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
                switchTab = true;
            }
        }// Reservation Info
        
        
    }//continue

    if(action == "back"){
        switchTab = true;
        HideError();
    }

    if(!switchTab){
        ShowError();
    }
    else{
        $(sender).removeClass("active");
        $(newSender).addClass("active");
        $(pageSender).removeClass("active");
        $(newPageSender).addClass("active");
        HideError();
    }

}

function CheckReservationInput(){
        alert("aaa");
    
}




function CheckDate(tempDate){
    var ErrorLabel = document.getElementById("ErrorLabel2");
    var PastError = false;
    var WeekError = false;
    var selectedDate = new Date(tempDate);
    var today = new Date();
    var nextWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate()+7);
    if (selectedDate < today){
       $('#CheckInDateError').addClass("has-warning");
       ShowError();
       document.getElementById("ErrorMessage").innerHTML = "Invalid Date";
       PastError = true;
    }
    else if(!(selectedDate >= nextWeek)){
       ShowError();
       document.getElementById("ErrorMessage").innerHTML = "Please choose a date 7 days from now";
       $('#CheckInDateError').addClass("has-warning");
       WeekError = true;
    }
    
    if((!(WeekError)) && (!(PastError))){
        HideError();
        $('#CheckInDateError').removeClass("has-warning");
    }
    
}





$( document ).ready(function() {
    $('#CheckInDate').on('changeDate', function(ev) {
        CheckInDate = document.getElementById("CheckInDate").value;
        
    }).data('datepicker');
});




function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())){
        age--;
    }
    return age;
}*/

/*$( document ).ready(function() {
    $('#CheckInDate').on('changeDate', function(ev) {
        CheckInDate = document.getElementById("CheckInDate").value;
        CheckDate(CheckInDate);

        Date.prototype.addDays = function(days) {
          var dat = new Date(this.valueOf());
          dat.setDate(dat.getDate() + days);
          return dat;    
        }

        var dat = new Date(CheckInDate);
        var DaysToAdd = parseInt(PackageInfo[5]);
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
    }).data('datepicker');
});*/

