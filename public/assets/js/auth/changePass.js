$('#change-btn').click(function (event) {
    initLoader('change-btn', 'Update', 'btn-orio');
    event.preventDefault();
    var forms = $("#change-pass");
    var formData = forms.serialize();
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        destroyLoader('change-btn', 'Update', 'btn btn-orio')
        return false;
    }
    if (forms.parsley().isValid()) {
        $.ajax({
            url: ajaxUrl,
            method: 'POST',
            data: formData,
            success: function (result) {
                if (result.status == 1) {
                    swal.fire({
                        icon: "success",
                        title: "Success",
                        text: result.message,
                        confirmButtonClass: "btn-success",
                        type: "success",
                    });
                    $('#change-pass')[0].reset();
                }
                else {
                    notify('danger', result.message)
                }
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
            }
        });
        destroyLoader('change-btn', 'Update', 'btn btn-orio')
    }
});

