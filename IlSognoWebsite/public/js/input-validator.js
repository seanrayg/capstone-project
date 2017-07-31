function ValidateInput(field, variableType, holder){
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
    
    if(variableType == "string2"){
        inputError = CheckString2(field.value);
    }
    
    if(variableType == "email"){
        inputError = CheckEmail(field.value);
    }

    if(inputError){
        $(holder).addClass("has-danger");
    }
    else{
        $(holder).removeClass("has-danger");
    }
}


// Validators

function CheckString(temp){
    if(/^[a-zA-Z0-9- ]*$/.test(temp) == false) {
        return true;
    }
    else if(temp.charAt(0)==' '){
        return true;
    }
    else if(temp.indexOf('  ') >= 0){
        return true;
    }
    else{
        return false;
    }
}

function CheckString2(temp){
    if(/^[a-zA-Z\s]*$/.test(temp) == false) {
        return true;
    }
    else if(temp.charAt(0)==' '){
        return true;
    }
    else if( temp.indexOf('  ') >= 0){
        return true;
    }
    else{
        return false;
    }
}

function CheckDouble(temp){
    if(/^-?\d*(\.\d+)?$/.test(temp) == false) {
        return true;
    }
    else if(temp == 0){
        return true;
    }
    else{
        return false;
    }
}

function CheckInteger(temp){
    if(/^[0-9]*$/.test(temp) == false) {
        return true;
    }
    else if(temp == 0){
        return true;
    }
    else{
        return false;
    }
}

function CheckInteger2(temp){
    if(/^[0-9]*$/.test(temp) == false) {
        return true;
    }
    return false;
}

function CheckEmail(temp) {
    if(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(temp) == false){
      return true;
    }
    else if(temp.charAt(0)==' '){
        return true;
    }
    else if( temp.indexOf('  ') >= 0){
        return true;
    }
    else{
        return false;
    }
}

//Reset all forms
function ResetInput(){
    $('.form-group').removeClass("has-warning");
    $('.form-group').removeClass("has-error");
    var x = document.getElementsByClassName("ErrorLabel");
    for(var i = 0; i < x.length; i++){
        x[i].innerText="";
    }
}

function HighlightRow(table){
    $(table).addClass('selected').siblings().removeClass("selected");
}

function CheckTable(TableName){
    if($(TableName).hasClass('selected')){
        return true;
    }
        return false;  
}

