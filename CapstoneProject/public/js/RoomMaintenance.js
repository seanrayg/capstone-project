var cells;
var RoomInfo=[];
var RoomTypes = [];
var CottageTypes = [];

//MODAL CONTROLLER
function ShowModalAddRoom(){
    if($('#RoomType').hasClass('active')){
        document.getElementById("AddModalTitle").innerHTML = "Add Room";
        document.getElementById("AddSelectLabel").innerHTML = "Room Type";
        LoadSelectBox("Room");
    }
    else if($('#Cottage').hasClass('active')){
        document.getElementById("AddModalTitle").innerHTML = "Add Cottage";
        document.getElementById("AddSelectLabel").innerHTML = "Cottage Type";
        LoadSelectBox("Cottage");
    }
    document.getElementById("DivModalAddRoom").style.display = "block";
}

function HideModalAddRoom(){
    document.getElementById("DivModalAddRoom").style.display = "none";
}

function ShowModalEditRoom(){
    var TableChecker = CheckTable("#RoomTable tr");
    var TableChecker2 = CheckTable("#CottageTable tr");
    if(TableChecker || TableChecker2){
        if($('#RoomType').hasClass('active')){
        document.getElementById("EditModalTitle").innerHTML = "Add Room";
        document.getElementById("EditSelectLabel").innerHTML = "Room Type";
        LoadSelectBox("Room");
        }
        else if($('#Cottage').hasClass('active')){
            document.getElementById("EditModalTitle").innerHTML = "Add Cottage";
            document.getElementById("EditSelectLabel").innerHTML = "Cottage Type";
            LoadSelectBox("Cottage");
        }
        
        document.getElementById("DivModalEditRoom").style.display = "block";
        
        document.getElementById("EditRoomID").value = RoomInfo[0];
        document.getElementById("EditSelectRoomType").value = RoomInfo[1];
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
    var TableChecker2 = CheckTable("#CottageTable tr");
    if(TableChecker || TableChecker2){
        if($('#RoomType').hasClass('active')){
            document.getElementById("DeleteModalTitle").innerHTML = "Delete Room?";
        }
        if($('#Cottage').hasClass('active')){
            document.getElementById("DeleteModalTitle").innerHTML = "Delete Cottage?"; 
        }
        document.getElementById("DivModalDeleteRoom").style.display = "block";
        document.getElementById("DeleteRoomID").value = RoomInfo[0];
    }
}

function HideModalDeleteRoom(){
    document.getElementById("DivModalDeleteRoom").style.display = "none";
}

function LoadSelectBox(sender){
    $("#SelectRoomType option").remove();
    $("#EditSelectRoomType option").remove();
    if(sender == "Room"){
        for(var x = 0; x < RoomTypes.length; x++){
            var SelectID = document.getElementById("SelectRoomType");
            var option = document.createElement("option");
            option.text = RoomTypes[x];
            SelectID.add(option);
        }    
        
        for(var x = 0; x < RoomTypes.length; x++){
            var SelectID = document.getElementById("EditSelectRoomType");
            var option = document.createElement("option");
            option.text = RoomTypes[x];
            SelectID.add(option);
        }    
    }
    
    else{
        for(var x = 0; x < CottageTypes.length; x++){
            var SelectID = document.getElementById("SelectRoomType");
            var option = document.createElement("option");
            option.text = CottageTypes[x];
            SelectID.add(option);
        }   
        
        for(var x = 0; x < CottageTypes.length; x++){
            var SelectID = document.getElementById("EditSelectRoomType");
            var option = document.createElement("option");
            option.text = CottageTypes[x];
            SelectID.add(option);
        }    
    }
}

function ShowModalGuestInfo(){
    document.getElementById("DivModalGuestInfo").style.display = "block";
}

function HideModalGuestInfo(){
    document.getElementById("DivModalGuestInfo").style.display = "none";
}


//MISC
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

window.onload = function(){
    $.ajax({
        type:'get',
        url:'/Maintenance/Rooms/RoomTypes',
        success:function(data){
            console.log('success');
            RoomTypes = data;
           
        },
        error:function(response){
            console.log(response);

        }
    });

    $.ajax({
            type:'get',
            url:'/Maintenance/Rooms/CottageTypes',
            success:function(data){
                console.log('success');
                CottageTypes = data;
            },
            error:function(response){
                console.log(response);

            }
        });
}

function ResetTables(table){
    $(table).removeClass("selected");
    document.getElementById("SearchBar").value = "";
    SearchTable("RoomTable", "2");
    document.getElementById("SearchBar2").value = "";
    SearchTable2("CottageTable", "2");
}

function SearchTable2(TableID, rowNumber) {
  var input, filter, table, tr, td, i;
  input = document.getElementById("SearchBar2");
  filter = input.value.toUpperCase();
  table = document.getElementById(TableID);
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[rowNumber];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}