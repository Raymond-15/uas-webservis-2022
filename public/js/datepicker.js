// Bootstrap Date Picker
$("#datestart").datepicker({
    defaultDate: new Date(),
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    todayHighlight: true,
    autoclose: true,
});

$("#dateend").datepicker({
    defaultDate: new Date(),
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    todayHighlight: true,
    autoclose: true,
});

$("#clockPicker1").clockpicker();

$("#clockPicker2").clockpicker();
