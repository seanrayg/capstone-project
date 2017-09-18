function SelectPrintAction() {

	document.getElementById('PrintSelectedReport').value = document.getElementById("SelectQuery").value;

}

function IncludeDeleted() {
    if(document.getElementById("CheckIncludeDeleted").checked){

        document.getElementById('PrintIncludeDeleted').value = 1;

    }else {

        document.getElementById('PrintIncludeDeleted').value = 0;

    }
}
