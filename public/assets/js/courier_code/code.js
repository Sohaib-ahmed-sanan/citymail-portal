
/* ------------------------------- add form ------------------------------ */
$("#add-code-btn").click(function (e) {
    var form_id = $(this).closest('.modal-content').find('form').attr('id');
    var title = $(this).html()
    var forms = $("#" + form_id);
    forms.parsley().validate();
    initLoader('add-code-btn', title, 'btn-orio');
    if (!forms.parsley().isValid()) {
        destroyLoader('add-code-btn', title, 'btn btn-orio')
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        var formdata = new FormData($("#" + form_id)[0]);
        var route = $('#add_code_url').val();
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
                    $("#code_modal").modal("hide");
                    $("#" + form_id)[0].reset();
                    $("#example").DataTable().ajax.reload();
                    destroyLoader('add-code-btn', title, 'btn btn-orio')
                } else if (result.status === 0) {
                    notify("danger", result.message, result.payload);
                    destroyLoader('add-code-btn', title, 'btn btn-orio')
                }
            },
            error: function (xhr, err) {
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
                destroyLoader('add-code-btn', title, 'btn btn-orio')
            }
        });

    }
});

/* ------------------------------- for displaying edit modal ------------------------------ */
$(document).on("click", ".view-codes", function (e) {
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
            $("#append").html(response);
            $("#code_edit_modal").modal("show");
            $(".btn-type").html("List");
        },
    });
});

$(document).on("click",".edit-code",function (e) {
    var route = $(this).data('route'); 
    var id = $(this).data('id'); 
    var code_input = $(this).closest('tr').find('input').val()   
    // return false
    if (code_input != '') {
        $.ajax({
            url: route,
            type: "POST",
            data: {
                id : id,
                code : code_input,
            },
            success: function (result) {
                if (result.status == 1) {
                    swal.fire({
                        icon: "success",
                        title: result.message,
                        text: result.payload,
                        confirmButtonClass: "btn-success",
                        type: "success",
                    });
                    $("#code_edit_modal").modal("hide");
                    $("#" + form_id)[0].reset();
                    $("#example").DataTable().ajax.reload();
                } else if (result.status == 0) {
                    notify("danger", result.message, result.payload);
                }
            },
            error: function (xhr, err) {
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
            }
        });
    }else{
        notify("danger", "Error","Code feild should not be empty");
    }
});


