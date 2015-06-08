$(document).ready(function() {
    $(".week").click(function() {
        var date = $(this).attr("date");
        window.location = "year.php?date=" + date;
    });

    for (var date in Dates) {
        var item = Dates[date];

        var elem = $(".week[date='" + date + "']");

        elem.html(item["emoji"]);
        elem.attr("class", "week");
    }
});
