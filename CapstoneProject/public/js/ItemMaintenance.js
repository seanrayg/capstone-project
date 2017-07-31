//global variables

var cells;
var ItemInfo;


//Modal Functions

function ShowModalAddItem(){
    document.getElementById("DivModalAddItem").style.display = "block";
}

function HideModalAddItem(){
    document.getElementById("DivModalAddItem").style.display = "none";
    document.getElementById("ItemForm").reset();
    ResetInput();
}

function ShowModalEditItem(){
    var TableChecker = CheckTable('#ItemTable tr');
    if(TableChecker){
        document.getElementById("DivModalEditItem").style.display = "block";
        
        document.getElementById("OldItemID").value = ItemInfo[0];
        document.getElementById("OldItemName").value = ItemInfo[1];
        document.getElementById("OldItemRate").value = ItemInfo[3];
        
        document.getElementById("EditItemID").value = ItemInfo[0];
        document.getElementById("EditItemName").value = ItemInfo[1];
        document.getElementById("EditItemQuantity").value = ItemInfo[2];
        document.getElementById("EditItemRate").value = ItemInfo[3];
        if(ItemInfo[4] != "N/A"){
            document.getElementById("EditItemDescription").value = ItemInfo[4];
        }
    }
}

function HideModalEditItem(){
    document.getElementById("DivModalEditItem").style.display = "none";
    document.getElementById("EditItemForm").reset();
    ResetInput();
}

function ShowModalDeleteItem(){
    var TableChecker = CheckTable('#ItemTable tr');
    if(TableChecker){
        document.getElementById("DivModalDeleteItem").style.display = "block";
        document.getElementById("DeleteItemID").value = ItemInfo[0];
    }
}

function HideModalDeleteItem(){
    document.getElementById("DivModalDeleteItem").style.display = "none";
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

    ItemInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML];
}