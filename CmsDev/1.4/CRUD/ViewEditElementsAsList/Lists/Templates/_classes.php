<?php

/**
 * Description of Templates
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\ViewEditElementsAsList\Lists\Templates;

class Templates {

    protected static function Render() {
        $HTML = '';
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_results("SELECT * FROM site");
        $HTML .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="CustomList TableListElementsSKT">';
        $HTML .= '<thead>
            <tr>
                <th scope="col" style="white-space: nowrap; width: 25%;">
                    <div class="right skt-btn skt-btn-list-add">
                        <i class="skt-iconbrush"></i>
                        <span>' . \SKT_ADMIN_Templates_AddListItem . '</span>
                    </div>
            </th>
            <th scope="col">' . \SKT_ADMIN_TemplateUrl . '</th>
            <th scope="col">' . \SKT_ADMIN_TemplateSlogan . '</th>
          </tr>
        </thead>';
        foreach ($query as $List) {
            $active = '';
            $activeI = 'class="skt-iconcircle-empty" title="' . \SKT_ADMIN_Templates_ActiveIn . '"';
            if ($List->active === '1') {
                $active = 'SKTActiveSite';
                $activeI = 'class="skt-iconcircle" title="' . \SKT_ADMIN_Templates_ActiveNow . '" " style="color: yellow ! important; cursor: default;"';
            }
            $HTML .= '<tr class="' . $active . '">';
            $HTML .= '<td><i ' . $activeI . ' id="ID' . $List->ID . '"></i>                    <div class="InfoRemove" style="display:none;">
                        <div class="Info">
                            <p>' . self::EncodeValue($List->SiteName) . '</p>
                            <img src="' . self::EncodeValue($List->ImagePreview) . '" alt="' . self::EncodeValue($List->TemplateSite) . '"/>
                        </div>
                    </div>
                <i class="skt-icon-edit" id="ID' . $List->ID . '"></i>';
            $HTML .= '<i class="skt-icon-eye-1 showPreview"  id="ID' . $List->ID . '">
                <span class="imgPreview">
                    <a href="_TemplateSite/' . $List->TemplateSite . '/preview.jpg" target="_blank" title="' . \SKT_ADMIN_Ampliar . '"><img src="_TemplateSite/' . $List->TemplateSite . '/preview.jpg" alt="" class="clearfix"/></a>
                </span>
                </i>';
            if ($List->active === '0') {
                $HTML .= '<i class="skt-icon-cancel" id="ID' . $List->ID . '"></i>
                    <div class="InfoRemove" style="display:none;">
                        <div class="Info">
                            <p>' . self::EncodeValue($List->SiteName) . '</p>
                            <img src="' . self::EncodeValue($List->ImagePreview) . '" alt="' . self::EncodeValue($List->TemplateSite) . '"/>
                        </div>
                    </div>
                </td>';
            } else {
                //$HTML .= '<i class="skt-iconstar" style="color: yellow ! important; cursor: default;"></i></td>';
            }
            $HTML .= '<td><h4><span style="color:#999">_TemplateSite/</span><strong>' . self::EncodeValue($List->TemplateSite) . '</strong></h4></td>';
            $HTML .= '<td><span>' . self::EncodeValue($List->SiteName) . '</span></td>';
            $HTML .= '</tr>';
        }
        $HTML .= '</table>';
        echo $HTML;
    }

    protected static function Add($Title = '', $Description = '', $Image = '', $Content = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Title = self::DecodeValue(isset($Title) ? $Title : '');
        $Description = self::DecodeValue(isset($Description) ? $Description : '...');
        $Content = self::DecodeValue(isset($Content) ? $Content : '');
        $Image = isset($Image) ? $Image : '';
        $Autor = self::DecodeValue($_SESSION['UserID']);
        $Date = \date(\SKT_DATEFORMAT, \time());
        $insert = $SKTDB->query("INSERT INTO site (IDPage, AllPage, IDZone, Type, Title, Description, Content, Date, RecycleBin, Position, Custom, Autor) 
		VALUES (" .
                \GetSQLValueString(0, "int") . "," .
                \GetSQLValueString(1, "int") . "," .
                \GetSQLValueString(0, "text") . "," .
                \GetSQLValueString('Templates', "text") . "," .
                \GetSQLValueString($Title, "text") . "," .
                \GetSQLValueString($Description, "text") . "," .
                \GetSQLValueString($Content, "text") . "," .
                \GetSQLValueString($Date, "date") . "," .
                \GetSQLValueString(0, "int") . "," .
                \GetSQLValueString(1, "int") . "," .
                \GetSQLValueString($Image, "text") . "," .
                \GetSQLValueString($Autor, "text") . ")"
        );
        if ($insert) {
            echo 'okay';
        } else {
            echo "error";
        }
    }

    protected static function Edit($ID = '', $Title = '', $Description = '', $Image = '', $Content = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Title = self::DecodeValue(isset($Title) ? $Title : '');
        $Description = self::DecodeValue(isset($Description) ? $Description : '...');
        $Content = self::DecodeValue(isset($Content) ? $Content : '');
        $Image = isset($Image) ? $Image : '';
        $Autor = self::DecodeValue($_SESSION['UserID']);
        $Date = \date(\SKT_DATEFORMAT, \time());
        $update = $SKTDB->query(sprintf("UPDATE site Set 
            Content = %s,
            Date = %s, 
            Custom = %s,
            Title = %s,
            Description = %s,
            Autor = %s
            WHERE ID = %s", \GetSQLValueString($Content, "text"), \GetSQLValueString($Date, "date"), \GetSQLValueString($Image, "text"), GetSQLValueString($Title, "text"), GetSQLValueString($Description, "text"), GetSQLValueString($Autor, "text"), GetSQLValueString($ID, "int")
        ));
        if ($update) {
            echo 'okay';
        } else {
            echo "error";
        }
    }

    protected static function Activate($ID = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $update = $SKTDB->query(sprintf("UPDATE site Set active = 0 WHERE active = 1"));
        $update2 = $SKTDB->query(sprintf("UPDATE site Set active = 1 WHERE ID = '" . \GetSQLValueString(\str_replace('ID', '', $ID), "int") . "'"));
        if ($update) {
            echo 'okay';
        } else {
            echo "error";
        }
    }

    protected static function Remove($ID = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $DeleteQuery = $SKTDB->query("DELETE FROM site WHERE ID = '" . \GetSQLValueString(\str_replace('ID', '', $ID), "int") . "' LIMIT 1");
        if ($DeleteQuery) {
            echo 'ok';
        } else {
            echo \SKT_ADMIN_Message_Update_Error;
        }
    }

    protected static function EncodeValue($value) {

        return \utf8_encode($value);
    }

    protected static function DecodeValue($value) {

        return \utf8_decode($value);
    }

}

class _classes extends Templates {

    public function RenderList() {

        return static::Render();
    }

    public function AddToList($Title, $Description, $Image, $Content) {

        return static::Add($Title, $Description, $Image, $Content);
    }

    public function ActivateItemList($ID = '') {

        return static::Activate($ID);
    }

    public function RemoveFromList($ID = '') {

        return static::Remove($ID);
    }

    public function EditItemList($ID, $Title, $Description, $Image, $Content) {

        return static::Edit($ID, $Title, $Description, $Image, $Content);
    }

}

?>
