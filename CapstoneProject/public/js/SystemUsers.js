var UserInfo = [];

function ShowModalAddUser(){
    document.getElementById("DivModalAddUser").style.display = "block";
}

function HideModalAddUser(){
    document.getElementById("DivModalAddUser").style.display = "none";
    document.getElementById("AddUserForm").reset();
}

function ShowModalEditUser(){
    document.getElementById("DivModalEditUser").style.display = "block";
    document.getElementById("EditUserID").value = UserInfo[0];
    document.getElementById("EditUsername").value = UserInfo[1];
    document.getElementById("EditOldUsername").value = UserInfo[1];
    document.getElementById("EditOldPassword").value = UserInfo[11];

    if(UserInfo[2] == "Yes"){
        document.getElementById("EditToggleRoom").checked = true;   
    }
    if(UserInfo[3] == "Yes"){
        document.getElementById("EditToggleBoat").checked = true;   
    }
    if(UserInfo[4] == "Yes"){
        document.getElementById("EditToggleFee").checked = true;   
    }
    if(UserInfo[5] == "Yes"){
        document.getElementById("EditToggleItem").checked = true;   
    }
    if(UserInfo[6] == "Yes"){
        document.getElementById("EditToggleActivity").checked = true;   
    }
    if(UserInfo[7] == "Yes"){
        document.getElementById("EditToggleBilling").checked = true;   
    }
    if(UserInfo[8] == "Yes"){
        document.getElementById("EditToggleMaintenance").checked = true;   
    }
    if(UserInfo[9] == "Yes"){
        document.getElementById("EditToggleUtilities").checked = true;   
    }
    if(UserInfo[10] == "Yes"){
        document.getElementById("EditToggleReports").checked = true;   
    }
    

}

function HideModalEditUser(){
    document.getElementById("DivModalEditUser").style.display = "none";
}

function ShowModalDeleteUser(){
    document.getElementById("DeleteUserID").value = UserInfo[0];
    document.getElementById("DivModalDeleteUser").style.display = "block";
}

function HideModalDeleteUser(){
    document.getElementById("DivModalDeleteUser").style.display = "none";
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

    UserInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML, cells[7].innerHTML, cells[8].innerHTML, cells[9].innerHTML, cells[10].innerHTML, cells[11].innerHTML];
}

