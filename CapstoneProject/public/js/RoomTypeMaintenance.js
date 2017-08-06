//Global variables

var cells;
var RoomTypeInfo = [];

//Modal functions

function ShowModalAddRoomType() {
    $('#RoomTypeForm').trigger("reset");
    document.getElementById("DivModalAddRoomType").style.display = "block";
    if($('#RoomType').hasClass('active')){
        document.getElementById("AddModalTitle").innerHTML = "Add Room Type";
        document.getElementById("NoOfBeds").readOnly = false;
        document.getElementById("NoOfBathrooms").readOnly = false;
        document.getElementById("NoOfBeds").value = "";
        document.getElementById("NoOfBathrooms").value = "";
        document.getElementById("RoomPerks").style.display = "block";
        document.getElementById("RoomCategory").value = "Room";
    }
    else if($('#Cottage').hasClass('active')){
        document.getElementById("AddModalTitle").innerHTML = "Add Cottage Type";
        document.getElementById("NoOfBeds").readOnly = true;
        document.getElementById("NoOfBathrooms").readOnly = true;
        document.getElementById("NoOfBeds").value = "0";
        document.getElementById("NoOfBathrooms").value = "0";
        document.getElementById("RoomAirconditioned").checked = false;
        document.getElementById("RoomPerks").style.display = "none";
        document.getElementById("RoomCategory").value = "Cottage";
    }
}

function HideModalAddRoomType(){
    document.getElementById("DivModalAddRoomType").style.display = "none";
    document.getElementById("RoomTypeForm").reset();
    ResetInput();
}
 
function ShowModalEditRoomType(){
    var TableChecker = CheckTable('#RoomTypeTable tr');
    var TableChecker2 = CheckTable('#CottageTable tr');
    if(TableChecker || TableChecker2){
        ResetInput();
  
        document.getElementById("DivModalEditRoomType").style.display = "block";
        
        document.getElementById("OldRoomTypeCode").value = RoomTypeInfo[0];
        document.getElementById("OldRoomTypeName").value = RoomTypeInfo[1];
        document.getElementById("OldRoomRate").value = RoomTypeInfo[7];
        
        document.getElementById("EditRoomTypeCode").value = RoomTypeInfo[0];
        document.getElementById("EditRoomTypeName").value = RoomTypeInfo[1];
        document.getElementById("EditRoomCategory").value = RoomTypeInfo[2];
        document.getElementById("EditRoomCapacity").value = RoomTypeInfo[3];
        document.getElementById("EditNoOfBeds").value = RoomTypeInfo[4];
        document.getElementById("EditNoOfBathrooms").value = RoomTypeInfo[5];
        document.getElementById("EditRoomRate").value = RoomTypeInfo[7];
        
        if(RoomTypeInfo[8]!="N/A"){
            document.getElementById("EditRoomDescription").value = RoomTypeInfo[8];
        }
        
        if(RoomTypeInfo[6]=="Yes"){
          document.getElementById("EditAirconditioned").checked = true;
        }
        
        if(RoomTypeInfo[2]=="Cottage"){
            document.getElementById("EditRoomPerks").style.display = "none";
        }
        else{
            document.getElementById("EditRoomPerks").style.display = "block";
        }
        
        if($('#RoomType').hasClass('active')){
            document.getElementById("EditModalTitle").innerHTML = "Edit Room Type";
        }
        else if($('#Cottage').hasClass('active')){
            document.getElementById("EditModalTitle").innerHTML = "Edit Cottage Type";

        }

    }
}

function HideModalEditRoomType(){
    document.getElementById("DivModalEditRoomType").style.display = "none";
    document.getElementById("EditRoomTypeForm").reset();
    ResetInput();
}

function ShowModalDeleteRoomType(){
    var TableChecker = CheckTable('#RoomTypeTable tr');
    var TableChecker2 = CheckTable("#CottageTable tr");
    if(TableChecker || TableChecker2){
        if($('#RoomType').hasClass('active')){
            document.getElementById("DeleteModalTitle").innerHTML = "Delete Room type?";
        }
        if($('#Cottage').hasClass('active')){
            document.getElementById("DeleteModalTitle").innerHTML = "Delete Cottage type?";
        }
        
        document.getElementById("DivModalDeleteRoomType").style.display = "block";
        
    }
}

function HideModalDeleteRoomType(){
    document.getElementById("DivModalDeleteRoomType").style.display = "none";
}

//DELETE ROOM TYPE

function DeleteRoomType(){
    document.getElementById("d-RoomTypeID").value = RoomTypeInfo[0];
    return true;
}


//Table Functions

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
    
    RoomTypeInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML, cells[7].innerHTML, cells[8].innerHTML];
}

//misc

function ResetTables(table){
    $(table).removeClass("selected");
}


function AlterInput(field, dataType, holder){
    if(document.getElementById("RoomCategory").value == "Cottage"){
        ValidateInput(field, 'int2', holder);
    }
    else{
        ValidateInput(field, dataType, holder);
    }
}


window.onload = function(){
    if(document.getElementById("RoomCategory").value == "Cottage"){
        document.getElementById("RoomPerks").style.display = "none";
    }
    
    if(document.getElementById("EditRoomCategory").value == "Cottage"){
        document.getElementById("EditRoomPerks").style.display = "none";
    }
}


