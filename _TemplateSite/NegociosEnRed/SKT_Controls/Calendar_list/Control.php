<?php
$internalsectionlist = 24;
$TitleCustom = 'Blog';
$ShowHidden = " RecycleBin = '0'  AND";
$SKTDB = \CmsDev\Sql\db_Skt::connect();

if ($LoggedInAdmin == true) {
    $ShowHidden = "";
}
if (isset($Zone->CustomProperty)) {
    if ($Zone->CustomProperty != '') {
        $internalsectionlist = $Zone->CustomProperty;
    }
    if ($Zone->Title != '') {
        $TitleCustom = $Zone->Title;
    }
}

$ShowDescription = isset($CCParams['Description']) ? $CCParams['Description'] : true;

$Section = $SKTDB->get_row("SELECT URLName FROM " . DB_PREFIX . "sections WHERE ID = '$internalsectionlist'");
$Projects = $SKTDB->get_results("SELECT * FROM " . DB_PREFIX . "sections WHERE $ShowHidden SID = '$internalsectionlist' ORDER BY datePost DESC LIMIT 50");
if ($Projects) {
    foreach ($Projects as $ProjectItem) {
        if ($ProjectItem->RecycleBin == 1) {
            $Recycled = 'Recycled';
        } else {
            $Recycled = '';
        }
        ?>

        <article class="post <?php echo $Recycled; ?>">
            <div class="post-inner">
                <h4 class="post-title"><a href="<?php echo SUBSITE . $Section->URLName . '/' . $ProjectItem->URLName . '/'; ?>" title="<?php echo $ProjectItem->Title; ?>"  class="color-1"><?php echo $ProjectItem->Title; ?></a></h4>
                <ul class="post-meta">
                    <li>
                        <i class="fa fa-calendar"></i> <a href="#"><?php echo date('d-m, Y', strtotime($ProjectItem->datePost)); ?></a>
                    </li>
                </ul>
                <?php if ($ShowDescription) { ?>
                    <p class="post-desciption"><?php echo $ProjectItem->Description; ?></p>
                <?php } ?>
                <a href="<?php echo SUBSITE . $Section->URLName . '/' . $ProjectItem->URLName . '/'; ?>" class="btn btn-small btn-primary">Leer m&aacute;s</a>
            </div>
        </article>


        <?php
    }
}
?>
