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
    $Metadata = new \CmsDev\AdminFilesystem\Metadata();
    $Metadata->File($file);
    
    $Name = explode("_FileSystems", $file);
    $NameOnly = str_replace('\\', '', $Name[count($Name) - 1]);
    $ext = strtolower(substr($NameOnly, strrpos($NameOnly, ".") + 1, 3));
    if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $ext == 'bmp') {
        echo '<img src="' . SKTServerURL . 'SKTSize' . $NameOnly . '" alt="" class="img-responsive" style="max-height: 300px"/>';
    }
    ?>
    <input type="hidden" id="File" value="<?php echo Code::Encode($file); ?>" name="File"/>
    <div style="width:100%;" class="row">
        <div class="col-md-12">
            <h3><?php echo \SKT_ADMIN_adicionalTagsTitle ?></h3>
        </div>
        <div class="col-md-6">
            <span>Titulo</span>
            <input id="Title" type="text" name="Title" value="<?php echo $Metadata->File_Title() ?>" style="width:100%;" class="form-control"/>
            <span><?php echo \SKT_ADMIN_adicionalTagsLink ?></span>
            <input id="hiperlink" type="text" name="hiperlink" value="<?php echo $Metadata->File_Hiperlink() ?>" style="width:100%;" class="form-control"/>
        </div>
        <div class="col-md-6">
            <span><?php echo \SKT_ADMIN_adicionalTagsDescription ?></span>
            <textarea id="TagsDescription" name="TagsDescription" style="width:100%;"class="form-control"><?php echo  $Metadata->File_Description() ?></textarea>
            <input id="FileOrder" type="hidden" name="FileOrder" value="<?php echo  $Metadata->File_Order() ?>" class="form-control"/>
        </div>
        <div class="col-md-12">
            <span>Custom Data</span>
            <textarea id="CustomData" name="CustomData" style="width:100%;"class="form-control"><?php echo  $Metadata->File_CustomData() ?></textarea>
        </div>
    </div>
    <div class="clear"></div>

    <?php
}
?>