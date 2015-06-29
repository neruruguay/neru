<?php
$IDZoneColectObj = \CmsDev\Content\ZoneColect::init();
$IDZoneColect = $IDZoneColectObj->Colect();
$IDZoneColectArray = explode(',', $IDZoneColect);
$IDZoneColectArrayCorrect = array_unique($IDZoneColectArray);
$ListZone = '<select name = "IDZone">';
foreach ($IDZoneColectArrayCorrect as $value) {
    if ($value != '') {
        $arr = \explode('|', $value);
        $k = $arr[1];
        $v = $arr[0];
        $ListZone.='<option value = "' . $v . '">' . $k . '</option>';
    }
}
$ListZone.='</select>';
?>
<div style="display:none">
    <div id="ListZoneColector"><?php echo $ListZone ?></div>
    <div id="dialog-confirm" title="<?php echo \SKT_ADMIN_Message_Confirm_Delete_Title ?>">
        <p><span class="skt-icon-info" style="float:left; margin:0 7px 0 0; font-size: 2em;"></span><span id="text-dialog-confirm"><?php echo \SKT_ADMIN_Message_Confirm_Delete_Text ?></span><br />
            <span id="countdown"></span></p>
    </div>
    <div id="dialog-reload" title="<?php echo \SKT_ADMIN_Reloading ?>">
        <span class="loader"><img src="<?php echo \ASSETS . 'img/loader.gif' ?>" alt="..." /><span id="countdownBig"></span></span>
    </div>
    <div id="dialog-CustomControl" title="<?php echo \SKT_ADMIN_TXT_CC ?>">
        <span></span>
    </div>
    <form action="" method="post" name="colectorskt" id="colectorskt">
        <input name="IDSections" type="hidden" value="<?php echo \SKT_SECTION_ID ?>" />
        <?php if (\SKT_PARENT_ID != '') { ?>
            <input name="ParentSectionValues" type="hidden" value="<?php echo \SKT_PARENT_ID ?>" />
        <?php }if (\SKT_PARENT2_ID != '') { ?>
            <input name="Parent_2_SectionValues" type="hidden" value="<?php echo \SKT_PARENT2_ID ?>" />
        <?php } ?>
        <input name="RenderURL" type="hidden" value="<?php echo \TOTAL_REQUEST ?>" />
        <input name="RenderSubDir" type="hidden" value="<?php echo \SUBURL ?>" />
        <input name="Language" type="hidden" value="<?php echo \THIS_LANG ?>" />
        <input name="MetaDataTitle" type="hidden" value="<?php echo \SKT_SECTION_METADATATITLE; ?>" />
        <input name="MetaDataDescription" type="hidden" value="<?php echo \SKT_SECTION_METADATADESCRIPTION ?>" />
        <input name="MetaDataKeywords" type="hidden" value="<?php echo \SKT_SECTION_METADATAKEYWORDS ?>" />
    </form>
</div>