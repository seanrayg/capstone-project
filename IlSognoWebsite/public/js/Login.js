function Login(){

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
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
        dataType: 'json',
        success: function (data) {
            alert('hehe');
        },
        error: function (data) {
            
        }
    });

}

function ShowVerificationModal(){
    $('#ModalVerification').modal('show');
    var CustomerEmail = document.getElementById("CustomerEmail").value;
    document.getElementById("ModalTitle").innerHTML = "We have sent a verifivation code to your Email Address: " + CustomerEmail +" Please enter the code to continue";
}

function HideVerificationModal(){
    $('#ModalVerification').modal('hide');
}