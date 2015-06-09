$(document).ready(function() {
    $(".week").click(function() {
        var date = $(this).attr("date");
        window.location = "year.php?date=" + date;
    });
});
