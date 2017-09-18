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

function ShowModalImages(){
    var TableChecker = CheckTable('#RoomTypeTable tr');
    var TableChecker2 = CheckTable('#CottageTable tr');
    if(TableChecker || TableChecker2){
        $.ajax({
            type:'get',
            url:'/Accommodation/Images/Get',
            data:{RoomTypeID: RoomTypeInfo[0]},
            success:function(data){

                $('#tblRoomTypeImages tbody').empty();

                var tableRef = document.getElementById('tblRoomTypeImages').getElementsByTagName('tbody')[0];

                for(var x = 0; x < data.length; x++){
                    var newRow   = tableRef.insertRow(tableRef.rows.length);

                    var newCell1  = newRow.insertCell(0);
                    var newCell2  = newRow.insertCell(1);

                    newCell1.innerHTML = "<img src='" + data[x].blobRoomPPicture + "' alt='Rounded Image' class='img-rounded img-responsive RoomTypeImage'>";
                    newCell2.innerHTML = "<button type='button' rel='tooltip' title='Edit' class='btn btn-primary btn-simple btn-xs' value ='"+data[x].strRoomPictureID+"' onclick='ShowModalEditImages(this)'><i class='material-icons'>edit</i></button><button type='button' rel='tooltip' title='Remove' class='btn btn-danger btn-simple btn-xs' value ='"+data[x].strRoomPictureID+"'  onclick='ShowModalDeleteImages(this)'><i class='material-icons'>close</i></button>";

                }

                 document.getElementById("DivModalImages").style.display = "block";
            },
            error:function(response){
                console.log(response);
                alert("error");
            }
        });   
        
       
    }
}

function HideModalImages(){
    document.getElementById("DivModalImages").style.display = "none";
}

function ShowModalAddImages(){
    HideModalImages();
    document.getElementById("AddImageRoomTypeID").value = RoomTypeInfo[0];
    document.getElementById("DivModalAddImages").style.display = "block";
}

function HideModalAddImages(){
    document.getElementById("DivModalAddImages").style.display = "none";
}

function ShowModalEditImages(RoomPictureID){
    document.getElementById("EditRoomPictureID").value = RoomPictureID.value;
    HideModalImages();
    document.getElementById("DivModalEditImages").style.display = "block";
}

function HideModalEditImages(){
    document.getElementById("DivModalEditImages").style.display = "none";
}

function ShowModalDeleteImages(RoomPictureID){
    document.getElementById("DeleteRoomPictureID").value = RoomPictureID.value;
    HideModalImages();
    document.getElementById("DivModalDeleteImages").style.display = "block";
}

function HideModalDeleteImages(){
    document.getElementById("DivModalDeleteImages").style.display = "none";
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
    document.getElementById("SearchBar").value = "";
    SearchTable("RoomTypeTable", "1");
    document.getElementById("SearchBar2").value = "";
    SearchTable2("CottageTable", "1");
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


