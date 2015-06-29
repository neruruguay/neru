<?php

/**
 * Description of Purchase_Requests
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\ViewEditElementsAsList\Lists\Purchase_Requests;

class Purchase_Requests {

    protected $ListTemplate = '';
    protected $PurchaseRequestsFields = array(
        'id' => 'int',
        'Seller' => 'int',
        'Customer' => 'int',
        'PID' => 'int',
        'OrderPurchase' => 'text',
        'Currency' => 'int',
        'UnitPrice' => 'int',
        'Quantity' => 'int',
        'TotalPrice' => 'int',
        'OrderDate' => 'date',
        'SellerOpinion' => 'text',
        'CustomerOpinion' => 'text',
        'SellerSemaphore' => 'int',
        'CustomerSemaphore' => 'int',
        'Finalized' => 'int',
        'FinalizedDate' => 'date'
    );
    protected $DefaultParams = array();

    protected function Render() {
        $ListTemplate = '<div class="PurchaseRequests">'
                . '<div class="col">[id]</div>'
                . '<div class="col">[Seller]</div>'
                . '<div class="col">[Customer]</div>'
                . '<div class="col">[PID]</div>'
                . '<div class="col">[OrderPurchase]</div>'
                . '<div class="col">[Currency]</div>'
                . '<div class="col">[UnitPrice]</div>'
                . '<div class="col">[Quantity]</div>'
                . '<div class="col">[TotalPrice]</div>'
                . '<div class="col">[OrderDate]</div>'
                . '<div class="col">[SellerOpinion]</div>'
                . '<div class="col">[CustomerOpinion]</div>'
                . '<div class="col">[SellerSemaphore]</div>'
                . '<div class="col">[CustomerSemaphore]</div>'
                . '<div class="col">[Finalized]</div>'
                . '<div class="col">[FinalizedDate]</div>'
                . '</div>';
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Query = $SKTDB->get_results("SELECT * FROM purchase_requests");
        self::TemplateItem($Query, $ListTemplate);
    }

    public function PurchaseRequestsCurrency($Currency) {
        if ((int) $Currency == 0) {
            return '$';
        } else {
            return 'U$S';
        }
    }

    public function Semaphore($Semaphore, $who = 0, $whoisme) {
        $whois = '';
        $ValueReturn = false;
        if ($who == 0) {
            $whois = ' del Vendedor';
        } else {
            $whois = ' del Comprador';
        }
        if ((int) $Semaphore == 0) {
            $ValueReturn = 'Iniciado';
        } elseif ((int) $Semaphore == 1) {
            $ValueReturn = 'En espera' . $whois;
        } elseif ((int) $Semaphore == 2) {
            $ValueReturn = 'Finalizado';
        } else {
            $ValueReturn = false;
        }
        if ((int) $Semaphore != 2) {
            if ($whoisme == 'Customer') {
                $ValueReturn = '<a href="#Customer">Confirmar Compra</a>';
            } else if ($whoisme == 'Seller') {
                $ValueReturn = '<a href="#Seller">Confirmar Venta</a>';
            } else {
                $ValueReturn = '';
            }
        }
        return $ValueReturn;
    }

    public function SemaphoreConstruct($item) {
        $html = '';
        if ($item->SellerOpinion != '' || $item->CustomerOpinion != '') {
            //$html = '<b>Comentarios</b><hr>';
            if ($item->SellerOpinion != '') {
                $html.= '<div class="text-block"><span><b>El Vendedor dice:</b><br>' . $item->SellerOpinion . '</span></div>';
            }
            if ($item->CustomerOpinion != '') {
                $html.= '<div class="text-block"><span><b>El Comprador dice:</b><br>' . $item->CustomerOpinion . '</span></div>';
            }
        }
        return $html;
    }

    public function Finalized($Finalized) {
        if ((int) $Finalized == 0) {
            return '';
        } elseif ((int) $Finalized == 1) {
            return 'En espera';
        } elseif ((int) $Finalized == 2) {
            return 'Finalizado';
        } else {
            return false;
        }
    }

    protected function TemplateItem($Query, $Settings = array()) {
        if ($TemplateItem == '') {
            $TemplateItem = 'No se ha definido un template (Purchase Requests)';
        }
        $find = array(
            '[id]',
            '[Seller]',
            '[Customer]',
            '[CustomerName]',
            '[CustomerCompany]',
            '[CustomerRUT]',
            '[CustomerEmail]',
            '[CustomerPhone]',
            '[SellerCompany]',
            '[SellerName]',
            '[RUT]',
            '[email]',
            '[Phone]',
            '[PID]',
            '[OrderPurchase]',
            '[Currency]',
            '[UnitPrice]',
            '[Quantity]',
            '[TotalPrice]',
            '[OrderDate]',
            '[SellerOpinion]',
            '[CustomerOpinion]',
            '[SellerSemaphore]',
            '[CustomerSemaphore]',
            '[Semaphore]',
            '[Finalized]',
            '[FinalizedDate]',
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
            '[TextExpired]'
        );
        $Thisitem = '';
        if (!empty($Query)) {
            foreach ($Query as $item) {

                $Products = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes();
                $Products->setProductImageSize($Settings['ProductImageSize']);

                $Seller = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes();
                $SellerDataset = $Seller->GetByID($item->Seller);

                $Customer = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes();
                $CustomerDataset = $Customer->GetByID($item->Customer);

                $replace = array(
                    $item->id,
                    $item->Seller,
                    $item->Customer,
                    $CustomerDataset->Name . ' ' . $CustomerDataset->Surname,
                    $CustomerDataset->Company,
                    $CustomerDataset->RUT,
                    $CustomerDataset->email,
                    $CustomerDataset->Phone,
                    $SellerDataset->Company,
                    $SellerDataset->Name . ' ' . $SellerDataset->Surname,
                    $SellerDataset->RUT,
                    $SellerDataset->email,
                    $SellerDataset->Phone,
                    $item->PID,
                    $item->OrderPurchase,
                    $Products->ProductCurrency($item->Currency),
                    $item->UnitPrice,
                    $item->Quantity,
                    $item->TotalPrice,
                    $item->OrderDate,
                    $item->SellerOpinion,
                    $item->CustomerOpinion,
                    self::Semaphore($item->SellerSemaphore, 0, $Settings['whois']),
                    self::Semaphore($item->CustomerSemaphore, 1, $Settings['whois']),
                    self::SemaphoreConstruct($item),
                    self::Finalized($item->Finalized),
                    $item->FinalizedDate,
                    $item->Title,
                    $item->Price,
                    $Products->ProductImage($item, 'ProductImage', 'ProductImageSize'),
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
                    $Products->ProductCurrency($item->Currency),
                    $Products->ProductCurrencyPrice($item->Currency, $item->Price),
                    $item->RecycleBin,
                    $item->Packing,
                    $item->RelatedDocument,
                    $Products->ProductImage($item, 'Image2', 'Image2Size'),
                    $Products->ProductImage($item, 'Image3', 'Image3Size'),
                    $Products->ProductImage($item, 'Image4', 'Image4Size'),
                    $Products->ProductImage($item, 'Image5', 'Image5Size'),
                    $Products->ProductImage($item, 'Image6', 'Image6Size'),
                    $item->Date,
                    $item->expiredate,
                    invertirFecha($item->Date),
                    invertirFecha($item->expiredate),
                    $item->Plan,
                    $item->CatP,
                    $item->Cat,
                    $item->Priority,
                    $Products->CompanyLink($item->id, $item->CompanyUrl, $item->Company),
                    $Products->ProductMedal($item->Plan_Name),
                    $Products->ProductUrlDetail($item),
                    $this->stock,
                    $Products->UnitOrAll($item->UnitOrAll),
                    $Products->Expired($item),
                    $Products->Expired($item, true)
                );
                $Thisitem .= str_replace($find, $replace, $Settings['TemplateItem']);
            }
        }
        return $Thisitem;
    }

    protected function CustomGetList($InstancsParams) {
        $SelfParams = array(
            'TemplateItem' => $this->ListTemplate,
            'ShowExpired' => 1,
        );
        $Settings = array_merge($this->DefaultParams, $SelfParams, $InstancsParams);
        $this->DefaultParams = $Settings;

        $SKTDB = \CmsDev\Sql\db_Skt::connect();

        $Query = $SKTDB->get_results("SELECT * FROM purchase_requests");

        $QueryWhere = ' purchase.id!=0 ';
        if ($Settings['IDUser'] != '') {
            if ($Settings['whois'] == 'Seller') {
                $QueryWhere .= ' AND purchase.Seller = "' . $Settings['IDUser'] . '" '
                        . 'AND product.ProductUID = purchase.PID '
                        . 'AND user.id = purchase.Seller AND profile.IDX = purchase.Seller';
            } elseif ($Settings['whois'] == 'Customer') {
                $QueryWhere .= ' AND purchase.Customer = "' . $Settings['IDUser'] . '" '
                        . 'AND product.ProductUID = purchase.PID '
                        . 'AND user.id = purchase.Customer AND profile.IDX = purchase.Customer';
            } else {
                //$QueryWhere = ' purchase.Customer = "' . $Settings['IDUser'] . '" OR purchase.Seller = "' . $Settings['IDUser'] . '" ';
                $QueryWhere = ' purchase.Customer = "0" AND purchase.Seller = "0" ';
            }
        }
        $CustomQuery = "SELECT * "
                . "FROM "
                . "purchase_requests as purchase "
                . "JOIN " . \DB_PREFIX . "products AS product "
                . "JOIN users AS user "
                . "JOIN userprofile AS profile "
                . "WHERE " . $QueryWhere . "  "
                . "ORDER BY purchase.id DESC "
                . "LIMIT " . $Settings['Limit'];
        ;
        //echo $CustomQuery;
        $Query = $SKTDB->get_results($CustomQuery);

        return $this->TemplateItem($Query, $Settings);
    }

    protected function GetDataset($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $CustomQuery = "SELECT PurchaseRequests.*, BPPlan.*, user.*, profile.* FROM "
                . "purchase_requests AS PurchaseRequests "
                . "JOIN plan as BPPlan "
                . "JOIN users AS user "
                . "JOIN userprofile as profile "
                . "ON PurchaseRequests.Plan = BPPlan.Plan_id AND PurchaseRequests.IDUser = user.id AND profile.IDX = user.id "
                . "WHERE PurchaseRequestsUID = " . GetSQLValueString($ID, 'int');
        $Query = $SKTDB->get_row($CustomQuery);
        return $Query;
    }

    function html($string) {
        return htmlspecialchars($string, ENT_COMPAT | ENT_XHTML, 'ISO-8859-1');
    }

    protected function MailerPurchaseDataset($PurchaseID, $SellerID, $CustomerID, $ProductUID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $SellerQuery = $SKTDB->get_row("SELECT user.*, profile.* FROM users AS user JOIN userprofile as profile ON profile.IDX = user.id WHERE user.id = "
                . "" . GetSQLValueString($SellerID, 'int'));
        $CustomerQuery = $SKTDB->get_row("SELECT user.*, profile.* FROM users AS user JOIN userprofile as profile ON profile.IDX = user.id WHERE user.id = "
                . "" . GetSQLValueString($CustomerID, 'int'));
        $PurchaseQuery = $SKTDB->get_row("SELECT * FROM purchase_requests WHERE id = "
                . "" . GetSQLValueString($PurchaseID, 'int'));
        $ProductQuery = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "products WHERE ProductUID = "
                . "" . GetSQLValueString($ProductUID, 'int'));

        if ($ProductQuery->Currency == 0) {
            $Currency = '$';
        } else {
            $Currency = 'U$S';
        }
        $Customer_Picture = "/" . $CustomerQuery->ClientAuth_picture;
        if (strpos($CustomerQuery->ClientAuth_picture, 'http') === false) {
            $Customer_Picture = \SITE_SERVER . "/" .$CustomerQuery->ClientAuth_picture;
        }
        $Seller_Picture = "/" . $SellerQuery->ClientAuth_picture;
        if (strpos($SellerQuery->ClientAuth_picture, 'http') === false) {
            $Seller_Picture = \SITE_SERVER . "/" .$SellerQuery->ClientAuth_picture;
        }
        $InstancsParams = array(
            'URL' => \SITE_SERVER,
            'ASSETS' => \SITE_SERVER . '/CmsDev/' . \VERSION . '/CRUD/ViewEditElementsAsList/Lists/Mailer/Assets/',
            'Template_Logo' => \SERVER_DIR . \SKTURL_TemplateSite . '/assets/img/logo.png',
            'Email_Info' => \SKT_SITE_EMAIL,
            "Template_Product_Quantity" => $PurchaseQuery->Quantity,
            "Template_Product_Total" => $PurchaseQuery->TotalPrice,
            "Template_Product_Description" => $this->html($ProductQuery->ProductDescription),
            "Template_Product_Url" => "/Detail/" . $ProductQuery->ProductUID . "/" . $ProductQuery->URLName . "/",
            "Template_OrderPurchase" => $PurchaseQuery->OrderPurchase,
            "Template_Seller_Url" => "/usr/" . $SellerID . "/" . $SellerQuery->CompanyUrl . "/",
            "Template_Seller_Email" => $SellerQuery->email,
            "Template_Seller_Company" => $this->html($SellerQuery->Company),
            "Template_Seller_Phone" => $SellerQuery->Phone,
            "Template_Seller_Address" => $this->html($SellerQuery->Address),
            "Template_Seller_Logo" => $Seller_Picture,
            "Template_Customer_Url" => "/usr/" . $CustomerID . "/" . $CustomerQuery->CompanyUrl . "/",
            "Template_Customer_Email" => $CustomerQuery->email,
            "Template_Customer_Company" => $this->html($CustomerQuery->Company),
            "Template_Customer_Phone" => $CustomerQuery->Phone,
            "Template_Customer_Address" => $this->html($CustomerQuery->Address),
            "Template_Customer_Logo" => $Customer_Picture,
            "Template_Product_Image" => $ProductQuery->ProductImage,
            "Template_Product_Title" => $this->html($ProductQuery->Title),
            "Template_Product_Price" => $ProductQuery->Price,
            "Template_Product_Currency" => $Currency
        );
        //var_dump($InstancsParams);
        $Mailer = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Mailer\_classes;
        $Mailer->To_Customer($InstancsParams);
        $Mailer->To_Seller($InstancsParams);
    }

    protected function AddPurchase() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $queryPurchaseRequestsFields = $queryPurchaseRequestsValues = '';

        if (isset($_POST['data']) && $_POST['data'] != '') {
            $RData = json_decode(\CmsDev\skt_Code::Decode($_POST['data']));
            foreach ($RData as $data => $Value) {
                $CompiledData[$data] = $Value;
            }
            foreach ($CompiledData as $Field => $Value) {
                if (array_key_exists($Field, $this->PurchaseRequestsFields)) {
                    $queryPurchaseRequestsFields.= $Field . ',';
                }
            }
            foreach ($CompiledData as $Field => $Value) {
                if (array_key_exists($Field, $this->PurchaseRequestsFields)) {
                    $queryPurchaseRequestsValues.= self::DecodeValue(\GetSQLValueString($Value, $this->PurchaseRequestsFields[$Field])) . ',';
                }
            }
        }
        foreach ($_POST as $Field => $Value) {
            if (array_key_exists($Field, $this->PurchaseRequestsFields)) {
                $queryPurchaseRequestsFields.= $Field . ',';
            }
        }
        foreach ($_POST as $Field => $Value) {
            if (array_key_exists($Field, $this->PurchaseRequestsFields)) {
                $queryPurchaseRequestsValues.= self::DecodeValue(\GetSQLValueString($Value, $this->PurchaseRequestsFields[$Field])) . ',';
            }
        }
        $queryPurchaseRequestsFields.= 'TotalPrice';
        $queryPurchaseRequestsValues.= ($CompiledData['UnitPrice'] * $_POST['Quantity']) . ',';

        $queryPurchaseRequestsFieldsTrimed = trim($queryPurchaseRequestsFields, ',');
        $queryPurchaseRequestsValuesTrimed = trim($queryPurchaseRequestsValues, ',');
        $query = "INSERT INTO purchase_requests ($queryPurchaseRequestsFieldsTrimed) VALUES ($queryPurchaseRequestsValuesTrimed)";

        if ($queryPurchaseRequestsFieldsTrimed) {
            $insert = $SKTDB->query($query);
        }
        if ($insert) {
            echo '<h3>Gracias por su compra!</h3><br><p>Consulte su correo, le enviaremos todo lo necesario para completar la compra directamente con la Empresa.</p>';
            $PurchaseID = $SKTDB->insert_id;
            $SellerID = $RData->Seller;
            $CustomerID = $RData->Customer;
            $ProductUID = $RData->PID;
            //var_dump($RData);
            $this->MailerPurchaseDataset($PurchaseID, $SellerID, $CustomerID, $ProductUID);
        } else {
            echo "Lo sentimos , ha ocurrido un error.<br>"
            . "Refresque la p&aacute;gina e intente nuevamente, disculpe las molestias causadas.";
        }
    }

    /*
      '[Seller]',
      '[Customer]',
     */

    protected function Update($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $queryPurchaseRequestsFields = '';
        foreach ($_POST as $Field => $Value) {
            if (in_array($Field, $this->PurchaseRequestsFields)) {
                $queryPurchaseRequestsFields.= $Field . ' = ' . self::DecodeValue(\GetSQLValueString($Value, $this->PurchaseRequestsFields[$Field])) . ',';
            }
        }
        $queryPurchaseRequestsFieldsTrimed = trim($queryPurchaseRequestsFields, ',');
        if ($queryPurchaseRequestsFieldsTrimed) {
            $update = $SKTDB->query("UPDATE purchase_requests Set 
            $queryPurchaseRequestsFieldsTrimed
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

    protected function StateUpdate($POST) {
        /*
          ["Who"]=> "Customer"
          ["OrderPurchase"]=> "MC40MzM3ODQwMCAxNDMxODc1ODk0"
          ["Whois"]=> "132"
          ["SendOrderPurchase"]=> "0"
          ["Opinion"]=> "Excelente vendedor, entrego en tiempo y forma"
          ["Ranking"]=> "5"
          ["Opinion"]=> "Excelente"
         */
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $ThisElement = $SKTDB->get_row("SELECT * FROM purchase_requests WHERE OrderPurchase = " . GetSQLValueString($POST["OrderPurchase"], "text") . " LIMIT 1");
        if ($ThisElement) {
            $SellerOpinion = $ThisElement->SellerOpinion;
            $CustomerOpinion = $ThisElement->CustomerOpinion;
            $SellerSemaphore = $ThisElement->SellerSemaphore;
            $CustomerSemaphore = $ThisElement->CustomerSemaphore;
            $Finalized = $ThisElement->Finalized;
            $FinalizedDate = $ThisElement->FinalizedDate;
            $Ranking = $ThisElement->Ranking;
            $SendToCustomer = false;
            $SendToSeller = false;

            if ($POST["Who"] == "Customer") {
                if ($CustomerSemaphore != 2) {
                    $CustomerOpinion = $POST["Opinion"];
                    $CustomerSemaphore = 2;
                    $Finalized = $Finalized++;
                    $SendToSeller = true;
                }
            }

            if ($POST["Who"] == "Seller") {
                if ($SellerSemaphore != 2) {
                    $SellerOpinion = $POST["Opinion"];
                    $SellerSemaphore = 2;
                    $Finalized = $Finalized++;
                    $SendToCustomer = true;
                }
            }

            if ($Finalized >= 2) {
                $Finalized = 2;
                $FinalizedDate = date('Y-m-d');
            }

            if (isset($POST["Ranking"]) && $POST["Ranking"] >= 1) {
                $Ranking = (int) ($Ranking + $POST["Ranking"]) / 2;
            }

            if (isset($POST["SendOrderPurchase"]) && $POST["SendOrderPurchase"] == 1) {
                $Finalized = 3;
                $FinalizedDate = date('Y-m-d');
            }
            //echo $Ranking;
            //var_dump($POST);
            //exit();
            $Query = "UPDATE purchase_requests Set 
            SellerOpinion = " . \GetSQLValueString($SellerOpinion, "text") . ", 
            CustomerOpinion = " . \GetSQLValueString($CustomerOpinion, "text") . " ,
            SellerSemaphore = " . \GetSQLValueString($SellerSemaphore, "text") . " ,
            CustomerSemaphore = " . \GetSQLValueString($CustomerSemaphore, "text") . " ,
            Finalized = " . \GetSQLValueString($Finalized, "text") . ", 
            FinalizedDate = " . \GetSQLValueString($FinalizedDate, "text") . ", 
            Ranking = " . \GetSQLValueString($Ranking, "int") . "
            WHERE OrderPurchase = " . \GetSQLValueString($POST["OrderPurchase"], "text") . " LIMIT 1";
            $update = $SKTDB->query(sprintf($Query));
        }
        if ($update) {
            echo 'Gracias por su confirmaci&oacute;n!';
        } else {
            echo "Error, intente nuevamente";
            //echo $Query;
        }

        //var_dump($POST);
    }

    protected function State($State, $ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $State = self::DecodeValue(isset($State) ? $State : '');
        $update = $SKTDB->query(sprintf("UPDATE purchase_requests Set 
            Finalized = %s
            WHERE id = %s", \GetSQLValueString($State, "text"), GetSQLValueString($ID, "int")
        ));
        if ($update) {
            echo 'ok';
        } else {
            echo "Error, intente nuevamente";
        }
    }

    protected static function Remove($ID = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $DeleteQuery = $SKTDB->query("DELETE FROM purchase_requests WHERE id = '" . \GetSQLValueString(\str_replace('ID', '', $ID), "int") . "' LIMIT 1");
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

class _classes extends Purchase_Requests {

    public function RenderList() {
        return self::Render();
    }

    public function Dataset($ID) {
        return self::GetDataset($ID);
    }

    public function AddToList() {
        return self::AddPurchase();
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

    public function Confirm($POST) {
        return self::StateUpdate($POST);
    }

    public function GetList($InstancsParams) {
        return self::CustomGetList($InstancsParams);
    }

    public function GetSearchResults($ListTemplate, $Where, $limit, $PurchaseRequestsBeforeList, $PurchaseRequestsAfterList) {
        return self::Search($ListTemplate, $Where, $limit, $PurchaseRequestsBeforeList, $PurchaseRequestsAfterList);
    }

    public function GetListOtherFromUser($ListTemplate, $IDUser, $Exclude, $limit) {
        return self::OtherFromUser($ListTemplate, $IDUser, $Exclude, $limit);
    }

}

?>