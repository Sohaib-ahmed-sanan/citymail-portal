/* ------------------------------- add form ------------------------------ */
$("#add-btn").click(function (e) {
    var form_id = $(this).closest('.modal-content').find('form').attr('id');
    var title = $(this).html()
    var forms = $("#" + form_id);
    forms.parsley().validate();
    initLoader('add-btn', 'btn-orio');
    if (!forms.parsley().isValid()) {
        destroyLoader('add-btn', title, 'btn btn-orio')
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#" + form_id)[0]);
        var route = $('#add_url').val();
        $.ajax({
            url: route,
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 8000000,
            success: function (result) {
                if (result.status == 1) {
                    swal.fire({
                        icon: "success",
                        title: result.message,
                        text: result.payload,
                        confirmButtonClass: "btn-success",
                        type: "success",
                    });
                    $("#add_modal").modal("hide");
                    $("#" + form_id)[0].reset();
                    $("#example").DataTable().ajax.reload();
                    $("#" + form_id)[0].reset();
                    destroyLoader('add-btn', title, 'btn btn-orio')
                }
                if (result.status == 0) {
                    notify("danger", result.message, result.payload);
                    destroyLoader('add-btn', title, 'btn btn-orio')
                }
            },
            error: function (xhr, err) {
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
                destroyLoader('add-btn', title, 'btn btn-orio')
            }
        });

    }
});
/* ------------------------------- for displaying edit modal ------------------------------ */
$(document).on("click", ".edit-item", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    var route = $(this).data("route");
    $.ajax({
        url: route,
        method: "POST",
        data: {
            id: id,
            type: "edit_modal",
        },
        success: function (response) {
            $("#edit_form_append").html(response);
            initSelect2();
            $("#edit_modal").modal("show");
        },
    });
});

// ------------------------ For updating the data ----------------------
$('#updateBtn').click(function (e) {
    var form_id = $(this).closest('.modal-content').find('form').attr('id');
    var title = $(this).html()
    var forms = $("#" + form_id);
    initLoader('updateBtn', title, 'btn btn-orio');
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        destroyLoader('updateBtn', title, 'btn btn-orio')
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#" + form_id)[0]);
        var route = $('.url').val();
        $.ajax({
            url: route,
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                if (result.status == 1) {
                    destroyLoader('updateBtn', title, 'btn btn-orio')
                    swal.fire({
                        icon: "success",
                        title: result.message,
                        text: result.payload,
                        confirmButtonClass: "btn-success",
                        type: "success",
                    });
                    $("#example").DataTable().ajax.reload();
                    $("#edit_modal").modal("hide");
                    $("#" + form_id)[0].reset();
                } else {
                    notify("danger", result.message, result.payload);
                }
            },
            error: function (xhr, err) {
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
                destroyLoader('updateBtn', title, 'btn btn-orio')
            }
        });
    }
});

$(document).on('change', '#is-sub-account', function () {
    var check = $(this).val();
    if (check == 1) {
        var customer_acno = $('#select_customer_id').val(); 
        if ((customer_acno == "" || customer_acno == null) && sessionType == 'superAdmin') {
            $('#select_customer_id').parsley().validate();
        }
        $('#sub_account_id').removeClass('d-none')
        $('#sub-acc-select').attr('required')
    } else {
        $('#sub_account_id').addClass('d-none')
        $('#sub-acc-select').val('').trigger('change')
        $('#sub-acc-select').removeAttr('required')
    }
});

$(document).on('change', '#select_customer_id', function () {
    var customer_acno = $(this).val();
    get_sub_account(customer_acno)
});

$(document).on('change' , '.select-city',function(){
    var city_id = $(this).val();
    $.ajax({
        url: BASEURL+'get-stations',
        method: "POST",
        data: {
            city_id: city_id,
        },
        success: function (response) {
            $(".select-station").html(response);
            initSelect2();
        },
    });
});


let get_sub_account = (customer_acno) => {
    $.ajax({
        url: BASEURL + 'get-sub-accounts',
        method: "POST",
        data: {
            customer_acno: customer_acno,
        },
        success: function (response) {
            $("#sub-acc-select").html(response.payload);
        },
    });
}