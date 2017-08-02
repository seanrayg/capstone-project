function ShowVerificationModal(){
    $('#ModalVerification').modal('show');
    var CustomerEmail = document.getElementById("CustomerEmail").value;
    document.getElementById("ModalTitle").innerHTML = "We have sent a verifivation code to your Email Address: " + CustomerEmail +" Please enter the code to continue";
}

function HideVerificationModal(){
    $('#ModalVerification').modal('hide');
}