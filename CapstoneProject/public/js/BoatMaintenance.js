var cells;
var BoatInfo = [];

function ShowModalAddBoat(){
  document.getElementById("DivModalAddBoat").style.display = "block";
}

function HideModalAddBoat(){
  document.getElementById("DivModalAddBoat").style.display = "none";
  document.getElementById("BoatForm").reset();
  ResetInput();
}

function ShowModalEditBoat(){
  var TableChecker = CheckTable('#BoatTable tr');
    
  if(TableChecker){
        document.getElementById("DivModalEditBoat").style.display = "block";

        document.getElementById("OldBoatID").value = BoatInfo[0];
        document.getElementById("OldBoatName").value = BoatInfo[1];
        document.getElementById("OldBoatRate").value = BoatInfo[4];

        document.getElementById("EditBoatID").value = BoatInfo[0];
        document.getElementById("EditBoatName").value = BoatInfo[1];
        document.getElementById("EditBoatCapacity").value = BoatInfo[2];
        document.getElementById("EditBoatStatus").value = BoatInfo[3];
        document.getElementById("EditBoatRate").value = BoatInfo[4];
        if(BoatInfo[5] != "N/A"){
            document.getElementById("EditBoatDescription").value = BoatInfo[5];
        }    
  }
      
}

function HideModalEditBoat(){
  document.getElementById("DivModalEditBoat").style.display = "none";
  document.getElementById("EditBoatForm").reset();
  ResetInput();
}

function ShowModalDeleteBoat(){
  var TableChecker = CheckTable('#BoatTable tr');
    
  if(TableChecker){
      document.getElementById("DivModalDeleteBoat").style.display = "block";
      
      document.getElementById("DeleteBoatID").value = BoatInfo[0];
  }
}

function HideModalDeleteBoat(){
    document.getElementById("DivModalDeleteBoat").style.display = "none"; 
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

    BoatInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML];
}

