$('#submit-btn').click(function (e) {
    e.preventDefault();
    var title = "Update Profile";
    var formdata = new FormData($("#profile_form")[0]);
    var forms = $("#profile_form");
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        return false;
    }
    e.preventDefault();
    initLoader('submit-btn', 'btn-orio');
    if (forms.parsley().isValid()) {
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
                    swal.fire({
                        icon: "success",
                        title: "Success",
                        text: result.payload,
                        confirmButtonClass: "btn-success",
                        type: "success",
                    });
                    window.setTimeout(function () {
                        window.location.href = returnUrl;
                    }, 2000);
                } else {
                    destroyLoader('submit-btn', title, 'btn btn-orio')
                    notify("danger", result.message, result.payload);
                }
            },
            error: function (xhr, status) {
                destroyLoader('submit-btn', title, 'btn btn-orio')
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
            }
        });
    }
});

// for company_settings
$('#update_setting').click(function (e) {
    e.preventDefault();
    var forms = $("#company_settings_form");
    var title = "Update Settings";
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        initLoader('update_setting', 'btn-orio');
        var formData = new FormData($("#company_settings_form")[0]);
        $.ajax({
            url: storeUrl,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                console.log(result.status);
                if (result.status == '1') {
                    notify("success", "Success", result.message);
                    window.location.reload();
                } else {
                    destroyLoader('update_setting', title, 'btn btn-orio')
                    notify("danger", "Error", result.message);
                }
            },
            error: function (xhr, status, error) {
                destroyLoader('update_setting', title, 'btn btn-orio')
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
            }
        });
    }

});

$('#currency_id').change(function(){
    var currency_code = $(this).val();

    var html = '';
    $('#currency_id option').each(function(){
        if(currency_code != $(this).val() && $(this).val() != '')
        {
            var remaing_currency = $(this).val();
            html += `<div class="col-md-3">
                        <label for="">Ammount In ${remaing_currency}<span
                                class="req">*</span></label>
                        <input type="text" name="${remaing_currency.toLowerCase()}" class="form-control float"
                            required placeholder="Ammount In ${remaing_currency}" id="${remaing_currency}">
                    </div>`
        }
    });

    $('#rates-div').html(html);
});

