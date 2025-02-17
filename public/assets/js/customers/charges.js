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
    $(".add_new_charge_btn").click(function () {
        var form_id = $(this).data('form_id');
        var btn_text = $(this).text();
        var formdata = new FormData($(form_id)[0]);
        $(".add_new_charge_btn").attr("disabled", true).text("Please Wait....");
        $.ajax({
            url: BASEURL + "insert-charges",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                if (result.status == 1) {
                    initSelect2();
                    notify("success", result.message, result.payload);
                    location.reload();
                    $(".add_new_charge_btn").removeAttr("disabled", true).text(btn_text)
                } else {
                    notify("danger", result.message, result.payload);
                    $(".add_new_charge_btn").removeAttr("disabled", true).text(btn_text)
                }
            },
            error: function (xhr, err) {
                notify("warning", "Oh snap!", "Something went while wrong performing operation");
                $(".add_new_charge_btn").removeAttr("disabled", true).text(btn_text)
            }
        });
    });

    $(".check_box").click(function () {
        var btn_id = $(this).data('btn_id');
        if ($(this).prop('checked')) {
            $(btn_id).removeClass('d-none');
        } else {
            $(btn_id).addClass('d-none');
        }
    });

    $(document).on('click', '.update_charges_btn', function () {
        initLoader('update_tariff', 'btn btn-secondary-orio');
        var title = 'Update';
        var check_box = $(this).data('check_id');
        var checked = '.' + check_box + ':checked'
        let formData = new FormData();
        $(checked).each(function () {
            let row = $(this).closest('tr');
            let formFields = row.find('input, select').serializeArray();
            formFields.forEach(field => {
                formData.append(field.name, field.value);
            });
        });
        formData.append('customer_acno', customer_acno);
        $.ajax({
            url: BASEURL + "update-charges",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (result) {
                if (result.status == 1) {
                    notify("success", "Success", result.message);
                    window.setTimeout(function () {
                        window.location.reload();
                        // window.location.href = BASEURL + 'customers';
                    }, 1000);
                    destroyLoader('update_tariff', title, 'btn btn-secondary-orio')
                } else {
                    notify("danger", "Error", result.message);
                    destroyLoader('update_tariff', title, 'btn btn-secondary-orio')
                }
            },
            error: function (xhr, err) {
                destroyLoader('update_tariff', title, 'btn btn-secondary-orio')
                var errorMessage = xhr.responseJSON.message;
                notify("warning", errorMessage);
            }
        });
    });

});

// for removing the rows 
$(document).on('click', '.remove_row', function () {
    var no = $(this).data('count');
    var type = $(this).data('type');
    var id = '#' + type + '_hidden_input_' + no;
    $(id).remove();
    $(this).parent().parent().remove();
});

$(document).on('change','#destination_country',function(){
    var id = $(this).val();
    const originalOptions = `<option value="T-1">Tier-1</option><option value="T-2">Tier-2</option><option value="T-3">Tier-3</option>`;
    if(id != '395')
    {
        $('#region_type').html('<option value="DEF">Default</option>')   
    }else{
        $('#region_type').html(originalOptions)           
    }
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
            service_id: null, origin_country: null, destination_country: null,
            origin_country_name: null, destination_country_name: null, service_name: null,
            tarif_service_name: null, region_type: null, start_weight: null, end_weight: null,
            charges: null, add_weight: null, add_charges: null, rto_charges: null,
            add_rto_weight: null, add_rto_charges: null, handling_service_name: null,
            min_amt: null, max_amt: null, handling_charges: null, handling_charges_type: null,
            deducton_type: null, deducton_type_label: null, additional_service_name: null,
            add_charges_type: null, add_charges_name: null, add_charges_amt: null,
            additional_charges_type: null, additional_deduction_type: null
        };
        

        if (type === "tarrif") {
            def_class = '.default-tarif';
            rowData.service_id = $thisForm.find('select[name="service_name"]').val();
            rowData.tarif_service_name = $thisForm.find('select[name="service_name"]').val();
            rowData.region_type = $thisForm.find('select[name="region_type"]').val();
            rowData.start_weight = $thisForm.find('input[name="start_weight"]').val();
            rowData.end_weight = $thisForm.find('input[name="end_weight"]').val();
            rowData.charges = $thisForm.find('input[name="charges"]').val();
            rowData.add_weight = $thisForm.find('input[name="add_weight"]').val();
            rowData.add_charges = $thisForm.find('input[name="add_charges"]').val();
            rowData.rto_charges = $thisForm.find('input[name="rto_charges"]').val();
            // rowData.add_rto_weight = $thisForm.find('input[name="add_rto_weight"]').val();
            rowData.add_rto_charges = $thisForm.find('input[name="add_rto_charges"]').val();
            rowData.origin_country = $thisForm.find('select[name="origin_country"]').val();
            rowData.destination_country = $thisForm.find('select[name="destination_country"]').val();

            rowData.service_name = $thisForm.find('select[name="service_name"] option:selected').text();
            rowData.origin_country_name = $thisForm.find('select[name="origin_country"] option:selected').text();
            rowData.destination_country_name = $thisForm.find('select[name="destination_country"] option:selected').text();
        } else if (type === "handling") {
            def_class = '.default-handling';
            rowData.handling_service_name = $thisForm.find('select[name="handling_service_name"]').val();
            rowData.deducton_type = $thisForm.find('select[name="handling_deduction_type"]').val();
            rowData.min_amt = $thisForm.find('input[name="min_amt"]').val();
            rowData.max_amt = $thisForm.find('input[name="max_amt"]').val();
            rowData.handling_charges = $thisForm.find('input[name="handling_charges"]').val();
        } else if (type === "additional") {
            def_class = '.default-additional';
            rowData.service_id = $thisForm.find('select[name="additional_service_name"]').val();
            rowData.additional_deduction_type = $thisForm.find('select[name="additionl_deduction_type"]').val();
            rowData.additional_service_name = $thisForm.find('select[name="additional_service_name"]').val();
            rowData.add_charges_type = $thisForm.find('select[name="add_charges_type"]').val();
            rowData.add_charges_amt = $thisForm.find('input[name="additional_amt"]').val();
            rowData.add_charges_name = $thisForm.find('select[name="add_charges_type"] option:selected').text();
            rowData.service_name = $thisForm.find('select[name="additional_service_name"] option:selected').text();
        }


        if ((parseInt(rowData.deducton_type) == 1) || (parseInt(rowData.additional_deduction_type) == 1)) {
            rowData.deducton_type_label = "Flat";
        } else if ((parseInt(rowData.deducton_type) == 2) || (parseInt(rowData.additional_deduction_type) == 2)) {
            rowData.deducton_type_label = "Percentage";
        }
        // ${rowData.add_rto_weight !== null ? `<td>${rowData.add_rto_weight}</td>` : ``}
        rows += `<tr>
            ${rowData.count !== null ? `<td>${rowData.count}</td>` : ``}
            ${rowData.service_name !== null ? `<td>${rowData.service_name}</td>` : ``}
            ${rowData.origin_country !== null ? `<td>${rowData.origin_country_name}</td>` : ``}
            ${rowData.destination_country !== null ? `<td>${rowData.destination_country_name}</td>` : ``}
            ${rowData.deducton_type_label !== null ? `<td>${rowData.deducton_type_label}</td>` : ``}
            ${rowData.region_type !== null ? `<td>${rowData.region_type}</td>` : ``}
            ${rowData.start_weight !== null ? `<td>${rowData.start_weight}</td>` : ``}
            ${rowData.end_weight !== null ? `<td>${rowData.end_weight}</td>` : ``}
            ${rowData.charges !== null ? `<td>${rowData.charges}</td>` : ``}
            ${rowData.add_weight !== null ? `<td>${rowData.add_weight}</td>` : ``}
            ${rowData.add_charges !== null ? `<td>${rowData.add_charges}</td>` : ``}
            ${rowData.rto_charges !== null ? `<td>${rowData.rto_charges}</td>` : ``}
            ${rowData.add_rto_charges !== null ? `<td>${rowData.add_rto_charges}</td>` : ``}
            ${rowData.min_amt !== null ? `<td>${rowData.min_amt}</td>` : ''}
            ${rowData.max_amt !== null ? `<td>${rowData.max_amt}</td>` : ''}
            ${rowData.handling_charges !== null ? `<td>${rowData.handling_charges}</td>` : ``}
            ${rowData.add_charges_name !== null ? `<td>${rowData.add_charges_name}</td>` : ``}
            ${rowData.add_charges_amt !== null ? `<td>${rowData.add_charges_amt}</td>` : ``}
            <td><button type="button" class="btn btn-danger p-2 btn-sm remove_row" data-type="${type}" style="min-width: 10px !important" data-count="${rowData.count}"><i class="fa-solid fa-trash"></i></button></td>
        </tr>`;

        // Append only if the value is not null or undefined
        fields += `<div id="${type}_hidden_input_${rowData.count}">
            ${rowData.service_id !== null ? `<input type="hidden" name="service_name[]" value="${rowData.service_id}">` : ''}
            ${rowData.origin_country !== null ? `<input type="hidden" name="origin_country[]" value="${rowData.origin_country}">` : ''}
            ${rowData.destination_country !== null ? `<input type="hidden" name="destination_country[]" value="${rowData.destination_country}">` : ''}
            ${rowData.tarif_service_name !== null ? `<input type="hidden" name="tarif_service_name[]" value="${rowData.tarif_service_name}">` : ''}
            ${rowData.additional_service_name !== null ? `<input type="hidden" name="additional_service_name[]" value="${rowData.additional_service_name}">` : ''}
            ${rowData.region_type !== null ? `<input type="hidden" name="region_type[]" value="${rowData.region_type}">` : ''}
            ${rowData.start_weight !== null ? `<input type="hidden" name="start_weight[]" value="${rowData.start_weight}">` : ''}
            ${rowData.end_weight !== null ? `<input type="hidden" name="end_weight[]" value="${rowData.end_weight}">` : ''}
            ${rowData.charges !== null ? `<input type="hidden" name="charges[]" value="${rowData.charges}">` : ''}
            ${rowData.add_weight !== null ? `<input type="hidden" name="add_weight[]" value="${rowData.add_weight}">` : ''}
            ${rowData.add_charges !== null ? `<input type="hidden" name="add_charges[]" value="${rowData.add_charges}">` : ''}
            ${rowData.rto_charges !== null ? `<input type="hidden" name="rto_charges[]" value="${rowData.rto_charges}">` : ''}
            ${rowData.add_rto_charges !== null ? `<input type="hidden" name="add_rto_charges[]" value="${rowData.add_rto_charges}">` : ''}
            ${rowData.min_amt !== null ? `<input type="hidden" name="min_amt[]" value="${rowData.min_amt}">` : ''}
            ${rowData.max_amt !== null ? `<input type="hidden" name="max_amt[]" value="${rowData.max_amt}">` : ''}
            ${rowData.handling_charges !== null ? `<input type="hidden" name="handling_charges[]"  value="${rowData.handling_charges}">` : ''}
            ${rowData.deducton_type !== null ? `<input type="hidden" name="handling_deduction[]"  value="${rowData.deducton_type}">` : ''}
            ${rowData.additional_deduction_type !== null ? `<input type="hidden" name="additional_deduction[]"  value="${rowData.additional_deduction_type}">` : ''}
            ${rowData.add_charges_type !== null ? `<input type="hidden" name="add_charges_type[]"  value="${rowData.add_charges_type}">` : ''}
            ${rowData.add_charges_amt !== null ? `<input type="hidden" name="add_charges_amt[]"  value="${rowData.add_charges_amt}">` : ''}
            </div>`;
    });
    $(def_class).remove()
    $(display_table).append(rows);
    $(input_hidden).append(fields);
    // ${rowData.add_rto_weight !== null ? `<input type="hidden" name="add_rto_weight[]" value="${rowData.add_rto_weight}">` : ''}
}

function checkForDuplicateRows(form_id, forms, input_hidden) {
    var msg = null;
    if (input_hidden == '#tariff_hidden_feilds') {
        var formDataText = [
            forms.find('[name="service_name"]').val(),
            forms.find('[name="origin_country"]').val(),
            forms.find('[name="destination_country"]').val(),
            forms.find('[name="region_type"]').val(),
            forms.find('[name="start_weight"]').val(),
            forms.find('[name="end_weight"]').val()
        ].join('');
        var isDuplicate = false;
        var rows = $(input_hidden).find('div');
        var ServiceName = forms.find('[name="service_name"]').val();
        var originCountry = forms.find('[name="origin_country"]').val();
        var destinationCountry = forms.find('[name="destination_country"]').val();
        var RegionType = forms.find('[name="region_type"]').val();
        var startWeight = parseFloat(forms.find('[name="start_weight"]').val());
        var endWeight = parseFloat(forms.find('[name="end_weight"]').val());

        rows.each(function () {
            var $row = $(this);
            var rowServiceName = $row.find('[name="service_name[]"]').val();
            var rowOriginCountry = $row.find('[name="origin_country[]"]').val();
            var rowDestinationCountry = $row.find('[name="destination_country[]"]').val();
            var rowRegionType = $row.find('[name="region_type[]"]').val();
            var rowStartWeight = parseFloat($row.find('[name="start_weight[]"]').val());
            var rowEndWeight = parseFloat($row.find('[name="end_weight[]"]').val());
            var rowData = [
                rowServiceName,
                rowOriginCountry,
                rowDestinationCountry,
                rowRegionType,
                $row.find('[name="start_weight[]"]').val(),
                $row.find('[name="end_weight[]"]').val()
            ].join('');
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
            if (ServiceName === rowServiceName && RegionType === rowRegionType) {
                if((originCountry == rowOriginCountry) && (destinationCountry == rowDestinationCountry))
                {
                    if (startWeight === rowStartWeight || startWeight <= rowStartWeight) {
                        msg = "Start weight overlaps with an existing range.";
                        isDuplicate = true;
                        return false;
                    } else if (endWeight == rowEndWeight || endWeight <= rowEndWeight) {
                        msg = "End weight overlaps with an existing range.";
                        isDuplicate = true;
                        return false;
                    }
                }
            }
        });
    }
    if (input_hidden == '#handling_hidden_feilds') {
        var formDataText = [
            forms.find('[name="handling_deduction_type"]').val(),
            forms.find('[name="min_amt"]').val(),
            forms.find('[name="max_amt"]').val()
        ].join('');
        var DeductionType = forms.find('[name="handling_deduction_type"]').val();
        var min_amt = parseFloat(forms.find('[name="min_amt"]').val());
        var max_amt = parseFloat(forms.find('[name="max_amt"]').val());
        var isDuplicate = false;
        var rows = $(input_hidden).find('div');
        rows.each(function () {
            var $row = $(this);
            var rowDeduction = $row.find('[name="handling_deduction[]"]').val();
            var rowMinAmt = parseFloat($row.find('[name="min_amt[]"]').val());
            var rowMaxAmt = parseFloat($row.find('[name="max_amt[]"]').val());
            var rowData = [
                rowDeduction,
                $row.find('[name="min_amt[]"]').val(),
                $row.find('[name="max_amt[]"]').val()
            ].join('');
            if (formDataText === rowData) {
                msg = "Dulplicate entry please enter unique data.";
                isDuplicate = true;
                return false;
            }
            if (min_amt == max_amt) {
                msg = "Minimum ammount should not be equal to maximum ammount.";
                isDuplicate = true;
                return false;
            }
            if (min_amt >= max_amt) {
                msg = "Minimum ammount should not be greater maximum ammount.";
                isDuplicate = true;
                return false;
            }
            if (DeductionType == rowDeduction) {
                if (min_amt <= rowMinAmt) {
                    msg = "Minimum ammount should be greater then previous one."
                    isDuplicate = true;
                    return false;
                } else if (max_amt <= rowMaxAmt) {
                    msg = "Maximum ammount should be greater then previous one."
                    isDuplicate = true;
                    return false;
                }

            }

        });
    }
    if (input_hidden == '#additional_hidden_feilds') {
        var formDataText = [
            forms.find('[name="additional_service_name"]').val(),
            forms.find('[name="add_charges_type"]').val(),
            forms.find('[name="additionl_deduction_type"]').val()
        ].join('');
        var ServiceName = forms.find('[name="additional_service_name"]').val();
        var ChargesType = forms.find('[name="add_charges_type"]').val();
        var isDuplicate = false;
        var rows = $(input_hidden).find('div');
        rows.each(function () {
            var $row = $(this);
            var rowData = [
                $row.find('[name="service_name[]"]').val(),
                $row.find('[name="additional_deduction[]"]').val(),
                $row.find('[name="add_charges_type[]"]').val()
            ].join('');
            var RowServiceName = $row.find('[name="service_name[]"]').val();
            var RowChargesType = $row.find('[name="add_charges_type[]"]').val();
            if (formDataText === rowData) {
                msg = "Dulplicate entry please enter unique data.";
                isDuplicate = true;
                return false;
            }
            if (ServiceName === RowServiceName && ChargesType === RowChargesType) {
                msg = "Service can not accept similar charges.";
                isDuplicate = true;
                return false;
            }
        });
    }
    if (isDuplicate) {
        return { "status": 0, "msg": msg }
    } else {
        return { "status": 1, "msg": msg }
    }

}
