
/* ------------------------------- upload file ------------------------------ */
$('#file').on('change', function () {
    var fileName = $(this).val();
    var label = fileName.split('\\').pop();
    $('#outputFile').text(label);
    var extension = fileName.split('.').pop().toLowerCase();
    if (extension !== 'xls') {
        $('#outputFile').text('Choose file...')
        notify("danger", "Error", "Please select a .xls file.");
        $(this).val(''); // Clear the file input
    }
    return false
});
$("#uploadorder").click(function (e) {
    var forms = $("#excel_upload");
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        return false;
    }

    e.preventDefault();
    if (forms.parsley().isValid()) {
        initLoader('uploadorder', 'btn-orio');
        var formdata = new FormData($("#excel_upload")[0]);
        $.ajax({
            url: BASEURL + "upload-bulk-file",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                if (result.status == 1) {
                    $('#sub_account').attr('readonly', true);
                    if (result.error_html != '') {
                        $('#sub_account').attr('readonly', 'true')
                        $('#error_order_detail').empty();
                        $('#error_order_detail').html(result.error_html)
                        var count = $('#error_order_detail').find('tr').length
                        $('#error_count').removeClass('d-none').text(count);
                        notify("success", "Success", result.message + " Some shipments are not valid");
                        initSelect2();
                    } else {
                        notify("success", "Success", result.message);
                    }
                    if (result.success_html != '') {
                        $('#order_detail').empty();
                        $('#order_detail').html(result.success_html)
                    }
                }
                if (result.status == 0) {
                    $('#sub_account').attr('readonly', true);
                    if (result.error_html != '') {
                        $('#sub_account').attr('readonly', 'true')
                        $('#error_order_detail').empty();
                        $('#error_order_detail').html(result.error_html)
                        var count = $('#error_order_detail').find('tr').length
                        $('#error_count').removeClass('d-none').text(count);
                        notify("danger", "Error", result.message);
                        initSelect2();
                    }else{
                        notify("danger", "Error", result.message);
                    }
                }
                destroyLoader('uploadorder', "Upload", 'btn btn-orio')
            },
            error: function (xhr, err) {
                notify("warning", "Oh snap!", "Something went wrong");
                destroyLoader('uploadorder', "Upload", 'btn btn-orio')
            }
        });
    }
});


function switchTabs(tabToHide, tabToShow) {
    $(tabToHide).removeClass('active show');
    $(tabToShow).addClass('active show');
    $('#home1-tab').removeClass('active');
    $('#profile1-tab').addClass('active');
}

$(document).on('click', '.re-upload-check', function () {
    check_shipment();
});

$('#push_orders').click(function () {
    initLoader('push_orders', 'btn-orio');
    var detail = check_shipment();
    var sub_account = $('#sub_account').val();
    $.ajax({
        url: BASEURL + "push-orders",
        type: "POST",
        data: {
            data: detail,
            sub_account: sub_account,
        },
        success: function (result) {
            $('#push_modal').modal('show');
           if (result.success_html != '') {
                $('#display-success').html('');
                $('#display-success').html(result.success_html);
                $('#display-success tr').each(function() {
                    var shipment_ref = $(this).find('td:eq(2)').text().trim();
                    $('#error_order_detail tr').each(function() {
                        var input = $(this).find('input[name="shipment_ref"]');
                        if (input.val() === shipment_ref) {
                            $(this).remove();
                        }
                    });
                });
            }
            if (result.error_html != '') {
                $('#display-error').html('');
                $('#display-error').html(result.error_html);
            }
            destroyLoader('push_orders', "Push Orders", 'btn btn-orio')
        },
        error: function (xhr, err) {
            notify("warning", "Oh snap!", "Something went wrong");
            destroyLoader('push_orders', "Push Orders", 'btn btn-orio')
        }
    });
});

let check_shipment = (elem) => {
    let detail = [];
    $("#error_order_detail .re-upload-check:checked").each(function () {
        var row = $(this).closest("tr");
        // Getting text values of each td
        var msg = row.find("td:eq(1)").text().trim();
        var name = row.find("td:eq(2)").text().trim();
        var email = row.find("td:eq(3)").text().trim();
        var address = row.find("td:eq(4)").text().trim();
        var phone = row.find("td:eq(5)").text().trim();
        var order_amount = row.find("td:eq(8)").text().trim();
        var weight = row.find("td:eq(10)").text().trim();
        var comments = row.find("td:eq(11)").text().trim();
        var insurance = row.find("td:eq(12)").text().trim();
        var fragile = row.find("td:eq(13)").text().trim();
        var product_detail = row.find("td:eq(14)").text().trim();
        var payment_method_id = row.find("td:eq(15)").text().trim();
        var currency_code = row.find("td:eq(18)").text().trim();
        var pickup_location = row.find("td:eq(19)").text().trim();
        if (msg === 'destination city not found') {
            var destination = row.find("select[name='destination_city']").val();
            if (destination === null || destination === '') {
                notify("danger", 'Please select destination');
                $(this).prop('checked', false);
                return false
            }
        } else {
            var destination = row.find("td:eq(6)").text().trim();
        }
        if (msg === 'service not found') {
            var service = row.find("select[name='service']").val();
            if (service === null || service === '') {
                notify("danger", 'Please select service');
                $(this).prop('checked', false);
                return false
            }
        } else {
            var service = row.find("td:eq(17)").text().trim();
        }

        var pickup_location = row.find("select[name='pickup_location']").val();
        if (pickup_location === null || pickup_location === '') {
            notify("danger", 'Please select pickup');
            $(this).prop('checked', false);
            return false
        }


        var shipment_ref = row.find("input[name='shipment_ref']").val();
        if (shipment_ref === null || shipment_ref === '') {
            $(this).prop('checked', false);
            notify("danger", 'Please enter shipment referance');
            return false
        }

        if (msg === 'weight or peices not found') {
            var weight = row.find("input[name='weight']").val();
            var peices = row.find("input[name='peices']").val();
            if (weight === null && peices === '') {
                $(this).prop('checked', false);
                notify("danger", 'Please enter weight and peices');
                return false
            }
        } else {
            var peices = row.find("td:eq(9)").text().trim();
            var weight = row.find("td:eq(10)").text().trim();
        }

        detail.push({
            'name': name,
            'email': email,
            'address': address,
            'phone': phone,
            'destination': destination,
            'shipment_ref': shipment_ref,
            'order_amount': order_amount,
            'weight': weight,
            'peices': peices,
            'comments': comments,
            'insurance': insurance,
            'fragile': fragile,
            'product_detail': product_detail,
            'payment_method_id': payment_method_id,
            'pickup_location': pickup_location,
            'service': service,
            'currency_code': currency_code,
        });
    });
    if (detail.length > 0) {
        $('#push_orders').removeClass('d-none');
        return detail;
    } else {
        $('#push_orders').addClass('d-none');
    }
};

$(document).on('change', '#is-sub-account', function () {
    var check = $(this).val();
    if (check == 1) {
        $('#sub_account').removeClass('d-none')
        $('#sub-acc-select').attr('required')
    } else {
        $('#sub_account').addClass('d-none')
        $('#sub_account').val()
        $('#sub_account').empty()
        $('#sub-acc-select').removeAttr('required')
    }
});