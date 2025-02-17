$('#search-btn').click(function (e) {
    var form_id = $(this).closest('.order-filter-wrapper').find('form').attr('id');
    var title = $(this).html()
    var forms = $("#"+form_id);
    forms.parsley().validate();
    initLoader('search-btn','btn-orio');
    if (!forms.parsley().isValid()) {
        destroyLoader('search-btn', title, 'btn btn-orio')
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        $('#output').html()
        var cn_numbers = $('#cn_no').val().split(',');
        var sanitised = $.unique(cn_numbers);
        var rearrange_sanitise = sanitised.join(',');
        $('#cn_no').val(rearrange_sanitise);
        $.ajax({
            url: route,
            type: "POST",
            data: {
                cn_no : rearrange_sanitise
            },
            success: function (result) {
                if (result.status == 1) {
                    notify("success", "Success", "Following are the tracking details.");
                    $('#output').html(result.payload)
                    $("#cn_no").val('');
                    $("#cn_no").empty();
                    $(".label-info").remove();
                    destroyLoader('search-btn', title, 'btn btn-orio')
                } else {
                    notify("danger", result.message, result.payload);
                    destroyLoader('search-btn', title, 'btn btn-orio')
                }
            },
            error: function (xhr, err) {
                notify("danger", "Oh snap!", "Something went wrong request error");
                destroyLoader('search-btn', title, 'btn btn-orio')
            }
        });


    }
});

$('#cn_no').tagsinput({
    allowDuplicates: false
});