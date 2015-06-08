<?php include("header.php"); ?>

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
            $startDate = new DateTime("4/1/1985");

            $date = clone $startDate;
            $today = new DateTime();
            $thisYear = date("Y");
        ?>
        <?php for ($year = 1985; $year < (1985 + 100); $year++) { ?>
            <div class="year">
                <?php
                for ($i = 0; $i < 52; $i++) {
                    if ($date->getTimestamp() < $today->getTimestamp()) {
                        $weekClassName = "week empty past";
                    } else {
                        $weekClassName = "week empty";
                    }

                    $dateString = $date->format("Y-m-d");
                ?>
                    <div title="<?=$dateString?>" class="<?=$weekClassName?>" date="<?=$dateString?>"></div>

                <?php
                    // Add one week to $date
                    $date->add(new DateInterval("P7D"));
                } ?>
            </div>
        <?php
            $startDate->add(new DateInterval("P1Y"));
            $date = clone $startDate;
        } ?>
    </div>
</div>

<br />
<br />
<br />

<?php include("footer.php"); ?>
