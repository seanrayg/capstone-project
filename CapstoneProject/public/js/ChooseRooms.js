var ReservationID = "";
var ChosenRoomType = "";
var ChosenRoom = "";
var ChosenRowIndex;
var AvailableRowIndex;
var Rooms = []; // Object of rooms
var ajaxRooms = [];
var AvailableRoom = "";

//Modal Controller

function ShowModalReplaceRoom(){
    var TableChecker = CheckTable('#tblChosenRooms tr');
    if(TableChecker){
        var RecordFound = false;
        for(var x = 0; x < Rooms.length; x++){
            if(Rooms[x].RoomTypeName == ChosenRoomType){
                RecordFound = true;
            }
        }
        
        if(RecordFound){
            $('#tblAvailableRooms tbody').empty();
            for(var x = 0; x < Rooms.length; x++){
                if(Rooms[x].RoomTypeName == ChosenRoomType){
                    for(var y = 0; y < Rooms[x].AvailableRooms.length; y++){
                        var tableRef = document.getElementById('tblAvailableRooms').getElementsByTagName('tbody')[0];
                        var newRow   = tableRef.insertRow(tableRef.rows.length);
                        var newCell1  = newRow.insertCell(0);
                        newCell1.innerHTML = Rooms[x].AvailableRooms[y];
                    }
                }
            }
        }
        else{
            $.ajax({
                type:'get',
                url:'/CheckIn/AvailableRooms',
                data:{ReservationID:ReservationID,
                      ChosenRoomType:ChosenRoomType},
                success:function(data){
                    if(data.length != 0){
                        var arrRooms = [];
                        console.log('success');
                        $('#tblAvailableRooms tbody').empty();
                        var tableRef = document.getElementById('tblAvailableRooms').getElementsByTagName('tbody')[0];

                        for(var x = 0; x < data.length; x++){
                            var newRow   = tableRef.insertRow(tableRef.rows.length);

                            var newCell1  = newRow.insertCell(0);

                            newCell1.innerHTML = data[x].strRoomName;
                            arrRooms[x] = data[x].strRoomName;
                        }
                        Rooms.push({
                            RoomTypeName:ChosenRoomType, 
                            AvailableRooms:arrRooms});
                        document.getElementById("EmptyTableError").innerHTML = "";
                    }
                    else{
                        document.getElementById("EmptyTableError").innerHTML = "No available rooms!";
                    }
                    

                },
                error:function(response){
                    console.log(response);
                    alert("error");
                }
            }); 
        }
        document.getElementById("DivModalReplaceRoom").style.display = "block";
    }
}

function HideModalReplaceRoom(){
    document.getElementById("DivModalReplaceRoom").style.display = "none";
}



window.onload = function(){
    if (localStorage.getItem("ReservationID") === null) {
      ReservationID = document.getElementById("ReservationID").value;
    }
    else{
        ReservationID = localStorage.getItem("ReservationID");
        localStorage.removeItem("ReservationID");
    }
    
    var arrRoomType = [];
    var temp = "";
    //Remove all existing options

    $("#tblChosenRoomTypes tr").each(function(){
        arrRoomType.push($(this).find("td:first").text());
    });
    
    for(var x = 1; x < arrRoomType.length; x++){
       saveObjectDetails(arrRoomType[x]);
    }
}

function saveObjectDetails(RoomTypeName){
     $.ajax({
            type:'get',
            url:'/CheckIn/Rooms',
            data:{ReservationID:ReservationID,
                  ChosenRoomType:RoomTypeName},
            success:function(data){
                var arrRooms = [];
                console.log('success');
                for(var x = 0; x < data.length; x++){
                    arrRooms[x] = data[x].strRoomName;
                }
                saveObjectDetails2(RoomTypeName, arrRooms);
            },
            error:function(response){
                console.log(response);
                alert("error");
            }
        }); 
}

function saveObjectDetails2(RoomTypeName, arrRooms){
    ajaxRooms.push({
                RoomTypeName:RoomTypeName, 
                ChosenRooms:arrRooms});
}

//get table values
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
    if(sender == "ChosenRoomTypes"){
        ChosenRoomType = cells[0].innerHTML;
        getRooms();
    }
    
    if(sender == "ChosenRooms"){
        ChosenRoom = [cells[0].innerHTML];
    }
    
    if(sender == "AvailableRooms"){
        AvailableRoom = [cells[0].innerHTML];
    }
}

//tblChosenRooms click
$( document ).ready(function() {
    $('#tblChosenRooms tbody').on('click', 'tr', function(){
        ChosenRowIndex = $(this).index();
        HighlightRow(this);
    });
    
    $('#tblAvailableRooms tbody').on('click', 'tr', function(){
        AvailableRowIndex = $(this).index();
        HighlightRow(this);
    });
});


function getRooms(){
    $('#tblChosenRooms tbody').empty();
    for(var x = 0; x < ajaxRooms.length; x++){
        if(ajaxRooms[x].RoomTypeName == ChosenRoomType){
            for(var y = 0; y < ajaxRooms[x].ChosenRooms.length; y++){
                var tableRef = document.getElementById('tblChosenRooms').getElementsByTagName('tbody')[0];
                var newRow   = tableRef.insertRow(tableRef.rows.length);
                var newCell1  = newRow.insertCell(0);
                newCell1.innerHTML = ajaxRooms[x].ChosenRooms[y];   
            }
        }
    }
}

//replace rooms

function ReplaceRoom(){
    
    var TableChecker = CheckTable('#tblAvailableRooms tr');
    var arrRooms = [];
    if(TableChecker){
        for(var x = 0; x < Rooms.length; x++){
            if(Rooms[x].RoomTypeName == ChosenRoomType){
                for(var y = 0; y < Rooms[x].AvailableRooms.length; y++){
                    if(Rooms[x].AvailableRooms[y] == AvailableRoom){
                        document.getElementById("tblChosenRooms").deleteRow(ChosenRowIndex+1);
                        document.getElementById("tblAvailableRooms").deleteRow(AvailableRowIndex+1);       
                        var tableRef = document.getElementById('tblChosenRooms').getElementsByTagName('tbody')[0];
                        var newRow   = tableRef.insertRow(tableRef.rows.length);
                        var newCell1  = newRow.insertCell(0);
                        newCell1.innerHTML = Rooms[x].AvailableRooms[y];
                        Rooms[x].AvailableRooms[y] = ChosenRoom+"";
                        for(var z = 0; z < ajaxRooms.length; z++){
                            if(ajaxRooms[z].RoomTypeName == ChosenRoomType){
                                for(var i = 0; i < ajaxRooms[z].ChosenRooms.length; i++){
                                    if(ajaxRooms[z].ChosenRooms[i] == ChosenRoom){
                                        ajaxRooms[z].ChosenRooms[i] = newCell1.innerHTML;
                                    }
                                }
                            }
                        }
                        HideModalReplaceRoom();
                    }
                }
            }
        }//end for
    }
}

//Save Rooms

function SaveRooms(){
    document.getElementById("s-ChosenRooms").value = JSON.stringify(ajaxRooms);
    document.getElementById("s-ReservationID").value = ReservationID;
    
    return true;
}


