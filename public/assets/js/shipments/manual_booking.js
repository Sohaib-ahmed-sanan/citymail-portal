
$("#addCustomer").click(function (e) {
    var forms = $("#customer_form");
    forms.parsley().validate();
    var title = $(this).html()
    initLoader('addCustomer', title, 'btn-orio');
    if (!forms.parsley().isValid()) {
        destroyLoader('addCustomer', title, 'btn-orio')
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#customer_form")[0]);
        $.ajax({
            url: storeUrl,
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                if (result.status == 1) {
                    info_sweet_alert("", "Success", result.payload)
                    window.setTimeout(function () {
                        window.location.href = BASEURL + 'shipments';
                        $("#example").DataTable().ajax.reload();
                    }, 2000);
                    $("#customer_form")[0].reset();
                    destroyLoader('addCustomer', title, 'btn-orio')
                } else {
                    notify("danger", result.message, result.payload);
                }
            },
            error: function (xhr, err) {
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
                destroyLoader('addCustomer', title, 'btn-orio')
            }
        });
    }
});
// for add pages
$(document).on('change', '#customer_acno', function () {
    var customer_acno = $(this).val();
    $("#pickup_locations").html('')
    if (sessionType == '6') {
        $.ajax({
            url: BASEURL + 'get-sub-accounts',
            type: "POST",
            data: {
                customer_acno: customer_acno
            },
            success: function (result) {
                if (result['status'] == 1) {
                    $("#sub_account").html(result['payload'])
                }
            }
        });
    }
    get_service(customer_acno)
    get_pickup(customer_acno);
})
$(document).on('change', '#sub_account', function () {
    $("#pickup_locations").html();
    var customer_id = $(this).val();
    get_pickup(customer_id);
})
// when it is on edit
$(document).ready(function () {
    if (sessionType == '6' && pageType == 'addEdit') {
        if ($('#customer_acno').val() != '') {
            var customer_acno = $('#customer_acno').val();
            $.ajax({
                url: BASEURL + 'get-sub-accounts',
                type: "POST",
                data: {
                    customer_acno: customer_acno
                },
                success: function (result) {
                    if (result['status'] == 1) {
                        $("#sub_account").html(result['payload'])
                    }
                }
            });
            get_pickup(customer_acno);
            get_service(customer_acno);
        }
    }
})

// on change of the payment option
$(document).on('change', '#payment_method_id', function () {

    if ($(this).val() == 1) {

        $('#amount').removeAttr('disabled');

    } else {

        $('#amount').val(0);

        $('#amount').attr('disabled', 'true');

    }

})
// for the loadsheet work checkboxes
$(document).on('click', '.check_box', function () {
    check_all();
});

$(document).on('click', '#generate_loadSheet', function () {
    var checkedValues = [];
    $('.check_box:checked').each(function () {
        if ($(this).data('status') == '1') {
            checkedValues.push($(this).val());
        }
    });
    if (checkedValues.length > 0) {
        var text = "";
        confirm_sweet("Are you sure you want to create load sheet ?").then(action => {
            if (action) {
                $.ajax({
                    url: BASEURL + 'generate-loadsheet',
                    type: 'POST',
                    data: {
                        order_ids: checkedValues
                    },
                    success: function (result) {
                        if (result.status == 1) {
                            info_sweet_alert("", "Success", result.message)
                            $("#example").DataTable().ajax.reload();
                        } else {
                            notify("danger", "Oh snap!", result.message);
                        }
                    },
                    error: function (xhr, err) {
                        notify("warning", "Oh snap!", "Something went wrong");
                    }
                });
            }
        });
    } else {
        notify("warning", "Oh snap!", "No consignments are valid to create loadsheet");
        return false
    }
});

$(document).on('click', '#print_airway', function () {
    var checkedValues = [];
    $('.check_box:checked').each(function () {
        checkedValues.push($(this).val());
    });
    if (checkedValues.length > 0) {
        var ids = checkedValues.join(',');
        window.open(BASEURL + 'airway-pdf/' + btoa(ids), '_blank');
    } else {
        notify("danger", "Error", "Please select any one checkbox");
        return false
    }
});

$("#check_all").click(function () {
    if ($(this).prop('checked') == true) {
        $(".check_box").prop('checked', true);
    } else {
        $(".check_box").prop('checked', false);
    }
    check_all();
});

// for cn void 

$("#cancle-btn").click(function (e) {
    var forms = $("#cancle-form");
    var title = $(this).html();
    
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#cancle-form")[0]);
        confirm_sweet("Are you sure you want to void the shipments ?").then(action => {
            if (action) {
                initLoader('cancle-btn', 'btn-orio');
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
                            window.setTimeout(function () {
                                info_sweet_alert("", "Success", result.payload)
                                $("#cancle-form")[0].reset();
                            }, 1000);
                            $("#cancle-form")[0].reset();
                            $("#cn_void_modal").modal("hide");
                            destroyLoader('cancle-btn', title, 'btn btn-orio')
                            $("#example").DataTable().ajax.reload();
                        } else {
                            destroyLoader('cancle-btn', title, 'btn btn-orio')
                            notify("danger", "Error", result.payload);
                        }
                    },
                    error: function (xhr, err) {
                        notify("danger", "Oh snap!", "Something went wrong");
                        destroyLoader('cancle-btn', title, 'btn btn-orio')
                    }
                });
            }
        });
    }
});

$(document).on('change', '#is-sub-account', function () {
    var check = $(this).val();
    if (check == 1) {
        var customer_id = $('#customer_acno').val();
        if ((customer_id == "" || customer_id == null) && sessionType == 'superAdmin') {
            $('#customer_acno').parsley().validate();
        }
        $('#sub_account_id').removeClass('d-none')
        $('#sub_account').attr('required')
    } else {
        $('#sub_account_id').addClass('d-none')
        $('#sub_account').val('').trigger('change')
        $('#pickup_locations').val('').trigger('change')
        $('#sub_account').removeAttr('required')
        var customer_acno = $('#customer_acno').val();
        get_pickup(customer_acno)
    }
});

$(document).on('change', '#insurance_select', function () {
    var check = $(this).val();
    if (check == 1) {
        $('#insurance_amt').attr('required', true)
        $('#insurance_amt').parent().removeClass('d-none')
    } else {
        $('#insurance_amt').removeAttr('required', true)
        $('#insurance_amt').parent().addClass('d-none');
    }
});

//--------------- functions
let check_all = (elem) => {
    var mylabel = $('.dataTables_wrapper table').find('.check_box');
    mylabel.each(function () {
        var l = $('.dataTables_wrapper table').find('.check_box:checked').length;
        if (l > 0) {
            $('#append_btn_div').addClass('d-block').slideDown();
            $('#append_btn_div').removeClass('d-none').slideDown();
        } else {
            $('#append_btn_div').addClass('d-none').slideUp();
            $('#append_btn_div').removeClass('d-block').slideUp();
        }

        var chkArray = [];
        var checkError = 0;
        $(".check_box:checked").each(function () {
            var odid = $(this).attr('odidcn');
            if ($("#status_name_" + odid).attr('selected_status_id') == 8 || $("#status_name_" + odid).attr('selected_status_id') == 9) {
                checkError = 1;
                $("#myCheck" + odid).prop("checked", false);
            }
            chkArray.push($(this).val());
        });
    });
};

$(document).on('change', '#country_id', function () {
    var country = $(this).val();
    if (country != '436') {
        $('#service_name').val('3').trigger('change');
    } else {
        $('#service_name').val('1').trigger('change');
    }
});
