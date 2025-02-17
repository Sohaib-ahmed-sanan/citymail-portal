$(document).ready(function () {
    $.ajax({
        url: route,
        method: 'POST',
        data: {
            token: $('#token').val(),
            tabel: $('#tabel').val()
        },
        success: function (result) {
            if (result.status == 1) {
                notify("success", "Success", result.message);
                window.setTimeout(function () {
                    window.location.href = BASEURL + '/';
                }, 1000);
            } else {
                notify("danger", "Error", result.message);
                window.setTimeout(function () {
                    window.location.href = BASEURL + '/';
                }, 1000);
            }
        },
        error: function (xhr, status, error) {
            notify("warning", "Oh snap!", "Something went wrong");
        }
    });
});