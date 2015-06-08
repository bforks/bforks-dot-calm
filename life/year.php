<?php
    include("header.php");

    $date = $_GET["date"];
    $year = date("Y", strtotime($date));
?>

<link rel="stylesheet" href="css/year.css" />

<script type="text/javascript">
    function addPhase(phase) {
    var phaseElement = document.createElement("div");
    phaseElement.className = "phase";

    phaseElement.innerHTML = phase["emoji"] + " ";

    var phaseDescriptionElement = document.createElement("span");
    phaseDescriptionElement.className = "description";
    phaseDescriptionElement.innerHTML = phase["description"];
    phaseElement.appendChild(phaseDescriptionElement);

    $("#phases").append(phaseElement);
}

function addEvent(date, eventItem) {
    var eventElement = document.createElement("div");
    eventElement.className = "event";

    var dateElement = document.createElement("div");
    dateElement.className = "date";
    dateElement.innerHTML = date;
    eventElement.appendChild(dateElement);

    var emojiElement = document.createElement("div");
    emojiElement.className = "emoji";
    emojiElement.innerHTML = eventItem["emoji"];
    eventElement.appendChild(emojiElement);

    var descriptionElement = document.createElement("div");
    descriptionElement.className = "description";
    descriptionElement.innerHTML = eventItem["description"];
    eventElement.appendChild(descriptionElement);

    $("#dates").append(eventElement);
}

$(document).ready(function() {
    var date = Dates["<?=$date?>"];

    // Find phases
    for (phaseno in Phases) {
        var phase = Phases[phaseno];

        var thisDate = new Date("<?=$date?>");
        var startDate = new Date(phase["start"]);
        var endDate = new Date(phase["end"]);

        if ( (thisDate >= startDate) && (thisDate < endDate) ) {
            addPhase(phase);
        }
    }

    // Iterate through all events, find those who match the appropriate year
    var yearDates = []
    for (var date in Dates) {
        if (date.substring(0, 4) == "<?=$year?>") {
            yearDates[date] = date;
        }
    }

    // For clarity, separately loop through all found dates
    for (var date in yearDates) {
        var eventItem = Dates[date];
        addEvent(date, eventItem);
    }
});

</script>

<div class="row">
    <div class="large-12 columns">
        <h1><?=$year?></h1>
    </div>
</div>

<div class="row lifetime">
    <div class="large-12 columns">
        <div id="phases"></div>
        <div id="dates"></div>
    </div>
</div>

<?php include("footer.php"); ?>
