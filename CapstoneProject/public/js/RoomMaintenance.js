var cells;
var RoomInfo=[];


function ShowModalAddRoom(){
    document.getElementById("DivModalAddRoom").style.display = "block";
}

function HideModalAddRoom(){
    document.getElementById("DivModalAddRoom").style.display = "none";
}

function ShowModalEditRoom(){
    var TableChecker = CheckTable("#RoomTable tr");

    if(TableChecker){
        document.getElementById("DivModalEditRoom").style.display = "block";

        document.getElementById("EditRoomID").value = RoomInfo[0];
        document.getElementById("EditRoomType").value = RoomInfo[1];
        document.getElementById("EditRoomName").value = RoomInfo[2];
        document.getElementById("EditRoomStatus").value = RoomInfo[3];

        document.getElementById("OldRoomID").value = RoomInfo[0];
        document.getElementById("OldRoomName").value = RoomInfo[2];
    }   
}

function HideModalEditRoom(){
    document.getElementById("DivModalEditRoom").style.display = "none";
}

function ShowModalDeleteRoom(){
    var TableChecker = CheckTable("#RoomTable tr");

    if(TableChecker){
        document.getElementById("DivModalDeleteRoom").style.display = "block";

        document.getElementById("DeleteRoomID").value = RoomInfo[0];
    }
}

function HideModalDeleteRoom(){
    document.getElementById("DivModalDeleteRoom").style.display = "none";
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

    RoomInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML];
}