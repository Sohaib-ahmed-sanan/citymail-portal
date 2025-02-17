
$('#register_button').click(function (event) {
    event.preventDefault();
    var forms = $('#register');
    $("#register_button").addClass('d-none')
    $("#register_loader").removeClass('d-none')
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        $("#register_button").removeClass('d-none')
        $("#register_loader").addClass('d-none')
        return false;
    }
    event.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#register")[0]);
        if ($('#terms_check').is(':checked')) {
            $.ajax({
                url: storeUrl,
                method: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                success: function (result) {
                    if (result.status == 1) {
                        notify("success", "Success", result.message);
                        window.setTimeout(function () {
                            window.location.href = BASEURL + '/login';
                        }, 1000);
                    } else {
                        $("#register_button").removeClass('d-none')
                        $("#register_loader").addClass('d-none')
                        notify("danger", "Error", result.message);
                    }
                },
                error: function (xhr, status, error) {
                    $("#register_button").removeClass('d-none')
                    $("#register_loader").addClass('d-none')
                    notify("warning", "Oh snap!", "Something went wrong");
                }
            });
        } else {
            $("#register_button").removeClass('d-none')
            $("#register_loader").addClass('d-none')
            $('#conditions_err').removeClass('d-none').text('Terms & Condition required')
        }
    }

});

$('#signin').click(function (event) {
    event.preventDefault();
    var forms = $('#login');
    $("#signin").addClass('d-none')
    $("#register_loader").removeClass('d-none')
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        $("#signin").removeClass('d-none')
        $("#register_loader").addClass('d-none')
        return false;
    }
    event.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#login")[0]);
        $.ajax({
            url: loginUrl,
            method: 'POST',
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                if (result.status == 1) {
                    notify("success", "Success", result.message);
                    window.setTimeout(function () {
                        window.location.href = BASEURL ;
                    }, 1000);
                } else {
                    $("#signin").removeClass('d-none')
                    $("#register_loader").addClass('d-none')
                    notify("danger", "Error", result.message);
                }
            },
            error: function (xhr, status, error) {
                $("#signin").removeClass('d-none')
                $("#register_loader").addClass('d-none')
                notify("warning", "Oh snap!", "Something went wrong");
            }
        });
    }
});
    
$(document).on("click", ".show_pass", function () {
    // togel password 
    var passwordField = $(this).prev(".passwordField");
    var icon = $(this).find("i");

    if (passwordField.attr("type") === "password") {
        passwordField.attr("type", "text");
        icon.removeClass("bi-eye").addClass("bi-eye-slash");
    } else {
        passwordField.attr("type", "password");
        icon.removeClass("bi-eye-slash").addClass("bi-eye");
    }
});