<?php

/**
 * Description of LoadMod
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Content;

use \CmsDev\Security\loginIntent as SKT_SECURE,
    \CmsDev\sql\db_Skt as SKT_DB,
    \CmsDev\skt_Code as CS;

class LoadMod {

    public static function FixZone($value) {
        $search = array('.', '-', '*', ',', '|');
        $replace = array('', '', '', '', '');
        $NameFixed = str_replace($search, $replace, $value);
        return $NameFixed;
    }

    public static function render($IDZone, $NameZone = '', $StyleClass = '') {
        $IDZone = static::FixZone($IDZone);
        if ($NameZone === '') {
            $NameZone = static::FixZone($IDZone);
        } else {
            $NameZone = static::FixZone($NameZone);
        }
        $isLogged = SKT_SECURE::action('validateAdmin');
        $SKTDB = SKT_DB::connect();
        $IDSections = \SKT_SECTION_ID;
        $editorCMS = 0;
        $editorcss = "";
        $editorCMS_WrapBefore = "";
        $editorCMS_WrapAfter = "";
        $editorScript_WrapBefore = "";
        $editorScript_WrapAfter = "";
        $total_lock_mod = 0;
        $_SESSION_View_DesignCMS = 0;
        $IDZoneColect = $IDZone . '|' . $NameZone . ',';
        $IDZoneColectObj = \CmsDev\Content\ZoneColect::init();
        $IDZoneColectObj->set($IDZoneColect);
        $DS = DIRECTORY_SEPARATOR;

        if ($isLogged === true) {
            $editorCMS_WrapBefore = '<div class="' . $editorcss . ' sktEditorContentWrapper">
        <h3 class="EditorHeaderTitle ui-dialog-titlebar ui-widget-header ui-corner-all">
            <span class="Title">[TitleZone]</span><div class="CmsDevIcon"><a href="javascript:void(0);"></a>
                <ul class="">
                    <li class="Delete" rel="[ID]" title="' . SKT_ADMIN_Btn_Delete . '">
                    <li class="Recycle" rel="[ID]" title="' . SKT_ADMIN_Btn_Recycle . '"></li>
                    <li class="Property" rel="[ID]" title="' . SKT_ADMIN_Btn_Properties . '"></li>
                    </li><li class="CmsDevEditCMS" rel="[ID]" title="' . SKT_ADMIN_Btn_Edit . '"></li>
                </ul>
            </div>
        </h3>';
            $editorCMS_WrapAfter = '<div class="clear"></div></div>';

            $editorScript_WrapBefore = '<div class="' . $editorcss . ' sktEditorContentWrapper">
        <h3 class="EditorHeaderTitle ui-dialog-titlebar ui-widget-header ui-corner-all">
            <span class="Title">[TitleZone]</span><div class="CmsDevIcon"><a href="javascript:void(0);"></a>
                <ul class="">
                    <li class="Delete" rel="[ID]" title="' . SKT_ADMIN_Btn_Delete . '"></li>
                    <li class="Recycle" rel="[ID]" title="' . SKT_ADMIN_Btn_Recycle . '"></li>
                    <li class="Property" rel="[ID]" title="' . SKT_ADMIN_Btn_Properties . '"></li>
                    <li class="CmsDevEditScript" rel="[ID]" title="' . SKT_ADMIN_Btn_Edit . '"></li>			
                </ul>
            </div>
        </h3>';
            $editorScript_WrapAfter = '<div class="clear"></div></div>';

            $editorCC_WrapBefore = '<div class="' . $editorcss . ' sktEditorContentWrapper">
        <h3 class="EditorHeaderTitle ui-dialog-titlebar ui-widget-header ui-corner-all">
            <span class="Title">[TitleZone]</span><div class="CmsDevIcon"><a href="javascript:void(0);"></a>
                <ul class="">
                    <li class="Delete" rel="[ID]" title="' . SKT_ADMIN_Btn_Delete . '"></li>
                    <li class="Recycle" rel="[ID]" title="' . SKT_ADMIN_Btn_Recycle . '"></li>
                    <li class="Property" rel="[ID]" title="' . SKT_ADMIN_Btn_Properties . '"></li>
                    [FILES] 
                    [CUSTOMIZED]
                    <li class="CmsDevEditCC" rel="[ID]" title="' . SKT_ADMIN_Btn_Edit . '"></li>
                </ul>
                <form action="" method="post" style="display:none;">
                    <input name="Action" id="Action" type="hidden" value="[Action]" />
                    <input name="ID" type="hidden" value="[ID]" />
                    <input name="IDZone" type="hidden" value="[IDZone]" />
                    <input name="CCFromTemplate" id="CCFromTemplate" type="hidden" value="[CCFromTemplate]" />
                    <textarea name="CustomProperty" id="CustomProperty" />[CustomProperty]</textarea>
                </form>
            </div>
        </h3>';
            $editorCC_WrapAfter = '<div class="clear"></div></div>';

            $editorNote_WrapBefore = '<div class="' . $editorcss . ' sktEditorContentWrapper">
        <h3 class="EditorHeaderTitle ui-dialog-titlebar ui-widget-header ui-corner-all">
            <span class="Title">[TitleZone]</span><div class="CmsDevIcon"><a href="javascript:void(0);"></a>
                <ul class="">
                    <li class="Delete" rel="[ID]" title="' . SKT_ADMIN_Btn_Delete . '"></li>
                    <li class="Recycle" rel="[ID]" title="' . SKT_ADMIN_Btn_Recycle . '"></li>
                    <li class="Property" rel="[ID]" title="' . SKT_ADMIN_Btn_Properties . '"></li>
                    <li class="CmsDevEditNote" rel="[ID]" id="[ID]" title="' . SKT_ADMIN_Btn_Edit . '"></li>
                </ul>
            </div>
        </h3>';
            $editorNote_WrapAfter = '<div class="clear"></div></div>';

            $editorPhoto_WrapBefore = '<div class="' . $editorcss . ' sktEditorContentWrapper">
        <h3 class="EditorHeaderTitle ui-dialog-titlebar ui-widget-header ui-corner-all">
            <span class="Title">[TitleZone]</span><div class="CmsDevIcon"><a href="javascript:void(0);"></a>
                <ul class="">
                    <li class="Delete" rel="[ID]" title="' . SKT_ADMIN_Btn_Delete . '"></li>
                    <li class="Recycle" rel="[ID]" title="' . SKT_ADMIN_Btn_Recycle . '"></li>
                    <li class="Property" rel="[ID]" title="' . SKT_ADMIN_Btn_Properties . '"></li>
                    <li class="CmsDevEditPhoto" rel="[ID]" id="[ID]" title="' . SKT_ADMIN_Btn_Edit . '"></li>
                </ul>
            </div>
        </h3>';
            $editorPhoto_WrapAfter = '<div class="clear"></div></div>';
        }


        if (isset($_POST['View_DesignCMS'])) {
            $_SESSION_View_DesignCMS = $_POST['View_DesignCMS'];
            $_SESSION['View_DesignCMS'] = $_SESSION_View_DesignCMS;
        } else {
            if (isset($_SESSION['View_DesignCMS'])) {
                $_SESSION_View_DesignCMS = $_SESSION['View_DesignCMS'];
            } else {
                $_SESSION_View_DesignCMS = 0;
            }
        }

        if ($isLogged === true) {
            $editorCMS = 1;
            $editorcss = " EditorContainer ui-corner-all EditorActive";
            echo '<div class="ZoneContainer"><h4>' . $NameZone . '</h4></div>';
        }

        $contentIDZoneCount = $SKTDB->get_var("SELECT count(*) FROM " . DB_PREFIX . "content WHERE (IDPage = '$IDSections' AND IDZone = '$IDZone') OR (IDZone = '$IDZone' AND AllPage = '1')");

        if ($contentIDZoneCount >= 1) {
            $contentIDZone = $SKTDB->get_results("SELECT * FROM " . DB_PREFIX . "content WHERE (IDPage = '$IDSections' AND IDZone = '$IDZone') OR (IDZone = '$IDZone' AND AllPage = '1') ORDER BY Position ASC");
            $query = $SKTDB->get_col_info($info_type = "name", $col_offset = -1);
            $cols = array();
            foreach ($query as $name) {
                array_push($cols, $name);
            }
            foreach ($contentIDZone as $Zone) {

                if ($isLogged === true) {

                    $DivWrapBefore = '<div id="E_' . $Zone->ID . '_' . $Zone->IDPage . '_' . $Zone->IDZone . '_' . $Zone->Date . '" rel="' . $Zone->Title . '" class="sktEditorContent ' . $StyleClass . ' ' . $Zone->css_class . '">';

                    if ($Zone->Type == 'html') {
                        $editorSet = $editorCMS_WrapBefore;
                        foreach ($cols as $col) {
                            $editorSet = str_replace('[' . $col . ']', CS::Charset($Zone->$col), $editorSet);
                        }
                        $editorSet = str_replace("[TitleZone]", CS::Charset($Zone->Title), $editorSet);
                        if ($Zone->RecycleBin == 1) {
                            $editorSet = str_replace("EditorHeaderTitle", "EditorHeaderTitle SKTRecycled", $editorSet);
                            $DivWrapBefore = str_replace("sktEditorContent ", "sktEditorContent SKTRecycled", $DivWrapBefore);
                        }
                        echo $editorSet . $DivWrapBefore;
                        //$Zone->Content = str_replace("[[ZONA]]",LoadMod('CustomArea'.$Zone->ID.$Zone->IDZone),$Zone->Content);
                        echo CS::Charset($Zone->Content);
                        echo '</div>';
                        echo $editorCMS_WrapAfter;
                    }

                    if ($Zone->Type == 'Note') {
                        $editorSet = $editorNote_WrapBefore;
                        if ($Zone->CustomProperty != '') {
                            if (\is_file(\SKTPATH_TemplateSite . $Zone->CustomProperty)) {
                                $NoteTemplate = file_get_contents(\SKTPATH . $Zone->CustomProperty);
                            } elseif (\is_file(\SKTPATH_TemplateSite . $DS . "SKT_Theme_Parts" . $DS . 'Notes' . $DS . $Zone->CustomProperty)) {
                                $NoteTemplate = file_get_contents(\SKTPATH_TemplateSite . $DS . "SKT_Theme_Parts" . $DS . 'Notes' . $DS . $Zone->CustomProperty);
                            }
                        }
                        if ($NoteTemplate != '') {
                            $editorSet.=$NoteTemplate;
                        }
                        foreach ($cols as $col) {
                            $editorSet = str_replace('[' . $col . ']', CS::Charset($Zone->$col), $editorSet);
                        }
                        $editorSet = str_replace("[TitleZone]", CS::Charset($Zone->Title), $editorSet);
                        if ($Zone->RecycleBin == 1) {
                            $editorSet = str_replace("EditorHeaderTitle", "EditorHeaderTitle SKTRecycled", $editorSet);
                            $DivWrapBefore = str_replace("sktEditorContent ", "sktEditorContent SKTRecycled", $DivWrapBefore);
                        }
                        echo $editorSet . $DivWrapBefore;
                        echo '</div>';
                        echo $editorNote_WrapAfter;
                    }

                    if ($Zone->Type == 'Photo') {

                        $editorSet = $editorPhoto_WrapBefore;
                        foreach ($cols as $col) {
                            $editorSet = str_replace('[' . $col . ']', CS::Charset($Zone->$col), $editorSet);
                        }
                        $editorSet = str_replace("[TitleZone]", CS::Charset($Zone->Title), $editorSet);
                        if ($Zone->RecycleBin == 1) {
                            $editorSet = str_replace("EditorHeaderTitle", "EditorHeaderTitle SKTRecycled", $editorSet);
                            $DivWrapBefore = str_replace("sktEditorContent ", "sktEditorContent SKTRecycled", $DivWrapBefore);
                        }
                        echo $editorSet . $DivWrapBefore;
                        $fileprop = \SKTPATH_FileSystems . $Zone->CustomProperty;
                        $file = str_replace("/SKTSize/", "", $fileprop);
                        $file = str_replace("/", DIRECTORY_SEPARATOR, $file);
                        $hiperlink = DataTag($file, 'hiperlink');
                        $title = DataTag($file, 'title');
                        $Description = DataTag($file, 'Description');
                        $urlSrc = $Zone->CustomProperty;
                        $ThePhoto = '';
                        if ($hiperlink != '' && $hiperlink != 'null' && $hiperlink != 'undefined') {
                            $ThePhoto.= '<a href="' . $hiperlink . '" title="' . $title . '" target="_blank">';
                            $ThePhoto.= '<img src="' . $urlSrc . '" alt="' . $title . '"  class="img-responsive ' . $StyleClass . '"/><span class="hidden Description">' . $Description . '</span>';
                            $ThePhoto.= '</a>';
                        } else {
                            $ThePhoto.= '<img src="' . $urlSrc . '"  alt="' . $title . '"  class="img-responsive ' . $StyleClass . '"/><span class="hidden Description">' . $Description . '</span>';
                        }
                        if ($Description != '' && $Description != 'null' && $Description != 'undefined') {
                            $ThePhoto = '<figure class="figureDescription">' . $ThePhoto . '</figure>';
                        }
                        echo $ThePhoto;
                        echo '</div>';
                        echo $editorPhoto_WrapAfter;
                    }



                    if ($Zone->Type == 'script') {

                        $editorSet = $editorScript_WrapBefore;
                        foreach ($cols as $col) {
                            $editorSet = str_replace('[' . $col . ']', CS::Charset($Zone->$col), $editorSet);
                        }
                        $editorSet = str_replace("[TitleZone]", CS::Charset($Zone->Title), $editorSet);
                        if ($Zone->RecycleBin == 1) {
                            $editorSet = str_replace("EditorHeaderTitle", "EditorHeaderTitle SKTRecycled", $editorSet);
                            $DivWrapBefore = str_replace("sktEditorContent ", "sktEditorContent SKTRecycled", $DivWrapBefore);
                        }
                        echo $editorSet . $DivWrapBefore;
                        echo CS::Charset($Zone->Content);
                        echo '</div>';
                        echo $editorScript_WrapAfter;
                    }

                    if ($Zone->Type == 'Anchor') {
                        if ($Zone->RecycleBin == 1) {
                            $editorScript_WrapBefore = str_replace("EditorHeaderTitle", "EditorHeaderTitle SKTRecycled", $editorScript_WrapBefore);
                        }
                        echo str_replace("[TitleZone]", CS::Charset($Zone->Title), $editorScript_WrapBefore) . $DivWrapBefore;
                        echo '<a name="' . CS::Charset($Zone->Content) . '" id="' . CS::Charset($Zone->Content) . '"></a>';
                        echo '</div>';
                        echo $editorScript_WrapAfter;
                    }

                    if ($Zone->Type == 'SKT_Controls') {

                        $editorCCBeforeok_find = array(
                            "[TitleZone]",
                            "[Action]",
                            "[CustomProperty]",
                            "[ID]",
                            "[IDZone]",
                            "[CCFromTemplate]"
                        );
                        $editorCCBeforeok_replace = array(
                            CS::Charset($Zone->Title),
                            CS::Charset($Zone->Custom),
                            CS::Charset($Zone->CustomProperty),
                            $Zone->ID,
                            $Zone->IDZone,
                            $Zone->CCFromTemplate
                        );


                        $editorCCBeforeRep = str_replace("[TitleZone]", CS::Charset($Zone->Title), $editorCC_WrapBefore);

                        $editorCCBeforeok = str_replace($editorCCBeforeok_find, $editorCCBeforeok_replace, $editorCCBeforeRep);


                        if ($Zone->RecycleBin == 1) {
                            $editorCCBeforeok = str_replace("EditorHeaderTitle", "EditorHeaderTitle SKTRecycled", $editorCCBeforeok);
                        }


                        $find = strstr($Zone->Custom, 'File_');

                        $FilesGoTo = '[FILES]';

                        if ($find == true) {

                            $FilesGoTo = '<li class="CmsDevEditFiles" title="' . SKT_ADMIN_Btn_Edit . '"></li>';

                            $editorCCBeforeok = str_replace("CmsDevEditCC", "CmsDevEditCCF", $editorCCBeforeok);
                        }

                        $editorCCBeforeok = str_replace("[FILES]", $FilesGoTo, $editorCCBeforeok);

                        //

                        $find2 = strstr($Zone->Custom, 'Folder_');

                        $FilesGoTo = '';

                        if ($find2 == true) {

                            $FilesGoTo = '<li class="CmsDevEditFiles" title="' . SKT_ADMIN_Btn_Edit . '"></li>';

                            $editorCCBeforeok = str_replace("CmsDevEditCC", "CmsDevEditCCF", $editorCCBeforeok);
                        }

                        $editorCCBeforeok = str_replace("[FILES]", $FilesGoTo, $editorCCBeforeok);

                        //

                        $find3 = strstr($Zone->Custom, 'Customized_');

                        $FilesGoTo = '[CUSTOMIZED]';

                        if ($find3 == true) {

                            $FilesGoTo = '<li class="CmsDevEditCCCustomized" title="' . SKT_ADMIN_Btn_Edit . '"></li>';

                            //$editorCCBeforeok = str_replace("CmsDevEditCC","CmsDevEditCCCustomized",$editorCCBeforeok);

                            $editorCCBeforeok = str_replace("[CUSTOMIZED]", $FilesGoTo, $editorCCBeforeok);
                        }

                        $editorCCBeforeok = str_replace("[CUSTOMIZED]", '', $editorCCBeforeok);

                        //				

                        echo $editorCCBeforeok . '<div id="E_' . $Zone->ID . '_' . $Zone->IDPage . '_' . $Zone->IDZone . '_' . $Zone->Date . '" rel="' . $Zone->Title . '" class="SKT_Controls ' . $Zone->css_class . '" ><div class="CustomProperty">' . $Zone->CustomProperty . '</div>';


                        if ($Zone->CCFromTemplate == '') {
                            if (\is_file(\SKTPATH . '/SKT_Controls/' . $Zone->Custom . '/Control.php') && SKT_TEMPLATE_ERROR === '') {
                                include(\SKTPATH . '/SKT_Controls/' . $Zone->Custom . '/Control.php');
                            } else {
                                $MessageBox = \CmsDev\Info\Asistance::get();
                                $MessageBox->TipError('No se encuentra el control nativo en: ' . $Zone->Custom . '/Control.php', false);
                                echo 'No se encuentra el control ' . $Zone->Custom;
                            }
                        } else {
                            if (\is_file(\SKTPATH_TemplateSite . '/SKT_Controls/' . $Zone->Custom . '/Control.php') && SKT_TEMPLATE_ERROR === '') {
                                include(\SKTPATH_TemplateSite . '/SKT_Controls/' . $Zone->Custom . '/Control.php');
                                //echo "OKIDOKI";
                            } else {
                                $MessageBox = \CmsDev\Info\Asistance::get();
                                $MessageBox->TipError('No se encuentra el control personalizado en: ' . $Zone->CCFromTemplate . $Zone->Custom . '/Control.php', false);
                                echo 'No se encuentra el control personalizado ' . $Zone->Custom;
                            }
                        }


                        echo '</div>';

                        echo $editorCC_WrapAfter;
                    }
                } else {

                    if ($Zone->RecycleBin == 0) {

                        if ($Zone->Type == 'SKT_Controls') {

                            if ($Zone->Title != '') {
                                echo '<h3 class="TitleControl"><span>' . CS::Charset($Zone->Title) . '</span></h3>';
                            }

                            echo '<div class="' . $StyleClass . ' SKT_Controls">';


                            if ($Zone->CCFromTemplate == '') {
                                if (\is_file(\SKTPATH . '/SKT_Controls/' . 'SKT_Controls/' . $Zone->Custom . '/Control.php') && SKT_TEMPLATE_ERROR === '') {
                                    include(\SKTPATH . 'SKT_Controls/' . 'SKT_Controls/' . $Zone->Custom . '/Control.php');
                                } else {
                                    $MessageBox = \CmsDev\Info\Asistance::get();
                                    $MessageBox->TipError('No se encuentra el control nativo en: ' . $Zone->CCFromTemplate . $Zone->Custom . '/Control.php', false);
                                    echo 'No se encuentra el control ' . $Zone->Custom;
                                }
                            } else {
                                if (\is_file(\SKTPATH_TemplateSite . 'SKT_Controls/' . $Zone->Custom . '/Control.php') && SKT_TEMPLATE_ERROR === '') {
                                    include(\SKTPATH_TemplateSite . 'SKT_Controls/' . $Zone->Custom . '/Control.php');
                                } else {
                                    $MessageBox = \CmsDev\Info\Asistance::get();
                                    $MessageBox->TipError('No se encuentra el control personalizado en: ' . \SKTPATH_TemplateSite . $Zone->Custom . '/Control.php', false);
                                    echo 'No se encuentra el control ' . $Zone->Custom;
                                }
                            }

                            echo '</div>';
                        } elseif ($Zone->Type == 'Anchor') {

                            echo '<h3 class="Anchor EditorHeaderTitle ui-dialog-titlebar ui-widget-header ui-corner-all"><a name="' . CS::Charset($Zone->Content) . '" id="' . CS::Charset($Zone->Content) . '"></a>' . CS::Charset($Zone->Title) . '<div class="ui-state-default ui-corner-all ScrollTop" onclick="javascript:$.scrollTo(\'#ScrollTop\',800);"><div class="ui-icon ui-icon-circle-arrow-n "></div></div></h3>';
                        } elseif ($Zone->Type == 'Note') {

                            if ($Zone->CustomProperty != '') {
                                $NoteTemplate = file_get_contents($Zone->CustomProperty);
                            }

                            $note_find = array(
                                "[Title]",
                                "[Content]",
                                "[Date]",
                                "[Autor]",
                                "[CssClass]"
                            );
                            $note_replace = array(
                                CS::Charset($Zone->Title),
                                CS::Charset($Zone->Content),
                                $Zone->Date,
                                CS::Charset($Zone->Autor),
                                CS::Charset($Zone->css_class)
                            );
                            $note = str_replace($note_find, $note_replace, $NoteTemplate);
                            echo $note;
                        } elseif ($Zone->Type == 'Photo') {
                            $file = \SKT_URL_BASE . '/' . $Zone->CustomProperty;
                            $file = str_replace("//", "/", $file);
                            $hiperlink = DataTag($file, 'hiperlink');
                            $title = DataTag($file, 'title');
                            $Description = DataTag($file, 'Description');
                            $ThePhoto = '';

                            if ($hiperlink != '' && $hiperlink != 'null' && $hiperlink != 'undefined') {

                                $ThePhoto.= '<a href="' . $hiperlink . '" title="' . $title . '" target="_blank">';

                                $ThePhoto.= '<img src="' . $Zone->CustomProperty . '" alt="' . $title . '"  class="img-responsive ' . $StyleClass . '"/><span class="hidden Description">' . $Description . '</span>';

                                $ThePhoto.= '</a>';
                            } else {

                                $ThePhoto.= '<img src="' . $Zone->CustomProperty . '" alt="' . $title . '"  class="img-responsive ' . $StyleClass . '"/><span class="hidden Description">' . $Description . '</span>';
                            }
                            if ($Description != '' && $Description != 'null' && $Description != 'undefined') {
                                $ThePhoto = '<figure class="figureDescription">' . $ThePhoto . '</figure>';
                            }

                            echo $ThePhoto;
                        } else {

                            if ($Zone->Title != '') {
                                echo '<h3 class="TitleControl"><span>' . CS::Charset($Zone->Title) . '</span></h3>';
                            }
                            echo '<div class="sktEditorContent ' . CS::Charset($Zone->css_class) . '" rel="' . CS::Charset($Zone->Title) . '">' . CS::Charset($Zone->Content) . '</div>';
                        }
                    }
                }
            }
        } else {
            
        };
        $Zone = '';
    }

}

class LoadhHtml extends \CmsDev\Content\LoadMod {

    function __construct() {
        return 'Se ha cargado un módulo HTML';
    }

}

class LoadNote extends \CmsDev\Content\LoadMod {

    function __construct() {
        return 'Se ha cargado un módulo Note';
    }

}

class LoadPhoto extends \CmsDev\Content\LoadMod {

    function __construct() {
        return 'Se ha cargado un módulo Photo';
    }

}

class LoadScript extends \CmsDev\Content\LoadMod {

    function __construct() {
        return 'Se ha cargado un módulo Script';
    }

}

class LoadAnchor extends \CmsDev\Content\LoadMod {

    function __construct() {
        return 'Se ha cargado un módulo Anchor';
    }

}

class LoadCustomControl extends \CmsDev\Content\LoadMod {

    function __construct() {
        return 'Se ha cargado un módulo Custom Control';
    }

}

?>
