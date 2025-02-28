/* ------------------------------- arrivals functins on page reload ------------------------------ */
var html = "";
var form = "";
$('#shipment_no').on('input', function () {
    var val = $(this).val();
    if (val.length >= 9) {
        var shipment_no = $('#shipment_no').val();
        is_exist = false;
        $('#arrival_list .cn_number').each(function () {
            if ($(this).text() === shipment_no) {
                is_exist = true;
            }
        });
        if (!is_exist) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: BASEURL + 'fetch-pickup-cn',
                type: "POST",
                data: {
                    shipment_no: shipment_no,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (result) {
                    if (result.status == 1) {
                        $("#def_msg").remove();
                        $("#arrival_list").append(result.payload);
                        $("#save-btn").removeClass('d-none');
                        $("#shipment_no").val('');
                    } else {
                        notify("danger", result.message, result.payload);
                    }
                },
                error: function (xhr, err) {
                    var errorMessage = xhr.responseJSON.message;
                    notify("warning", errorMessage);
                }

            })
        } else {
            $('#shipment_no').val('');
            notify("warning", "consignment " + shipment_no + " number already exist !");
        }
    }
});

$(document).on('click', '#save-btn', function () {
    var title = $(this).html();
    var rider_id = $('#riders_id').val();
    var route_id = $('#route_id').val();
    var station_id = $('#station_id').val();

    if (rider_id !== '' && station_id !== '' && route_id !== '') {
        var shipments = [];
        $('#arrival_list tr').each(function () {
            var shipment = {
                cn_number: $(this).find('.cn_number').text(),
                flag: $(this).find('.flag').text(),
                arrival_peices: $(this).find('input[name="arrival_peices[]"]').val(),
                arrival_weight: $(this).find('input[name="arrival_weight[]"]').val(),
                origin_city: $(this).find('.origin_city').text(),
                origin_country: $(this).find('.origin_country').text(),
                destination_country: $(this).find('.destination_country').text(),
                destination_city: $(this).find('.destination_city').text(),
                cod_amt: $(this).find('.cod_amt').text(),
                service_id: $(this).find('.service_id').text(),
                customer_acno: $(this).find('.customer_acno').text()
            };

            shipments.push(shipment);
        });

        confirm_sweet("Are you sure you want to create pickup ?").then(action => {
            if (action) {
                initLoader('save-btn', title, 'btn-orio');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: BASEURL + 'insert-pickups',
                    type: "POST",
                    data: {
                        shipments: shipments,
                        rider_id: rider_id,
                        route_id: route_id,
                        station_id: station_id,
                    },
                    success: function (response) {
                        destroyLoader('save-btn', title, 'btn-orio');
                        if (response.status === 1) {
                            swal.fire({
                                icon: "success",
                                title: "Pickup sheet no # " + response.sheet_no,
                                text: response.message,
                                confirmButtonClass: "btn-success",
                                type: "success",
                            });
                            setTimeout(() => {
                                window.location.href = BASEURL + 'pickups';
                            }, 3000);
                        } else {
                            notify("danger", "Error", response.payload);
                        }
                    },
                    error: function (xhr) {
                        destroyLoader('save-btn', title, 'btn-orio');
                        var errorMessage = xhr.responseJSON?.message || "Something went wrong!";
                        notify("danger", "Error", errorMessage);
                    }
                });
            }
        });

    } else {
        destroyLoader('save-btn', title, 'btn-orio');
        notify("danger", "Error", "Please select all fields");
    }
});



// to remove the cn 
$(document).on('click', '.rem_row', function () {
    var btn_id = $(this).data('id');
    $('#' + btn_id).remove();
    $(this).closest('tr').remove();

    if ($('#arrival_list tr').length === 0) {
        $("#search-btn").show().removeAttr("disabled", true).text("Search");
        $("#save-btn").addClass('d-none');
    }
});

// for edit 
$('#update_sheet').click(function (e) {
    var forms = $("#edit_sheet_form");
    var title = $(this).html()
    initLoader('update_sheet', title, 'btn-orio');
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        destroyLoader('update_sheet', title, 'btn-orio')
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#edit_sheet_form")[0]);
        formdata.append('_token', $('meta[name="csrf-token"]').attr('content'))
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: storeUrl,
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                if (result.status == 1) {
                    notify("success", "Success", result.message);
                    window.setTimeout(function () {
                        window.location.href = BASEURL + 'pickups';
                        $("#example").DataTable().ajax.reload();
                    }, 1000);
                    destroyLoader('update_sheet', title, 'btn-orio')
                } else {
                    if(result.payload.length > 0){
                       let message = result.payload.map(data => 
                            `${data.consignment_no} - ${data.message}`
                        ).join("\n");
                        notify("danger",result.message,message);
                    }else{
                        notify("danger", "Error", result.message);
                    }
                    destroyLoader('update_sheet', title, 'btn-orio')
                }
            },
            error: function (xhr, err) {
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
                destroyLoader('update_sheet', title, 'btn-orio')
            }
        });

    }
});


// $('form').on('keydown', function (event) {
//     if (event.key === 'Enter') {
//         get_cn_data();
//     }
// });

// $('#search-btn').click(function () {
//     get_cn_data();
// });

let get_cn_data = () => {
    var weight = $("#weight-first").val();
    var peice = $("#peices-first").val();
    var shipment_no = $("#shipment_no").val();
    if (shipment_no.length > 8) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: BASEURL + 'fetch-pickup-cn',
            type: "POST",
            data: {
                shipment_no: shipment_no,
                weight: weight,
                peice: peice,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                if (result.status == 1) {
                    $("#def_msg").remove();
                    $("#arrival_list").append(result.payload);
                    $("#insert_arrival").append(result.form);
                    $("#save-btn").removeClass('d-none');
                    $("#search-btn").addClass('d-none');

                    $(".wp-col").addClass('d-none');
                    $("#weight-first").addClass('d-none').val('');
                    $("#peices-first").addClass('d-none').val('');
                    $("#shipment_no").val('');
                }
            },
            error: function (xhr, err) {

            }
        })
    } else {
        notify("danger", "Error", "Please enter valid consignment no");
    }
}
