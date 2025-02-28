$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// validations
$(".mobilenumber").keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $text = $(this);
    if (key !== 8 && key !== 9) {
        if ($text.val().length === 4) {
            $text.val($text.val() + "-");
        }
        if ($text.val().length === 12) {
            e.preventDefault()
            return;
        }
    }
    return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
});

$(".cnicNumber").keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $text = $(this);
    if (key !== 8 && key !== 9) {
        if ($text.val().length === 5 || $text.val().length === 13) {
            $text.val($text.val() + "-");
        }
        if ($text.val().length === 15) {
            e.preventDefault()
            return;
        }
    }
    return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
});

// ----------------------------------------- Ntn Validation -----------------------------
$(".ntnNumber").keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $text = $(this);
    if (key !== 8 && key !== 9) {
        if ($text.val().length === 7) {
            $text.val($text.val() + "-");
        }
        if ($text.val().length === 9) {
            e.preventDefault()
            return;
        }
    }
    return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
});

//=================================== Notify Function ==================================================//

// swal delete
$(document).on("click", ".delete", function () {
    var element = $(this);
    let id = $(this).data('id');
    let table = $(this).attr("table");
    let dtable = "example";
    swal.fire({
        title: 'Confirmation',
        text: 'Are you sure you want to delete?',
        type: "question",
        buttonsStyling: !1,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
        confirmButtonClass: "btn btn-orio",
        cancelButtonClass: "btn btn-secondary-orio mx-3"
    }).then(t => {
        t.value && $.ajax({
            url: "/delete",
            method: "POST",
            data: {
                id: id,
                table: table,
            },
            success: function (result) {
                var responseData = JSON.parse(result);
                if (responseData.status == 1) {
                    $(element).parent().parent().remove();
                    swal.fire({
                        title: "Delete",
                        text: "Deleted Successfully",
                        confirmButtonClass: "btn-success",
                        type: "success",
                    });
                } else {
                    swal.fire({
                        title: "Error",
                        text: "Something Went Wrong",
                        confirmButtonClass: "btn-danger",
                        type: "error",
                    });
                }
                $('#example').DataTable().ajax.reload();
            },
            error: function (xhr, err) {
                notify("warning", "Oh snap!", "Something went wrong");
            }
        });
    });
});

$(document).on("click", ".status_btn", function () {
    let id = $(this).data('id');
    let table = $(this).attr("table");
    let status = $(this).data("status");
    let dtable = $(this).data("dataTabel") || '#example';
    console.log(dtable);

    swal.fire({
        title: 'Confirmation',
        text: 'Are you sure you update the status?',
        type: "question",
        buttonsStyling: !1,
        showCancelButton: true,
        confirmButtonText: 'Yes, update it!',
        cancelButtonText: 'No, cancel',
        confirmButtonClass: "btn btn-orio",
        cancelButtonClass: "btn btn-secondary-orio mx-3"
    }).then(t => {
        t.value && $.ajax({
            url: "/status",
            method: "POST",
            data: {
                id: id,
                table: table,
                status: status,
            },
            success: function (data) {
                $(dtable).DataTable().ajax.reload();
            }
        });
    });
});

//==================================== CNIC VALIDATION PARSELEY =============================================
window.Parsley.addValidator('cnic', {
    validateString: function (value) {
        var cnicRegex = /^([1-7])(?:(?:(?!\1)[0-9]){3}|(?!([0-9])\2{2}))[0-9]{4}-[0-9]{7}-[1-9]$/;

        if (!cnicRegex.test(value)) {
            return false;
        }
        return true;
    },
    messages: {
        en: 'Invalid CNIC number',
    },
});
//==================================== CNIC VALIDATION PARSELEY =============================================

//==================================== PARSELEY ERROR FIELDS =============================================
window.Parsley.on('field:error', function () {
    this.$element.addClass('is-invalid').removeClass('is-valid');

    var label = this.$element.parent('div').find('label').clone().find('span').remove().end().text().trim();
    var errorMessage = this.$element.parent('div').find('li').text();
    var finalMessage = errorMessage.replace('This value', label);
    this.$element.parent('div').find('li').text(finalMessage);

    if (this.$element.hasClass('select2-hidden-accessible')) {
        var div = this.$element.parent();
        div.append(this.$element.parent().find('ul'));
    }
});

$('form [data-toggle="custom-select2"]').on('change', function () {
    $(this).parsley().validate();
});

window.Parsley.on('field:success', function () {
    this.$element.removeClass('is-invalid').addClass('is-valid');
});


//==================================== PARSELEY ERROR FIELDS =============================================
let init_tooltip = () => {
    $('[data-toggle="tooltip"]').tooltip();
};

$(document).ready(function () {
    // clear cache
    setTimeout(function () {
        // console.log(111)
        $.ajax({
            url: '/clear-cache',
            type: "POST",
            data: {
                type: 'all'
            },
            success: function (result) {

            },
            error: function (xhr, err) {}
        });
    }, 30000);
    var path = window.location.pathname;
    console.log(path);
    $('.sub_menu__items[href="' + path + '"]').parent().addClass('mm-active');
    initSelect2();

    $('select').change(function () {
        $(this).parsley().validate();
    });

});

// $(document).on('select2:open', () => {
// 	document.querySelector('.select2-search__field').focus();
// });
// Function to initialize Select2
const initSelect2 = () => {
    $('[data-toggle="select2"]').select2({
        theme: 'bootstrap4',
        width: 'element',
        placeholder: function () {
            return $(this).data('placeholder');
        },
        allowClear: function () {
            return Boolean($(this).data('allow-clear'));
        }
    });
};

// ======================================= Init date picker ======================================

function init_datepicker(picker, start, end, datalist) {
    picker.daterangepicker({
        startDate: start,
        endDate: end,
        opens: 'left',
        minDate: moment().subtract(4, 'months'),
        maxDate: moment(),
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last 3 Months': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            // 'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
    }, function (start, end, label) {
        datalist({
            start: start,
            end: end,
            label: label
        });
    });
}

// ==================== loader ===================
let initLoader = (id, text, className, type = 'N') => {
    $(`#${id}`).html('');
    $(`#${id}`).removeClass(className);
    $(`#${id}`).attr('disabled', true);
    if (type == 'N') {
        $(`#${id}`).css('min-width', '150px');
        $(`#${id}`).css('text-align', 'center');
    }
    let loaderClass = (type == 'S') ? 'spinner_loader' : '';
    $(`#${id}`).html(`<div class="spinner-border text-primary ${loaderClass}" role="status" id="initLoader">
	<span class="btn sr-only">Loading...</span>
	</div>`);
};

let destroyLoader = (id, text, className, style = 'N') => {
    $(`#${id}`).html('');
    $(`#${id}`).addClass(className);
    $(`#${id}`).removeAttr('disabled');
    if (style == 'N') {
        $(`#${id}`).removeAttr("style");
    }
    setTimeout(() => {
        $(`#${id}`).html(text);
    }, 100);
};

$(document).on("click", ".show_pass_btn", function () {
    var passwordField = $(this).prev(".passwordField");
    var icon = $(this).find("i");
    if (passwordField.attr("type") === "password") {
        passwordField.attr("type", "text");
        icon.removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
        passwordField.attr("type", "password");
        icon.removeClass("fa-eye-slash").addClass("fa-eye");
    }
});

$(document).on("input", ".number", function () {
    // Remove all non-numeric characters
    var currentValue = $(this).val();
    var cleanedValue = currentValue.replace(/\D/g, ''); // \D matches any non-digit character
    $(this).val(cleanedValue);
});

$(document).on("input", ".float", function () {
    var currentValue = $(this).val();

    // Remove all non-numeric and non-point characters except the first point
    var cleanedValue = currentValue.replace(/[^0-9.]/g, '').replace(/^(\d+\.\d*)\./, '$1');

    // Ensure there is at least one number at the beginning
    if (!cleanedValue.match(/^\d/)) {
        cleanedValue = cleanedValue.replace(/^\.*/, ''); // Remove leading points if there is no number at the beginning
    }

    $(this).val(cleanedValue);
});

$(document).on("input", "#user_name", function () {
    var currentValue = $(this).val();
    var cleanedValue = currentValue
        .replace(/[',\/?\\|=+`~\s{}[\]:;<>*\-\ ]/g, '')
    if ((cleanedValue.match(/\./g) || []).length > 1) {
        cleanedValue = cleanedValue.replace(/\.(?=.*\.)/g, '');
    }
    $(this).val(cleanedValue);
});

//=================================== Notify Function ==================================================//
let notify = (type, title, message = '') => {
    let icon;
    icon = (type == 'danger') ? 'exclamation-circle' : (type == 'warning') ? 'exclamation-triangle' : 'check-circle';
    $.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: title,
        message: message,
        target: '_blank',
        url: '#example'
    }, {
        // settings
        type: type,
        newest_on_top: true,
        allow_dismiss: true,
        showProgressbar: true,
        animate: {
            enter: 'animated zoomIn',
            exit: 'animated zoomOut'
        },
        placement: {
            from: "top",
            align: "center"
        },
        offset: {
            x: 15,
            y: 15
        },
        spacing: 10,
        z_index: 1080,
        delay: 1500,
        timer: 2500,
        url_target: "_blank",
        mouse_over: !1,
        template: '<div data-notify="container" class="alert alert-dismissible text-white-50 shadow-sm alert-notify" role="alert">\n' +
            '    <div class="alert-wrapper-bg bg-{0}"></div>\n' +
            '    <div class="alert-content-wrapper">\n' +
            '        <i class="fas fa-' + icon + '"></i>\n' +
            '        <div class="pl-3">\n' +
            '            <span class="alert-title text-white" data-notify="title">{1}</span>\n' +
            '            <div data-notify="message" class="alert-text">{2}</div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '<button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
            '</div>'
    });
};
//=================================== Notify Function ==================================================//


// ====================================== APEX SPARKLINES GRAPH =======================================//
let renderSparklinesGraph = (id, color, data) => {
    if (data.length > 0) {
        $(`#${id}`).html('');

        var sparklinesGraph = {
            chart: {
                type: 'line',
                height: 40,
                sparkline: {
                    enabled: true
                },
                events: {
                    dataPointMouseEnter: function (event) {
                        event.fromElement.style.cursor = "pointer";
                    }
                }
            },
            colors: [`${color}`],
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function (seriesName) {
                            return '';
                        }
                    }
                },
                marker: {
                    show: false
                }
            },
            series: [{
                data: data
            }],
            yaxis: {
                min: 0
            }
        };

        var sparklinesGraphRender = new ApexCharts(
            document.querySelector(`#${id}`),
            sparklinesGraph
        );
        sparklinesGraphRender.render();
    }
};

// ===================================== APEX DONUT GRAPH ============================================//
//========================= 3pl Donut =========================
let renderDonutGraph3 = (id, labels, series, colors) => {
    $(`#${id}`).html('');

    var graphData = {
        chart: {
            type: 'donut',
            height: 250,
            width: '100%',
        },
        dataLabels: {
            enabled: false,
        },
        labels: labels,
        series: series,
        colors: colors,
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'round',
            width: 2,
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '60%',
                    labels: {
                        show: true,
                        showAlways: true,
                        total: {
                            show: true,
                            showAlways: true,
                        },
                        value: {
                            fontSize: '16px',
                            color: '#474747'
                        },
                        name: {
                            fontSize: '18px',
                            color: '#001E31'
                        }
                    },
                },
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            offsetY: 0,
            fontSize: '11px',
            itemMargin: {
                horizontal: 2,
                vertical: 3,
            },
        }
    };

    var chart = new ApexCharts(document.querySelector(`#${id}`), graphData);
    chart.render();
};

let renderThirdPartyGraph = (account_id, data, colors) => {
    let status_name = [],
        status_orders = [];
    for (let i = 0; i < data.length; i++) {
        status_name.push(data[i].status_name);
        status_orders.push(parseInt(data[i].shipments));
    }
    if (status_name.length > 0 && status_orders.length > 0) {
        renderDonutGraph3(account_id, status_name, status_orders, colors);
    } else {
        $(`#${account_id}`).html("<span class='empty-circle'></span>");
    }
};
//====================================== New appex donut =============================================//

let renderDonutGraph2 = (id, labels, series, colors) => {
    $(`#${id}`).html('');
    var graphData = {
        chart: {
            type: 'donut',
            width: 380,
            height: 250,
            align: 'left',
            offsetX: 0,
            borderRadius: 100,
        },
        dataLabels: {
            enabled: false,
        },
        labels: labels,
        series: series,
        colors: colors,
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'round',
            width: 5,
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    labels: {
                        show: true,
                        showAlways: true,
                        total: {
                            show: true,
                            showAlways: true,
                        },
                        value: {
                            fontSize: '16px',
                            color: '#474747'
                        },
                        name: {
                            fontSize: '18px',
                            color: '#001E31'
                        }
                    },
                },
            }
        },
        legend: {
            position: 'right',
            horizontalAlign: 'left',
            offsetY: 40,
            itemMargin: {
                horizontal: 3,
                vertical: 10,
            },
        }
    };
    var chart = new ApexCharts(document.querySelector(`#${id}`), graphData);
    chart.render();
};

//====================================== Password Generator ==========================================// 
$(document).on('click', '.gen-pass', function () {
    var pass = generatePassword(8);
    $('#password').val(pass)
    $('#confirm_password').val(pass)
});

let genPass = () => {
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+";
    var password = "";
    for (var i = 0; i < 10; i++) {
        var randomIndex = Math.floor(Math.random() * charset.length);
        password += charset[randomIndex];
    }

    $('#password').val(password)
    $('#confirm_password').val(password)
}
let generatePassword = (length) => {
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+";
    var password = "";
    for (var i = 0; i < length; i++) {
        var randomIndex = Math.floor(Math.random() * charset.length);
        password += charset[randomIndex];
    }
    return password;
}

//====================================== CN TRACKING ==============================================//
// $('#track-nav').click(function (e) {
$(document).on('input', '#track-nav', function () {
    var title = $(this).html()
    $('#append_track').html()
    var cn_no = $(this).val();
    if (cn_no.length === 9) {
        $.ajax({
            url: track_route,
            type: "POST",
            data: {
                cn_no: cn_no
            },
            dataType: "json",
            success: function (result) {
                console.log(result.payload.tracking_details);
                if (result.status == 1) {
                    $('#track-details').html();
                    $('#track-details').html(result.payload);
                    $("#track-nav").val('');
                    $(".label-info").remove();
                    if (window.location.pathname === '/track') {
                        $('.shipment-details').addClass('d-none');
                    }
                    $('#tracking_modal').modal("show")
                } else {
                    $('#tracking_modal').modal("hide")
                    notify("danger", result.message, result.payload);
                }
            },
            error: function (xhr, err) {
                notify("danger", "Oh snap!", "Something went wrong request error");
            }
        });
    }

});

$(document).on('change', '.country_id', function () {
    var id = $(this).val();
    get_city(id)
});

let get_city = (country_id, selector = '.city_id') => {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: BASEURL + 'get-cities-specific',
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            country_id: country_id,
        },
        success: function (response) {
            $(selector).html();
            if (response.status == 1) {
                var payload = response.payload;
                var html = '';
                payload.forEach(function (data) {
                    html += `<option value="${data.id}">${data.city}</option>`;
                });
                $(selector).html(html);
            } else {
                notify('danger', 'Error', `${response.payload}`);
            }
        },
        error: function (xhr, err) {
            var errorMessage = xhr.responseJSON.message;
            notify("warning", errorMessage);
        }
    });
}
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


const copyToClipboard = (id) => {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(id).val()).select();
    document.execCommand("copy");
    $temp.remove();
}

//==================================== Column Visiblity =============================================
$(document).on('click', '.buttons-colvis', function () {
    $('.dt-button.dropdown-item.buttons-columnVisibility').each(function () {
        $(this).toggleClass('checked', $(this).hasClass('active'));
    });
});
$(document).on('click', '.dt-button.buttons-columnVisibility', function () {
    const isActive = $(this).hasClass('active');
    $(this).toggleClass('checked', isActive);
    // if ($(this).hasClass('checked')) {$("#orderDetail").DataTable().ajax.reload();}
})
// ==================================== Column Visiblity =============================================
//==================================== Datatable Search Filter =============================================
let init_search = () => {
    $(".dataTables_filter").addClass("pr-0");
    $(".dataTables_filter input[type='search']").removeClass("form-control-sm");
    $(".dataTables_filter input[type='search']").addClass("dt-search");
    $(".buttons-excel").attr({
        "data-toggle": "tooltip",
        "data-original-title": "Export Excel",
    });
    $(".buttons-colvis").attr({
        "data-toggle": "tooltip",
        "data-original-title": "Column Visibility",
    });
    $(".buttons-csv").attr({
        "data-toggle": "tooltip",
        "data-original-title": "Export CSV",
    });
};
//==================================== Datatable Search Filter =============================================

// =================================== Shipment airway system =============================================
let stsyem_print = (check_selector) => {
    var checkedValues = [];
    $(check_selector + ':checked').each(function () {
        checkedValues.push($(this).data('consignment'));
    });
    if (checkedValues.length > 0) {
        var ids = checkedValues.join(',');
        window.open(BASEURL + 'airway-pdf/' + btoa(ids), '_blank');
    } else {
        notify("danger", "Error", "Please select any one checkbox");
        return false
    }
}

//=================================== Adjust DataTable ==================================================//
$(document).ready(function () {
    if (location.pathname != '/home') {
        setTimeout(() => {
            if ($('table').length) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
                console.log(`Adjust DataTable`);
            }
        }, 4000);
    }
});
$(document).on('click', '.toggle-sidebar', function () {
    let sidebarCollapsed = ($('body').hasClass('sidebar-collapsed')) ? 'Yes' : 'No';
    // setCookie('sidebarCollapsed', sidebarCollapsed);
    if (location.pathname != '/home') {
        setTimeout(() => {
            if ($('table').length) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
                console.log(`Adjust DataTable`);
            }
        }, 2000);
    }
});
let adjustDataTable = () => {
    if ($('table').length) {
        setTimeout(function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
        }, 2000)
    }
}
//=================================== Adjust DataTable ==================================================//

//=================================== GET Customer specific data ========================================//
let get_pickup = (customer_acno) => {
    $.ajax({
        url: BASEURL + 'pickup-location-specific',
        type: "POST",
        data: {
            customer_acno: customer_acno
        },
        success: function (result) {
            if (result['status'] == 1) {
                $("#pickup_locations").html(result['payload'])
            } else {
                $("#pickup_locations").html('')
            }
        },
        error: function (xhr, err) {
            var errorMessage = xhr.responseJSON.message;
            notify("danger", errorMessage);
        }
    });

}

let get_service = (customer_acno) => {
    $.ajax({
        url: BASEURL + 'get-customer-service',
        type: "POST",
        data: {
            customer_acno: customer_acno
        },
        success: function (result) {
            $("#service_name").html(result)
        }
    });
}

//================================== Sweet alert ======================================================//
let info_sweet_alert = (title,text) =>{
    swal.fire({
        icon: "success",
        title: title,
        text: text,
        confirmButtonClass: "btn-success",
        type:"success",
    });
}

let confirm_sweet = (text) => {
    return new Promise((resolve) => {
        swal.fire({
            title: "Confirmation",
            text: text,
            type: "question",
            buttonsStyling: !1,
            showCancelButton: true,
            confirmButtonText: 'Yes, create it!',
            cancelButtonText: 'No, cancel',
            confirmButtonClass: "btn btn-orio",
            cancelButtonClass: "btn btn-secondary-orio mx-3"
        }).then(action => {
            if (action.value == true) { 
                resolve(true);
            } else {
                resolve(false);
            }
        });
    });
};