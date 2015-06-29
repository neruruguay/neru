<?php

/**
 * Description of  Users
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\ViewEditElementsAsList\Lists\Users;

class Users {

    protected $ListTemplate = '<div class="col-md-4 col-masonry element-item">
                    <a class="col-xs-12 col-sm-6 col-md-6" href="/usr/[id]/[Company]/">
                <div class="product-thumb product-thumb-horizontal padding">
                    <header class="product-header col-md-4">
                        <img title="[Company]" alt="[Company]" src="[ClientAuth_picture]"/>
                    </header>
                    <div class="product-desciption col-md-8">
                        <h5 class="product-title">[Company]</h5>
                        <div class="product-desciption">[Description]</div>
                        <div class="product-meta hidden"><span class="product-time"><i class="fa fa-map-marker"></i> [Address]</span>
                            <ul class="product-price-list">
                                <li>
                                    <span class="product-save"><i class="fa fa-phone"></i> [Phone]</span>
                                </li>
                            </ul>
                        </div>
                        <p class="product-location text-left">
                        <h5>Categor&iacute;as</h5>
                        <span class="small">[category1]</span><br>
                        <span class="small">[category2]</span><br>
                        <span class="small">[category3]</span><br>
                        <span class="small">[category4]</span><br>
                        <span class="small">[category5]</span>
                        </p>
                    </div>
                </div>
            </a>
    </div>';

    protected static function Render() {
        $html = '';
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $ListCatNames = new \CmsDev\Dataset\Categories();
        $query = $SKTDB->get_results("SELECT * FROM users as user join userprofile as profile WHERE user.id = profile.idX ORDER BY Company ASC");

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
                '[id]',
                '[Company]',
                '[RUT]',
                '[email]',
                '[level]',
                '[Position]',
                '[Name]',
                '[Surname]',
                '[Address]',
                '[Phone]',
                '[ClientAuth_picture]',
                '[category1]',
                '[category2]',
                '[category3]',
                '[category4]',
                '[category5]'
            );
            $replace = array(
                $itemId->id,
                $itemId->Company,
                $itemId->RUT,
                $itemId->email,
                $itemId->level,
                $itemId->Position,
                $itemId->Name,
                $itemId->Surname,
                $itemId->Address,
                $itemId->Phone,
                $itemId->ClientAuth_picture,
                $ListCatNames->getName()[$itemId->category1],
                $ListCatNames->getName()[$itemId->category2],
                $ListCatNames->getName()[$itemId->category3],
                $ListCatNames->getName()[$itemId->category4],
                $ListCatNames->getName()[$itemId->category5]
            );
            $Thisitem = str_replace($find, $replace, $TemplateItem);
            echo utf8_encode($Thisitem);
        }
    }

    protected static function Add($LevelType = 'Customers', $ClientAuth = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Type = self::DecodeValue(isset($Type) ? $Type : 'Customers');
        $Description = self::DecodeValue(isset($Description) ? $Description : '');

        $insert = $SKTDB->query("INSERT INTO users (Title, Description, url, icon, Sid) 
		VALUES (" .
                \GetSQLValueString($Title, "text") . "," .
                \GetSQLValueString($Description, "text") . "," .
                \GetSQLValueString($url, "text") . "," .
                \GetSQLValueString($icon, "text") . "," .
                \GetSQLValueString($Sid, "int") . ")"
        );
        if ($insert) {
            echo 'okay';
        } else {
            echo "error";
        }
    }

    protected static function Edit($ID = '', $Company = '', $RUT = '', $CompanyUrl = '', $Description = '', $category1 = '', $category2 = '', $category3 = '', $category4 = '', $category5 = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Company = self::DecodeValue(isset($Company) ? $Company : '');
        $Description = self::DecodeValue(isset($Description) ? $Description : '');
        $update = $SKTDB->query(sprintf("UPDATE userprofile Set 
            Company = %s,
            RUT = %s, 
            category1 = %s,
            category2 = %s,
            category3 = %s,
            category4 = %s,
            category5 = %s
            WHERE IDX = %s", \GetSQLValueString($Company, "text"), \GetSQLValueString($RUT, "text"), \GetSQLValueString($category1, "text"), GetSQLValueString($category2, "text"), GetSQLValueString($category3, "text"), GetSQLValueString($category4, "text"), GetSQLValueString($category5, "text"), GetSQLValueString($ID, "int")
        ));
        $update2 = $SKTDB->query(sprintf("UPDATE users Set 
            Description = %s,
            CompanyUrl = %s
            WHERE id = %s", \GetSQLValueString($Description, "text"), \GetSQLValueString($CompanyUrl, "text"), GetSQLValueString($ID, "int")
        ));
        if ($update && $update2) {
            echo 'okay';
        } else {
            echo "error";
        }
    }

    protected static function UpdateData($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();

        $queryUserFields = '';
        $queryUserprofileFields = '';
        $queryUserValues = '';
        $queryUserprofileValues = '';

        $userFields = array('email', 'cust_no', 'Description', 'Lat', 'Lon', 'zoom', 'website', 'ViewHelp');

        $userprofileFields = array(
            'level', 'Company', 'RUT', 'Position', 'Name', 'Surname', 'Country', 'City', 'CP', 'Address',
            'eFrom', 'eTo', 'Phone', 'payment_method', 'created', 'ClientAuth', 'ClientAuth_id',
            'ClientAuth_link', 'ClientAuth_name', 'ClientAuth_family_name', 'ClientAuth_given_name',
            'ClientAuth_email', 'ClientAuth_picture', 'ClientAuth_locale', 'ClientAuth_gender',
            'category1', 'category2', 'category3', 'category4', 'category5');

        foreach ($_POST as $Field => $Value) {
            if (in_array($Field, $userFields)) {
                $queryUserFields.= $Field . ' = ' . self::DecodeValue(\GetSQLValueString($Value, "text")) . ',';
            }
            if (in_array($Field, $userprofileFields)) {
                $queryUserprofileFields.= $Field . ' = ' . self::DecodeValue(\GetSQLValueString($Value, "text")) . ',';
            }
        }
        $queryUserFieldsTrimed = trim($queryUserFields, ',');
        $queryUserValuesTrimed = trim($queryUserValues, ',');
        $queryUserprofileFieldsTrimed = trim($queryUserprofileFields, ',');
        $queryUserprofileValuesTrimed = trim($queryUserprofileValues, ',');
//        echo "UPDATE userprofile Set 
//            $queryUserprofileFieldsTrimed
//            WHERE IDX = ".GetSQLValueString($ID, "int");
//        echo "UPDATE users Set 
//            $queryUserFieldsTrimed
//            WHERE id = ".GetSQLValueString($ID, "int");
//        exit();
        if ($queryUserprofileFieldsTrimed != '') {
            $update = $SKTDB->query("UPDATE userprofile Set 
            $queryUserprofileFieldsTrimed
            WHERE IDX = " . GetSQLValueString($ID, "int"));
        } else {
            $update = true;
        }
        if ($queryUserFieldsTrimed) {
            $update2 = $SKTDB->query("UPDATE users Set 
            $queryUserFieldsTrimed
            WHERE id = " . GetSQLValueString($ID, "int"));
        } else {
            $update2 = true;
        }
        if ($update && $update2) {
            echo 'Los datos fueron actualizados correctamente.';
        } else {
            echo "error";
        }
    }

    public static function GetUseTheme($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_row("SELECT * FROM user_theme WHERE IDX = '" . \GetSQLValueString($ID, "int") . "'");
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    protected static function PassRecovery($email) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();

        $UQuery = "SELECT * FROM users WHERE email = " . \GetSQLValueString($email, "text") . " LIMIT 1";
        $User = $SKTDB->get_row($UQuery);
        if ($User) {
            $t = md5(microtime(TRUE));
            $UQueryToken = "UPDATE users Set token =  " . \GetSQLValueString($t, "text") . " WHERE email = " . \GetSQLValueString($email, "text") . " LIMIT 1";
            $Usertoken = $SKTDB->query($UQueryToken);
            $username = $User->username;
            $activekey = $User->activekey;
            $resetkey = $User->resetkey;
            $md5 = $User->md5;
            $Name = $User->Name;
            $Surname = $User->Surname;
            $Company = $User->Company;
            $RUT = $User->RUT;
            $Position = $User->Position;
            $Address = $User->Address;
            $Phone = $User->Phone;

            $URLActivate = \SITE_SERVER . "PasswordRecovery?codeValidate=" . $md5 . "&tokenValidate=" . $t;
            $code = "";
            $Sitio = SITE_SERVER;
            $TemplateSite = SKT_TEMPLATE;
            $Logo = SERVER_DIR . SKTURL_TemplateSite . '/assets/img/logo.png';
            $Assets = \SITE_SERVER . '_TemplateSite/NegociosEnRed/mails/assets/';

            $Mail_PassRecovery = SKTPATH_CmsDev . 'CRUD' . DS . 'ViewEditElementsAsList' . DS . 'Lists' . DS . 'Users' . DS . 'PasswordRecovery.php';
            $EmailMessagge = \file_get_contents($Mail_PassRecovery);
            $find = array('[Assets]', '[Sitio]', '[Logo]', '[URLActivate]', '[code]', '[username]', '[activekey]', '[resetkey]', '[md5]', '[Name]', '[Surname]', '[Company]', '[RUT]', '[Position]', '[Address]', '[Phone]', '[email]');
            $replace = array($Assets, $Sitio, $Logo, $URLActivate, $code, $username, $activekey, $resetkey, $md5, $Name, $Surname, $Company, $RUT, $Position, $Address, $Phone, $email);
            $EmailMessagge = str_replace($find, $replace, $EmailMessagge);
//-------------------------------------------------------//
            $InfoEMAIL = SKT_SITE_EMAIL;
            $Emailfrom = SKT_SITE_EMAIL;
            $Emailto = $email;
            $EmailSubject = SKT_SITE_NAME . ' - Registro de usuario';
//-------------------------------------------------------//
            $smtp = new \CmsDev\Security\smtp\smtp();
            $smtp->host_name = "localhost";       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
            $smtp->host_port = 26;                /* Change this variable to the port of the SMTP server to use, like 465 */
            $smtp->ssl = 0;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
            $smtp->http_proxy_host_name = '';     /* Change this variable if you need to connect to SMTP server via an HTTP proxy */
            $smtp->http_proxy_host_port = 3128;   /* Change this variable if you need to connect to SMTP server via an HTTP proxy */
            $smtp->socks_host_name = '';        /* Change this variable if you need to connect to SMTP server via an SOCKS server */
            $smtp->socks_host_port = 1080;      /* Change this variable if you need to connect to SMTP server via an SOCKS server */
            $smtp->socks_version = '5';         /* Change this variable if you need to connect to SMTP server via an SOCKS server */
            $smtp->start_tls = 0;                 /* Change this variable if the SMTP server requires security by starting TLS during the connection */
            $smtp->localhost = "localhost";       /* Your computer address */
            $smtp->direct_delivery = 0;           /* Set to 1 to deliver directly to the recepient SMTP server */
            $smtp->timeout = 10;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
            $smtp->data_timeout = 0;              /* Set to the number seconds wait for sending or retrieving data from the SMTP server.
              Set to 0 to use the same defined in the timeout variable */
            $smtp->debug = 0;                     /* Set to 1 to output the communication with the SMTP server */
            $smtp->html_debug = 0;                /* Set to 1 to format the debug output as HTML */
            $smtp->pop3_auth_host = "";           /* Set to the POP3 authentication host if your SMTP server requires prior POP3 authentication */
            $smtp->user = "";                     /* Set to the user name if the server requires authetication */
            $smtp->realm = "";                    /* Set to the authetication realm, usually the authentication user e-mail domain */
            $smtp->password = "";                 /* Set to the authetication password */
            $smtp->workstation = "";              /* Workstation name for NTLM authentication */
            $smtp->authentication_mechanism = "PLAIN"; /* Specify a SASL authentication method like LOGIN, PLAIN, CRAM-MD5, NTLM, etc..
              Leave it empty to make the class negotiate if necessary */
            if ($smtp->SendMessage(
                            $Emailfrom, array(
                        $Emailto
                            ), array(
                        "X-Mailer: PHP/" . phpversion() . "",
                        "MIME-Version: 1.0",
                        "Content-type: text/html; charset=iso-8859-1",
                        "Content-Transfer-Encoding: 8bit",
                        "From: $Emailfrom",
                        "To: $Emailto" . ";" . $Emailfrom,
                        "Subject: " . $EmailSubject,
                        "Date: " . strftime("%a, %d %b %Y %H:%M:%S %Z")
                            ), $EmailMessagge)) {
                return "<br>" . $username . ".<br>Hemos enviado un link a su casilla de correos para que genere una nueva contrase&ntilde;a.<br>Revisa tu correo.";
            } else {
                return "No se puede validar, comuniquese con Negocios en Red para asistencia.";
            }
        } else {
            return 'No encontramos un usuario con esa direcci&oacute;n de correo.<br> Verifiquela e intente nuevamente.';
        }
    }

    protected static function Token($code, $token) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $UQuery = "SELECT * FROM users JOIN userprofile ON users.id = userprofile.IDX WHERE md5 = " . \GetSQLValueString($code, "text") . " AND token = " . \GetSQLValueString($token, "text") . " LIMIT 1";
        $User = $SKTDB->get_row($UQuery);
        if ($User) {
            return $User;
        }
    }

    protected static function UpdatePassword($ID, $token, $password) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $UQueryPass = "UPDATE users Set password =  " . \GetSQLValueString(md5($password), "text") . ", token = '' WHERE id = " . \GetSQLValueString($ID, "int") . " AND token = " . \GetSQLValueString($token, "text") . " LIMIT 1";
        $QueryPass = $SKTDB->query($UQueryPass);
        if ($QueryPass) {
            return 'ok';
        }
    }

    protected static function UpdateInterests($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Interests = explode(',', trim($_POST['Interests'], ','));
        $InterestJson = '{"id":' . json_encode($Interests) . '}';
        $UQueryPass = "UPDATE user_interests "
                . "SET interests =  " . \GetSQLValueString($InterestJson, "text") . " "
                . "WHERE UID = " . \GetSQLValueString($ID, "int") . " LIMIT 1";
        $QueryPass = $SKTDB->query($UQueryPass);
        if ($QueryPass) {
            echo 'Los datos fueron actualizados correctamente.';
        } else {
            $insert = $SKTDB->query("INSERT INTO user_interests (UID, interests) 
		VALUES (" .
                    \GetSQLValueString($ID, "int") . "," .
                    \GetSQLValueString($InterestJson, "text") . ")"
            );
            if ($insert) {
                echo 'Los datos fueron actualizados correctamente.';
            } else {
                echo "error";
            }
        }
    }

    public static function GetUserLogged() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_row("SELECT *
                    FROM users as user join userprofile as profile 
                    ON user.md5 = " . \GetSQLValueString($_SESSION['login'], 'int') . "
                    WHERE user.id = profile.IDX 
            ");
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    protected static function UpdateTheme($ID) {
        $queryUserFields = '';
        $userFields = array('ColorTheme', 'WideBoxed', 'Pattern', 'Background');

        $SKTDB = \CmsDev\Sql\db_Skt::connect();

        $IDX = $SKTDB->get_var("SELECT IDX FROM user_theme WHERE IDX = '" . \GetSQLValueString($ID, "int") . "'");
        if ($IDX) {
            foreach ($_POST as $Field => $Value) {
                if (in_array($Field, $userFields)) {
                    $queryUserFields.= $Field . ' = ' . self::DecodeValue(\GetSQLValueString($Value, "text")) . ',';
                }
            }
            $queryUserFieldsTrimed = trim($queryUserFields, ',');

            if ($queryUserFieldsTrimed) {
                $update = $SKTDB->query("UPDATE user_theme Set 
            $queryUserFieldsTrimed
            WHERE IDX = " . GetSQLValueString($ID, "int"));
            } else {
                $update = true;
            }
            if ($update) {
                echo 'Los datos fueron actualizados correctamente.';
            } else {
                echo "error";
            }
        } else {
            $insert = $SKTDB->query("INSERT INTO user_theme (IDX, ColorTheme, WideBoxed, Pattern, Background, BackgroundCustom) 
		VALUES (" .
                    \GetSQLValueString($ID, "int") . "," .
                    \GetSQLValueString($_POST['ColorTheme'], "text") . "," .
                    \GetSQLValueString($_POST['WideBoxed'], "text") . "," .
                    \GetSQLValueString($_POST['Pattern'], "text") . "," .
                    \GetSQLValueString($_POST['Background'], "text") . "," .
                    \GetSQLValueString($_POST['BackgroundCustom'], "text") . ")"
            );
            if ($insert) {
                echo 'Los datos fueron actualizados correctamente.';
            } else {
                echo "error";
            }
        }
    }

    protected static function Avatar($Image, $ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Image = self::DecodeValue(isset($Image) ? $Image : '');
        $update = $SKTDB->query(sprintf("UPDATE userprofile Set 
            ClientAuth_picture = %s
            WHERE IDX = %s", \GetSQLValueString($Image, "text"), GetSQLValueString($ID, "int")
        ));

        if ($update) {
            echo 'Imagen actualizada';
        } else {
            echo "Error, intente nuevamente";
        }
    }

    protected static function GetUserByID($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_row("SELECT *
                    FROM users as user join userprofile as profile 
                    ON user.id = " . \GetSQLValueString($ID, 'int') . "
                    WHERE user.id = profile.IDX 
            ");
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    protected function Search($ListTemplate = '', $Where = '', $limit = 100, $ProductBeforeList, $ProductAfterList) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Where = self::DecodeValue($Where);
        $QueryWhere = '';
        $QueryWhereCheck = 'AND user.isactive = "1" ';
        $words = str_word_count($Where, 1);
        foreach ($words as $word) {

            $QueryWhere .= ' profile.Name like "%' . $word . '%" ' . $QueryWhereCheck . '';
            $QueryWhere .= ' OR (profile.Surname like "%' . $word . '%" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (profile.Address like "%' . $word . '%" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (profile.Company like "%' . $word . '%" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (user.username like "%' . $word . '%" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (user.Description like "%' . $word . '%" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (user.website like "%' . $word . '%" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (user.email like "%' . $word . '%" ' . $QueryWhereCheck . ')';

            $QueryWhere .= ' OR (profile.Name like "%' . $word . '" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (profile.Surname like "%' . $word . '" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (profile.Address like "%' . $word . '" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (profile.Company like "%' . $word . '" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (user.username like "%' . $word . '" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (user.Description like "%' . $word . '" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (user.website like "%' . $word . '" ' . $QueryWhereCheck . ')';
            $QueryWhere .= ' OR (user.email like "%' . $word . '" ' . $QueryWhereCheck . ')';


            $Where .= ' ' . $word . 's';
            $word = rtrim($word, 's');
            $Where .= ' ' . $word . 's';
        }
        $MATCH = 'profile.Name,profile.Surname,profile.Address,profile.Company,user.username,user.Description,user.website,user.email';
        $CustomQuery = "SELECT user.*, profile.*,
            MATCH(" . $MATCH . ")
            AGAINST('$Where' IN BOOLEAN MODE) AS sort_rel FROM "
                . "users AS user "
                . "JOIN userprofile as profile "
                . "ON user.id = profile.IDX "
                . "WHERE " . $QueryWhere . " OR((MATCH(" . $MATCH . ") "
                . "AGAINST('$Where' IN BOOLEAN MODE) )) HAVING sort_rel > 0.2  LIMIT " . $limit;
        //echo '<div style="position:relative; z-index:9999; background:white">' . $CustomQuery . '</div>';
        $Query = $SKTDB->get_results($CustomQuery);
        if ($ListTemplate == '') {
            $ListTemplate = $this->ListTemplate;
        }
        if ($Query) {
            return $ProductBeforeList . self::TemplateItem($Query, $ListTemplate) . $ProductAfterList;
        }
    }

    protected static function TemplateItem($Query, $TemplateItem = '') {
        $find = array(
            '[id]',
            '[Company]',
            '[CompanyUrl]',
            '[ClientAuth_picture]',
            '[Description]',
            '[Address]',
            '[Phone]',
            '[category1]',
            '[category2]',
            '[category3]',
            '[category4]',
            '[category5]'
        );
        $Thisitem = '';
        if (!empty($Query)) {
            foreach ($Query as $item) {
                $replace = array(
                    $item->id,
                    $item->Company,
                    $item->CompanyUrl,
                    $item->ClientAuth_picture,
                    $item->Description,
                    $item->Address,
                    $item->Phone,
                    $item->category1,
                    $item->category2,
                    $item->category3,
                    $item->category4,
                    $item->category5
                );
                $Thisitem .= str_replace($find, $replace, $TemplateItem);
            }
        }
        return $Thisitem;
    }

    protected static function Remove($id = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $DeleteQuery = $SKTDB->query("DELETE FROM users WHERE id = '" . \GetSQLValueString(\str_replace('id', '', $id), "int") . "' LIMIT 1");
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

class _classes extends Users {

    public function RenderList() {
        return static::Render();
    }

    public function GetByID($id = '') {
        return self::GetUserByID($id);
    }

    public function AddToList($Title, $Description, $url, $icon, $Sid) {
        return static::Add($Title, $Description, $url, $icon, $Sid);
    }

    public function RemoveFromList($id = '') {
        return static::Remove($id);
    }

    public function EditItemList($ID, $Company, $RUT, $CompanyUrl, $Description, $category1, $category2, $category3, $category4, $category5) {
        return static::Edit($ID, $Company, $RUT, $CompanyUrl, $Description, $category1, $category2, $category3, $category4, $category5);
    }

    public function UpdateAvatar($Image, $ID) {
        return static::Avatar($Image, $ID);
    }

    public function Theme($ID) {
        return static::UpdateTheme($ID);
    }

    public function GetSearchResults($ListTemplate, $Where, $limit, $ProductBeforeList, $ProductAfterList) {
        return self::Search($ListTemplate, $Where, $limit, $ProductBeforeList, $ProductAfterList);
    }

    public function GoUpdateData($ID) {
        return static::UpdateData($ID);
    }

    public function GoUpdateInterests($ID) {
        return static::UpdateInterests($ID);
    }

    public function UserPassRecovery($email) {

        return static::PassRecovery($email);
    }

    public function UserToken($code, $token) {
        return static::Token($code, $token);
    }

    public function UserUpdatePassword($ID, $token, $password) {
        return static::UpdatePassword($ID, $token, $password);
    }

}
