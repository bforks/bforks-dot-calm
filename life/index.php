<?php
	include("header.php");
	include("events.php");
?>

<script src="../lib/dateFormat.js"></script>
<script src="js/events.js"></script>
<script src="js/life.js"></script>

<div class="row">
    <div class="large-12 columns">
        <h1>Sup</h1>
    </div>
</div>

<div class="row lifetime">
    <div class="large-12 columns">
        <?php
			$events = new Events();
            $birthdate = new DateTime("4/1/1985");
            $today = new DateTime();

			$startDate = clone $birthdate;
			$endDate = clone $startDate;
			$endDate->add(new DateInterval("P100Y")); // 100 years

			$weekDict = $events->keyedWeekDictionary($birthdate);
		?>
		<div class="year">
		<?php
			$nextBirthday = clone $birthdate;
			$nextBirthday->add(new DateInterval("P1Y"));

			$weekCounter = 0;
			while ($startDate < $endDate) {
				$nextDate = clone $startDate;
				$nextDate->add(new DateInterval("P1W"));

				$diff = $nextDate->diff($nextBirthday);
				if ($diff->invert == 1 ) {
					echo "</div>\n";
					echo "<div class=\"year\">\n";

					$nextBirthday->add(new DateInterval("P1Y"));
				}


				$innerHTML = "";

				if ($startDate->getTimestamp() < $today->getTimestamp()) {
                   $weekClassName = "week empty past";
                } else {
                    $weekClassName = "week empty";
                }

				$dateStamp = $startDate->format("Y-m-d");

				if (array_key_exists($weekCounter, $weekDict)) {
					$eventsThisWeek = $weekDict[$weekCounter];

					// Only use the first event this week as the representative item
					$event = $eventsThisWeek[0];
					$innerHTML = $event["emoji"];
					$weekClassName = "week";
				}

				?>

				<div title="<?=$dateStamp?>" date="<?=$dateStamp?>" class="<?=$weekClassName?>"><?=$innerHTML?></div>

				<?php

				$weekCounter++;
				$startDate = $nextDate;
			}
			echo "</div>"

        ?>
    </div>
</div>

<br />
<br />
<br />

<?php include("footer.php"); ?>
