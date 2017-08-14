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
    
    FillData();

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
                CheckDates(StartDate, EndDate, 'add');
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
                CheckDates(StartDate, EndDate, 'add');
            }
        }
    }).data('datepicker');
    
    $('#EditStartDate').on('changeDate', function(ev) {
        var StartDate = document.getElementById("EditStartDate").value;
        var PastError = DateChecker(StartDate);
        if(PastError){
            $('#EditStartDateError').addClass("has-warning");
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="Invalid Date";
            } 
        }
        else{
            $('#EditStartDateError').removeClass("has-warning");
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="";
            } 
            var EndDate = document.getElementById("EditEndDate").value;
            if(StartDate != "" && EndDate != ""){
                CheckDates(StartDate, EndDate, 'edit');
            }
        }
        
    }).data('datepicker');

    $('#EditEndDate').on('changeDate', function(ev) {
        var EndDate = document.getElementById("EditEndDate").value;
        var PastError = DateChecker(EndDate);
        if(PastError){
            $('#EditEndDateError').addClass("has-warning");
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="Invalid Date";
            } 
        }
        else{
            $('#EditEndDateError').removeClass("has-warning");
            var x = document.getElementsByClassName("ErrorLabel");
            for(var i = 0; i < x.length; i++){
                x[i].innerText="";
            } 
            var StartDate = document.getElementById("EditStartDate").value;
            if(StartDate != "" && EndDate != ""){
                CheckDates(StartDate, EndDate, 'edit');
            }
        }
    }).data('datepicker');
});


function CheckDates(StartDate, EndDate, sender){
    if(StartDate <= EndDate){
        if(sender == "add"){
            $('#EndDateError').removeClass("has-warning");
        }
        else{
            $('#EditEndDateError').removeClass("has-warning");
        }
        var x = document.getElementsByClassName("ErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="";
        } 
    }
    else{
        if(sender == "add"){
            $('#EndDateError').addClass("has-warning");
        }
        else{
            $('#EditEndDateError').addClass("has-warning");
        }
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

//fills inputs on edit modal
function FillData(){
    document.getElementById("OldDateID").value = DatesInfo[0];
    document.getElementById("OldDateName").value = DatesInfo[1];
    document.getElementById("EditDateID").value = DatesInfo[0];
    document.getElementById("EditDateName").value = DatesInfo[1];
    document.getElementById("EditStartDate").value = DatesInfo[6];
    document.getElementById("EditEndDate").value = DatesInfo[7];
    document.getElementById("EditDateStatus").value = DatesInfo[4];
    document.getElementById("EditDateDescription").value = DatesInfo[5];
    
    document.getElementById("DeleteDateID").value = DatesInfo[0];
    
    $('#EditStartDate').datepicker('setValue', DatesInfo[6]);
    $('#EditEndDate').datepicker('setValue', DatesInfo[7]);
}