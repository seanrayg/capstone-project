function DisplayFields(field){
   document.getElementById("DailyReport").style.display = "none";
   document.getElementById("MonthlyReport").style.display = "none";
   
   var chosenReport = field.value+"Report";
   document.getElementById(chosenReport).style.display = "block";
}

window.onload = function(){
    var tempDate = new Date();
    var yearNow = parseInt(tempDate.getFullYear());

    var x = document.getElementById("SelectMonthlyYear");
    for(var y = yearNow; y < (yearNow+50); y++){
        var option = document.createElement("option");
        option.text = y;
        x.add(option);
    }
}

function GenerateReport(){
    SelectedReport = document.getElementById("SelectQuery").value;
    if(SelectedReport == "Reservations"){
        var ReservationReport = document.getElementById("SelectReservationReport").value;
        var ReservationMonth = document.getElementById("ReservationMonth").value;
        var ReservationYear = document.getElementById("SelectMonthlyYear").value;
        var DailyReservation = document.getElementById("DailyReservation").value;

        $.ajax({
            type:'get',
            url:'/Reports/Query/Reservation',
            data:{ReservationReport: ReservationReport,
                  ReservationMonth: ReservationMonth,
                  ReservationYear: ReservationYear,
                  DailyReservation: DailyReservation},
            success:function(data){
                fillTable(data, SelectedReport);
            },
            error:function(response){
                console.log(response);
                alert(response.status);
            }
        });  
    }
    else{
        var IncludeDeleted = 0;
        if(document.getElementById("CheckIncludeDeleted").checked){
            IncludeDeleted = 1;
        }
        $.ajax({
            type:'get',
            url:'/Reports/Query',
            data:{SelectedReport: SelectedReport,
                  IncludeDeleted: IncludeDeleted},
            success:function(data){

                fillTable(data, SelectedReport);
            },
            error:function(response){
                console.log(response);
                alert(response.status);
            }
        });  
    }
    
}

function fillTable(data, SelectedReport){
    $('#QueryTable tr').remove();
    if(SelectedReport == "Reservations"){
        var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
        var newRow = tableRef.insertRow(tableRef.rows.length);

        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4 = newRow.insertCell(3);
        var newCell5  = newRow.insertCell(4);
        var newCell6  = newRow.insertCell(5);
        var newCell7  = newRow.insertCell(6);
        var newCell8 = newRow.insertCell(7);
        var newCell9  = newRow.insertCell(8);

        newCell1.innerHTML = "Name";
        newCell2.innerHTML = "Address";
        newCell3.innerHTML = "Contact Number";
        newCell4.innerHTML = "Email";
        newCell5.innerHTML = "Check In Date";
        newCell6.innerHTML = "Check Out Date";
        newCell7.innerHTML = "Number of Adults";
        newCell8.innerHTML = "Number of Children";
        newCell9.innerHTML = "Status";
        
        tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
        for(var x = 0; x < data.length; x++){
           
            newRow = tableRef.insertRow(tableRef.rows.length);

            newCell1  = newRow.insertCell(0);
            newCell2  = newRow.insertCell(1);
            newCell3  = newRow.insertCell(2);
            newCell4 = newRow.insertCell(3);
            newCell5  = newRow.insertCell(4);
            newCell6  = newRow.insertCell(5);
            newCell7  = newRow.insertCell(6);
            newCell8 = newRow.insertCell(7);
            newCell9  = newRow.insertCell(8);

            newCell1.innerHTML = data[x].Name;
            newCell2.innerHTML = data[x].strCustAddress;
            newCell3.innerHTML = data[x].strCustContact;
            newCell4.innerHTML = data[x].strCustEmail;
            newCell5.innerHTML = data[x].dtmResDArrival;
            newCell6.innerHTML = data[x].dtmResDDeparture;
            newCell7.innerHTML = data[x].intResDNoOfAdults;
            newCell8.innerHTML = data[x].intResDNoOfKids;
            newCell9.innerHTML = data[x].intResDStatus;
        }
    }
    if(SelectedReport == "Accomodations" || SelectedReport == "Room Types Only"){
        var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
        var newRow = tableRef.insertRow(tableRef.rows.length);

        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4 = newRow.insertCell(3);
        var newCell5  = newRow.insertCell(4);
        var newCell6  = newRow.insertCell(5);
        var newCell7  = newRow.insertCell(6);
        var newCell8 = newRow.insertCell(7);
        var newCell9  = newRow.insertCell(8);
        var newCell10  = newRow.insertCell(9);

        newCell1.innerHTML = "ID";
        newCell2.innerHTML = "Name";
        newCell3.innerHTML = "Amenity Type";
        newCell4.innerHTML = "Capacity";
        newCell5.innerHTML = "Rate";
        newCell6.innerHTML = "Number of Beds";
        newCell7.innerHTML = "Number of Bathrooms";
        newCell8.innerHTML = "Aircondition";
        newCell9.innerHTML = "Description";
        newCell10.innerHTML = "Status";
        
        tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
        for(var x = 0; x < data.length; x++){
           
            newRow = tableRef.insertRow(tableRef.rows.length);

            newCell1  = newRow.insertCell(0);
            newCell2  = newRow.insertCell(1);
            newCell3  = newRow.insertCell(2);
            newCell4 = newRow.insertCell(3);
            newCell5  = newRow.insertCell(4);
            newCell6  = newRow.insertCell(5);
            newCell7  = newRow.insertCell(6);
            newCell8 = newRow.insertCell(7);
            newCell9  = newRow.insertCell(8);
            newCell10  = newRow.insertCell(9);

            newCell1.innerHTML = data[x].strRoomTypeID;
            newCell2.innerHTML = data[x].strRoomType;
            newCell3.innerHTML = data[x].intRoomTCategory;
            newCell4.innerHTML = data[x].intRoomTCapacity;
            newCell5.innerHTML = data[x].dblRoomRate;
            newCell6.innerHTML = data[x].intRoomTNoOfBeds;
            newCell7.innerHTML = data[x].intRoomTNoOfBathrooms;
            newCell8.innerHTML = data[x].intRoomTAirconditioned;
            newCell9.innerHTML = data[x].strRoomDescription;
            newCell10.innerHTML = data[x].intRoomTDeleted;
        }
    }
    else if(SelectedReport == "Beach Activities"){
        var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
        var newRow = tableRef.insertRow(tableRef.rows.length);

        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4 = newRow.insertCell(3);
        var newCell5  = newRow.insertCell(4);
        var newCell6  = newRow.insertCell(5);

        newCell1.innerHTML = "ID";
        newCell2.innerHTML = "Name";
        newCell3.innerHTML = "Rate";
        newCell4.innerHTML = "Is Boat Needed?";
        newCell5.innerHTML = "Description";
        newCell6.innerHTML = "Status";
        
        tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
        for(var x = 0; x < data.length; x++){
           
            newRow = tableRef.insertRow(tableRef.rows.length);

            newCell1  = newRow.insertCell(0);
            newCell2  = newRow.insertCell(1);
            newCell3  = newRow.insertCell(2);
            newCell4 = newRow.insertCell(3);
            newCell5  = newRow.insertCell(4);
            newCell6  = newRow.insertCell(5);

            newCell1.innerHTML = data[x].strBeachActivityID;
            newCell2.innerHTML = data[x].strBeachAName;
            newCell3.innerHTML = data[x].dblBeachARate;
            newCell4.innerHTML = data[x].intBeachABoat;
            newCell5.innerHTML = data[x].strBeachADescription;
            newCell6.innerHTML = data[x].strBeachAStatus;
    }
}
    else if(SelectedReport == "Boats"){
        var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
        var newRow = tableRef.insertRow(tableRef.rows.length);

        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4 = newRow.insertCell(3);
        var newCell5  = newRow.insertCell(4);
        var newCell6  = newRow.insertCell(5);

        newCell1.innerHTML = "ID";
        newCell2.innerHTML = "Name";
        newCell3.innerHTML = "Rate";
        newCell4.innerHTML = "Capacity";
        newCell5.innerHTML = "Description";
        newCell6.innerHTML = "Status";

        tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
        for(var x = 0; x < data.length; x++){

            newRow = tableRef.insertRow(tableRef.rows.length);

            newCell1  = newRow.insertCell(0);
            newCell2  = newRow.insertCell(1);
            newCell3  = newRow.insertCell(2);
            newCell4 = newRow.insertCell(3);
            newCell5  = newRow.insertCell(4);
            newCell6  = newRow.insertCell(5);

            newCell1.innerHTML = data[x].strBoatID;
            newCell2.innerHTML = data[x].strBoatName;
            newCell3.innerHTML = data[x].dblBoatRate;
            newCell4.innerHTML = data[x].intBoatCapacity;
            newCell5.innerHTML = data[x].strBoatDescription;
            newCell6.innerHTML = data[x].strBoatStatus;
        }
    }
    else if(SelectedReport == "Cottages Only" || SelectedReport == "Rooms Only"){
        var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
        var newRow = tableRef.insertRow(tableRef.rows.length);

        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4 = newRow.insertCell(3);

        newCell1.innerHTML = "ID";
        newCell2.innerHTML = "Name";
        newCell3.innerHTML = "Type";
        newCell4.innerHTML = "Status";

        tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
        for(var x = 0; x < data.length; x++){

            newRow = tableRef.insertRow(tableRef.rows.length);

            newCell1  = newRow.insertCell(0);
            newCell2  = newRow.insertCell(1);
            newCell3  = newRow.insertCell(2);
            newCell4 = newRow.insertCell(3);

            newCell1.innerHTML = data[x].strRoomID;
            newCell2.innerHTML = data[x].strRoomName;
            newCell3.innerHTML = data[x].strRoomType;
            newCell4.innerHTML = data[x].strRoomStatus;
        }
    }
    else if(SelectedReport == "Cottage Types Only"){
        var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
        var newRow = tableRef.insertRow(tableRef.rows.length);

        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4 = newRow.insertCell(3);
        var newCell5  = newRow.insertCell(4);
        var newCell6  = newRow.insertCell(5);
        var newCell7  = newRow.insertCell(6);

        newCell1.innerHTML = "ID";
        newCell2.innerHTML = "Name";
        newCell3.innerHTML = "Amenity Type";
        newCell4.innerHTML = "Capacity";
        newCell5.innerHTML = "Rate";
        newCell6.innerHTML = "Description";
        newCell7.innerHTML = "Status";
        
        tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
        for(var x = 0; x < data.length; x++){
           
            newRow = tableRef.insertRow(tableRef.rows.length);

            newCell1  = newRow.insertCell(0);
            newCell2  = newRow.insertCell(1);
            newCell3  = newRow.insertCell(2);
            newCell4 = newRow.insertCell(3);
            newCell5  = newRow.insertCell(4);
            newCell6 = newRow.insertCell(5);
            newCell7  = newRow.insertCell(6);

            newCell1.innerHTML = data[x].strRoomTypeID;
            newCell2.innerHTML = data[x].strRoomType;
            newCell3.innerHTML = data[x].intRoomTCategory;
            newCell4.innerHTML = data[x].intRoomTCapacity;
            newCell5.innerHTML = data[x].dblRoomRate;
            newCell6.innerHTML = data[x].strRoomDescription;
            newCell7.innerHTML = data[x].intRoomTDeleted;
        }
    }
    else if(SelectedReport == "Customers"){
        var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
        var newRow = tableRef.insertRow(tableRef.rows.length);

        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4 = newRow.insertCell(3);
        var newCell5  = newRow.insertCell(4);
        var newCell6  = newRow.insertCell(5);
        var newCell7  = newRow.insertCell(6);
        var newCell8  = newRow.insertCell(7);
        var newCell9  = newRow.insertCell(8);
        var newCell10  = newRow.insertCell(9);
        var newCell11  = newRow.insertCell(10);

        newCell1.innerHTML = "ID";
        newCell2.innerHTML = "Last Name";
        newCell3.innerHTML = "First Name";
        newCell4.innerHTML = "Middle Name";
        newCell5.innerHTML = "Address";
        newCell6.innerHTML = "Contact Number";
        newCell7.innerHTML = "Email";
        newCell8.innerHTML = "Nationality";
        newCell9.innerHTML = "Gender";
        newCell10.innerHTML = "Birthday";
        newCell11.innerHTML = "Status";

        
        tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
        for(var x = 0; x < data.length; x++){
           
            newRow = tableRef.insertRow(tableRef.rows.length);

            var newCell1  = newRow.insertCell(0);
            var newCell2  = newRow.insertCell(1);
            var newCell3  = newRow.insertCell(2);
            var newCell4 = newRow.insertCell(3);
            var newCell5  = newRow.insertCell(4);
            var newCell6  = newRow.insertCell(5);
            var newCell7  = newRow.insertCell(6);
            var newCell8  = newRow.insertCell(7);
            var newCell9  = newRow.insertCell(8);
            var newCell10  = newRow.insertCell(9);
            var newCell11  = newRow.insertCell(10);

            newCell1.innerHTML = data[x].strCustomerID;
            newCell2.innerHTML = data[x].strCustLastName;
            newCell3.innerHTML = data[x].strCustFirstName;
            newCell4.innerHTML = data[x].strCustMiddleName;
            newCell5.innerHTML = data[x].strCustAddress;
            newCell6.innerHTML = data[x].strCustContact;
            newCell7.innerHTML = data[x].strCustEmail;
            newCell8.innerHTML = data[x].strCustNationality;
            newCell9.innerHTML = data[x].strCustGender;
            newCell10.innerHTML = data[x].dtmCustBirthday;
            newCell11.innerHTML = data[x].intCustStatus;
        }
    }
    else if(SelectedReport == "Fees"){

        var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
        var newRow = tableRef.insertRow(tableRef.rows.length);

        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4 = newRow.insertCell(3);
        var newCell5  = newRow.insertCell(4);

        newCell1.innerHTML = "ID";
        newCell2.innerHTML = "Name";
        newCell3.innerHTML = "Amount";
        newCell4.innerHTML = "Description";
        newCell5.innerHTML = "Status";

        tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
        for(var x = 0; x < data.length; x++){
           
            newRow = tableRef.insertRow(tableRef.rows.length);

            var newCell1  = newRow.insertCell(0);
            var newCell2  = newRow.insertCell(1);
            var newCell3  = newRow.insertCell(2);
            var newCell4 = newRow.insertCell(3);
            var newCell5  = newRow.insertCell(4);

            newCell1.innerHTML = data[x].strFeeID;
            newCell2.innerHTML = data[x].strFeeName;
            newCell3.innerHTML = data[x].dblFeeAmount;
            newCell4.innerHTML = data[x].strFeeDescription;
            newCell5.innerHTML = data[x].strFeeStatus;
        }
    }
    else if(SelectedReport == "Inoperational Dates"){
        
    }
    else if(SelectedReport == "Packages"){
        
    }
    else if(SelectedReport == "Rental Items"){
        var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
        var newRow = tableRef.insertRow(tableRef.rows.length);
        
        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4 = newRow.insertCell(3);
        var newCell5  = newRow.insertCell(4);
        var newCell6  = newRow.insertCell(5);

        newCell1.innerHTML = "ID";
        newCell2.innerHTML = "Name";
        newCell3.innerHTML = "Quantity";
        newCell4.innerHTML = "Rate";
        newCell5.innerHTML = "Description";
        newCell6.innerHTML = "Status";

        tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
        for(var x = 0; x < data.length; x++){
           
            newRow = tableRef.insertRow(tableRef.rows.length);

            var newCell1  = newRow.insertCell(0);
            var newCell2  = newRow.insertCell(1);
            var newCell3  = newRow.insertCell(2);
            var newCell4 = newRow.insertCell(3);
            var newCell5  = newRow.insertCell(4);
            var newCell6  = newRow.insertCell(5);

            newCell1.innerHTML = data[x].strItemID;
            newCell2.innerHTML = data[x].strItemName;
            newCell3.innerHTML = data[x].intItemQuantity;
            newCell4.innerHTML = data[x].dblItemRate;
            newCell5.innerHTML = data[x].strItemDescription;
            newCell6.innerHTML = data[x].intItemDeleted;
        }
    }
    else if(SelectedReport == "Reservations"){
        
    }
    else if(SelectedReport == "Rooms & Cottages"){
        var tableRef = document.getElementById('QueryTable').getElementsByTagName('thead')[0];
        var newRow = tableRef.insertRow(tableRef.rows.length);

        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);
        var newCell3  = newRow.insertCell(2);
        var newCell4 = newRow.insertCell(3);
        var newCell5 = newRow.insertCell(4);

        newCell1.innerHTML = "ID";
        newCell2.innerHTML = "Name";
        newCell3.innerHTML = "Accomodation Type";
        newCell4.innerHTML = "Room/Cottage Type";
        newCell5.innerHTML = "Status";

        tableRef = document.getElementById('QueryTable').getElementsByTagName('tbody')[0];
        for(var x = 0; x < data.length; x++){

            newRow = tableRef.insertRow(tableRef.rows.length);

            newCell1  = newRow.insertCell(0);
            newCell2  = newRow.insertCell(1);
            newCell3  = newRow.insertCell(2);
            newCell4 = newRow.insertCell(3);
            newCell5 = newRow.insertCell(4);

            newCell1.innerHTML = data[x].strRoomID;
            newCell2.innerHTML = data[x].strRoomName;
            newCell3.innerHTML = data[x].intRoomTCategory;
            newCell4.innerHTML = data[x].strRoomType;
            newCell5.innerHTML = data[x].strRoomStatus;
        }
    }
}
