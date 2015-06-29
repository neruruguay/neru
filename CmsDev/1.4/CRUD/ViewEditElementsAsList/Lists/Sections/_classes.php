<?php

/**
 * Description of sections
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\ViewEditElementsAsList\Lists\Sections;

class sections {

    protected $SectionFields = array(
        'UID' => 'int',
        'SectionID' => 'int',
        'IDUser' => 'int',
        'Title' => 'text',
        'Price' => 'int',
        'SectionImage' => 'text',
        'SectionWeight' => 'int',
        'SectionDescription' => 'text',
        'SectionDescriptionHTML' => 'text',
        'sectionstatus' => 'int',
        'SectionOrder' => 'int',
        'SectionNew' => 'int',
        'SectionOffer' => 'int',
        'URLName' => 'text',
        'TextOffer' => 'text',
        'SectionType' => 'text',
        'Currency' => 'int',
        'RecycleBin' => 'int',
        'Packing' => 'int',
        'RelatedDocument' => 'text',
        'Image2' => 'text',
        'Image3' => 'text',
        'Image4' => 'text',
        'Image5' => 'text',
        'Image6' => 'text',
        'Date' => 'text',
        'Plan' => 'int',
        'CatP' => 'int',
        'Cat' => 'int'
    );

    protected static function Render() {
        $html = '';
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $ListCatNames = new \CmsDev\Dataset\Categories();
        $query = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "sections as Section join userprofile as profile WHERE Section.id = profile.idX ORDER BY Company ASC");

        $html .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="CustomList TableListElementsSKT">'
                . '<thead>
    <tr>
        <th scope="col" style="width:5%;">
            <div class="right skt-btn skt-btn-list-add hidden">
                <i class="skt-icon-tags"></i>
                <span>Agregar</span>
            </div>
        </th>
        <th scope="col">Logo</th>
        <th scope="col" style="width:20%;">empresa</th>
        <th scope="col" style="width:20%;">Email y Tel&eacute;fono</th>
        <th scope="col" style="width:70%;">Categor&iacute;as</th>
    </tr>
</thead>';
        echo $html;
        $TemplateItem = '<tr>
    <td>
        <i class="skt-icon-edit" id="id[id]"></i>
        <!-- <i class="skt-icon-cancel" id="id[id]"></i> -->
        <i class="skt-icon-docs" id="id[id]"></i>
        <div class="InfoRemove" style="display:none;">
            <div class="Info">
                <b>empresa:</b><br>
                <p>[Company]</p>
            </div>
        </div>
    </td>
    <td style="text-align:center;"><img src="/[ClientAuth_picture]" style="cursor: default; width: 80px;"></i></td>
    <td><b>[Company]</b><br>
    RUT: [RUT]<br>
    [Position]: [Name] [Surname]</td>
    <td><a href="mailto:[email]">[email]</a>
    <br>Tel&eacute;fono: [Phone]
    <br>[Address]
    </td>
    <td><span>[category1]</span> - <span>[category2]</span> - <span>[category3]</span> - <span>[category4]</span> - <span>[category5]</span></td>
</tr>';

        foreach ($query as $itemId) {
            $find = array(
                'UID',
                'SectionID',
                'IDUser',
                'Title',
                'Price',
                'SectionImage',
                'SectionWeight',
                'SectionDescription',
                'SectionDescriptionHTML',
                'sectionstatus',
                'SectionOrder' ,
                'SectionNew',
                'SectionOffer',
                'URLName',
                'TextOffer',
                'SectionType',
                'Currency',
                'RecycleBin',
                'Packing',
                'RelatedDocument',
                'Image2',
                'Image3',
                'Image4',
                'Image5',
                'Image6',
                'Date',
                'Plan',
                'CatP',
                'Cat'
            );
            $replace = array(
                $itemId->id,
                $itemId->UID,
                $itemId->SectionID,
                $itemId->IDUser,
                $itemId->Title,
                $itemId->Price,
                $itemId->SectionImage,
                $itemId->SectionWeight,
                $itemId->SectionDescription,
                $itemId->SectionDescriptionHTML,
                $itemId->sectionstatus,
                $itemId->SectionOrder ,
                $itemId->SectionNew,
                $itemId->SectionOffer,
                $itemId->URLName,
                $itemId->TextOffer,
                $itemId->SectionType,
                $itemId->Currency,
                $itemId->RecycleBin,
                $itemId->Packing,
                $itemId->RelatedDocument,
                $itemId->Image2,
                $itemId->Image3,
                $itemId->Image4,
                $itemId->Image5,
                $itemId->Image6,
                $itemId->Date,
                $itemId->Plan,
                $itemId->CatP,
                $itemId->Cat
            );
            $Thisitem = str_replace($find, $replace, $TemplateItem);
            echo utf8_encode($Thisitem);
        }
    }

    protected function Add() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $insert = $SKTDB->query("INSERT INTO " . \DB_PREFIX . "sections () VALUES ()");
        if ($insert) {
            echo 'okay';
        } else {
            echo "error";
        }
    }

    protected function Edit($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $update2 = $SKTDB->query(sprintf("UPDATE " . \DB_PREFIX . "sections Set "));
        if ($update) {
            echo 'okay';
        } else {
            echo "error";
        }
    }

    protected function Update($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $querySectionFields = '';
        foreach ($_POST as $Field => $Value) {
            if (in_array($Field, $this->SectionFields)) {
                $querySectionFields.= $Field . ' = ' . self::DecodeValue(\GetSQLValueString($Value, $this->SectionFields[$Field])) . ',';
            }
        }
        $querySectionFieldsTrimed = trim($querySectionFields, ',');
        if ($querySectionFieldsTrimed) {
            $update = $SKTDB->query("UPDATE " . \DB_PREFIX . "sections Set 
            $querySectionFieldsTrimed
            WHERE id = " . GetSQLValueString($ID, "int"));
        } else {
            $update = true;
        }
        if ($update) {
            echo 'Los datos fueron actualizados correctamente.';
        } else {
            echo "error";
        }
    }

    protected function Image($Image, $ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Image = self::DecodeValue(isset($Image) ? $Image : '');
        $update = $SKTDB->query(sprintf("UPDATE " . \DB_PREFIX . "sections Set 
            SectionImage = %s
            WHERE UID = %s", \GetSQLValueString($Image, "text"), GetSQLValueString($ID, "int")
        ));

        if ($update) {
            echo 'Imagen actualizada';
        } else {
            echo "Error, intente nuevamente";
        }
    }

    protected static function Remove($ID = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $DeleteQuery = $SKTDB->query("DELETE FROM " . \DB_PREFIX . "sections WHERE UID = '" . \GetSQLValueString(\str_replace('ID', '', $ID), "int") . "' LIMIT 1");
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

class _classes extends sections {

    public function RenderList() {

        return self::Render();
    }

    public function AddToList($ID) {

        return self::Add($ID);
    }

    public function RemoveFromList($ID) {

        return self::Remove($ID);
    }

    public function EditItemList($ID) {

        return self::Edit($ID);
    }

    public function UpdateImage($Image, $ID) {

        return self::Image($Image, $ID);
    }

    public function UpdateData($ID) {

        return self::Update($ID);
    }

}

?>
