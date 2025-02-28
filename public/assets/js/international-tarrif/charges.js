// for adding the tarifs
$(document).ready(function () {
    $(".add_more_info").click(function () {
        var $this = $(this);
        var form_id = $this.data('form_id');
        var type = $this.data('type');
        var count = $this.data('count');
        get_info(form_id, type, count, $this);
    });

    // for edit page insertion modal
    $("#add_new_charge_btn").click(function () {
        var btn_text = $(this).text();
        let charges_details = [],
            totalRows = $('#tariff_display tr').length;
        if (totalRows >= 1) {
            $('#tariff_display tr').each(function () {
                if ($(this).find('td').length > 2) {
                    let rowData = {
                        "service_id": $(this).find('.service_id').text().trim(),
                        "origin_country": $(this).find('.origin_country').text().trim(),
                        "destination_country": $(this).find('.destination_country').text().trim(),
                        "start_weight": $(this).find('.start_weight').text().trim(),
                        "end_weight": $(this).find('.end_weight').text().trim(),
                        "charges": $(this).find('.charges').text().trim(),
                        "additional_weight": $(this).find('.add_weight').text().trim(),
                        "additional_charges": $(this).find('.add_charges').text().trim()
                    };
                    charges_details.push(rowData);
                }
            });
            if (charges_details.length === 0) {
                notify("danger", "Error", "Please define at least 1 tariff");
            }
        } else {
            notify("danger", "Error", "Please define at least 1 tariff");
        }

        confirm_sweet("Are you sure you want to create tarrif ?").then(action => {
            if (action) {
                initLoader('add_new_charge_btn', btn_text, 'btn-orio');
                $.ajax({
                    url: BASEURL + "add-international-charges",
                    type: "POST",
                    data: {
                        charges:charges_details
                    },
                    timeout: 800000,
                    success: function (result) {
                        if (result.status == 1) {
                            initSelect2();
                            notify("success","Success",result.message);
                            location.reload();
                            destroyLoader('add_new_charge_btn',btn_text, 'btn-orio')
                        } else {
                            if (result.payload.errors.length > 0) {
                                let message = result.payload.errors.map(data =>
                                    data.message
                                ).join("\n");
                                notify("danger",result.message,message);
                            } else {
                                notify("danger", result.message, "");
                            }
                            destroyLoader('add_new_charge_btn',btn_text,'btn-orio')
                        }
                    },
                    error: function (xhr, err) {
                        notify("warning", "Oh snap!", "Something went while wrong performing operation");
                        destroyLoader('add_new_charge_btn',btn_text,'btn-orio')
                    }
                });
            }
        });
    });

    $(document).on('click', '#update_tariff', function () {
        var checkedValues = [];
        allValid = true;
        $('.check_box:checked').each(function () {
            var tarrif_id = $(this).val();
            var service_id = $(this).data('service-id');
            var flag = $(this).data('flag');
            var row = $(this).closest("tr");
    
            var start_weight = row.find("[name='start_weight[]']");
            var end_weight = row.find("[name='end_weight[]']");
            var charges = row.find("[name='charges[]']");
            var add_weight = row.find("[name='add_weight[]']");
            var add_charges = row.find("[name='add_charges[]']");
            
            if (!start_weight.val() || !end_weight.val() || !charges.val()) {
                start_weight.parsley().validate();
                end_weight.parsley().validate();
                charges.parsley().validate();
        
                allValid = false;
                return false; 
            }
    
            var rowData = {
                tarrif_id: tarrif_id,
                service_id: service_id,
                flag: flag,
                start_weight: start_weight.val(),
                end_weight: end_weight.val(),
                charges: charges.val(),
                add_weight: add_weight.val(),
                add_charges: add_charges.val()
            };
            checkedValues.push(rowData);
        });
        if (!allValid) {
            return;
        }
        confirm_sweet("Are you sure you want to update tariff charges ?").then(action => {
            if (action) {
                $.ajax({
                    url: BASEURL + 'update-international-charges',
                    type: 'POST',
                    data: {
                        values: checkedValues
                    },
                    success: function (result) {
                        if (result.status == 1) {
                            notify("success","Success",result.message,);
                            $('#append_btn_div').addClass('d-none').slideUp();
                            $('#append_btn_div').removeClass('d-block').slideUp();
                            $("#example").DataTable().ajax.reload();
                        } else {
                            if (result.payload.errors.length > 0) {
                                let message = result.payload.errors.map(data =>
                                    data.message
                                ).join("\n");
                                notify("danger",result.message,message);
                            } else {
                                notify("danger", result.message, "");
                            }
                        }
                    },
                    error: function (xhr, err) {
                        notify("warning", "Oh snap!", "Something went wrong");
                    }
                });
            }
        });
    });
    
});

// for removing the rows 
$(document).on('click', '.remove_row', function () {
    $(this).parent().parent().remove();
});


function get_info(form_id, type, count, $button) {
    var forms = $(form_id);
    var display_tabel = $(form_id).data('display_table');
    var input_hidden = $(form_id).data('input_hidden');
    var type = type;

    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        return false;
    }
    if (forms.parsley().isValid()) {
        var isDuplicate = checkForDuplicateRows(form_id, forms, input_hidden);
        if (isDuplicate.status == 0) {
            notify("danger", "Error", isDuplicate.msg);
            return false;
        } else {
            append_rows(type, count, forms, input_hidden, display_tabel);
            $button.data('count', count + 1);
        }
    }
}

function append_rows(type, count, forms, input_hidden, display_table) {
    var rows = "";
    var fields = "";
    var def_class = '';
    forms.each(function () {
        var $thisForm = $(this);
        var rowData = {
            count: count,
            service_id: null,
            origin_country: null,
            destination_country: null,
            origin_country_name: null,
            destination_country_name: null,
            service_name: null,
            tarif_service_name: null,
            region_type: null,
            start_weight: null,
            end_weight: null,
            charges: null,
            add_weight: null,
            add_charges: null,
            rto_charges: null,
            add_rto_weight: null,
            add_rto_charges: null
        };


        if (type === "tarrif") {
            def_class = '.default-tarif';
            rowData.service_id = $thisForm.find('select[name="service_name"]').val();
            rowData.tarif_service_name = $thisForm.find('select[name="service_name"]').val();

            rowData.start_weight = $thisForm.find('input[name="start_weight"]').val();
            rowData.end_weight = $thisForm.find('input[name="end_weight"]').val();
            rowData.charges = $thisForm.find('input[name="charges"]').val();
            rowData.add_weight = $thisForm.find('input[name="add_weight"]').val();
            rowData.add_charges = $thisForm.find('input[name="add_charges"]').val();
            rowData.origin_country = '449';
            rowData.destination_country = $thisForm.find('select[name="destination_country"]').val();
            rowData.service_name = $thisForm.find('select[name="service_name"] option:selected').text();
            rowData.origin_country_name = 'Pakistan';
            rowData.destination_country_name = $thisForm.find('select[name="destination_country"] option:selected').text();
        }


        rows += `<tr>
            ${rowData.count !== null ? `<td>${rowData.count}</td>` : ``}
            ${rowData.service_name !== null ? `<td>${rowData.service_name}</td>` : ``}
            ${rowData.service_id !== null ? `<td class="d-none service_id">${rowData.service_id}</td>` : ``}
            ${rowData.origin_country !== null ? `<td>${rowData.origin_country_name}</td>` : ``}
            ${rowData.origin_country !== null ? `<td class="d-none origin_country">${rowData.origin_country}</td>` : ``}
            ${rowData.destination_country !== null ? `<td>${rowData.destination_country_name}</td>` : ``}
            ${rowData.destination_country !== null ? `<td class="d-none destination_country">${rowData.destination_country}</td>` : ``}
            ${rowData.start_weight !== null ? `<td class="start_weight">${rowData.start_weight}</td>` : ``}
            ${rowData.end_weight !== null ? `<td class="end_weight">${rowData.end_weight}</td>` : ``}
            ${rowData.charges !== null ? `<td class="charges">${rowData.charges}</td>` : ``}
            ${rowData.add_weight !== null ? `<td class="add_weight">${rowData.add_weight}</td>` : ``}
            ${rowData.add_charges !== null ? `<td class="add_charges">${rowData.add_charges}</td>` : ``}

            <td> <div class="remove_row cursor-pointer" data-type="${type}" data-count="${rowData.count}"> <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M9 8.5V17" stroke="#525252" stroke-width="2" stroke-linecap="round"/> <path d="M13 8.5V17" stroke="#525252" stroke-width="2" stroke-linecap="round"/> <path d="M2.75 4.5L3.89495 19.6133C3.95421 20.3955 4.60619 21 5.39066 21H16.6093C17.3938 21 18.0458 20.3955 18.1051 19.6133L19.25 4.5" stroke="#525252" stroke-width="2"/> <path d="M1 4.5H21" stroke="#525252" stroke-width="2" stroke-linecap="round"/> <path d="M7.5 4.5L8.22075 2.81824C8.69349 1.71519 9.7781 1 10.9782 1H11.0218C12.2219 1 13.3065 1.71519 13.7792 2.81824L14.5 4.5" stroke="#525252" stroke-width="2" stroke-linejoin="round"/> </svg> </div></td>
            </tr>`;

    });
    $(def_class).remove()
    $(display_table).append(rows);
}

function checkForDuplicateRows(form_id, forms, input_hidden) {
    var msg = null;
    if (input_hidden == '#tariff_display') {
        var formDataText = [
            forms.find('[name="service_name"]').val(),
            forms.find('[name="destination_country"]').val(),
            forms.find('[name="start_weight"]').val(),
            forms.find('[name="end_weight"]').val()
        ].join('');
        var isDuplicate = false;
        var rows = $(input_hidden).find('tr');
        var ServiceName = forms.find('[name="service_name"]').val();
        var originCountry = 'Pakistan';
        var destinationCountry = forms.find('[name="destination_country"]').val();
        var startWeight = parseFloat(forms.find('[name="start_weight"]').val());
        var endWeight = parseFloat(forms.find('[name="end_weight"]').val());

        rows.each(function () {
            var $row = $(this);
            var rowServiceName = $row.find('.service_id').text().trim();
            var rowDestinationCountry = $row.find('.destination_country').text().trim();
            var rowStartWeight = parseFloat($row.find('.start_weight').text().trim());
            var rowEndWeight = parseFloat($row.find('.end_weight').text().trim());
            var rowData = [
                rowServiceName,
                rowDestinationCountry,
                rowStartWeight,
                rowEndWeight
            ].join('');

            console.log(formDataText);
            console.log(rowData);

            if (formDataText === rowData) {
                msg = "Dulplicate entry please enter unique data.";
                isDuplicate = true;
                return false;
            }
            if (startWeight === endWeight) {
                msg = "Start weight and end weight should be similar.";
                isDuplicate = true;
                return false;
            }
            if (startWeight > endWeight) {
                msg = "Start weight should not be greater then end weight.";
                isDuplicate = true;
                return false;
            }
            if (ServiceName === rowServiceName) {
                if (destinationCountry == rowDestinationCountry) {
                    if (
                        (startWeight >= rowStartWeight && startWeight < rowEndWeight) || // New start weight falls inside an existing range
                        (endWeight > rowStartWeight && endWeight <= rowEndWeight) || // New end weight falls inside an existing range
                        (startWeight <= rowStartWeight && endWeight >= rowEndWeight) // New range fully covers the existing range
                    ) {
                        msg = "Weight range overlaps with an existing range.";
                        isDuplicate = true;
                        return false;
                    }
                }
            }
        });
    }


    if (isDuplicate) {
        return {
            "status": 0,
            "msg": msg
        }
    } else {
        return {
            "status": 1,
            "msg": msg
        }
    }

}
