//Global Variable Declaration
var OldDuration = "";
var ContinueDefault = false;
var TotalRoomCapacity = 0;
var strRoomCapacity = "";
var TotalAmount = 0;
var RoomInfo=[];
var ItemInfo=[];
var ActivityInfo=[];
var FeeInfo=[];
var RoomIndex;
var ItemIndex;
var ActivityIndex;
var FeeIndex;
var RoomTypeDetails;

//Modal Controller
function ShowModalDuration(){
    document.getElementById("DivModalDuration").style.display = "block";
}

function HideModalDuration(){
    document.getElementById("DivModalDuration").style.display = "none";
}

function ShowModalRoomChoice(){
    GetRoomDetails();
    document.getElementById("DivModalRoomChoice").style.display = "block";
}

function ShowModalItemChoice(){
    GetItemDetails();
    document.getElementById("DivModalItemChoice").style.display = "block";
}

function ShowModalActivityChoice(){
    GetActivityDetails();
    document.getElementById("DivModalActivityChoice").style.display = "block";
}

function ShowModalFeeChoice(){
    GetFeeDetails();
    document.getElementById("DivModalFeeChoice").style.display = "block";
}

function HideModalRoomChoice(){
    document.getElementById("DivModalRoomChoice").style.display = "none";
}

function HideModalItemChoice(){
    document.getElementById("DivModalItemChoice").style.display = "none";
}

function HideModalActivityChoice(){
    document.getElementById("DivModalActivityChoice").style.display = "none";
}

function HideModalFeeChoice(){
    document.getElementById("DivModalFeeChoice").style.display = "none";
}
    

//AJAX FUNCTIONS
function GetRoomDetails(){
    ResetModalInput();
    document.getElementById("RoomQuantity").value = "";
    var RoomType = document.getElementById("SelectRoomType").value;
    $.ajax({
        type:'get',
        url:'/Maintenance/Package/Add/RoomType',
        data:{id:RoomType},
        success:function(data){
            console.log('success');

            document.getElementById("RoomTypeID").innerHTML = data[0].strRoomTypeID;
            document.getElementById("RoomTypeName").innerHTML = data[0].strRoomType;
            document.getElementById("RoomCapacity").innerHTML = data[0].intRoomTCapacity;
            document.getElementById("RoomRate").innerHTML = data[0].dblRoomRate;
            document.getElementById("NoOfBeds").innerHTML = data[0].intRoomTNoOfBeds;
            document.getElementById("NoOfBathrooms").innerHTML = data[0].intRoomTNoOfBathrooms;
            document.getElementById("RoomDescription").innerHTML = data[0].strRoomDescription;
            if(data[0].intRoomTCategory == 1){
                document.getElementById("RoomCategory").innerHTML = "Room";
            }
            else{
                document.getElementById("RoomCategory").innerHTML = "Cottage";
            }
            if(data[0].intRoomTAirconditioned == 1){
                document.getElementById("RoomAircondition").innerHTML = "Yes";
            }
            else{
                document.getElementById("RoomAircondition").innerHTML = "No";
            }
            document.getElementById("RoomsAvailable").innerHTML = data['TotalRooms'];


        },
        error:function(response){
            console.log(response);
        }
    });   
}

function GetItemDetails(){
    ResetModalInput();
    document.getElementById("pacItemQuantity").value = "";
    document.getElementById("pacItemDuration").value = "";
    var ItemName = document.getElementById("SelectItem").value;
    $.ajax({
        type:'get',
        url:'/Maintenance/Package/Add/Item',
        data:{id:ItemName},
        success:function(data){
            console.log('success');

            document.getElementById("ItemID").innerHTML = data[0].strItemID;
            document.getElementById("ItemName").innerHTML = data[0].strItemName;
            document.getElementById("ItemQuantity").innerHTML = data[0].intItemQuantity;
            document.getElementById("ItemRate").innerHTML = data[0].dblItemRate;
            document.getElementById("ItemDescription").innerHTML = data[0].strItemDescription;


        },
        error:function(response){
            console.log(response);
        }
    });   
}

function GetActivityDetails(){
    ResetModalInput();
    document.getElementById("ActivityQuantity").value = "";
    var ActivityName = document.getElementById("SelectActivity").value;
    $.ajax({
        type:'get',
        url:'/Maintenance/Package/Add/Activity',
        data:{id:ActivityName},
        success:function(data){
            console.log('success');

            document.getElementById("ActivityID").innerHTML = data[0].strBeachActivityID;
            document.getElementById("ActivityName").innerHTML = data[0].strBeachAName;
            document.getElementById("ActivityBoat").innerHTML = data[0].intBeachABoat;
            document.getElementById("ActivityRate").innerHTML = data[0].dblBeachARate;
            document.getElementById("ActivityDescription").innerHTML = data[0].strBeachADescription;



        },
        error:function(response){
            console.log(response);
        }
    });   
}
    
function GetFeeDetails(){
        ResetModalInput();
        var FeeName = document.getElementById("SelectFee").value;
        $.ajax({
            type:'get',
            url:'/Maintenance/Package/Add/Fee',
            data:{id:FeeName},
            success:function(data){
                console.log('success');

                document.getElementById("FeeID").innerHTML = data[0].strFeeID;
                document.getElementById("FeeName").innerHTML = data[0].strFeeName;
                document.getElementById("FeeAmount").innerHTML = data[0].dblFeeAmount;
                document.getElementById("FeeDescription").innerHTML = data[0].strFeeDescription;



            },
            error:function(response){
                console.log(response);
            }
        });  
    }

function getRooms(){
    var PackageDuration = document.getElementById("EditPackageDuration").value;
    $.ajax({
        type:'get',
        url:'/Maintenance/Package/Rooms',
        data:{PackageDuration:PackageDuration},
        success:function(data){
            console.log('success');
            $("#SelectRoomType option").remove();
            for(var x = 0; x < data.length; x++){
                var SelectID = document.getElementById("SelectRoomType");
                var option = document.createElement("option");
                option.text = data[x];
                SelectID.add(option);
            }    
        },
        error:function(response){
            console.log(response);

        }
    });  
}


//Add Modal Function

function addRoomType(){
    if(!($(".form-group").hasClass("has-warning"))){  
        var inputError = false;
        var RoomQuantity = document.getElementById("RoomQuantity").value;
        var PackageDuration = document.getElementById("EditPackageDuration").value;
        if(RoomQuantity == ""){
            inputError = true;
        }

        else if(parseInt(RoomQuantity) > parseInt(document.getElementById("RoomsAvailable").innerHTML)){
            inputError = true;
        }

        checkInput('#PacRoomError', inputError);

        if(!($(".form-group").hasClass("has-warning"))){
            var e = document.getElementById("SelectRoomType");
            var RoomName = e.options[e.selectedIndex].value;
            e.remove(e.selectedIndex);


            var tableRef = document.getElementById('PacRoomTable').getElementsByTagName('tbody')[0];

            var newRow   = tableRef.insertRow(tableRef.rows.length);

            var newCell1  = newRow.insertCell(0);
            var newCell2  = newRow.insertCell(1);
            var newCell3 = newRow.insertCell(2);

            newCell1.innerHTML = document.getElementById("RoomTypeName").innerHTML;
            newCell2.innerHTML = RoomQuantity;
            newCell3.innerHTML = parseInt(document.getElementById("RoomRate").innerHTML) * parseInt(RoomQuantity);

            TotalAmount+= (parseInt(document.getElementById("RoomRate").innerHTML) * parseInt(RoomQuantity) * parseInt(PackageDuration));

            document.getElementById("TotalAmount").innerHTML = TotalAmount;

            TotalRoomCapacity += parseInt(document.getElementById("RoomCapacity").innerHTML) * parseInt(RoomQuantity);

            document.getElementById("TotalRoomCapacity").innerHTML = TotalRoomCapacity;
            RoomCapacityChecker();
            strRoomCapacity += document.getElementById("RoomTypeName").innerHTML + "-" +(parseInt(document.getElementById("RoomCapacity").innerHTML) * parseInt(RoomQuantity)) + ",";
            if(e.length!=0){
                GetRoomDetails();
            }
            else{
                HideModalRoomChoice();
            }
        }
    }
}

function addItem(){
    if(!($(".form-group").hasClass("has-warning"))){  
        var inputError = false;
        var ItemQuantity = document.getElementById("pacItemQuantity").value;
        var ItemDuration = document.getElementById("pacItemDuration").value;

        if(ItemQuantity == ""){
            inputError = true;
            checkInput('#PacItemQuantityError', inputError);
        }

        if(ItemDuration == ""){
            inputError = true;
            checkInput('#PacItemDurationError', inputError);
        }

        if(parseInt(ItemQuantity) > parseInt(document.getElementById("ItemQuantity").innerHTML)){
            inputError = true;
            checkInput('#PacItemQuantityError', inputError);
        }

        if(!($(".form-group").hasClass("has-warning"))){
            var e = document.getElementById("SelectItem");
            var ItemName = e.options[e.selectedIndex].value;
            e.remove(e.selectedIndex);


            var tableRef = document.getElementById('PacItemTable').getElementsByTagName('tbody')[0];

            var newRow   = tableRef.insertRow(tableRef.rows.length);

            var newCell1  = newRow.insertCell(0);
            var newCell2  = newRow.insertCell(1);
            var newCell3 = newRow.insertCell(2);
            var newCell4 = newRow.insertCell(3);


            newCell1.innerHTML = document.getElementById("ItemName").innerHTML;
            newCell2.innerHTML = ItemQuantity;
            newCell3.innerHTML = ItemDuration;
            newCell4.innerHTML = (parseInt(document.getElementById("ItemRate").innerHTML) * ItemDuration) * ItemQuantity;

            TotalAmount+= (parseInt(document.getElementById("ItemRate").innerHTML) * ItemDuration) * ItemQuantity;

            document.getElementById("TotalAmount").innerHTML = TotalAmount;

            if(e.length!=0){
                GetItemDetails();
            }
            else{
                HideModalItemChoice();
            }
        }
    }
}

function addActivity(){
    if(!($(".form-group").hasClass("has-warning"))){  
        var inputError = false;
        var ActivityQuantity = document.getElementById("ActivityQuantity").value;

        if(ActivityQuantity == ""){
            inputError = true;
        }

        checkInput('#PacActivityError', inputError);

        if(!($(".form-group").hasClass("has-warning"))){
            var e = document.getElementById("SelectActivity");
            var ActivityName = e.options[e.selectedIndex].value;
            e.remove(e.selectedIndex);


            var tableRef = document.getElementById('PacActivityTable').getElementsByTagName('tbody')[0];

            var newRow   = tableRef.insertRow(tableRef.rows.length);

            var newCell1  = newRow.insertCell(0);
            var newCell2  = newRow.insertCell(1);
            var newCell3 = newRow.insertCell(2);

            newCell1.innerHTML = document.getElementById("ActivityName").innerHTML;
            newCell2.innerHTML = ActivityQuantity;
            newCell3.innerHTML = parseInt(document.getElementById("ActivityRate").innerHTML) * parseInt(ActivityQuantity);

            TotalAmount+= parseInt(document.getElementById("ActivityRate").innerHTML) * parseInt(ActivityQuantity);



            document.getElementById("TotalAmount").innerHTML = TotalAmount;

            if(e.length!=0){
                GetActivityDetails();
            }
            else{
                HideModalActivityChoice();
            }
        }
    }
}
    
function addFee(){
        var e = document.getElementById("SelectFee");
        var FeeName = e.options[e.selectedIndex].value;
        e.remove(e.selectedIndex);


        var tableRef = document.getElementById('PacFeeTable').getElementsByTagName('tbody')[0];

        var newRow   = tableRef.insertRow(tableRef.rows.length);

        var newCell1  = newRow.insertCell(0);
        var newCell2  = newRow.insertCell(1);


        newCell1.innerHTML = document.getElementById("FeeName").innerHTML;
        newCell2.innerHTML = document.getElementById("FeeAmount").innerHTML;

        TotalAmount+= parseInt(document.getElementById("FeeAmount").innerHTML);

        document.getElementById("TotalAmount").innerHTML = TotalAmount;

        if(e.length!=0){
            GetFeeDetails();
        }
        else{
            HideModalFeeChoice();
        }
    }

    
//window onload    
window.onload = function(){

        if(document.getElementById("PackagePrice").value != ""){
            var arrRoomType = [];
            var arrItem = [];
            var arrActivity = [];
            var arrFee = [];
            var OldTotal = 0;
            var temp = 0;
            //Remove all existing options

            $("#PacRoomTable tr").each(function(){
                arrRoomType.push($(this).find("td:first").text());
            });
            $("#PacItemTable tr").each(function(){
                arrItem.push($(this).find("td:first").text());
            });
            $("#PacActivityTable tr").each(function(){
                arrActivity.push($(this).find("td:first").text());
            });
            $("#PacFeeTable tr").each(function(){
                arrFee.push($(this).find("td:first").text());
            });
            
            if(arrRoomType.length > 1){
                for(var x=1; x<(arrRoomType.length); x++){
                    var selectobject = document.getElementById("SelectRoomType")
                      for (var i=0; i<selectobject.length; i++){
                          if (selectobject.options[i].value == arrRoomType[x]){
                              selectobject.remove(i);
                          }         
                      }
                }
            }

            if(arrItem.length > 1){
                for(var x=1; x<(arrItem.length); x++){
                    var selectobject = document.getElementById("SelectItem")
                      for (var i=0; i<selectobject.length; i++){
                          if (selectobject.options[i].value == arrItem[x])
                             selectobject.remove(i);
                          }
                }
            }

            if(arrActivity.length > 1){
                for(var x=1; x<(arrActivity.length); x++){
                    var selectobject = document.getElementById("SelectActivity")
                      for (var i=0; i<selectobject.length; i++){
                          if (selectobject.options[i].value == arrActivity[x]){
                              selectobject.remove(i);
                          }         
                      }
                }
            }
            
            if(arrFee.length > 1){
                for(var x=1; x<(arrFee.length); x++){
                    var selectobject = document.getElementById("SelectFee")
                      for (var i=0; i<selectobject.length; i++){
                          if (selectobject.options[i].value == arrFee[x]){
                              selectobject.remove(i);
                          }         
                      }
                }
            }

            //Compute
            
            $("#PacRoomTable tr").each(function(){
                if(($(this).find("td:nth-child(3)").text())!=""){
                    OldTotal += parseInt($(this).find("td:nth-child(3)").text()) * parseInt(document.getElementById("EditPackageDuration").value);
                }

            });
            $("#PacItemTable tr").each(function(){
                if(($(this).find("td:nth-child(4)").text())!=""){
                    OldTotal += parseInt($(this).find("td:nth-child(4)").text());
                }
            });
            $("#PacActivityTable tr").each(function(){
                if(($(this).find("td:nth-child(3)").text())!=""){
                    OldTotal += parseInt($(this).find("td:nth-child(3)").text());
                }
            });
            $("#PacFeeTable tr").each(function(){
                if(($(this).find("td:nth-child(2)").text())!=""){
                    OldTotal += parseInt($(this).find("td:nth-child(2)").text());
                }
            });
            
            if(document.getElementById("tempPackageTransportation").value == "1"){
                document.getElementById("EditPackageTransportation").checked = true;
            }
            TotalAmount = OldTotal;
            document.getElementById("TotalAmount").innerHTML = TotalAmount;
            document.getElementById("i-PackagePax").innerHTML = document.getElementById("EditPackagePax").value;
            getRoomCapacity();
            
        } 
    }



// Remove Modal Function

function RemoveRoomType(){
    var TableChecker = CheckTable('#PacRoomTable tr');
        if(TableChecker){
            TotalAmount = parseInt(TotalAmount) - (parseInt(RoomInfo[2]) * parseInt(document.getElementById("EditPackageDuration").value));
            document.getElementById("TotalAmount").innerHTML = TotalAmount;
            document.getElementById("PacRoomTable").deleteRow(RoomIndex+1);
            var select = document.getElementById("SelectRoomType");
            var option = document.createElement("option");
            option.text = RoomInfo[0];
            select.add(option);

            for(var x = 0; x < RoomTypeDetails.length; x++){
                if(RoomTypeDetails[x].strRoomType == RoomInfo[0]){
                    TotalRoomCapacity -= (parseInt(RoomTypeDetails[x].intRoomTCapacity) * parseInt(RoomInfo[1]));
                    document.getElementById("TotalRoomCapacity").innerHTML = TotalRoomCapacity;
                    break;
                }
            }

            RoomIndex= null;
            RoomCapacityChecker();
        }
}

function RemoveItem(){
    var TableChecker = CheckTable('#PacItemTable tr');
        if(TableChecker){
            TotalAmount = parseInt(TotalAmount) - parseInt(ItemInfo[3]);
            document.getElementById("TotalAmount").innerHTML = TotalAmount;
            document.getElementById("PacItemTable").deleteRow(ItemIndex+1);
            var select = document.getElementById("SelectItem");
            var option = document.createElement("option");
            option.text = ItemInfo[0];
            select.add(option);
            ItemIndex= null;
        }
}

function RemoveActivity(){
    var TableChecker = CheckTable('#PacActivityTable tr');
        if(TableChecker){
            TotalAmount = parseInt(TotalAmount) - parseInt(ActivityInfo[2]);
            document.getElementById("TotalAmount").innerHTML = TotalAmount;
            document.getElementById("PacActivityTable").deleteRow(ActivityIndex+1);
            var select = document.getElementById("SelectActivity");
            var option = document.createElement("option");
            option.text = ActivityInfo[0];
            select.add(option);
            ActivityIndex= null;
        }
}

function RemoveFee(){
    var TableChecker = CheckTable('#PacFeeTable tr');
    if(TableChecker){
        TotalAmount = parseInt(TotalAmount) - parseInt(FeeInfo[1]);
        document.getElementById("TotalAmount").innerHTML = TotalAmount;
        document.getElementById("PacFeeTable").deleteRow(FeeIndex+1);
        var select = document.getElementById("SelectFee");
        var option = document.createElement("option");
        option.text = FeeInfo[0];
        select.add(option);
        FeeIndex= null;
    }
}


//MISC

// Table Function
function run(event, sender){
    var cells;
    event = event || window.event; 
    var target = event.target || event.srcElement;
    while (target && target.nodeName != 'TR') {
        target = target.parentElement;
    }

    cells = target.cells;
    if (!cells.length || target.parentNode.nodeName == 'THEAD') {
        return;
    }

    if(sender == "RoomType"){
        RoomInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML];
    }
    if(sender == "Item"){
        ItemInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML];
    }
    if(sender == "Activity"){
        ActivityInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML];
    }
    if(sender == "Fee"){
        FeeInfo = [cells[0].innerHTML, cells[1].innerHTML];
    }
}

//table row clicked

$(document).ready(function(){
    $('#PacRoomTable').on('click', 'tbody tr', function(){
        HighlightRow(this);
        RoomIndex = $(this).index();
    });

    $('#PacItemTable').on('click', 'tbody tr', function(){
        HighlightRow(this);
        ItemIndex = $(this).index();
    });

    $('#PacActivityTable').on('click', 'tbody tr', function(){
        HighlightRow(this);
        ActivityIndex = $(this).index();
    });
    
    $('#PacFeeTable').on('click', 'tbody tr', function(){
        HighlightRow(this);
        FeeIndex = $(this).index();
    });
});

//get Room Capacity AJAX

function getRoomCapacity(){
    var i = 0;
    var RoomNames = [];
    var RoomInfo = "";
    var tempRoomCapacity = 0;
    $("#PacRoomTable tr").each(function(){
        if(($(this).find("td:first-child").text())!=""){
            RoomNames[i]= $(this).find("td:first-child").text();
            i++;
        }
    });
    
     $.ajax({
            type:'get',
            url:'/Maintenance/Package/RoomCapacity',
            success:function(data){
                console.log('success');
                RoomTypeDetails = data;
                for(var x = 0; x < RoomNames.length; x++){
                    for(var y = 0; y < data.length; y++){
                        if(data[y].strRoomType == RoomNames[x]){
                            $("#PacRoomTable tr").each(function(){
                                if(($(this).find("td:first-child").text()) == data[y].strRoomType){
                                    tempRoomCapacity += parseInt($(this).find("td:nth-child(2)").text()) * parseInt(data[y].intRoomTCapacity);
                                }
                            });
                            break;
                        }
                    }
                }
            
            document.getElementById("TotalRoomCapacity").innerHTML = tempRoomCapacity;
            TotalRoomCapacity = tempRoomCapacity;
                
            },
            error:function(response){
                console.log(response);
            }
        });   
}

//Validator

function checkInput(holder, inputError){
    if(inputError){
        $(holder).addClass("has-warning");
    }
    else{
        $(holder).removeClass("has-warning");
    }

    if($(".modal-input").hasClass("has-warning")){
        var x = document.getElementsByClassName("ModalErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="Invalid input!";
        }
    }

    else{
        var x = document.getElementsByClassName("ModalErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="";
        }
    }
}

function ModalValidateInput(field, variableType, holder){
    var inputError = false;

    if(variableType == "string"){
        inputError = CheckString(field.value);
    }

    if(variableType == "int"){
        inputError = CheckInteger(field.value);
    }

    if(variableType == "int2"){
        inputError = CheckInteger2(field.value);
    }

    if(variableType == "double"){
        inputError = CheckDouble(field.value);
    }

    if(inputError){
        $(holder).addClass("has-warning");
    }
    else{
        $(holder).removeClass("has-warning");
    }

    if($(".modal-input").hasClass("has-warning")){
        var x = document.getElementsByClassName("ModalErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="Invalid input!";
        }
    }

    else{
        var x = document.getElementsByClassName("ModalErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="";
        }
    }

}

//Package Pax input event listener

function PackagePaxEvent(field, dataType, holder){
    document.getElementById("i-PackagePax").innerHTML = document.getElementById("EditPackagePax").value;
    RoomCapacityChecker();
    ValidateInput(field, dataType, holder);
}

function RoomCapacityChecker(){
    if(TotalRoomCapacity >= parseInt(document.getElementById("i-PackagePax").innerHTML)){
        $("#TotalRoomCapacity").removeClass("text-danger");
        document.getElementById("PaxError").innerHTML = "";
    }
    else{
        $("#TotalRoomCapacity").addClass("text-danger");
        document.getElementById("PaxError").innerHTML = "Package pax exceeds total room capacity. Please add more room or edit package pax";
    }
}

//Package Duration event listener
function PackageDurationEvent(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if((!ContinueDefault) && (!$(holder).hasClass('has-warning'))){
        ShowModalDuration();
        $('#ContinueButton').click(function () {
            if (this.id == 'ContinueButton') {
                $('#PacRoomTable tbody').empty();
                TotalRoomCapacity = 0;
                document.getElementById("TotalRoomCapacity").innerHTML = TotalRoomCapacity;
                strRoomCapacity = "";
                ContinueDefault = true;
                HideModalDuration();
                getRooms();
            }
        });
        $('#CancelButton').click(function () {
            if (this.id == 'CancelButton') {
                document.getElementById("PackageDuration").value = OldDuration;
                HideModalDuration();
            }
        });
    }
    else{
        getRooms();
    }
    
}

function PressPreventDefault(event){
    if(!ContinueDefault){
        event.preventDefault();
    } 
}

function PressContinueDefault(){
    if(document.getElementById("packageTables").style.display == "block"){
        ContinueDefault = false;
    }
}    
    
//Reset modal

function ResetModalInput(){
    $('.modal-input').removeClass("has-warning");
    $('.modal-input').removeClass("has-error");
    var x = document.getElementsByClassName("ModalErrorLabel");
    for(var i = 0; i < x.length; i++){
        x[i].innerText="";
    }
}
    
function SavePackage(){
    var rowCount = $('#PacRoomTable tbody tr').length;
    var TableError = false;
    if(rowCount == 0){
        document.getElementById("EmptyRoomError").innerHTML = "Please choose atleast 1 room";
        TableError = true;
    }
    else{
        document.getElementById("EmptyRoomError").innerHTML = "";
        TableError = false;
    }

    if(TableError){
        return false;
    }
    if($(".form-group").hasClass("has-warning")){  
        return false;
    }
    else if($("#TotalRoomCapacity").hasClass("text-danger")){
        return false;
    }
    else{
        //Get data from tables
        var pacRoomType = document.getElementById('PacRoomTable'), cellsRoomType = pacRoomType.getElementsByTagName('td');
        var pacItem = document.getElementById('PacItemTable'), cellsItem = pacItem.getElementsByTagName('td');
        var pacActivity = document.getElementById('PacActivityTable'), cellsActivity = pacActivity.getElementsByTagName('td');
        var pacFee = document.getElementById('PacFeeTable'), cellsFee = pacFee.getElementsByTagName('td');

        var pacRoomTypeCells = (document.getElementById('PacRoomTable').getElementsByTagName("tr").length - 1) * 3;
        var pacItemCells = (document.getElementById('PacItemTable').getElementsByTagName("tr").length - 1) * 4;
        var pacActivityCells = (document.getElementById('PacActivityTable').getElementsByTagName("tr").length - 1) * 3;
        var pacFeeCells = (document.getElementById('PacFeeTable').getElementsByTagName("tr").length - 1) * 2;

        var strRoomTypeData = "";
        for(var i = 0; i < pacRoomTypeCells; i += 3){             
          strRoomTypeData += cellsRoomType[i].innerHTML + "-" + cellsRoomType[i + 1].innerHTML + "-" + cellsRoomType[i + 2].innerHTML;  
          if(!(i == (pacRoomTypeCells - 3))){                  
              strRoomTypeData += ",";                  
          }          
        }

        var strItemData = "";        
        for(var i = 0; i < pacItemCells; i += 4){            
          strItemData += cellsItem[i].innerHTML + "-" + cellsItem[i + 1].innerHTML + "-" + cellsItem[i + 2].innerHTML + "-" + cellsItem[i + 3].innerHTML;           
          if(!(i == (pacItemCells - 4))){              
              strItemData += ",";            
          }           
        }

        var strActivityData = "";          
        for(var i = 0; i < pacActivityCells; i += 3){           
          strActivityData += cellsActivity[i].innerHTML + "-" + cellsActivity[i + 1].innerHTML + "-" + cellsActivity[i + 2].innerHTML;
          if(!(i == (pacActivityCells - 3))){               
              strActivityData += ",";               
          }
        }

        var strFeeData = "";          
        for(var i = 0; i < pacFeeCells; i += 2){           
          strFeeData += cellsFee[i].innerHTML + "-" + cellsFee[i + 1].innerHTML;
          if(!(i == (pacFeeCells - 2))){               
              strFeeData += ",";               
          }
        }
        
        document.getElementById("includedRooms").value = strRoomTypeData;
        document.getElementById("includedItems").value = strItemData;
        document.getElementById("includedActivities").value = strActivityData;
        document.getElementById("includedFees").value = strFeeData;
        
        return true;
    }   
}