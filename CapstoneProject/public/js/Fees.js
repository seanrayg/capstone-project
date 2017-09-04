var FeeInfo = [];
var DetailsInfo = [];

function ShowModalAddFees(){
    document.getElementById("DivModalAddFees").style.display = "block";
}

function HideModalAddFees(){
    document.getElementById("DivModalAddFees").style.display = "none";
}

function ShowModalCustomerFees(field){
     $.ajax({
        type:'get',
        url:'/Fee/Details',
        data:{ReservationID: field.value},
        success:function(data){
            $('#tblCustomerFees tbody').empty();

            var tableRef = document.getElementById('tblCustomerFees').getElementsByTagName('tbody')[0];

            console.log(data);

            for(var x = 0; x < data.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3 = newRow.insertCell(2);
                var newCell4 = newRow.insertCell(3);

                newCell1.innerHTML = data[x].strFeeID;
                newCell2.innerHTML = data[x].strFeeName;
                newCell3.innerHTML = data[x].intResFQuantity;
                newCell4.innerHTML = "<td><button type='button' rel='tooltip' title='Add Fee' class='btn btn-info btn-simple btn-xs' onclick='ShowModalEditFees()'><i class='material-icons'>create</i></button><button type='button' rel='tooltip' title='View Fees' class='btn btn-danger btn-simple btn-xs' onclick='ShowModalDeleteFees()'><i class='material-icons'>delete</i></button></td>";

            }
        },
        error:function(response){
            console.log(response);
            alert("error");
        }
    });   
    document.getElementById("DivModalCustomerFees").style.display = "block";
}

function HideModalCustomerFees(){
    document.getElementById("DivModalCustomerFees").style.display = "none";
}

function ShowModalEditFees(){
    document.getElementById("DivModalEditFees").style.display = "block";
}

function HideModalEditFees(){
    document.getElementById("DivModalEditFees").style.display = "none";
}

function ShowModalDeleteFees(){
    document.getElementById("DivModalDeleteFees").style.display = "block";
}

function HideModalDeleteFees(){
    document.getElementById("DivModalDeleteFees").style.display = "none";
}

function ShowModalPayFees(){
    var FeeID = document.getElementById("AddFeeID").value;
    document.getElementById("PayReservationID").value = FeeInfo[1];
    document.getElementById("PayFeeID").value = document.getElementById("AddFeeID").value;
    document.getElementById("PayFeeQuantity").value = document.getElementById("AddFeeQuantity").value;
    $.ajax({
        type:'get',
        url:'/Fee/Price',
        data:{FeeID:FeeID},
        success:function(data){
            console.log('success');
            var FeeAmount = data[0].dblFeeAmount;
            var FeeQuantity = document.getElementById("AddFeeQuantity").value;
            
            var TotalFeePrice = parseFloat(FeeAmount) * parseInt(FeeQuantity);
            
            document.getElementById("TotalFeePrice").value = TotalFeePrice;
        },
        error:function(response){
            console.log(response);
        }
    });   
    document.getElementById("DivModalPayFees").style.display = "block";
}

function HideModalPayFees(){
    document.getElementById("DivModalPayFees").style.display = "none";
}

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

    if(sender == "Add"){
        FeeInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML];
        fillAddFeeData();
    }
    if(sender == "Details"){
        DetailsInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML];
        fillEditFeeData();
    }
    
}

function fillAddFeeData(){
    document.getElementById("AddCustomerName").value = FeeInfo[2] +" "+ FeeInfo[3] +" "+ FeeInfo[4];
    document.getElementById("AddReservationID").value = FeeInfo[1];
}

function fillEditFeeData(){
    document.getElementById("EditFeeID").value = DetailsInfo[0];
    document.getElementById("EditFeeQuantity").value = DetailsInfo[2];
    document.getElementById("EditReservationID").value = FeeInfo[1];
    document.getElementById("DeleteFeeID").value = DetailsInfo[0];
    document.getElementById("DeleteReservationID").value = FeeInfo[1];
}

function SendPayment(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        
        var FeeTotal = parseInt(document.getElementById("TotalFeePrice").value);
        var FeePayment = parseInt(field.value);
        var Change = FeePayment - FeeTotal;
        if(Change < 0){
            document.getElementById("FeeChange").value = "Insufficient Payment";
        }
        else{
            document.getElementById("FeeChange").value = Change;
        }
        
    }
}