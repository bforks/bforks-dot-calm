<?php include("header.php"); ?>

<div class="row">
    <div class="large-12 columns">
        <h1>Sup</h1>
    </div>
</div>

<div class="row lifetime">
    <div class="large-12 columns">
        <?php
            $date = new DateTime("4/1/1985");
            $today = new DateTime();
            $thisYear = date("Y");
        ?>
        <?php for ($year = 1985; $year < (1985 + 100); $year++) { ?>
            <div class="year">
                <?php for ($i = 0; $i < 52; $i++) {
                    if ($date->getTimestamp() < $today->getTimestamp()) {
                        $weekClassName = "week empty past";
                    } else {
                        $weekClassName = "week empty";
                    }
                ?>
                    <div class="<?=$weekClassName?>" date="<?=$date->format("Y-m-d")?>"></div>

                <?php
                    // Add one week to $date
                    $date->add(new DateInterval("P1W"));
                } ?>
            </div>
        <?php } ?>
    </div>
</div>

<br />
<br />
<br />

<?php include("footer.php"); ?>
