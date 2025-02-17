const add_rule_row = (e) => {
    var rulescount = $("#rulescount").val();
    var newrow = 1 + Number(rulescount);
    var prev_selected_value = $(`#rule_select_condition_${e}`).val();
    var field_2 = $.trim($(`.field_${e}_2`).val());
    var field_3 = $.trim($(`.field_${e}_3`).val());
    if ((field_2 == '') || (field_3 == '')) {
        notify('danger', 'Error', 'Please fill empty fields');
        return false;
    }
    $("#rulescount").val(newrow);
    console.log(newrow);
    
    $('.maindropdown').removeClass('activedropdown');
    $("#rules_div").append(`<div class="row" id="rule_value_${newrow}" style="position:relative;"> <div class="col fl-0"><label>&</label></div> <div class="col-md-3 mb-3" id="rule_html_${newrow}_1"> <select onchange="rule_select_condition(${newrow})" id="rule_select_condition_${newrow}" class="form-control field_${newrow}_1 maindropdown activedropdown" data-toggle="select2" data-placeholder="Select Condition" data-allow-clear="1"><option value="Weight">Weight</option><option value="Payment method">Payment method</option> <option value="Countries">Countries</option> <option value="Order value">Order value</option> </select> </div> <div class="col-md-3 mb-3" id="rule_html_${newrow}_2"></div> <div class="col-md-3 mb-3" id="rule_html_${newrow}_3"></div> <div class="col-md-2 mb-3 pl-0" id="rule_html_${newrow}_4"></div> </div>`);
    initSelect2();
    $(".maindropdown option:selected").each(function () {
        if ($(this).val() != '') {
            console.log($(this).val()+" this is selected");
            $(`#rule_select_condition_${newrow} option[value="${$(this).val()}"]`).remove();
        }
    });
    $(`.field_${e}_1, .field_${e}_2, .field_${e}_3`).prop("disabled", true);
    $(`.addbtn_${e}`).css("display", "none");
    $(`.delbtn_${e}`).css("display", "inline");
}
const rule_select_condition = (e) => {
    var rule_type = $(`#rule_select_condition_${e}`).val();
    var counter = $("#rulescount").val();
    switch (rule_type) {
        case 'Weight':
            $(`#rule_html_${e}_2`).html(`<select id="rule_weighttype_${counter}" class="form-control weight_type field_${e}_2" data-toggle="select2" placeholder="Weight" data-allow-clear="1"><option value="">Select weight type</option><option value="=">Equal to</option><option value="<">Less than</option><option value=">">Greater than</option><option value="<=">Less than or equal to</option><option value=">=">Greater than or equal to</option></select>`);
            $(`#rule_html_${e}_3`).html(`<input type="number" min="0" class="form-control  weight_value field_${e}_3" id="rule_weightvalue_${counter}" placeholder="Enter Weight in KG" required="" isselect="1">`);
            $(`#rule_html_${e}_4`).html(`<a href="javascript:void(0);" onclick="add_rule_row(${counter})" rule_row="${counter}" class="addbtn_${e} plusbutton btn-sm btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="delete_rule_value_row(${counter})"  class="delbtn_${e} deletebutton btn-sm btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>`);
            break;
        case '  ':
            $(`#rule_html_${e}_2`).html(`<select id="rule_paymentmethod_${counter}" class="form-control paymentmethod_id field_${e}_2" data-toggle="select2" data-placeholder="Paynent Method" data-allow-clear="1"><option value="1">COD</option><option value="2">CC</option><option value="3">EasyPaisa</option><option value="4">JazzCash</option></select>`);
            $(`#rule_html_${e}_3`).html(`<input type="hidden" value="none" class="rules_paymentmethod2 field_${e}_3">`);
            $(`#rule_html_${e}_4`).html(`<a href="javascript:void(0);" onclick="add_rule_row(${counter})" rule_row="${counter}" class="addbtn_${e} plusbutton btn-sm btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="delete_rule_value_row(${counter})"  class="delbtn_${e} deletebutton btn-sm btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>`);
            break;
        case 'Cities':
            $(`#rule_html_${e}_2`).html(`<select id="rule_city_${counter}" class="form-control rules_cities field_${e}_2" data-toggle="select2" placeholder="List" data-allow-clear="1">${$("#regions_list").html()}</select>`);
            $(`#rule_html_${e}_3`).html(`<input type="hidden" value="none" class="rules_cities2 field_${e}_3">`);
            $(`#rule_html_${e}_4`).html(`<a href="javascript:void(0);" onclick="add_rule_row(${counter})" rule_row="${counter}" class="addbtn_${e} plusbutton btn-sm btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="delete_rule_value_row(${counter})"  class="delbtn_${e} deletebutton btn-sm btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>`);
            break;
        case 'Countries':
            $(`#rule_html_${e}_2`).html(`<select id="rule_city_${counter}" class="form-control rules_countries field_${e}_2" data-toggle="select2" placeholder="List" data-allow-clear="1">${$("#regions_list").html()}</select>`);
            $(`#rule_html_${e}_3`).html(`<input type="hidden" value="none" class="rules_countries2 field_${e}_3">`);
            $(`#rule_html_${e}_4`).html(`<a href="javascript:void(0);" onclick="add_rule_row(${counter})" rule_row="${counter}" class="addbtn_${e} plusbutton btn-sm btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="delete_rule_value_row(${counter})"  class="delbtn_${e} deletebutton btn-sm btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>`);
            break;
        case 'Order value':
            $(`#rule_html_${e}_2`).html(`<select id="rule_ordervaluetype_${counter}" class="form-control order_type field_${e}_2" data-toggle="select2" placeholder="Order value" data-allow-clear="1"><option value="">Select order value</option><option value="=">Equal to</option><option value="<">Less than</option><option value=">">Greater than</option><option value="<=">Less than or equal to</option><option value=">=">Greater than or equal to</option></select>`);
            $(`#rule_html_${e}_3`).html(`<input type="number" min="0" class="form-control order_value field_${e}_3" id="rule_ordervaluetypevalue_${counter}" placeholder="Enter Order Amount" required="">`);
            $(`#rule_html_${e}_4`).html(`<a href="javascript:void(0);" onclick="add_rule_row(${counter})" rule_row="${counter}" class="addbtn_${e} plusbutton btn-sm btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="delete_rule_value_row(${counter})"  class="delbtn_${e} deletebutton btn-sm btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>`);
            break;
    };
    initSelect2();
    const i = $(".maindropdown :selected[value!='']").length;
    $(`.addbtn_${e}`).toggle(i < 4);
}
const delete_rule_value_row = (e) => {
    var i = 0;
    $(".maindropdown :selected").each(function () {
        if ($(this).val() != '') {
            i++;
        }
    });
    var deleted_value = $(`#rule_select_condition_${e}`).val();
    $(".activedropdown").append(new Option(deleted_value, deleted_value));
    $(`#rule_value_${e}`).remove();
}

//======================= Add Rule ==========================
let addRule = () => {
    let trigger_status = $("#trigger_status").val();
    let customer_courier_id = $("#customer_courier_id option:selected").val();
    let courier_id = $('#customer_courier_id option:selected').attr('courier_id');
    let pickup_id = $('#pickup_id option:selected').val();
    if ($('#rule_title').val() == '') {
        notify('danger', 'Error', 'Please fill Rule Title');
        return false;
    }
    if (trigger_status == '') {
        notify('danger', 'Error', 'Please Select Status');
        return false;
    }
    if (customer_courier_id == '') {
        notify('danger', 'Error', 'Please Select Courier');
        return false;
    }
    if (pickup_id == '') {
        notify('danger', 'Error', 'Please Select Pickup');
        return false;
    }
    let weight_type, weight_value, paymentmethod_id, rules_cities,rules_countries, order_type, order_value;
    let error = 0;
    $(".maindropdown").each(function () {
        if ($(this).val() !== '') {
            switch ($(this).val()) {
                case 'Weight':
                    weight_type = $(".weight_type").val();
                    weight_value = $(".weight_value").val();
                    if (weight_type == '' || weight_value == '') {
                        error = 1;
                    }
                    break;
                case 'Payment method':
                    paymentmethod_id = $(".paymentmethod_id").val();
                    if (paymentmethod_id == '') {
                        error = 1;
                    }
                    break;
                case 'Cities':
                    rules_cities = $(".rules_cities option:selected").val();
                    if (rules_cities == '') {
                        error = 1;
                    }
                    break;
                case 'Countries':
                    rules_countries = $(".rules_countries option:selected").val();
                    if (rules_countries == '') {
                        error = 1;
                    }
                    break;
                case 'Order value':
                    order_type = $(".order_type").val();
                    order_value = $(".order_value").val();
                    if (order_type == '' || order_value == '') {
                        error = 1;
                    }
                    break;
            }
        } else {
            error = 1;
        }
    });
    if (error == 1) {
        notify('danger', 'Error', 'Please select atleast one condition');
        return false;
    }
    Swal.fire({
        title: 'Are you sure?',
        text: "These rules will be automatically implemented on Orders.",
        type: "question",
        showCancelButton: true,
        confirmButtonText: 'Yes, Sure'
    }).then((result) => {
        if (result.value) {
            let text = 'addRule';
            initLoader('add_rule', 'Add', 'btn btn-orio');
            $.ajax({
                url: add_route,
                type: "POST",
                data: {
                    rule_title: $('#rule_title').val(),
                    rules_status: trigger_status,
                    courier_id: courier_id,
                    pickup_id: pickup_id,
                    customer_courier_id: customer_courier_id,
                    service_code: $('#service_code option:selected').val(),
                    weight_type: weight_type,
                    weight_value: weight_value,
                    paymentmethod_id: paymentmethod_id,
                    rules_cities: rules_cities,
                    rules_countries: rules_countries,
                    order_type: order_type,
                    order_value: order_value,
                    customer_acno: $('#customer_acno').val(),
                    courier_acc_id: $('#courier_acc_id').val(),
                    service_id: $('#service_id').val(),
                    requestType: 'add_rule'
                },
                success: function (result) {
                    if (result.status == 1) {
                        Swal.fire('Success!',
                            'You have succesfully Add New Rule .', 'success')
                            .then(() => {
                                location.reload();
                            });
                        destroyLoader('add_rule', 'Add Rule', 'btn btn-orio');
                    } else {
                        destroyLoader('add_rule', 'Add Rule', 'btn btn-orio');
                        notify('danger', 'Error', `${result.message}`);
                    }
                },
                error: function (xhr, err) {
                    var errorMessage = xhr.responseJSON.message;
                    notify("warning", errorMessage);
                }
            });
        }
    })
};
//======================= Add Rule ==========================
//======================= Update Rule ==========================
$(document).on('click', '.updateRule', function () {
    $this = $(this);
    let rule_id = $this.data('rule-id');
    let rule_title = $(`#rule_title_${rule_id}`).val();
    let customer_courier_id = $(`#courier_acc_id_${rule_id}`).val();
    let courier_id = $(`#courier_acc_id_${rule_id} option:selected`).attr('courier_id');
    let customer_acno = $(`#customer_id_${rule_id} option:selected`).val();
    let pickup_id = $(`#pickup_id_${rule_id} option:selected`).val();
    let service_code = $(`#service_id_${rule_id}`).val();
    let trigger_status = $(`#rule_${rule_id}`)
    let status = (trigger_status.is(':checked')) ? '1' : '0'
    if (rule_title == '') {
        notify('danger', 'Error', 'Please fill Rule Title');
        return false;
    }
    if (status == '') {
        notify('danger', 'Error', 'Please Select Status');
        return false;
    }
    if (customer_courier_id == '') {
        notify('danger', 'Error', 'Please Select Courier');
        return false;
    }
    if (pickup_id == '') {
        notify('danger', 'Error', 'Please Select Pickup');
        return false;
    }
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to Update this Rule Status.",
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Sure'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: update_route,
                type: "POST",
                data: {
                    ruleid: rule_id,
                rule_title: rule_title,
                customer_acno: customer_acno,
                courier_id: courier_id,
                customer_courier_id: customer_courier_id,
                pickup_id: pickup_id,
                service_code: service_code,
                status: status,
                },
                success: function (result) {
                    if (result.status == 1) {
                        Swal.fire('Success!', 'You have succesfully updated your rule.', 'success')
                            .then(() => {
                                location.reload();
                            });
                    } else {
                        notify('danger', 'Error', `${result.message}`);
                    }
                },
                error: function (xhr, err) {
                    var errorMessage = xhr.responseJSON.message;
                    notify("warning", errorMessage);
                }
            });
        }
    });
});
//======================= Update Rule ==========================
//======================= Delete Rule ==========================
let deleteRule = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this Rule.",
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Sure'
    }).then((result) => {
        if (result.value) {
          
            $.ajax({
                url: BASEURL+'delete',
                type: "POST",
                data: {
                    id: id,
                    table: "rules"
                },
                success: function (data) {
                    var result = JSON.parse(data);
                    if (result.status == 1) {
                        Swal.fire('Success!', `You have succesfully deleted Rule`, 'success');
                        $(`#${id}`).remove();
                    } else {
                        notify('danger', 'Error', `${result.message}`);
                    }
                },
                error: function (xhr, err) {
                    var errorMessage = xhr.responseJSON.message;
                    notify("warning", errorMessage);
                }
            });
        }
    });
}
//======================= Delete Rule ==========================
// to get the services of courior 
$('.courier_acc_id').change(function () {
    var courier_id = $(this).val(); 
    var service_id = $(this).data('service-id'); 
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: BASEURL + 'get-selected-service',
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            courier_id: courier_id
        },
        success: function (result) {
            $('#'+service_id).empty();
            result.forEach(function (item) {
                $('#'+service_id).append('<option value="' + item.service_code + '">' + item.service_name + '</option>');
            });
        },
        error: function (xhr, err) {
            var errorMessage = xhr.responseJSON.message;
            notify("warning", errorMessage);
        }
    });
});


// to get the pickuplocations of customer 
$('.customer_acno').change(function () {
    var customer_acno = $(this).val();
    var pickup_id = $(this).data('pickup-id');
    var type = $(this).data('type');
    if(type == 'D')
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: BASEURL + 'pickup-location-specific',
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                customer_acno: customer_acno
            },
            success: function (response) {
                if (response.status == 1) {
                    $('#' + pickup_id).html(response.payload)
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
});

