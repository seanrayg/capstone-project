function SendInput(field, dataType, holder){
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

    document.getElementById("iReservationID").value = document.getElementById("s-ReservationID").value;

    var tblRoomInfo = GetTableInfo("tblRoomInfo");
    var tblItemInfo = GetTableInfo("tblItemInfo");
    var tblActivityInfo = GetTableInfo("tblActivityInfo");
    var tblFeeInfo = GetTableInfo("tblFeeInfo");
    var tblMiscellaneousInfo = GetTableInfo("tblMiscellaneousInfo");
    var tblAdditionalRooms = GetTableInfo("tblAdditionalRooms");
    var tblUpgradeRooms = GetTableInfo("tblUpgradeRooms");
    var tblExtendStay = GetTableInfo("tblExtendStay");
    var tblBoatInfo = GetTableInfo("tblBoatInfo");
    var tblDeductions = GetTableInfo("tblDeductions");

    if(tblRoomInfo != null) {

        $('#itblRoomInfo').val(JSON.stringify(tblRoomInfo));

    }

    if(tblItemInfo != null) {

        $('#itblItemInfo').val(JSON.stringify(tblItemInfo));

    }

    if(tblActivityInfo != null) {

        $('#itblActivityInfo').val(JSON.stringify(tblActivityInfo));

    }

    if(tblFeeInfo != null) {

        $('#itblFeeInfo').val(JSON.stringify(tblFeeInfo));

    }

    if(tblMiscellaneousInfo != null) {

        $('#itblMiscellaneousInfo').val(JSON.stringify(tblMiscellaneousInfo));
        document.getElementById("mfee").value = document.getElementById("miscfee").innerHTML;

    }

    if(tblAdditionalRooms != null) {

        $('#itblAdditionalRooms').val(JSON.stringify(tblAdditionalRooms));

    }

    if(tblUpgradeRooms != null) {

        $('#itblUpgradeRooms').val(JSON.stringify(tblUpgradeRooms));

    }

    if(tblExtendStay != null) {

        $('#itblExtendStay').val(JSON.stringify(tblExtendStay));

    }

    if(tblBoatInfo != null) {

        $('#itblBoatInfo').val(JSON.stringify(tblBoatInfo));

    }

    if (tblDeductions != null) {

        $('#itblDeductions').val(JSON.stringify(tblDeductions));

    }

    document.getElementById("checkoutAmountTendered").value = document.getElementById("PayPayment").value;
    document.getElementById("InvoiceForm").submit();

}

function GetTableInfo(TableName) {

    var tblInfo = [];

    //gets table
    var oTable = document.getElementById(TableName);

    if(oTable == null) {

        return null;

    }else {

        //gets rows of table
        var rowLength = oTable.rows.length;

        //loops through rows    
        for (i = 0; i < rowLength; i++){

            tblInfo[i] = [];

           //gets cells of current row
           var oCells = oTable.rows.item(i).cells;

           //gets amount of cells of current row
           var cellLength = oCells.length;

           //loops through each cell in current row
           for(var j = 0; j < cellLength; j++){
              /* get your cell info here */
              /* var cellVal = oCells.item(j).innerHTML; */

              tblInfo[i][j] = oCells.item(j).innerHTML;

           }
        }

        return tblInfo;

    }

}
