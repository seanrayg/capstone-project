
//notification

window.setTimeout(function() {
    $(".hide-automatic").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);

//table function

function HighlightRow(table){
    $(table).addClass('selected').siblings().removeClass("selected");
}

function CheckTable(TableName){
    if($(TableName).hasClass('selected')){
        return true;
    }
        return false;  
}

function SearchTable(TableID, rowNumber) {
  var input, filter, table, tr, td, i;
  input = document.getElementById("SearchBar");
  filter = input.value.toUpperCase();
  table = document.getElementById(TableID);
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[rowNumber];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function SearchTable2(TableID, rowNumber) {
  var input, filter, table, tr, td, i;
  input = document.getElementById("SearchBar2");
  filter = input.value.toUpperCase();
  table = document.getElementById(TableID);
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[rowNumber];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function sortTable(n, TableID, field) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById(TableID);
  switching = true;
  dir = "asc"; 

    
  while (switching) {
    switching = false;
    rows = table.getElementsByTagName("TR");
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      if(field == 'string'){
        if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              shouldSwitch= true;
              break;
            }
          } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              shouldSwitch= true;
              break;
            }
          }
      }
        
      else{
          if (dir == "asc") {
            if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
              shouldSwitch= true;
              break;
            }
          } else if (dir == "desc") {
            if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
              shouldSwitch= true;
              break;
            }
          }
      }
      
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++; 
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
    
  }
    var tRow = n + 1;
    var newTableID = '#'+TableID;
    $(newTableID+' th:nth-child('+tRow+')').addClass('activeHeader').siblings().removeClass("activeHeader");
}

//sidebar function

window.onload = function() {
    var Username = localStorage.getItem("Username");
    if(Username == null){
        document.location.href = "/";
    }
    
    var TitlePage = document.getElementById("TitlePage").innerHTML;
    $(".sidebar li").removeClass("active");
    if(TitlePage == "Dashboard"){
        $("#SB-Dashboard").addClass("active");
    }
    else if(TitlePage.indexOf("Reservation") > -1){
        $("#SB-Reservations").addClass("active");
    }

    else if(TitlePage == "Customers"){
        $("#SB-Customers").addClass("active");
    }
    
    else if(TitlePage == "Walk in"){
        $("#SB-Walkin").addClass("active");
    }

    else if(TitlePage == "Boat Schedule"){
        $("#SB-BoatSchedule").addClass("active");
    }

    else if(TitlePage == "Rooms"){
        $("#SB-Rooms").addClass("active");
    }

    else if(TitlePage == "Item Rental"){
        $("#SB-ItemRental").addClass("active");
    }

    else if(TitlePage == "Activities"){
        $("#SB-Activities").addClass("active");
    }

    else if(TitlePage == "Billing"){
        $("#SB-Billing").addClass("active");
    }

    else if(TitlePage.indexOf("Maintenance") > -1){
        $("#SB-Maintenance").addClass("active");
    }

    else if(TitlePage.indexOf("Package") > -1){
        $("#SB-Maintenance").addClass("active");
    }

    else if(TitlePage == "Reports"){
        $("#SB-Reports").addClass("active");
    }
    
    else if(TitlePage == "Fees"){
        $("#SB-Fees").addClass("active");
    }
    
    else if(TitlePage == "Utilities"){
        $("#SB-Utilities").addClass("active");
    }
    
     $.ajax({
        type:'get',
        url:'/SystemUsers/Restrictions',
        data:{Username: Username},
        success:function(data){
            if(data[0].intRoom == 1){
                document.getElementById("SB-Reservations").style.display = "block";
                document.getElementById("SB-Customers").style.display = "block";
                document.getElementById("SB-Walkin").style.display = "block";
            }
            if(data[0].intBoat == 1){
                document.getElementById("SB-BoatSchedule").style.display = "block";
            }
            if(data[0].intFee == 1){
                document.getElementById("SB-Fees").style.display = "block";
            }
            if(data[0].intItem == 1){
                document.getElementById("SB-ItemRental").style.display = "block";
            }
            if(data[0].intActivity == 1){
                document.getElementById("SB-Activities").style.display = "block";
            }
            if(data[0].intMaintenance == 1){
                document.getElementById("SB-Maintenance").style.display = "block";
            }
            if(data[0].intBilling == 1){
                document.getElementById("SB-Billing").style.display = "block";
            }
            if(data[0].intUtilities == 1){
                document.getElementById("SB-Utilities").style.display = "block";
            }
            if(data[0].intReports == 1){
                document.getElementById("SB-Reports").style.display = "block";
            }
          
        },
        error:function(response){
            console.log(response);
            alert("error");
        }
    });   
    
    
};

//modal for walkin

function ShowModalWalkinOption(){
    document.getElementById("DivModalWalkinOptions").style.display = "block";
}

function HideModalWalkinOption(){
    document.getElementById("DivModalWalkinOptions").style.display = "none";
}

//form

function CheckForm(){
    if($(".form-group").hasClass("has-warning")){  
        return false;
    }
    else{
        return true;
    }
}