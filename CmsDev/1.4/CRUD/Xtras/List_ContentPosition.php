<?php
$total = $SKTDB->get_var("SELECT count(*) FROM " . DB_PREFIX . "content WHERE IDPage = '$PositionIDPage' AND IDZone = '$PositionIDZone'");
?>
<select name="Position">
    <?php
    for ($i = 1; $i < $total + 1; $i++) {
        if ($PositionSelect == $i) {
            echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
        } else {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    ?>
</select>