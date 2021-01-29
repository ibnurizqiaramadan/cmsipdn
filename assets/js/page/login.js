$("#formLogin").submit(function(e) {
    e.preventDefault()
    $.ajax({
        url : `${ADMIN_PATH}/login/action`,
        type : "POST",
        data: new FormData(this),
		processData: false,
		contentType: false,
        cache: false,
        dataType: "JSON",
        beforeSend: function() {
            // disableButton()
        },
        complete: function(result) {
            let response = result.responseJSON
            msgSweetSuccess(response.password)
            enableButton()
        }
    })
})