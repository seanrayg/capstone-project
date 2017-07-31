
var cells;
var PackageInfo=[];

function ShowModalDeletePackage(){
  var TableChecker = CheckTable('#PackageTable tr');
    if(TableChecker){
        document.getElementById("DivModalDeletePackage").style.display = "block";
        document.getElementById("DeletePackageID").value = PackageInfo[0];
    }
}

function HideModalDeletePackage(){
  document.getElementById("DivModalDeletePackage").style.display = "none";
}

function showEditWebpage(){
    var TableChecker = CheckTable('#PackageTable tr');
    if(TableChecker){        
        window.location.href = '/Maintenance/Package/Edit/'+PackageInfo[0];
    }
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

    PackageInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML];

    $.ajax({
        type:'get',
        url:'/Maintenance/Package/Info',
        data:{id:PackageInfo[0]},
        success:function(data){
            console.log('success');
            $('#tblIncludedItems tbody').empty();
            $('#tblIncludedRooms tbody').empty();
            $('#tblIncludedActivities tbody').empty();
            $('#tblIncludedFees tbody').empty();

            var tableRef = document.getElementById('tblIncludedItems').getElementsByTagName('tbody')[0];

            console.log(data);

            console.log(data.PackageRoomInfo.length);

            for(var x = 0; x < data.PackageItemInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                var newCell3 = newRow.insertCell(2);

                newCell1.innerHTML = data.PackageItemInfo[x].strItemName;
                newCell2.innerHTML = data.PackageItemInfo[x].intPackageIQuantity;
                newCell3.innerHTML = data.PackageItemInfo[x].flPackageIDuration;

            }

            tableRef = document.getElementById('tblIncludedRooms').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.PackageRoomInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);

                newCell1.innerHTML = data.PackageRoomInfo[x].strRoomType;
                newCell2.innerHTML = data.PackageRoomInfo[x].intPackageRQuantity;
                
            }

            tableRef = document.getElementById('tblIncludedActivities').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.PackageActivityInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);

                newCell1.innerHTML = data.PackageActivityInfo[x].strBeachAName;
                newCell2.innerHTML = data.PackageActivityInfo[x].intPackageAQuantity;

            }
            
            tableRef = document.getElementById('tblIncludedFees').getElementsByTagName('tbody')[0];

            for(var x = 0; x < data.PackageFeeInfo.length; x++){
                var newRow   = tableRef.insertRow(tableRef.rows.length);

                var newCell1  = newRow.insertCell(0);

                newCell1.innerHTML = data.PackageFeeInfo[x].strFeeName;

            }



        },
        error:function(response){
            console.log(response);
        }
    });   
}