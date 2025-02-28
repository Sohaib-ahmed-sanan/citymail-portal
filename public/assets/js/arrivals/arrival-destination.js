/* ------------------------------- arrivals functins on page reload ------------------------------ */
if (page_type == 'list') {
    let datalist = (params) => {
        var {
            start,
            end,
            label,
            value_type,
            spinerType,
        } = params;
        var title = "";
        range = "";
        var start_date = start.format("YYYY-MM-DD");
        var end_date = end.format("YYYY-MM-DD");

        if (label == "Today") {
            title = "Today:";
            range = start.format("MMM DD, YYYY");
            rangejson = start.format("YYYY-MM-DD");
        } else if (label == "Yesterday") {
            title = "Yesterday:";
            range = start.format("MMM DD, YYYY");
            rangejson = start.format("YYYY-MM-DD");
        } else {
            range = start.format("MMM DD, YYYY") + " - " + end.format("MMM DD, YYYY");
            rangejson = start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD");
        }
        var aoColumns = [];
        // Push other columns
        aoColumns.push({
            data: "SNO"
        }, {
            data: "SHEET"
        }, {
            data: "DATE"
        }, {
            data: "CNCOUNT"
        }, {
            data: "ACTION"
        });
        $("#example").DataTable({
            destroy: true,
            responsive: true,
            bDeferRender: true,
            dom: '<"row"<"col-md-7 applyall"><"col-md-5 d-flex align-items-center justify-content-end" fB>><t><"table-footer-wrapper" <"row"<"col-md-6 d-flex align-items-center" il><"col-md-6 d-flex align-items-center justify-content-end" p>>>',
            buttons: [{
                    extend: "excelHtml5",
                    text: '<svg class="w-20" width="26" height="29" viewBox="0 0 26 29" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.2 14.1899C18.2 18.5899 18.2 22.9866 18.2 27.3866C18.2 27.4784 18.2 27.5702 18.2 27.662C18.1869 28.1801 17.8787 28.4522 17.3738 28.3801C13.7574 27.862 10.141 27.3407 6.52459 26.8227C4.75738 26.5702 2.98688 26.3211 1.21967 26.0752C0.439344 25.9637 0 25.4522 0 24.626C0 19.3014 0 13.9768 0 8.65549C0 7.02926 0 5.40303 0 3.78008C0 2.87844 0.429508 2.41614 1.31148 2.29483C3.64262 1.97024 5.97377 1.63254 8.30492 1.29811C10.8164 0.940733 13.3279 0.583356 15.8393 0.2227C16.3016 0.157126 16.7639 0.0948311 17.2262 0.0227C17.9344 -0.0854968 18.2 0.144011 18.2 0.868602C18.2 5.30795 18.2 9.74729 18.2 14.1899ZM9.10819 11.9506C9.01639 11.8293 8.95082 11.7407 8.88852 11.6522C8.31803 10.8391 7.74426 10.026 7.18033 9.20631C7.06885 9.04565 6.95082 8.98664 6.75738 8.98664C5.91475 8.99647 5.07213 8.98991 4.22951 8.99319C4.14426 8.99319 4.05574 9.00303 3.93443 9.01286C4.01311 9.13418 4.07213 9.22926 4.13443 9.31778C5.21639 10.8653 6.29508 12.4129 7.38688 13.9538C7.51147 14.1309 7.51475 14.2489 7.38688 14.4293C6.2918 15.9801 5.20656 17.5342 4.11803 19.0916C4.05902 19.1768 4.00656 19.2653 3.92459 19.3899C4.9541 19.3899 5.91803 19.3965 6.88197 19.3801C6.9836 19.3768 7.10819 19.2653 7.17705 19.1702C7.76065 18.3538 8.33442 17.5276 8.91147 16.7047C8.97049 16.6194 9.03606 16.5342 9.11475 16.4293C9.77049 17.367 10.4033 18.262 11.0229 19.1637C11.141 19.3342 11.2688 19.3965 11.4721 19.3932C12.3049 19.3834 13.1377 19.3899 13.9705 19.3866C14.0623 19.3866 14.1574 19.3735 14.2852 19.367C14.2033 19.2424 14.1508 19.1571 14.0918 19.0752C13.0033 17.5211 11.918 15.9637 10.8229 14.4129C10.7049 14.2424 10.7016 14.1342 10.8229 13.9637C11.918 12.4161 13.0033 10.8588 14.0918 9.30139C14.1541 9.21286 14.2098 9.12434 14.3016 8.98991C13.318 8.98991 12.3967 8.99647 11.4754 8.98664C11.2721 8.98336 11.1443 9.04237 11.0262 9.21614C10.3934 10.1178 9.76065 11.0129 9.10819 11.9506Z" fill="#525252"/><path d="M19.5212 25.8918C19.5212 18.0754 19.5212 10.2984 19.5212 2.48199C19.6327 2.48199 19.7311 2.48199 19.8294 2.48199C21.413 2.48199 22.9999 2.48199 24.5835 2.48199C25.4786 2.48199 25.9999 3.00331 25.9999 3.90495C26.0032 10.7607 26.0032 17.6197 25.9999 24.4754C25.9999 25.3705 25.4721 25.8918 24.577 25.8918C22.9934 25.8918 21.4065 25.8918 19.8229 25.8918C19.7344 25.8918 19.6426 25.8918 19.5212 25.8918Z" fill="#525252"/></svg>',
                    exportOptions: {
                        columns: ":gt(0)",
                    },
                },
                {
                    extend: "csvHtml5",
                    text: '<svg class="w-20" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M28 15.3674C28 18.8685 28 22.3654 28 25.8664C27.9794 25.9364 27.9588 26.0065 27.9423 26.0724C27.7199 26.9373 27.1968 27.5346 26.3607 27.8517C26.2001 27.9135 26.0312 27.9506 25.8664 27.9959C17.9541 27.9959 10.0418 27.9959 2.13357 27.9959C2.10062 27.9835 2.06767 27.9629 2.03472 27.9547C0.745513 27.6664 0 26.7396 0 25.4216C0 22.213 0 19.0044 0.00411886 15.7958C0.00411886 15.5528 0.028832 15.3015 0.0906149 15.0668C0.383054 13.9382 1.35099 13.2339 2.59488 13.2339C10.1942 13.2339 17.7935 13.2339 25.3969 13.2339C25.471 13.2339 25.541 13.2298 25.6152 13.238C26.5749 13.2957 27.2957 13.7446 27.7364 14.6013C27.8558 14.8361 27.9135 15.1121 28 15.3674ZM5.02913 20.6231C5.01265 20.6231 4.99618 20.6231 4.9797 20.6231C4.9797 21.208 4.96322 21.7887 4.98382 22.3736C5.02501 23.6793 6.14122 24.7296 7.45925 24.7173C8.76081 24.709 9.85643 23.6464 9.8935 22.3571C9.90997 21.8464 9.5887 21.4675 9.12327 21.4386C8.65784 21.4098 8.2995 21.7558 8.25831 22.2665C8.21712 22.7567 7.85878 23.0985 7.40159 23.0779C6.95675 23.0574 6.61901 22.7031 6.61901 22.2253C6.61489 21.1586 6.61489 20.0918 6.61901 19.025C6.61901 18.5307 6.96087 18.1683 7.41394 18.1559C7.87114 18.1436 8.21712 18.4813 8.25831 18.9797C8.2995 19.4698 8.65372 19.8117 9.11092 19.7952C9.57635 19.7746 9.90997 19.3957 9.89762 18.8932C9.86878 17.6699 8.87202 16.6237 7.64048 16.5248C6.40071 16.426 5.21036 17.2868 5.04972 18.5019C4.95087 19.1939 5.02913 19.9147 5.02913 20.6231ZM13.8929 24.7173C15.3345 24.7131 16.4342 23.634 16.459 22.3118C16.4837 20.9567 15.4334 19.8529 14.07 19.7952C13.6169 19.7787 13.3204 19.5646 13.2092 19.1774C13.1227 18.8602 13.2462 18.5431 13.5346 18.3495C13.8764 18.1188 14.2554 18.1394 14.5931 18.4072C14.9885 18.7243 15.4663 18.7078 15.7711 18.3619C16.08 18.0118 16.0388 17.5134 15.6681 17.1674C14.8114 16.3683 13.5057 16.2942 12.5502 16.9903C11.5987 17.6864 11.261 18.9591 11.7758 20.0135C12.2165 20.9197 12.9662 21.3851 13.9712 21.4345C14.4036 21.4551 14.7126 21.6981 14.8032 22.0935C14.8773 22.4231 14.7126 22.7649 14.3831 22.9297C14.0329 23.1068 13.7076 23.0821 13.3945 22.8185C13.0156 22.4972 12.5213 22.5301 12.2207 22.8802C11.9241 23.2262 11.9612 23.7164 12.3236 24.0541C12.7973 24.499 13.3657 24.7049 13.8929 24.7173ZM20.5943 20.376C20.5737 20.376 20.549 20.3719 20.5284 20.3719C20.4501 20.0547 20.3678 19.7376 20.2895 19.4204C20.1041 18.6708 19.9188 17.9211 19.7293 17.1715C19.6305 16.7885 19.338 16.5413 18.9797 16.5166C18.6461 16.4919 18.3042 16.6731 18.193 16.9903C18.1271 17.1674 18.1024 17.3898 18.1477 17.571C18.6708 19.7252 19.2104 21.8794 19.7499 24.0335C19.857 24.4619 20.1659 24.7173 20.5572 24.7214C20.9609 24.7255 21.2698 24.4701 21.381 24.0212C21.9164 21.8876 22.4478 19.7499 22.9791 17.6163C23.1109 17.0932 22.8555 16.6525 22.3778 16.5372C21.9329 16.4342 21.5169 16.7184 21.3892 17.2168C21.2945 17.5957 21.2039 17.9747 21.1091 18.3536C20.9362 19.0291 20.7673 19.7005 20.5943 20.376Z" fill="#525252"></path><path d="M5.46986 0C9.13564 0 12.7973 0 16.4631 0C16.4631 1.85761 16.4631 3.71933 16.4631 5.57693C16.4631 7.15858 17.501 8.20065 19.0786 8.20065C20.8373 8.20065 22.5961 8.20065 24.3548 8.20065C24.4537 8.20065 24.5484 8.20065 24.6473 8.20065C24.6473 9.34569 24.6473 10.4619 24.6473 11.5781C17.5422 11.5781 10.4537 11.5781 3.35276 11.5781C3.34864 11.5328 3.33629 11.4999 3.33629 11.4628C3.33629 8.42718 3.32805 5.39159 3.34453 2.35599C3.34864 1.60635 3.67403 0.959694 4.29186 0.531333C4.64197 0.296558 5.07445 0.177111 5.46986 0Z" fill="#525252"></path><path d="M18.1107 0.57251C20.1001 2.56192 22.0937 4.55545 24.0831 6.54485C24.0707 6.54897 24.013 6.56133 23.9595 6.56133C22.3037 6.56133 20.6438 6.56545 18.988 6.56133C18.4649 6.56133 18.1066 6.2277 18.1066 5.7252C18.1025 4.03235 18.1025 2.3395 18.1066 0.646649C18.1025 0.613698 18.1107 0.580747 18.1107 0.57251Z" fill="#525252" /></svg>',
                    exportOptions: {
                        columns: ":gt(0)",
                    },
                },
                {
                    extend: "colvis",
                    text: '<svg class="w-20" width="28" height="21" viewBox="0 0 28 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M28 19.5991C27.9531 19.7071 27.9129 19.815 27.8627 19.9196C27.5746 20.5066 27.0922 20.7865 26.4556 20.7899C25.0352 20.7967 23.6114 20.8034 22.191 20.7899C21.2128 20.7798 20.6265 20.1456 20.6265 19.1302C20.6265 14.276 20.6265 9.42177 20.6265 4.56753C20.6265 3.60276 20.6231 2.64136 20.6265 1.67658C20.6298 0.630848 21.2329 0.0169007 22.2714 0.0135273C23.531 0.010154 24.7906 0.040514 26.0469 0.00340731C26.9883 -0.0269527 27.6851 0.253034 28 1.20769C28 7.33704 28 13.4698 28 19.5991Z" fill="#525252"/><path d="M0 10.3899C0 7.47196 0 4.55402 0 1.63608C0 0.843348 0.40201 0.259761 1.08878 0.0809741C1.26968 0.0337473 1.46734 0.020254 1.65494 0.0168806C3.00502 0.010134 4.35511 0.010134 5.70184 0.0135073C6.77387 0.0168806 7.37353 0.620708 7.37353 1.70692C7.37353 7.50569 7.37353 13.3045 7.37353 19.1066C7.37353 20.1894 6.77387 20.7966 5.69849 20.7966C4.34841 20.8 3.00167 20.8 1.65159 20.7966C0.596315 20.7933 0 20.1861 0 19.1133C0 16.2055 0 13.2977 0 10.3899Z" fill="#525252"/><path d="M10.3216 10.3967C10.3216 7.48884 10.3216 4.57765 10.3216 1.66983C10.3216 0.843365 10.7069 0.269897 11.397 0.0809905C11.5779 0.0303904 11.7756 0.016897 11.9632 0.0135237C13.32 0.00677702 14.6801 0.00677702 16.0369 0.0101504C17.0855 0.0135237 17.6784 0.613978 17.6818 1.66646C17.6818 7.49221 17.6818 13.3213 17.6818 19.1471C17.6818 20.1861 17.0821 20.7865 16.0536 20.7899C14.6868 20.7933 13.32 20.7933 11.9531 20.7899C10.9213 20.7865 10.325 20.1827 10.325 19.1471C10.3183 16.2325 10.3216 13.3146 10.3216 10.3967Z" fill="#525252"/></svg>',
                    collectionLayout: "",
                },
            ],
            oLanguage: {
                sSearch: "",
                sSearchPlaceholder: "Search",
                oPaginate: {
                    "sPrevious": `<img src="${BASEURL}images/default/svg/chevron-left.svg" width="20" alt="Previous">`,
                    "sNext": `<img src="${BASEURL}images/default/svg/chevron-right.svg" width="20" alt="Next">`,
                }
            },
            order: [
                [0, "desc"]
            ],
            ordering: true,
            rowReorder: true,
            searchDelay: 200,
            processing: true,
            serverSide: false,
            lengthMenu: [
                [50, 100, 200],
                [50, 100, 200]
            ],
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: listRoute,
                type: "POST",
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    arrival_type: '1',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
            },
            drawCallback: function (settings) {
                var response = settings.json;
                if (value_type == 'filter' && response != undefined) {
                    getSpinnerType = spinerType.split('|');
                    var btn_class = getSpinnerType[0] == 'resetFilter' ? 'btn btn-secondary-orio' : 'btn btn-orio';
                    destroyLoader(getSpinnerType[0], getSpinnerType[1], btn_class);
                }
                $('#apply_filters').attr('data-startdate', start_date);
                $('#apply_filters').attr('data-enddate', end_date);
                init_tooltip();
                init_search();
            },
            aoColumns: aoColumns,
        });
        $("#datepicker").find("span.date_range").html(range);
        $("#datepicker").find("span.date_title").html(title);
    };

    $(document).ready(function () {
        var picker = $("#datepicker");
        var param = {
            start: moment().subtract(3, 'days'),
            end: moment(),
            label: '',
            value_type: "",
            spinerType: "",
        }
        init_datepicker(picker, param.start, param.end, datalist);
        datalist(param);
    });
}

var html = "";
$('#shipment_no').on('input', function () {
    var shipment_no = $(this).val();
    if (shipment_no.length >= 9) {
        var consignmentExists = false;
        $('#arrival_list tr').each(function () {
            var consignment = $(this).find("td:eq(0)").text().trim();
            if (shipment_no === consignment) {
                consignmentExists = true;
                return false;
            }
        });

        if (!consignmentExists) {
            var rowCount = $('#arrival_list tr').length;
            // if (rowCount <= 90) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: BASEURL + 'fetch-arrival-cn',
                type: "POST",
                data: {
                    shipment_no: shipment_no,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (result) {
                    append_data(result)
                },
                error: function (xhr, err) {
                    var errorMessage = xhr.responseJSON.message;
                    notify("warning", errorMessage);
                }
            });
            // } else {
            //     notify("warning", "Maximum limit exceded !");
            // }
        } else {
            $(".wp-col").addClass('d-none');
            $("#weight-first").addClass('d-none').val('');
            $("#peices-first").addClass('d-none').val('');
            notify("warning", "consignment number already exist !");
        }
    } else {
        $(".wp-col").addClass('d-none');
        $("#weight-first").addClass('d-none').val('');
        $("#peices-first").addClass('d-none').val('');
    }
});

$(document).on('click', '#save-btn', function () {
    let tabel_data = [];
    $('#arrival_list tr').each(function () {
        var consignment = $(this).find("td.cn_no").text().trim();
        var weight = $(this).find("input[name='arrival_weight[]']").val()
        var peices = $(this).find("input[name='arrival_peices[]']").val()
        var origin_city = $(this).find("td.origin_city").text().trim();
        var destination_city = $(this).find("td.destination_city").text().trim();
        var cod_amt = $(this).find("td.cod_amt").text().trim();
        var service_id = $(this).find("td.service").text().trim();
        var customer_acno = $(this).find("td.customer_acno").text().trim();

        tabel_data.push({
            "cn_number": consignment,
            "weight": weight,
            "peices": peices,
            "origin": origin_city,
            "destination": destination_city,
            "cod_amt": cod_amt,
            "service_id": service_id,
            "customer_acno": customer_acno,
        });
    });

    var title = $(this).html()
    var rider_id = $('#riders_id').val();
    var route_id = $('#route_id').val();
    var station_id = $('#station_id').val();
    if (rider_id != '' && station_id != '' && route_id != '') {
        swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to generate arrival',
            type: "question",
            buttonsStyling: !1,
            showCancelButton: true,
            confirmButtonText: 'Yes, create it!',
            cancelButtonText: 'No, cancel',
            confirmButtonClass: "btn btn-orio",
            cancelButtonClass: "btn btn-secondary-orio mx-3"
        }).then(action => {
            if (action.value == true) {
                initLoader('save-btn', title, 'btn-orio');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: BASEURL + 'insert-arrival',
                    type: "POST",
                    data: {
                        'rider_id': rider_id,
                        'route_id': route_id,
                        'station_id': station_id,
                        'arrival_type': '0',
                        'data': tabel_data
                    },
                    success: function (result) {
                        if (result.status == 1) {
                            swal.fire({
                                icon: "success",
                                title: "Arrival sheet no # " + result.sheet_no,
                                text: result.message,
                                confirmButtonClass: "btn-success",
                                type: "success",
                            });
                            window.setTimeout(function () {
                                window.location.href = BASEURL + 'arrivals';
                            }, 3000);
                        } else {
                            destroyLoader('save-btn', title, 'btn-orio')
                            notify("danger", 'Error', result.message);
                        }
                    },
                    error: function (xhr, err) {
                        var errorMessage = xhr.responseJSON.message;
                        notify("danger", errorMessage);
                        destroyLoader('save-btn', title, 'btn-orio')
                    }
                });
            }else{
                destroyLoader('save-btn', title, 'btn-orio')
            }
        });
    } else {
        notify("danger", "Error", "Please select all feilds");
    }
});


// to remove the cn 
$(document).on('click', '.rem_row', function () {
    $(this).closest('tr').remove();
    if ($('#arrival_list tr').length === 0) {
        $("#save-btn").addClass('d-none');
    }
});

// for edit 
$('#update_sheet').click(function (e) {
    var forms = $("#edit_sheet_form");
    var title = $(this).html()
    initLoader('update_sheet', title, 'btn-secondary-orio');
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        destroyLoader('update_sheet', title, 'btn-secondary-orio')
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        destroyLoader('update_sheet', title, 'btn btn-secondary-orio')
        var formdata = new FormData($("#edit_sheet_form")[0]);
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
                    notify("success", "Success", result.payload);
                    window.setTimeout(function () {
                        window.location.href = BASEURL + 'pickups';
                        $("#example").DataTable().ajax.reload();
                    }, 1000);
                    destroyLoader('update_sheet', title, 'btn btn-secondary-orio')
                } else {
                    notify("danger", "Error", result.payload);
                    destroyLoader('update_sheet', title, 'btn btn-secondary-orio')
                }
            },
            error: function (xhr, err) {
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
                destroyLoader('update_sheet', title, 'btn btn-secondary-orio')
            }
        });

    }
});


$(document).on('keydown', function (event) {
    if (event.key === 'Enter' || event.keyCode === 13) {
        event.preventDefault(); // Prevent form submission
        return false; // Block the default behavior
    }
});

$(document).on('click', '#import_btn', function (e) {
    var forms = $("#bulk_excel_form");
    forms.parsley().validate();
    var title = $(this).html()
    initLoader('import_btn', title, 'btn-orio');
    if (!forms.parsley().isValid()) {
        destroyLoader('import_btn', title, 'btn btn-orio')
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#bulk_excel_form")[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: BASEURL + 'fetch-arrival-cn',
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                append_data(result, 'bulk')
            },
            error: function (xhr, err) {
                var errorMessage = xhr.responseJSON.message;
                notify("warning", errorMessage);
            }
        });

    }
});

let append_data = (result, type = "") => {
    if (type == 'bulk') {
        destroyLoader('import_btn', 'Import', 'btn btn-orio')
        $('#bulk_modal').modal('hide')
        swal.fire({
            icon: "success",
            title: 'Success',
            text: "Consignments imported successfully",
            confirmButtonClass: "btn-success",
            type: "success",
        });
    }

    if (result.status == 1) {
        $("#def_msg").remove();
        $("#arrival_list").append(result.payload);

        $("#save-btn").removeClass('d-none');
        $("#search-btn").addClass('d-none');

        $(".wp-col").addClass('d-none');
        $("#weight-first").addClass('d-none').val('');
        $("#peices-first").addClass('d-none').val('');
        $("#shipment_no").val('');
    } else {
        notify("danger", result.message, result.payload);
    }

}
