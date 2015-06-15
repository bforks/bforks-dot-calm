<?php
	include("header.php");
	include("events.php");
?>

<script src="../lib/dateFormat.js"></script>
<script src="js/events.js"></script>
<script src="js/life.js"></script>

<div class="pink-band">
    <div class="row">
        <div class="strawberry"><img src="../img/strawberry.png"></div>
    </div>

    <div class="row">
        <div class="large-12 small-12 columns about">
            <p>Hello, I'm Brittany Forks. I'm a designer, illustrator, and crafter. I'm in love with the internet. I'm also a published author.</p>

            <p>In 2009, I wrote a book with Random House called Kilobyte Couture. It's a how-to book on making fancy jewelry out of computer components. You can check it out on <a href="http://www.amazon.com/Kilobyte-Couture-Easy-To-Find-Computer-Components/dp/0823099024" target="_blank" class="green">Amazon</a>.</p>

            <p>Lately, I've been illustrating more. Improving your craft should be a lifelong goal. At least, that's what I believe. Check out how my skills are progressing on <a href="/work" class="purple">my portfolio</a> or <a href="http://dribbble.com/brittanyforks" class="pink">Dribbble</a>.</p>

            <p>When I'm not designing at Twitter &mdash; I'm exploring San Francisco, polishing my nails at <a href="http://nailconf.com" target="_blank" class="pink">#nailconf</a>, having opinions on <a href="https://twitter.com/#!/brittanyforks" target="_blank"class="blue">twitter</a>, or posting pics on <a href="http://instagram.com/brittanyforks" target="_blank" class="green">instagram</a>.</p>
        </div>
    </div>
</div>


<div class="row">
    <div class="large-12 small-12 columns life-descript">
        <h1>eLife</h1>
        <p>This is the story of my life told in emoji, every dark pink dot represents a week i've been alive...</p>
    </div>
</div>

<div class="row lifetime">
    <div class="large-12 small-12 columns">
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
				// class = "week empty past";


				$diff = $today->diff($startDate);
				if ($diff->invert == 1) {
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

<div class="row">
    <div class="large-12 small-12 columns thanks">
        <p>👏 Special thanks to <a href="http://james.magahern.com">James</a> and
        <a href="http://twitter.com/x5315">Tom</a> for helping me build this representation of my life.
        Also big thanks to <a href="http://busterbenson.com">Buster Benson</a> for giving me the inspiration to create my own life graph.</p>
    </div>
</div>

<br />
<br />
<br />

<?php include("footer.php"); ?>
