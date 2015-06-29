<?php

/**
 * Description of  Messenger
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\ViewEditElementsAsList\Lists\Messenger;

class Messenger {

    protected static function Render() {
        $html = '';
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_results("SELECT * FROM messenger ORDER BY IDUser, datePost DESC");

        $html .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="CustomList TableListElementsSKT">'
                . '<thead>
    <tr>
        <th scope="col" style="width:5%;">
            <div class="right skt-btn skt-btn-list-add hidden">
                <i class="skt-icon-tags"></i>
                <span>Agregar</span>
            </div>
        </th>
        <th scope="col">Fecha</th>
        <th scope="col">ID / User</th>
        <th scope="col" style="width:20%;">Personas</th>
        <th scope="col" style="width:70%;">Mensaje</th>
    </tr>
</thead>';
        echo $html;
        $TemplateItem = '<tr>
    <td>
        <i class="skt-icon-edit" id="id[id]"></i>
        <i class="skt-icon-cancel" id="id[id]"></i>
        <div class="InfoRemove" style="display:none;">
            <div class="Info">
                <b>ID:[id] - Usuario:[IDUser]</b><br>
                <p>De:<a href="mailto:[EmailFrom]">[EmailFrom]</a><br>Para: <a href="mailto:[EmailTo]">[EmailTo]</a></p>
            </div>
        </div>
    </td>
    <td>[datePost]</td>
    <td>[id]-[IDUser]</td>
    <td>De:<a href="mailto:[EmailFrom]">[EmailFrom]<br>
    Para: <a href="mailto:[EmailTo]">[EmailTo]</td>
    <td>[Message]</td>
</tr>';

        foreach ($query as $itemId) {
            $find = array(
                '[datePost]',
                '[id]',
                '[IDUser]',
                '[Name]',
                '[EmailFrom]',
                '[EmailTo]',
                '[Message]',
                '[read]'
            );
            $replace = array(
                $itemId->datePost,
                $itemId->id,
                $itemId->IDUser,
                $itemId->Name,
                $itemId->EmailFrom,
                $itemId->EmailTo,
                $itemId->Message,
                $itemId->read
            );
            $Thisitem = str_replace($find, $replace, $TemplateItem);
            echo utf8_encode($Thisitem);
        }
    }

    public static function MessagerCount($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_var("SELECT COUNT(*) FROM messenger WHERE (IDFrom = " . GetSQLValueString($ID, "int") . " AND Parent IS NULL) OR (IDTo = " . GetSQLValueString($ID, "int") . " AND Parent IS NULL)");
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public static function MessagerCountUnread($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_var("SELECT COUNT(*) FROM messenger WHERE (IDFrom = " . GetSQLValueString($ID, "int") . " AND readFrom  = '0' AND Parent IS NULL) OR (IDTo = " . GetSQLValueString($ID, "int") . " AND readTo  = '0' AND Parent IS NULL)");
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public static function MessageRead($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_results("SELECT * FROM messenger WHERE (IDFrom = " . GetSQLValueString($ID, "int") . " AND DF = '0') OR (IDTo = " . GetSQLValueString($ID, "int") . " AND DT = '0') ORDER BY datePost DESC");
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public static function MessageReadChild($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_results("SELECT * FROM messenger WHERE Parent = " . GetSQLValueString($ID, "int") . " ORDER BY datePost DESC");
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    protected static function unread($ID, $UserID, $Owner) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        if ($Owner === 'readFrom') {
            $update = $SKTDB->query("UPDATE messenger Set readFrom = '0' WHERE id = " . GetSQLValueString($ID, "int"));
        } else {
            $update = $SKTDB->query("UPDATE messenger Set readTo = '0' WHERE id = " . GetSQLValueString($ID, "int"));
        }
        if ($update) {
            echo 'Marcado como No le&iacute;do';
        } else {
            echo "Error, intente nuevamente";
        }
    }

    protected static function read($ID, $UserID, $Owner) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        if ($Owner === 'readFrom') {
            $update = $SKTDB->query("UPDATE messenger Set readFrom = 1 WHERE id = " . GetSQLValueString($ID, "int"));
        } else {
            $update = $SKTDB->query("UPDATE messenger Set readTo = 1 WHERE id = " . GetSQLValueString($ID, "int"));
        }
        if ($update) {
            echo 'Marcado como le&iacute;do, archivado';
        } else {
            echo "Error, intente nuevamente";
        }
    }

    protected static function Remove($ID, $Owner) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        if ($Owner == 'readFrom') {
            $update = $SKTDB->query("UPDATE messenger Set DF = 1 WHERE id = " . GetSQLValueString($ID, "int"));
        } else {
            $update = $SKTDB->query("UPDATE messenger Set DT = 1 WHERE id = " . GetSQLValueString($ID, "int"));
        }
        if ($update) {
            echo 'Mensaje Borrado';
        } else {
            echo "Error, intente nuevamente";
        }
    }

    protected static function Add() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Name = self::DecodeValue(isset($_POST['Name']) ? $_POST['Name'] : '-');
        $Message = self::DecodeValue(isset($_POST['Message']) ? $_POST['Message'] : '-');

        $insert = $SKTDB->query("INSERT INTO messenger (IDTo, Message, EmailFrom, NameFrom, EmailTo) 
		VALUES (" .
                \GetSQLValueString($_POST['ID'], "int") . "," .
                \GetSQLValueString($Message, "text") . "," .
                \GetSQLValueString($_POST['EmailFrom'], "text") . "," .
                \GetSQLValueString($Name, "text") . "," .
                \GetSQLValueString($_POST['EmailTo'], "text") . ")"
        );

        if ($insert) {
            echo 'ok';
        } else {
            echo "error";
        }
    }

    protected static function AddResponse() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $insert = $SKTDB->query("INSERT INTO messenger (Type,Parent,IDFrom,IDTo,EmailFrom,NameFrom,readFrom,EmailTo,NameTo,readTo,Message) 
		VALUES (" .
                "0," .
                \GetSQLValueString($_POST['Parent'], "int") . "," .
                \GetSQLValueString($_POST['IDFrom'], "int") . "," .
                \GetSQLValueString($_POST['IDTo'], "int") . "," .
                \GetSQLValueString($_POST['EmailFrom'], "text") . "," .
                \GetSQLValueString($_POST['NameFrom'], "text") . "," .
                "0," .
                \GetSQLValueString($_POST['EmailTo'], "text") . "," .
                \GetSQLValueString($_POST['NameTo'], "text") . "," .
                "0," .
                \GetSQLValueString($_POST['Message'], "text") . ")"
        );
        if ($insert) {
            echo 'ok';
        } else {
            echo "error";
        }
    }

    protected static function EncodeValue($value) {

        return \utf8_encode($value);
    }

    protected static function DecodeValue($value) {

        return \utf8_decode($value);
    }

}

class _classes extends Messenger {

    public function RenderList() {

        return static::Render();
    }

    public function AddToList() {

        return static::Add();
    }

    public function Response() {

        return static::AddResponse();
    }

    public function RemoveFromList($ID, $Owner) {

        return static::Remove($ID, $Owner);
    }

    public function SetRead($ID, $UserID, $Owner) {

        return static::read($ID, $UserID, $Owner);
    }

    public function SetUnread($ID, $UserID, $Owner) {

        return static::unread($ID, $UserID, $Owner);
    }

}

?>
