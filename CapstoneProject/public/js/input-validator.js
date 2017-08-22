function ValidateInput(field, variableType, holder){
    var inputError = false;
 
    if(variableType == "string"){
        inputError = CheckString(field.value);
    }

    else if(variableType == "int"){
        inputError = CheckInteger(field.value);
    }

    else if(variableType == "int2"){
        inputError = CheckInteger2(field.value);
    }

    else if(variableType == "double"){
        inputError = CheckDouble(field.value);
    }
    
    else if(variableType == "double2"){
        inputError = CheckDouble(field.value);
    }
    
    else if(variableType == "string2"){
        inputError = CheckString2(field.value);
    }
    
    else if(variableType == "email"){
        inputError = CheckEmail(field.value);
    }
    
    else if(variableType = "contact"){
        inputError = CheckContact(field.value);
    }

    if(inputError){
        $(holder).addClass("has-warning");
    }
    else{
        $(holder).removeClass("has-warning");
    }

    if($(".form-group").hasClass("has-warning")){
        var x = document.getElementsByClassName("ErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="Invalid input!";
        }
    }

    else{
        var x = document.getElementsByClassName("ErrorLabel");
        for(var i = 0; i < x.length; i++){
            x[i].innerText="";
        }
    }

}


// Validators

function CheckContact(temp){
    if(/^(09|\+639)\d{9}$/.test(temp) == false){
        return true;
    }
    return false;
    
}

function CheckEmail(temp){
    if(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(temp) == false){
        return false;
    }
    return true;
}


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
    else if(temp.charAt(0)=='-'){
         return true;
    }
    else if(temp <= 0){
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
    else if(temp.charAt(0)=='-'){
         return true;
    }
    else if(temp < 0){
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




