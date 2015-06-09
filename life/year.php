<?php
    include("header.php");
	include("events.php");

    $date = $_GET["date"];
    $year = date("Y", strtotime($date));

	$events = new Events();
	$eventsForYear = $events->eventsForYear($year);

	$phasesDuringDate = $events->phasesDuringDate(new DateTime($date));
?>

<script src="js/events.js"></script>
<link rel="stylesheet" href="css/year.css" />

<div class="row">
    <div class="large-12 columns">
        <h1><?=$year?></h1>
    </div>
</div>

<div class="row lifetime">
    <div class="large-12 columns">
        <div id="phases">
        	<?php
        	foreach ($phasesDuringDate as $phase) {
    		?>
				<div class="phase">
					<?=$phase["emoji"]?>
					<span class="description">
						<?=$phase["description"]?>
					</span>
				</div>
			<?php
        	}
        	?>
        </div>
        <div id="dates">
        	<?php
			foreach ($eventsForYear as $event) {
                $dateFormatted = $event["date"]->format("F j");
			?>
				<div class="event">
                    <?=$dateFormatted?>
					<?=$event["emoji"]?>
					<?=$event["description"]?>
				</div>
			<?php
			}
        	?>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
