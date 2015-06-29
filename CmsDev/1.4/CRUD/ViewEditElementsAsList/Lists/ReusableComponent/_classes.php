<?php

/**
 * Description of ReusableComponent
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\ViewEditElementsAsList\Lists\ReusableComponent;

class ReusableComponent {

    protected static function Render() {
        $HTML = '';
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "content WHERE Type LIKE 'ReusableComponent%%' ");
        $HTML .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="CustomList TableListElementsSKT">';
        $HTML .= '<thead>
            <tr>
                <th scope="col" style="white-space: nowrap; width: 25%;" colspan="2">
                    <div class="right skt-btn skt-btn-list-add">
                        <i class="skt-iconhtml5"></i>
                        <span>' . \SKT_ADMIN_Lists_AddListItem . '</span>
                    </div>
                    <div class="right skt-btn skt-btn-list-addScript">
                        <i class="icon-skt-script"></i>
                        <span>' . \SKT_ADMIN_Lists_AddListItemScript . '</span>
                    </div>
            </th>
            <th scope="col">' . \SKT_ADMIN_ReusableComponent_Title . '</th>
            <th scope="col">' . \SKT_ADMIN_ReusableComponent_Description . '</th>
          </tr>
        </thead>';
        foreach ($query as $List) {
            $format = 'xml html text plain';
            $icon = '<i class="skt-iconhtml5" style="cursor:default;"></i>HTML';
            if ($List->Type === 'ReusableComponentScript') {
                $format = 'javascript jquery';
                $icon = '<i class="icon-skt-script" style="cursor:default;"></i>Script';
            }

            $HTML .= '<tr>';

            $HTML .= '<td>
                <i class="skt-icon-edit ' . $format . '" id="ID' . $List->ID . '"></i>';

            if ($List->Custom !== '' && $List->Custom !== null) {
                $HTML .= '<i class="skt-icon-eye-1 showPreview"  id="ID' . $List->ID . '">
                <span class="imgPreview">
                    <a href="_FileSystems/CodeSnippets_Preview/' . $List->Custom . '" target="_blank" title="' . \SKT_ADMIN_Ampliar . '"><img src="_thumb_/CodeSnippets_Preview/' . $List->Custom . '-350" alt="" class="clearfix"/></a>
                </span>
                </i>';
            }

            $HTML .= '<i class="skt-icon-code showPreview" id="ID' . $List->ID . '"></i>';
            $HTML .= '<i class="skt-icon-cancel" id="ID' . $List->ID . '"></i>
                    <div class="InfoRemove" style="display:none;">
                        <div class="Info">
                            <b>' . \SKT_ADMIN_ReusableComponent_Title . ':</b><br>
                            <p>' . self::EncodeValue($List->Title) . '</p>
                        </div>
                    </div>
                </td>';
            $HTML .= '<td>' . $icon . '</td>';
            $HTML .= '<td><h4>' . self::EncodeValue($List->Title) . '</h4></td>';
            $HTML .= '<td><span>' . self::EncodeValue($List->Description) . '</span></td>';

            $HTML .= '</tr>';


            $HTML .= '<tr class="CodePreview"><td colspan="4"><pre><code class="' . $format . '">' . \htmlentities(self::EncodeValue($List->Content)) . '</code></pre></td></tr>';
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
        $Date = \date(\SKT_ADMIN_dateFormat_dateFormat, \time());
        $insert = $SKTDB->query("INSERT INTO " . \DB_PREFIX . "content (IDPage, AllPage, IDZone, Type, Title, Description, Content, Date, RecycleBin, Position, Custom, Autor) 
		VALUES (" .
                \GetSQLValueString(0, "int") . "," .
                \GetSQLValueString(1, "int") . "," .
                \GetSQLValueString(0, "text") . "," .
                \GetSQLValueString('ReusableComponent', "text") . "," .
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

    protected static function AddScript($Title = '', $Description = '', $Image = '', $Content = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Title = self::DecodeValue(isset($Title) ? $Title : '');
        $Description = self::DecodeValue(isset($Description) ? $Description : '...');
        $Content = self::DecodeValue(isset($Content) ? $Content : '');
        $Image = isset($Image) ? $Image : '';
        $Autor = self::DecodeValue($_SESSION['UserID']);
        $Date = \date(\SKT_ADMIN_dateFormat_dateFormat, \time());
        $insert = $SKTDB->query("INSERT INTO " . \DB_PREFIX . "content (IDPage, AllPage, IDZone, Type, Title, Description, Content, Date, RecycleBin, Position, Custom, Autor) 
		VALUES (" .
                \GetSQLValueString(0, "int") . "," .
                \GetSQLValueString(1, "int") . "," .
                \GetSQLValueString(0, "text") . "," .
                \GetSQLValueString('ReusableComponentScript', "text") . "," .
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
        $Date = \date(\SKT_ADMIN_dateFormat_dateFormat, \time());
        $update = $SKTDB->query(sprintf("UPDATE " . \DB_PREFIX . "content Set 
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

    protected static function Remove($ID = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $DeleteQuery = $SKTDB->query("DELETE FROM " . \DB_PREFIX . "content WHERE ID = '" . \GetSQLValueString(\str_replace('ID', '', $ID), "int") . "' LIMIT 1");
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

class _classes extends ReusableComponent {

    public function RenderList() {

        return static::Render();
    }

    public function AddToList($Title, $Description, $Image, $Content) {

        return static::Add($Title, $Description, $Image, $Content);
    }

    public function AddToListScript($Title, $Description, $Image, $Content) {

        return static::AddScript($Title, $Description, $Image, $Content);
    }

    public function RemoveFromList($ID = '') {

        return static::Remove($ID);
    }

    public function EditItemList($ID, $Title, $Description, $Image, $Content) {

        return static::Edit($ID, $Title, $Description, $Image, $Content);
    }

}

?>
