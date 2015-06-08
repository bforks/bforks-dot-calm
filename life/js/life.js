$(document).ready(function() {
    $(".week").click(function() {
        var date = $(this).attr("date");
        window.location = "year.php?date=" + date;
    });

    for (var date in Dates) {
        var item = Dates[date];

        var year = date.substring(0, 4);
        var month = date.substring(6, 7);
        var sdate = date.substring(9, 10)

        var jDate = new Date(Date.UTC(year, month, sdate));

        var year = jDate.getFullYear();
        var birthday = new Date();
        birthday.setFullYear(year);
        birthday.setUTCDate(1);
        birthday.setUTCMonth(4);

        jDate.setUTCDate(jDate.getUTCDate() + (jDate.getUTCDay() - birthday.getUTCDay()));

        var dateString = "";
        dateString += jDate.getFullYear() + "-";

        if (jDate.getUTCMonth() < 10) dateString += "0";
        dateString += jDate.getUTCMonth() + "-";

        if (jDate.getUTCDate() < 10) dateString += "0";
        dateString += jDate.getUTCDate();

        console.log("Date: " + dateString + " : " + item["emoji"]);

        var elem = $(".week[date='" + dateString + "']");

        elem.html(item["emoji"]);
        elem.attr("class", "week");
    }
});
