$('#forgot-btn').click(function (event) {
    event.preventDefault();
    var forms = $('#forgot');
    $("#forgot-btn").addClass('d-none')
    $("#register_loader").removeClass('d-none')
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        $("#forgot-btn").removeClass('d-none')
        $("#register_loader").addClass('d-none')
        return false;
    }
    event.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#forgot")[0]);
        $.ajax({
            url: route,
            method: 'POST',
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                if (result.status == 1) {
                    notify("success", "Success", result.payload);
                    window.setTimeout(function () {
                        window.location.href = BASEURL + '/login';
                    }, 2000);
                } else {
                    $("#forgot-btn").removeClass('d-none')
                    $("#register_loader").addClass('d-none')
                    notify("danger", "Error", result.payload);
                }
            },
            error: function (xhr, status, error) {
                $("#forgot-btn").removeClass('d-none')
                $("#register_loader").addClass('d-none')
                notify("warning", "Oh snap!", "Something went wrong");
            }
        });
    }

});
$('#reset-btn').click(function (event) {
    event.preventDefault();
    var forms = $('#reset');
    $("#reset-btn").addClass('d-none')
    $("#register_loader").removeClass('d-none')
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        $("#reset-btn").removeClass('d-none')
        $("#register_loader").addClass('d-none')
        return false;
    }
    event.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#reset")[0]);
        $.ajax({
            url: route,
            method: 'POST',
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                if (result.status == 1) {
                    notify("success", "Success", result.payload);
                    window.setTimeout(function () {
                        window.location.href = BASEURL + '/';
                    }, 2000);
                } else {
                    $("#reset-btn").removeClass('d-none')
                    $("#register_loader").addClass('d-none')
                    notify("danger", "Error", result.payload);
                }
            },
            error: function (xhr, status, error) {
                $("#reset-btn").removeClass('d-none')
                $("#register_loader").addClass('d-none')
                notify("warning", "Oh snap!", "Something went wrong");
            }
        });
    }

});