const btn_html = `
    <div class="btn-group btn-group-split px-2 py-3" id="append_btn_div">
        <div id="create-btn-div" class="icn-container float-left pl-4">
            <div class="hover-icon" id="hover-icon-1-584">
                <a href="javascript:void(0);" id="generate_pickup"
                    class="btn btn-sm btn-secondary-sm mr-2" style="background-color: #e4e6eb"
                    data-toggle="tooltip" data-original-title="Assign Pickup"><i
                        class="fa-solid fa-dolly"></i></a>
            </div>
        </div>
    </div>
`;

$("#check_all").click(function () {
    if ($(this).prop('checked') == true) {
        $(".check_box").prop('checked', true);
        $('.riders').removeAttr('disabled');
    } else {
        $('.riders').attr('disabled', 'true');
        $('.riders').val('').trigger('change');
        $(".check_box").prop('checked', false);
    }
    check_all();
});
$(document).on('click', '.check_box', function () {
    var check_val = $(this).data('key');
    if ($(this).prop('checked')) {
        $('.riders_id_' + check_val).removeAttr('disabled');
    } else {
        $('.riders_id_' + check_val).attr('disabled', 'true');
        $('.riders_id_' + check_val).val('').trigger('change');
    }
    check_all();
});
let check_all = (elem) => {
    var mylabel = $('.dataTables_wrapper table').find('.check_box');
    mylabel.each(function () {
        var l = $('.dataTables_wrapper table').find('.check_box:checked').length;
        if (l > 0) {
            $('.applyall').html(btn_html);
            $('#append_btn_div').slideDown();
        } else {
            $('#append_btn_div').slideUp();
        }
    });
};
$(document).on('click', '#generate_pickup', function () {
    var checkedValues = [];
    allValid = true;
    $('.check_box:checked').each(function () {
        var check_key = $(this).data('key');
        var sheet_no = $(this).val();
        if (sheet_no == '') {
            notify("danger", "Oh snap!", "Please select rider !");
            allValid = false;
            return false
        }
        var selectElement = $('.riders_id_' + check_key).val();
        if (selectElement == '') {
            $('.riders_id_' + check_key).parsley().validate();
            allValid = false;
            return false;
        }
        let data = {
            'sheet_no': sheet_no,
            'rider_id': selectElement
        };
        checkedValues.push(data);
    });
    if (!allValid) {
        return;
    }
    swal.fire({
        title: 'Confirmation',
        text: 'Are you sure you want to assign driver ?',
        type: 'question',
        showCancelButton: true,
        buttonsStyling: !1,
        confirmButtonText: 'Yes, assign !',
        cancelButtonText: 'No, cancel',
        confirmButtonClass: "btn btn-orio",
        cancelButtonClass: "btn btn-secondary-orio mx-3"
    }).then(t => {
        t.value && $.ajax({
            url: BASEURL + 'generate-assign-driver',
            type: 'POST',
            data: {
                values: checkedValues
            },
            success: function (result) {
                if (result.status == 1) {
                    notify("success", result.message, result.payload);
                    $('#append_btn_div').addClass('d-none').slideUp();
                    $('#append_btn_div').removeClass('d-block').slideUp();
                    $("#example").DataTable().ajax.reload();
                } else {
                    notify("danger", result.message, result.payload);
                }
            },
            error: function (xhr, err) {
                notify("warning", "Oh snap!", "Something went wrong");
            }
        });
    });
});
