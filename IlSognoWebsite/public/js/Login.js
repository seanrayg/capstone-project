function Login(){

    if($('#CustomerEmail').val() != "" && $('#TransactionID').val() != ""){

        $('#login').hide();
        $('#loader').show();

        $('#validation').contents().remove();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var loginData = {
            CustomerEmail: $('#CustomerEmail').val(),
            TransactionID: $('#TransactionID').val()
        }

        $.ajax({

            type: 'POST',
            url: '/Login',
            data: loginData,
            success: function(data) {
                if(data == 1){

                    ShowVerificationModal();
                    $('#loader').hide();

                }else if(data == 2){

                    $('#validation').append("The Email or Transaction ID that you have entered is incorrect.");
                    $('#login').show();
                    $('#loader').hide();

                }
            },
            error: function(jqXHR, exception){
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                alert(msg);
            }

        });

    }else{

        $('#validation').contents().remove();
        $('#validation').append("Please enter your Email and Transaction ID");

    }

}//End of Login

function LoginCheckCode(){

    if($('#VerificationCode').val() != ""){

        $('#inputs').hide();
        $('#loader2').show();
        $('#VerificationCodeValidation').hide();

        $CustomerEmail = $('#CustomerEmail').val();
        $VerificationCode = $('#VerificationCode').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({

            type: 'POST',
            url: '/Login/VerifyCode',
            data: {
                CustomerEmail: $CustomerEmail,
                VerificationCode: $VerificationCode
            },
            success: function(data) {
                if(data != 2){

                    alert('Code matched');
                    window.location.href = '/Reservation/' + data;

                }else if(data == 2){

                    $('#inputs').show();
                    $('#loader2').hide();

                }
            }

        });

    }else{

        $('#VerificationCodeValidation').show();
        $('#inputs').show();
        $('#loader2').hide();

    }

}//End of LoginCheckCode

function ShowVerificationModal(){
    $('#ModalVerification').modal('show');
    var CustomerEmail = document.getElementById("CustomerEmail").value;
    document.getElementById("ModalTitle").innerHTML = "We have sent a verification code to your Email Address: " + CustomerEmail +" Please enter the code to continue";
}

function HideVerificationModal(){
    $('#ModalVerification').modal('hide');
    $('#login').show();
    $('#VerificationCodeValidation').hide();
    $('#loader2').hide();
    $('#inputs').show();
    document.getElementById('VerificationCode').value = "";
}