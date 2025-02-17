let datalist = (start, end, label) => {
    var title = "";
    var range = "";
    var rangejson = "";
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
     $("#example").DataTable({
        destroy: true,
        responsive: true,
        dom: '<"row"<"col-md-4 d-flex align-items-center"l><"col-md-8 d-flex align-items-center" fB>><"table-responsive" t><"table-footer-wrapper" <"divider"> <"row"<"col-md-6 d-flex align-items-center" il><"col-md-6 d-flex align-items-center" p>>>',
        buttons: [
          'excelHtml5',
          'csvHtml5',
          {
            extend: 'colvis',
            collectionLayout: 'fixed two-column'
          }
        ],
        order: [
            [0, "desc"]
        ],
        ordering: true,
        rowReorder: true,
        searchDelay: 200,
        processing: true,
        serverSide: false,
        lengthMenu: [[50, 100, 200], [50, 100, 200]],
        ajax: {
          url: listRoute,
          type: "POST",
          data: {
              start_date: start_date,
              end_date: end_date,
          },
        },
         aoColumns: [{
              data: "SNO"
            },
            {
              data: "ACCTITLE",
              visible: false,
            },
            {
              data: "NAME"
            },
            {
              data: "EMAIL"
            },
            {
              data: "PHONE"
            },
            {
              data: "ADDRESS"
            },
            {
              data: "STATUS"
            },
            {
              data: "ACTIONS"
            },
        ],
      });
};

$(document).ready(function () {
    initSelect2();
    var picker = $("#datepicker");
    var start = moment().subtract(3, "days");
    var end = moment();
    picker.daterangepicker(
        {
            startDate: start,
            endDate: end,
            opens: "left",
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [
                    moment().subtract(1, "month").startOf("month"),
                    moment().subtract(1, "month").endOf("month"),
                ],
            },
        },
        function (start, end, label) {
            datalist(start, end, label);
        }
    );
    datalist(start, end, "");
});


$("#addAccount").click(function (e) {
    var forms = $("#sub_account_form");
    var title = "Save";
    forms.parsley().validate();
    if (!forms.parsley().isValid()) {
        return false;
    }
    e.preventDefault();
    if (forms.parsley().isValid()) {
        initLoader('addAccount', 'btn-orio');
        var formdata = new FormData($("#sub_account_form")[0]);
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
                    swal.fire({
                        icon: "success",
                        title: result.message,
                        text: result.payload,
                        confirmButtonClass: "btn-success",
                        type: "success",
                    });
                    window.setTimeout(function () {
                        window.location.href = BASEURL + 'customer-sub-accounts';
                    }, 2000);
                    destroyLoader('addAccount', title, 'btn btn-orio')
                } else {
                    destroyLoader('addAccount', title, 'btn btn-orio')
                    notify("danger", result.message, result.payload);
                }
            },
            error: function (xhr, err) {
                var errorMessage = xhr.responseJSON.message;
                notify("danger", errorMessage);
                destroyLoader('addAccount', title, 'btn btn-orio')
            }
        });
    }
});

// $('.main_menu').
$(".main_menu").click(function () {
    var main_id = $(this).data('main-id');
    var $subMenus = $(".sub_menu[data-parent-id='"+main_id+"']");
    var isChecked = $(this).prop('checked');
    $subMenus.prop('checked', isChecked);
});
$(".sub_menu").click(function(){
    var main_id = $(this).data("parent-id");
    var all_unchecked = $(".sub_menu[data-parent-id='"+main_id+"']").filter(":checked").length === 0
     if (all_unchecked) {
        $('#' + main_id).prop('checked', false);
    } else {
        $('#' + main_id).prop('checked', true);
    }
});
