//global variables

var cells;
var ActivityInfo=[];


//modal functions

function ShowModalAddActivity(){
    document.getElementById("DivModalAddActivity").style.display = "block";
}

function HideModalAddActivity(){
    document.getElementById("DivModalAddActivity").style.display = "none";
    document.getElementById("ActivityForm").reset();
    ResetInput();
}

function ShowModalEditActivity(){
        var TableChecker = CheckTable('#ActivityTable tr');
        if(TableChecker){
            document.getElementById("DivModalEditActivity").style.display = "block";

            document.getElementById("OldActivityID").value = ActivityInfo[0];
            document.getElementById("OldActivityName").value = ActivityInfo[1];
            document.getElementById("OldActivityRate").value = ActivityInfo[3];

            document.getElementById("EditActivityID").value = ActivityInfo[0];
            document.getElementById("EditActivityName").value = ActivityInfo[1];
            document.getElementById("EditActivityStatus").value = ActivityInfo[2];
            document.getElementById("EditActivityRate").value = ActivityInfo[3];
            if(ActivityInfo[4]=="Yes"){
                document.getElementById("EditActivityBoat").checked = true;
            }
            if(ActivityInfo[5]!="N/A"){
                document.getElementById("EditActivityDescription").value = ActivityInfo[5];
            }
        }
    
}

function HideModalEditActivity(){
    document.getElementById("DivModalEditActivity").style.display = "none";
    document.getElementById("EditActivityForm").reset();
    ResetInput();
}

function ShowModalDeleteActivity(){
    var TableChecker = CheckTable('#ActivityTable tr');
    if(TableChecker){
        document.getElementById("DivModalDeleteActivity").style.display = "block";
        document.getElementById("DeleteActivityID").value = ActivityInfo[0];
    }
}

function HideModalDeleteActivity(){
    document.getElementById("DivModalDeleteActivity").style.display = "none";
}



//table functions

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

    ActivityInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML];
    
}
