<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../Core.php');
    $SKTDB = \CmsDev\sql\db_Skt::connect();
}

use \CmsDev\skt_Code as Code;

$file = Code::Decode($_POST['File']);
if (file_exists($file)) {

    $Name = explode("_FileSystems", $file);
    $NameOnly = str_replace('\\', '', $Name[count($Name) - 1]);
    $ext = strtolower(substr($NameOnly, strrpos($NameOnly, ".") + 1, 3));

    $Metadata = new \CmsDev\AdminFilesystem\Metadata();
    $Metadata->File($file);

    ?>
    <input type="hidden" id="File" value="<?php echo Code::Encode($file); ?>" name="File"/>
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 15px;">
            <input name="CustomProperty" id="CustomProperty" type="text" value="<?php echo SKTServerURL . 'SKTSize' . $NameOnly ?>"  class="form-control" />
        </div>
    </div>
    <div class="row">
        <?php
        if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $ext == 'bmp') {
            ?>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <img src="<?php echo SKTServerURL . 'SKTSize' . $NameOnly ?>|250x150" alt="" class="img-responsive" style="max-height: 130px;"/>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label><span><?php echo \SKT_ADMIN_IMAGE_FileNewFileX ?></span></label>
                <input name="FileNewFileX" id="FileNewFileX" type="text" value="" class="form-control"/>
                <div class="clear"></div>
                <label><span><?php echo \SKT_ADMIN_IMAGE_FileNewFileY ?></span></label>
                <input name="FileNewFileY" id="FileNewFileY" type="text" value="" class="form-control"/>
            </div>
            <div class="clear"></div>
            <?php
        } else {
            echo '<i class="skt-icon-' . $ext . '" style="font-size: 60px;"></i>';
        }
        ?>
        <div class="col-md-12">
            <h3><?php echo \SKT_ADMIN_adicionalTagsTitle ?></h3>
        </div>
        <div class="clear"></div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <span>Titulo</span>
            <input id="Title" type="text" name="Title" value="<?php echo $Metadata->File_Title() ?>" style="width:100%;" class="form-control"/>
            <span><?php echo \SKT_ADMIN_adicionalTagsLink ?></span>
            <input id="hiperlink" type="text" name="hiperlink" value="<?php $Metadata->File_Hiperlink(); ?>" style="width:100%;" class="form-control"/>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <span><?php echo \SKT_ADMIN_adicionalTagsDescription ?></span>
            <textarea id="TagsDescription" name="TagsDescription" style="width:100%;"class="form-control"><?php echo $Metadata->File_Description(); ?></textarea>
            <input id="FileOrder" type="hidden" name="FileOrder" value="<?php echo $Metadata->File_Order(); ?>" class="form-control"/>
        </div>
        <div class="clear"></div>
        <div class="col-md-12">
            <span>Custom Data</span>
            <textarea id="CustomData" name="CustomData" style="width:100%;"class="form-control"><?php echo $Metadata->File_CustomData(); ?></textarea>
        </div>
    </div>
    <div class="clear"></div>

    <?php
}
?>