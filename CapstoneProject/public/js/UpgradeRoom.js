var ReservationID;
var RoomType;
var RoomName;
var UpgradeRoom;
var UpgradeRoomType;


function ShowModalPayNow(){
    document.getElementById("DivModalPayNow").style.display = "block";
    document.getElementById("PayReservationID").value = ReservationID;
    document.getElementById("PayRoomName").value = RoomName;
    document.getElementById("PayNewRoomName").value = UpgradeRoom;
}

function HideModalPayNow(){
    document.getElementById("DivModalPayNow").style.display = "none";
}

function ShowModalUpgradeRoom(){
    var TableChecker = CheckTable('#tblRooms tr');
    if(TableChecker){
        var RoomName = document.getElementById("i-RoomName").innerHTML;
        $.ajax({
        type:'get',
        url:'/Upgrade/Price',
        data:{ReservationID:ReservationID,
              OriginalRoom:RoomType,
              UpgradeRoom:UpgradeRoomType,
              RoomName:RoomName},
        success:function(data){
                var OriginalRoomPrice = data.OriginalRoomPrice[0].dblRoomRate;
                var UpgradeRoomPrice = data.UpgradeRoomPrice[0].dblRoomRate;
                var ArrivalDate = data.ReservationDates[0].dtmResDArrival;
                var DepartureDate = data.ReservationDates[0].dtmResDDeparture;
                var date1 = new Date();
                var date2 = new Date(DepartureDate);
                diffDays = date2.getDate() - date1.getDate();
                if(diffDays == 0){
                    diffDays = 1;
                }

                alert(date1 + " " + date2);
                var OriginalRoomTotal = parseFloat(OriginalRoomPrice) * diffDays;

                var UpgradeRoomTotal = parseFloat(UpgradeRoomPrice) * diffDays;
            
                if(parseInt(data.RoomPaymentStatus[0].intResRPayment) % 2 == 0){
                    var AmountPaid = UpgradeRoomTotal - OriginalRoomTotal;
                    var RemainingAmount = Math.abs(OriginalRoomTotal + AmountPaid);
      
                    var AdditionalPayment = RemainingAmount;       
                }
                else{
                    var AdditionalPayment = UpgradeRoomTotal - OriginalRoomTotal;
                }
                
                document.getElementById("AdditionalPayment").innerHTML = "Additional payment amounting PHP" +AdditionalPayment +" is needed to upgrade the room";
            
                document.getElementById("PayTotal").value = AdditionalPayment;
            },
            error:function(response){
                console.log(response);
                alert("error");
            }
        }); 
        document.getElementById("DivModalUpgradeRoom").style.display = "block";
    }
}



function HideModalUpgradeRoom(){
    document.getElementById("DivModalUpgradeRoom").style.display = "none";
}


window.onload = function(){
    ReservationID = localStorage.getItem("ReservationID");
    RoomType = localStorage.getItem("RoomType");
    RoomName = localStorage.getItem("RoomName");
    document.getElementById("i-RoomType").innerHTML = RoomType;
    document.getElementById("i-RoomName").innerHTML = RoomName;
}

function SaveUpgradeInfo(){
    document.getElementById("ReservationID").value = ReservationID;
    document.getElementById("RoomName").value = RoomName;
    document.getElementById("NewRoomName").value = UpgradeRoom;
    document.getElementById("TotalAmount").value = document.getElementById("PayTotal").value;
    
    document.getElementById("UpgradePayLaterForm").submit();
}

function showRooms(field){
    $.ajax({
        type:'get',
        url:'/Upgrade/AvailableRooms',
        data:{ReservationID:ReservationID,
              ChosenRoomType:field},
        success:function(data){

                $('#tblRooms tbody').empty();

                var tableRef = document.getElementById('tblRooms').getElementsByTagName('tbody')[0];
                for(var x = 0; x < data.length; x++){
                    var newRow   = tableRef.insertRow(tableRef.rows.length);
                    var newCell1  = newRow.insertCell(0);
                    newCell1.innerHTML = data[x].strRoomName;
                }
            },
            error:function(response){
                console.log(response);
                alert("error");
            }
        }); 
}

//tblChosenRooms click
$( document ).ready(function() {    
    $('#tblRooms tbody').on('click', 'tr', function(){
        UpgradeRoom = $(this).text();
        HighlightRow(this);
    });
    
    $('#tblAccomodations tbody').on('click', 'tr', function(){
        UpgradeRoomType = $(this).text();
        HighlightRow(this);
    });
});

function SendPayment(field, dataType, holder){
    ValidateInput(field, dataType, holder);
    if(!($(holder).hasClass('has-warning'))){
        
        var Total = parseInt(document.getElementById("PayTotal").value);
        var Payment = parseInt(field.value);
        var Change = Payment - Total;
        if(Change < 0){
            document.getElementById("PayChange").value = "Insufficient Payment";
        }
        else{
            document.getElementById("PayChange").value = Change;
        }
        
    }
}

function PrintInvoice() {

    document.getElementById("iReservationID").value = ReservationID;
    document.getElementById("Description").value = "Upgrade " + RoomType + " to " + UpgradeRoomType;
    document.getElementById("iOrigRoomType").value = RoomType;
    document.getElementById("iRoomType").value = UpgradeRoomType;
    document.getElementById("Amount").value = document.getElementById("PayTotal").value;
    document.getElementById("upgradeAmountTendered").value = document.getElementById("PayPayment").value;
    document.getElementById("InvoiceForm").submit();

}


