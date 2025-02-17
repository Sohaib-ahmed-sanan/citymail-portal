Datepicker = (function () {
    var e = $('[data-toggle="datepicker"]');
    e.length && e.each((function () {
        $(this).datepicker({disableTouchKeyboard: !0, autoclose: !0,format: 'dd-mm-yyyy'})
    }))
})()
