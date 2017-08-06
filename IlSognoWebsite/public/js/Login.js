function Login(){

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
        success: function (data) {
            alert(data);
        }

    });

    // $.post('postRequest', loginData, function(data){
    //     alert(data);
    // });

}

function ShowVerificationModal(){
    $('#ModalVerification').modal('show');
    var CustomerEmail = document.getElementById("CustomerEmail").value;
    document.getElementById("ModalTitle").innerHTML = "We have sent a verifivation code to your Email Address: " + CustomerEmail +" Please enter the code to continue";
}

function HideVerificationModal(){
    $('#ModalVerification').modal('hide');
}