$(function () {
    $('[data-toggle="custom-select2"]').each(function () {
        $(this).select2({
            theme: 'bootstrap4',
            width: 'element',
            placeholder: $(this).attr('placeholder'),
            allowClear: Boolean($(this).data('allow-clear'))
        });
    });
});
