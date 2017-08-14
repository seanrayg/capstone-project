var DatesInfo = [];


//Date Modals
function ShowModalAddDate(){
    document.getElementById("DivModalAddDate").style.display = "block";
}
function HideModalAddDate(){
    document.getElementById("DivModalAddDate").style.display = "none";
}
function ShowModalEditDate(){     
    document.getElementById("DivModalEditDate").style.display = "block";
}
function HideModalEditDate(){
    document.getElementById("DivModalEditDate").style.display = "none";
}
function ShowModalDeleteDate(){
    document.getElementById("DivModalDeleteDate").style.display = "block";
}
function HideModalDeleteDate(){
    document.getElementById("DivModalDeleteDate").style.display = "none";
}

//Contact Modals
function ShowModalAddContact(){
    document.getElementById("DivModalAddContact").style.display = "block";
}
function HideModalAddContact(){
    document.getElementById("DivModalAddContact").style.display = "none";
}
function ShowModalEditContact(){     
    document.getElementById("DivModalEditContact").style.display = "block";
}
function HideModalEditContact(){
    document.getElementById("DivModalEditContact").style.display = "none";
}
function ShowModalDeleteContact(){
    document.getElementById("DivModalDeleteContact").style.display = "block";
}
function HideModalDeleteContact(){
    document.getElementById("DivModalDeleteContact").style.display = "none";
}


// Table Function
function run(event){

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

    DatesInfo = [cells[0].innerHTML, cells[1].innerHTML, cells[2].innerHTML, cells[3].innerHTML, cells[4].innerHTML, cells[5].innerHTML, cells[6].innerHTML, cells[7].innerHTML];

}

//Start/End date event listener
$( document ).ready(function() {
    $('#StartDate').on('changeDate', function(ev) {
        var StartDate = document.getElementById("StartDate").value;
        var PastError = DateChecker(StartDate);
        if(PastError){
            $('#StartDateError').addClass("has-warning");
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="Invalid Date";
            } 
        }
        else{
            $('#StartDateError').removeClass("has-warning");
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="";
            } 
            var EndDate = document.getElementById("EndDate").value;
            if(StartDate != "" && EndDate != ""){
                CheckDates(StartDate, EndDate);
            }
        }
        
    }).data('datepicker');

    $('#EndDate').on('changeDate', function(ev) {
        var EndDate = document.getElementById("EndDate").value;
        var PastError = DateChecker(EndDate);
        if(PastError){
            $('#EndDateError').addClass("has-warning");
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="Invalid Date";
            } 
        }
        else{
            $('#EndDateError').removeClass("has-warning");
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="";
            } 
            var StartDate = document.getElementById("StartDate").value;
            if(StartDate != "" && EndDate != ""){
                CheckDates(StartDate, EndDate);
            }
        }
    }).data('datepicker');
});


function CheckDates(StartDate, EndDate){
    if(StartDate <= EndDate){
        $('#EndDateError').removeClass("has-warning");
        var x = document.getElementsByClassName("ErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="";
        } 
    }
    else{
        $('#EndDateError').addClass("has-warning");
        var x = document.getElementsByClassName("ErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="Invalid Date!";
        }
    }
}

//check if the date is from the past
function DateChecker(selectedDate){
    var today = new Date();
    var nextWeek = today.getMonth()+1 + "/" +today.getDate() + "/" + today.getFullYear();
    if(!(Date.parse(selectedDate) >= Date.parse(nextWeek))){
       return true;
    }
    return false;
}