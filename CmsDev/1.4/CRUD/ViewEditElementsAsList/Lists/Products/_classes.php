<?php

/**
 * Description of Products
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\ViewEditElementsAsList\Lists\Products;

class Products {

    protected $ListTemplate = '<div class="col-md-3">
        <div class="product-thumb">
            <header class="product-header">
                [ProductImage]
            </header>
            <div class="product-inner">
                <h5 class="product-title">[Title]</h5>
                <p class="product-desciption">[ProductDescription]<br>[Priority]</p>
                <div class="product-meta">
                    <ul class="product-price-list">
                        <li><span class="product-price">[Currency][Price]</span></li>
                    </ul>
                    <ul class="product-actions-list">
                        <li><a class="btn btn-sm" href="[UrlLike]"><i class="fa fa-hand-o-up"></i> Me gusta</a>
                        </li>
                        <li><a class="btn btn-sm" href="[UrlDetail]"><i class="fa fa-plus"></i> Detalle</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>';
    protected $ProductFields = array(
        'UID' => 'int',
        'ProductID' => 'text',
        'IDUser' => 'int',
        'Title' => 'text',
        'Price' => 'int',
        'ProductImage' => 'text',
        'ProductWeight' => 'int',
        'ProductDescription' => 'text',
        'ProductDescriptionHTML' => 'text',
        'ProductStatus' => 'int',
        'ProductOrder' => 'int',
        'ProductNew' => 'int',
        'ProductOffer' => 'int',
        'URLName' => 'text',
        'TextOffer' => 'text',
        'ProductType' => 'text',
        'Currency' => 'int',
        'RecycleBin' => 'int',
        'Packing' => 'int',
        'RelatedDocument' => 'text',
        'Image2' => 'text',
        'Image3' => 'text',
        'Image4' => 'text',
        'Image5' => 'text',
        'Image6' => 'text',
        'Date' => 'date',
        'expiredate' => 'date',
        'Plan' => 'int',
        'CatP' => 'int',
        'Cat' => 'int',
        'Priority' => 'int',
        'Tags' => 'text',
        'stock' => 'int',
        'UnitOrAll' => 'text',
        'MinSell' => 'int'
    );
    protected $DefaultParams = array(
        'ProductImageSize' => '',
        'Image2Size' => '',
        'Image3Size' => '',
        'Image4Size' => '',
        'Image5Size' => '',
        'Image6Size' => '',
        'Currency' => 0,
        'CatP' => '',
        'Cat' => '',
        'Query' => '',
        'IDUser' => '',
        'Limit' => 20,
        'ProductBeforeList' => '',
        'ProductAfterList' => '',
        'ProductImageSize' => array('x' => '150', 'y' => '150'),
        'ShowExpired' => 0,
    );

    protected static function Render() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Query = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "products ORDER BY Priority DESC, Date ASC, Title ASC");
        $TemplateItem = '<div class="row box">
    <div class="col-md-5"><img src="[ProductImage]" alt="" title="" /></div>
    <div class="col-md-7">
        <div class="product-info"><h3>[Title]</h3>
            <p class="product-info-price">[Currency] [Price]</p>
            <p class="text-smaller text-muted">[ProductDescription]></p>
            <p class="text-smaller text-muted">[ProductDescriptionHTML]</p>
        </div>
    </div>
</div>';
        self::TemplateItem($Query, $TemplateItem);
    }
    public function setProductImageSize($param = array('x' => '150', 'y' => '150')) {
        $this->DefaultParams['ProductImageSize']['x'] = $param['x'];
        $this->DefaultParams['ProductImageSize']['y'] = $param['y'];
    }
    public function ProductImage($item, $field, $size) {
        if ($item->$field != '') {
            $imageSRC = $item->$field;
            $X = $this->DefaultParams[$size]['x'] ? 'width:' . $this->DefaultParams[$size]['x'] . 'px; ' : '';
            $Y = $this->DefaultParams[$size]['y'] ? 'height:' . $this->DefaultParams[$size]['y'] . 'px; ' : '';

            $XF = $this->DefaultParams[$size]['x'] ? '-' . $this->DefaultParams[$size]['x'] : '';
            $YF = $this->DefaultParams[$size]['y'] ? 'x' . $this->DefaultParams[$size]['y'] : '';

            if ($this->DefaultParams[$size]['x'] != '' || $this->DefaultParams[$size]['y'] != '') {
                $imageSRC = str_replace('_FileSystems', '_thumb_', $item->$field) . $XF . $YF;
                return '<img src="' . $imageSRC . '" alt="" style="' . $X . $Y . '" class="img-responsive"/>';
            } else {
                return '<img src="' . $imageSRC . '" alt=""  class="img-responsive"/>';
            }
        }
    }

    public function ProductCurrency($Currency) {
        if ((int) $Currency == 0) {
            return '$';
        } else {
            return 'U$S';
        }
    }

    public function ProductMedal($Plan, $cssClass = false) {
        $Class = $cssClass ? $cssClass : '';
        if ($Plan == 'Platinum') {
            return '<div class="MedalPlatinum ' . $Class . ' sktToolTip" title="Producto Platinum"></div>';
        } elseif ($Plan == 'Premium') {
            return '<div class="MedalPremium ' . $Class . ' sktToolTip" title="Producto Premium"></div>';
        } elseif ($Plan == 'Certificada') {
            return '<div class="Certificada ' . $Class . ' sktToolTip" title="Empresa Certificada"></div>';
        } else {
            return '';
        }
    }

    public function CompanyLink($id, $CompanyUrl, $CompanyName, $html = false, $cssClass = false) {
        $Class = $cssClass ? $cssClass : '';
        $CompanyName = $html ? $html : $CompanyName;
        return '<a class="' . $Class . ' sktToolTip" href="/usr/' . $id . '/' . $CompanyUrl . '/">' . $CompanyName . '</a>';
    }

    public function ProductUrlDetail($item) {
        return '/Detail/' . $item->ProductUID . '/' . $item->URLName . '/';
    }

    public function Expired($item, $text = false) {
        $ClassExpired = 'active';
        $textExpired = 'Activo';
        $now = new \DateTime(date('Y-m-d'));
        $expiredate = new \DateTime($item->expiredate);
        if ($now >= $expiredate) {
            $ClassExpired = 'Expired';
            $textExpired = 'Inactivo';
        }
        if ($text) {
            return $textExpired;
        } else {
            return $ClassExpired;
        }
    }
    public function UnitOrAll($UnitOrAll) {
        
        if ($UnitOrAll == 'All') {
            $lot = ' el lote';
        }else{
            $lot = ' c/u';
        }
            return $lot;
    }
    
    public function ProductCurrencyPrice($Currency, $Price) {
        if ((int) $Currency == 0) {
            $Symbol = '$';
        } else {
            $Symbol = 'U$S';
        }
        if ((int) $Price >= 1) {
            return $Symbol . ' ' . $Price;
        } else {
            return '<span onclick="javascript:document.location.href=\'/Detail/\';" class="white">Consultar</span>';
        }
    }

    protected function TemplateItem($Query, $Settings = array()) {
        $find = array(
            '[id]',
            '[UID]',
            '[ProductUID]',
            '[ProductID]',
            '[IDUser]',
            '[Title]',
            '[Price]',
            '[ProductImage]',
            '[ProductWeight]',
            '[ProductDescription]',
            '[ProductDescriptionHTML]',
            '[ProductStatus]',
            '[ProductOrder]',
            '[ProductNew]',
            '[ProductOffer]',
            '[URLName]',
            '[TextOffer]',
            '[ProductType]',
            '[Currency]',
            '[Currency+Price]',
            '[RecycleBin]',
            '[Packing]',
            '[RelatedDocument]',
            '[Image2]',
            '[Image3]',
            '[Image4]',
            '[Image5]',
            '[Image6]',
            '[Date]',
            '[expiredate]',
            '[InvertDate]',
            '[Invertexpiredate]',
            '[Plan]',
            '[CatP]',
            '[Cat]',
            '[Priority]',
            '[Company]',
            '[MEDAL]',
            '[UrlDetail]',
            '[stock]',
            '[UnitOrAll]',
            '[ClassExpired]',
            '[TextExpired]',
            '[MinSell]'
        );
        $Thisitem = '';
        if (!empty($Query)) {
            foreach ($Query as $item) {
                $replace = array(
                    $item->id,
                    $item->UID,
                    $item->ProductUID,
                    $item->ProductID,
                    $item->IDUser,
                    $item->Title,
                    $item->Price,
                    $this->ProductImage($item, 'ProductImage', 'ProductImageSize'),
                    $item->ProductWeight,
                    $item->ProductDescription,
                    $item->ProductDescriptionHTML,
                    $item->ProductStatus,
                    $item->ProductOrder,
                    $item->ProductNew,
                    $item->ProductOffer,
                    $item->URLName,
                    $item->TextOffer,
                    $item->ProductType,
                    $this->ProductCurrency($item->Currency),
                    $this->ProductCurrencyPrice($item->Currency, $item->Price),
                    $item->RecycleBin,
                    $item->Packing,
                    $item->RelatedDocument,
                    $this->ProductImage($item, 'Image2', 'Image2Size'),
                    $this->ProductImage($item, 'Image3', 'Image3Size'),
                    $this->ProductImage($item, 'Image4', 'Image4Size'),
                    $this->ProductImage($item, 'Image5', 'Image5Size'),
                    $this->ProductImage($item, 'Image6', 'Image6Size'),
                    $item->Date,
                    $item->expiredate,
                    invertirFecha($item->Date),
                    invertirFecha($item->expiredate),
                    $item->Plan,
                    $item->CatP,
                    $item->Cat,
                    $item->Priority,
                    $this->CompanyLink($item->id, $item->CompanyUrl, $item->Company),
                    $this->ProductMedal($item->Plan_Name),
                    $this->ProductUrlDetail($item),
                    $this->stock,
                    $this->UnitOrAll($item->UnitOrAll),
                    $this->Expired($item),
                    $this->Expired($item, true),
                    $this->MinSell
                );
                $Thisitem .= str_replace($find, $replace, $Settings['TemplateItem']);
            }
        }
        return $Thisitem;
    }

    protected function OtherFromUser($InstancsParams = array()) {
        $SelfParams = array(
            'TemplateItem' => $this->ListTemplate,
            'ExcludeID' => 0,
            'ShowExpired' => 0,
            'IDUser' => ''
        );
        $Settings = array_merge($this->DefaultParams, $SelfParams, $InstancsParams);

        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $QueryWhere = ' product.ProductUID!=' . GetSQLValueString($Settings['ExcludeID'], 'int');
        if ($Settings['IDUser'] != '') {
            $QueryWhere .= ' AND product.IDUser = "' . $Settings['IDUser'] . '" ';
        }
        if ($Settings['CatP'] != '') {
            $QueryWhere .= ' AND product.CatP = "' . $Settings['CatP'] . '" ';
        }
        if ($Settings['Cat'] != '') {
            $QueryWhere .= ' AND product.Cat = "' . $Settings['Cat'] . '" ';
        }
        $QueryWhereDate = ' AND product.Date >= "2015-01-01" AND product.expiredate >= "' . date('Y-m-d') . '" ';
        if ($Settings['ShowExpired'] == 1) {
            $QueryWhereDate = '';
        }

        $QueryWhereCombined = $QueryWhere . $QueryWhereDate;
        $CustomQuery = "SELECT product.*, BPPlan.*, user.*, profile.* FROM "
                . "" . \DB_PREFIX . "products AS product "
                . "JOIN plan as BPPlan "
                . "JOIN users AS user "
                . "JOIN userprofile as profile "
                . "ON product.Plan = BPPlan.Plan_id AND product.IDUser = user.id AND profile.IDX = user.id "
                . "WHERE " . $QueryWhereCombined . "  ORDER BY product.Date DESC, product.Priority DESC LIMIT " . $Settings['Limit'];
        $Query = $SKTDB->get_results($CustomQuery);
        return $this->TemplateItem($Query, $Settings);
    }

    protected function ListRelated($InstancsParams = array()) {
        $SelfParams = array(
            'TemplateItem' => $this->ListTemplate,
            'ExcludeID' => 0,
            'IDUser' => ''
        );
        $Settings = array_merge($this->DefaultParams, $SelfParams, $InstancsParams);

        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $QueryWhere = ' product.ProductUID!=' . GetSQLValueString($Settings['ExcludeID'], 'int');
        if ($Settings['IDUser'] != '') {
            $QueryWhere .= ' AND product.IDUser = "' . $Settings['IDUser'] . '" ';
        }
        if ($Settings['CatP'] != '') {
            $QueryWhere .= ' AND product.CatP = "' . $Settings['CatP'] . '" ';
        }
        if ($Settings['Cat'] != '') {
            $QueryWhere .= ' AND product.Cat = "' . $Settings['Cat'] . '" ';
        }
        $QueryWhereDate = ' AND product.Date >= "2015-01-01" AND product.expiredate >= "' . date('Y-m-d') . '" ';

        $QueryWhereCombined = $QueryWhere . $QueryWhereDate;
        $CustomQuery = "SELECT product.*, BPPlan.*, user.*, profile.* FROM "
                . "" . \DB_PREFIX . "products AS product "
                . "JOIN plan as BPPlan "
                . "JOIN users AS user "
                . "JOIN userprofile as profile "
                . "ON product.Plan = BPPlan.Plan_id AND product.IDUser = user.id AND profile.IDX = user.id "
                . "WHERE " . $QueryWhereCombined . "  ORDER BY product.Priority DESC LIMIT " . $Settings['Limit'];
        $Query = $SKTDB->get_results($CustomQuery);
        if ($ListTemplate == '') {
            $ListTemplate = $this->ListTemplate;
        }
        return $this->TemplateItem($Query, $ListTemplate);
    }

    protected function Search($InstancsParams = array()) {
        $SelfParams = array(
            'TemplateItem' => $this->ListTemplate,
            'SearchQuery' => $_GET['SearchQuery'],
            'ProductBeforeList' => '',
            'ProductAfterList' => ''
        );
        $Settings = array_merge($this->DefaultParams, $SelfParams, $InstancsParams);

        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Where = self::DecodeValue($Settings['SearchQuery']);
        $QueryWhere = '';
        $words = str_word_count($Where, 1);
        $QueryWhereDate = 'AND product.Date >= "2015-01-01" AND product.expiredate >= "' . date('Y-m-d') . '" ';
        if ($Settings['SearchType'] == 'Category') {
            
        } else {
            
        }
        foreach ($words as $word) {

            $QueryWhere .= ' OR (product.ProductDescription like "%' . $word . '%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (product.ProductDescriptionHTML like "%' . $word . '%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (product.Title like "%' . $word . '%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (product.Tags like "%' . $word . '%" ' . $QueryWhereDate . ')';

            $QueryWhere .= ' OR (LOWER( product.ProductDescription) like "%' . strtolower($word) . '%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (LOWER( product.ProductDescriptionHTML) like "%' . strtolower($word) . '%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (LOWER( product.Title) like "%' . strtolower($word) . '%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (LOWER( product.Tags) like "%' . strtolower($word) . '%" ' . $QueryWhereDate . ')';

            $QueryWhere .= ' OR (product.ProductDescription like "%' . $word . 's%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (product.ProductDescriptionHTML like "%' . $word . 's%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (product.Title like "%' . $word . 's%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (product.Tags like "%' . $word . 's%" ' . $QueryWhereDate . ')';

            $QueryWhere .= ' OR (LOWER( product.ProductDescription) like "%' . strtolower($word) . 's%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (LOWER( product.ProductDescriptionHTML) like "%' . strtolower($word) . 's%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (LOWER( product.Title) like "%' . strtolower($word) . 's%" ' . $QueryWhereDate . ')';
            $QueryWhere .= ' OR (LOWER( product.Tags) like "%' . strtolower($word) . 's%" ' . $QueryWhereDate . ')';

            $Where .= '% ' . $word . 's';
            $word = rtrim($word, 's');
            $Where .= '% ' . $word . 's';
        }


        $CustomQuery = "SELECT product.*, BPPlan.*, user.*, profile.*,
            MATCH(product.ProductDescription,product.ProductDescriptionHTML,product.Title,product.Tags)
            AGAINST('$Where' IN BOOLEAN MODE) AS sort_rel FROM "
                . "" . \DB_PREFIX . "products AS product "
                . "JOIN plan as BPPlan "
                . "JOIN users AS user "
                . "JOIN userprofile as profile "
                . "ON product.Plan = BPPlan.Plan_id AND product.IDUser = user.id AND profile.IDX = user.id "
                . "WHERE (MATCH(product.ProductDescription,product.ProductDescriptionHTML,product.Title,product.Tags) "
                . "AGAINST('$Where' IN BOOLEAN MODE) ) $QueryWhere HAVING sort_rel > 0.1 ORDER BY sort_rel DESC, product.Priority DESC LIMIT " . $Settings['Limit'];
        // echo '<div style="position:relative; z-index:9999; background:white">' . $CustomQuery . '</div>';
        $Query = $SKTDB->get_results($CustomQuery);
        if ($Query) {
            return $Settings['ProductBeforeList'] . $this->TemplateItem($Query, $Settings) . $Settings['ProductAfterList'];
        }
    }

    protected function CustomGetList($InstancsParams = array()) {
        $SelfParams = array(
            'TemplateItem' => $this->ListTemplate,
            'ShowExpired' => 1,
        );
        $Settings = array_merge($this->DefaultParams, $SelfParams, $InstancsParams);
        $this->DefaultParams = $Settings;
        $SKTDB = \CmsDev\Sql\db_Skt::connect();

        $QueryWhere = ' product.ProductUID!=0 ';
        if ($Settings['IDUser'] != '') {
            $QueryWhere .= ' AND product.IDUser = "' . $Settings['IDUser'] . '" ';
        }
        if ($Settings['CatP'] != '') {
            $QueryWhere .= ' AND product.CatP = "' . $Settings['CatP'] . '" ';
        }
        if ($Settings['Cat'] != '') {
            $QueryWhere .= ' AND product.Cat = "' . $Settings['Cat'] . '" ';
        }
        if ($Settings['Where'] != '') {
            $QueryWhere .= $Settings['Where'];
        }
        if ($Settings['ShowExpired'] == 1) {
            $QueryWhereDate = ' ';
        } else {
            $QueryWhereDate = ' AND product.Date >= "2015-01-01" AND product.expiredate >= "' . date('Y-m-d') . '" ';
        }
        $QueryWhereCombined = $QueryWhere . $QueryWhereDate;
        $CustomQuery = "SELECT product.*, BPPlan.*, user.*, profile.* FROM "
                . "" . \DB_PREFIX . "products AS product "
                . "JOIN plan as BPPlan "
                . "JOIN users AS user "
                . "JOIN userprofile as profile "
                . "ON product.Plan = BPPlan.Plan_id AND product.IDUser = user.id AND profile.IDX = user.id "
                . "WHERE " . $QueryWhereCombined . "  ORDER BY product.Date DESC, product.Priority DESC, product.Date ASC LIMIT " . $Settings['Limit'];
        $Query = $SKTDB->get_results($CustomQuery);
        return $this->TemplateItem($Query, $Settings);
    }

    protected function GetDataset($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $CustomQuery = "SELECT product.*, BPPlan.*, user.*, profile.* FROM "
                . "" . \DB_PREFIX . "products AS product "
                . "JOIN plan as BPPlan "
                . "JOIN users AS user "
                . "JOIN userprofile as profile "
                . "ON product.Plan = BPPlan.Plan_id AND product.IDUser = user.id AND profile.IDX = user.id "
                . "WHERE ProductUID = " . GetSQLValueString($ID, 'int');
        $Query = $SKTDB->get_row($CustomQuery);
        return $Query;
    }

    protected function GetUserID($DetailID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $CustomQuery = "SELECT IDUser FROM "
                . "" . \DB_PREFIX . "products"
                . "WHERE ProductUID = " . GetSQLValueString($DetailID, 'int');
        $Query = $SKTDB->get_var($CustomQuery);
        return $Query;
    }

    protected function Add() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $queryProductFields = $queryProductValues = '';
        foreach ($_POST as $Field => $Value) {
            if (array_key_exists($Field, $this->ProductFields)) {
                $queryProductFields.= $Field . ',';
            }
        }
        foreach ($_POST as $Field => $Value) {
            if (array_key_exists($Field, $this->ProductFields)) {
                $queryProductValues.= self::DecodeValue(\GetSQLValueString($Value, $this->ProductFields[$Field])) . ',';
            }
        }
        $queryProductFieldsTrimed = trim($queryProductFields, ',');
        $queryProductValuesTrimed = trim($queryProductValues, ',');

        if (isset($_POST['PlanGift']) && $_POST['PlanGift'] == '1') {
            $User_plan = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\User_plan\_classes;
            $User_plan->CountDown($_POST['IDUser']);
        }

        $query = "INSERT INTO " . \DB_PREFIX . "products ($queryProductFieldsTrimed) VALUES ($queryProductValuesTrimed)";
        if ($queryProductFieldsTrimed) {
            $insert = $SKTDB->query($query);
        }
        if ($insert) {
            echo 'okay';
        } else {
            echo "error";
        }
    }

    protected function Update($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $queryProductFields = '';
        foreach ($_POST as $Field => $Value) {
            if (in_array($Field, $this->ProductFields)) {
                $queryProductFields.= $Field . ' = ' . self::DecodeValue(\GetSQLValueString($Value, $this->ProductFields[$Field])) . ',';
            }
        }
        $queryProductFieldsTrimed = trim($queryProductFields, ',');
        if ($queryProductFieldsTrimed) {
            $update = $SKTDB->query("UPDATE " . \DB_PREFIX . "products Set 
            $queryProductFieldsTrimed
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
        $update = $SKTDB->query(sprintf("UPDATE " . \DB_PREFIX . "products Set 
            ProductImage = %s
            WHERE UID = %s", \GetSQLValueString($Image, "text"), GetSQLValueString($ID, "int")
        ));
        if ($update) {
            echo 'Imagen actualizada';
        } else {
            echo "Error, intente nuevamente";
        }
    }

    protected function Remove($ID = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $DeleteQuery = $SKTDB->query("DELETE FROM " . \DB_PREFIX . "products WHERE UID = '" . \GetSQLValueString(\str_replace('ID', '', $ID), "int") . "' LIMIT 1");
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

class _classes extends Products {

    public function RenderList() {
        return self::Render();
    }

    public function Dataset($ID) {
        return self::GetDataset($ID);
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

    public function GetList($InstancsParams) {
        return self::CustomGetList($InstancsParams);
    }

    public function GetSearchResults($InstancsParams) {
        return self::Search($InstancsParams);
    }

    public function GetListOtherFromUser($InstancsParams) {
        return self::OtherFromUser($InstancsParams);
    }

    public function GetPUserID($DetailID) {
        return self::GetUserID($DetailID);
    }

}

?>