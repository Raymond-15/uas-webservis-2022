$("#in_1").hide();
$("#in_2").hide();
$("#in_3").hide();
$("#simple-date1").hide();
$("#simple-date2").hide();
$("#simple-date4").hide();

$("#rep").change(function () {
    var x = document.getElementById("rep").value;
    if (x == 2) {
        // $("#pp").html(x);
        $("#in_1").show();
        $("#in_2").hide();
        $("#in_3").hide();
        $("#simple-date1").show();
        $("#simple-date2").show();
        $("#simple-date4").show();
    } else if (x == 3) {
        $("#in_1").hide();
        $("#in_2").show();
        $("#in_3").hide();
    } else if (x == 4) {
        $("#in_1").hide();
        $("#in_2").hide();
        $("#in_3").show();
    } else if (x == 0 || x == 1) {
        $("#in_1").hide();
        $("#in_2").hide();
        $("#in_3").hide();
        $("#simple-date1").show();
        $("#simple-date2").hide();
        $("#simple-date4").show();
    }
});
