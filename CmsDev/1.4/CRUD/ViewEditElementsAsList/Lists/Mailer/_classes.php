<?php

/**
 * Description of  Mailer
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\ViewEditElementsAsList\Lists\Mailer;

class Mailer {

    protected $Find = array();
    protected $Replace = array();
    protected $DefaultParams = array(
        'URL_Twitter' => 'https://twitter.com/negociosuy',
        'URL_Linkedin' => 'https://uy.linkedin.com/negociosuy',
        'URL_Facebook' => 'https://www.facebook.com/Negocios.en.Red.uy',
        'Unsubscribe_Url' => '/unsubscribe/',
        'Banner_Register_Image' => '/_FileSystems/images/vendedor0.jpg',
        'Banner_Register_Text1' => 'CONECTAR, COMPRAR Y VENDER',
        'Banner_Register_Text2' => 'No importa si eres una PYME o formas parte de una gran Empresa.',
        'Banner_Register_Text3' => 'Registra tu empresa y obten 100 Publicaciones de productos y/o Servicios por 6 meses para tu empresa, gratis!.',
        'Banner_Register_Btn1' => 'REGISTRATE COMO USUARIO',
        'Banner_Register_Btn2' => 'REGISTRA TU EMPRESA Y COMIENZA A VENDER',
        'Banner_Register_Btn1_URL' => '/UserLogin/',
        'Banner_Register_Btn2_URL' => '/UserRegistration/'
    );

    protected static function Render() {
        $html = '';
        $fileList = '';
        $MailerTemplates = '<div class="alert col-md-2">';
        global $SKT;
        $ListType = \SKTPATH_CmsDev . 'CRUD/ViewEditElementsAsList/Lists/Mailer/Templates/';
        $handle = opendir($ListType);
        while ($file = readdir($handle)) {
            if (!\is_file($file) && $file != ".." && $file != ".") {
                $properties = \file_get_contents($ListType . $file . '/Properties.json');
                $MailerTemplates.= '<div class="btn btn-default btn-block Add_Mail_' . $file . ' text-center">'
                        . '<h3 class="text-block">' . str_replace('_', ' ', $file) . '</h3>'
                        . '<img src="/CmsDev/' . \VERSION . '/CRUD/ViewEditElementsAsList/Lists/Mailer/Templates/' . $file . '/preview.png" class="img-responsive center m10">'
                        . '<form class="hidden" id="form_Mail_' . $file . '">'
                        . '<input type="text" name="MailName" value="' . str_replace('_', ' ', $file) . '">'
                        . '<textarea name="Template">' . \CmsDev\skt_Code::Encode(include($ListType . $file . '/Template.php')) . '</textarea>'
                        . '<textarea name="data">' . \CmsDev\skt_Code::Encode($properties) . '</textarea>'
                        . '</form>'
                        . '</div>'
                        . '<script type="text/javascript">'
                        . '$(".Add_Mail_' . $file . '").click(function () {'
                        . '     var Mailer_Add_Mail_' . $file . ' = "/SKTGoTo/" + admd2("CRUD/ViewEditElementsAsList/Lists/Mailer/Templates/' . $file . '/test");'
                        . '    jQuery.ajax({'
                        . '        "type": "POST",'
                        . '        "url":  Mailer_Add_Mail_' . $file . ','
                        . '        "cache": false,'
                        . '        "data": $("form#form_Mail_' . $file . '").serialize(),'
                        . '        "success": function (html) {'
                        . '            $("#CmsDevDialogContent").append(html);'
                        . '        }'
                        . '    });'
                        . '});'
                        . '</script>';
            }
        }
        closedir($handle);
        $MailerTemplates.= '</div>';
        echo $MailerTemplates;
    }

    protected function functionName() {
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
    }

    protected function Send_To_Seller($InstancsParams = array()) {
        $SelfParams = array(
            'URL' => \SITE_SERVER,
            'ASSETS' => \SITE_SERVER . '/CmsDev/' . \VERSION . '/CRUD/ViewEditElementsAsList/Lists/Mailer/Assets/',
            'Template_Logo' => \SERVER_DIR . \SKTURL_TemplateSite . '/assets/img/logo.png',
            'Email_Info' => \SKT_SITE_EMAIL,
            'ListType' => \SKTPATH_CmsDev . 'CRUD/ViewEditElementsAsList/Lists/Mailer/Templates/',
            'EmailSubject' => 'Nuevo pedido de Negocios en Red'
        );
        $Settings = array_merge($this->DefaultParams, $SelfParams, $InstancsParams);
        $this->DefaultParams = $Settings;
        $find = array();
        $replace = array();
        foreach ($Settings as $Field => $Value) {
            $find[$Field] = '[' . $Field . ']';
            $replace[$Value] = $Value;
        }
        $HTML = include(\SKTPATH_CmsDev . 'CRUD/ViewEditElementsAsList/Lists/Mailer/Templates/Send_To_Seller/Template.php');
        $EmailMessagge = str_replace($find, $replace, $HTML);
        //echo "Enviando a Vendedor: " . $Settings['Template_Seller_Email'] . "...<br>";
        $this->SendMail($EmailMessagge, $Settings['Template_Seller_Email'], $Settings['EmailSubject']);
        if (\DEBUG_MAILSEND === TRUE) {
            echo $EmailMessagge;
            var_dump($Settings);
        }
    }

    protected function Send_To_Customer($InstancsParams = array()) {
        $SelfParams = array(
            'URL' => \SITE_SERVER,
            'ASSETS' => \SITE_SERVER . '/CmsDev/' . \VERSION . '/CRUD/ViewEditElementsAsList/Lists/Mailer/Assets/',
            'Template_Logo' => \SERVER_DIR . \SKTURL_TemplateSite . '/assets/img/logo.png',
            'Email_Info' => \SKT_SITE_EMAIL,
            'ListType' => \SKTPATH_CmsDev . 'CRUD/ViewEditElementsAsList/Lists/Mailer/Templates/',
            'EmailSubject' => 'Detalle de su compra en Negocios en Red'
        );
        $Settings = array_merge($this->DefaultParams, $SelfParams, $InstancsParams);
        $this->DefaultParams = $Settings;
        $find = array();
        $replace = array();
        foreach ($Settings as $Field => $Value) {
            $find[$Field] = '[' . $Field . ']';
            $replace[$Value] = $Value;
        }
        $HTML = include(\SKTPATH_CmsDev . 'CRUD/ViewEditElementsAsList/Lists/Mailer/Templates/Send_To_Customer/Template.php');
        $EmailMessagge = str_replace($find, $replace, $HTML);
        //echo microtime() . "<br>Enviando a Comprador: " . $Settings['Template_Customer_Email'] . "...<br>";
        $this->SendMail($EmailMessagge, $Settings['Template_Customer_Email'], $Settings['EmailSubject']);
        if (\DEBUG_MAILSEND === TRUE) {
            echo $EmailMessagge;
            var_dump($Settings);
        }
    }

    protected function SendMail($EmailMessagge = '', $Emailto = '', $EmailSubject = '') {
        $Emailfrom = \SKT_SITE_EMAIL;
//-------------------------------------------------------//
        $smtp = new \CmsDev\Security\smtp\smtp();
        $smtp->host_name = "localhost";       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
        $smtp->host_port = 26;                /* Change this variable to the port of the SMTP server to use, like 465 */
        $smtp->ssl = 0;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
        $smtp->http_proxy_host_name = '';     /* Change this variable if you need to connect to SMTP server via an HTTP proxy */
        $smtp->http_proxy_host_port = 3128;   /* Change this variable if you need to connect to SMTP server via an HTTP proxy */
        $smtp->socks_host_name = '';          /* Change this variable if you need to connect to SMTP server via an SOCKS server */
        $smtp->socks_host_port = 1080;        /* Change this variable if you need to connect to SMTP server via an SOCKS server */
        $smtp->socks_version = '5';           /* Change this variable if you need to connect to SMTP server via an SOCKS server */
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
                    $Emailto, $Emailfrom
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
            include 'ValidateUserMessage1.php';
        } else {
            return "no";
        }
    }

    protected static function EncodeValue($value) {

        return \utf8_encode($value);
    }

    protected static function DecodeValue($value) {

        return \utf8_decode($value);
    }

}

class _classes extends Mailer {

    public function RenderList() {

        return static::Render();
    }

    public function AddToList() {

        return static::Add();
    }

    public function To_Customer($InstancsParams) {
        return static::Send_To_Customer($InstancsParams);
    }

    public function To_Seller($InstancsParams) {
        return static::Send_To_Seller($InstancsParams);
    }

}

?>