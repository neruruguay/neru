<?php

/**
 * Description of ValidateUserMail
 *
 * @author Mart&iacute;n Daguerre
 */

namespace CmsDev\Security;

use \CmsDev\Info as SKT_INFO;
use \CmsDev\skt_Code as Code;
use \CmsDev\sql\db_Skt as SKT_DB;

class ValidateUserMail {

    function User($User) {
        return $this->sendMailRegistration($User);
    }

    private function sendMailRegistration($User) {
        $SKTDB = SKT_DB::connect();
        $User = $SKTDB->get_row("SELECT *
                    FROM users as user join userprofile as profile 
                    ON user.id = " . \GetSQLValueString($User, 'int') . "
                    WHERE user.id = profile.IDX 
            ");
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
        $email = $User->email;
        $URLActivate = \SITE_SERVER . "/ValidateUser?codeValidate=" . $md5;
        $code = "";
        $Sitio = SITE_SERVER;
        $TemplateSite = SKT_TEMPLATE;
        $Logo = SERVER_DIR . SKTURL_TemplateSite . '/assets/img/logo.png';
        $Assets = \SITE_SERVER . '/_TemplateSite/NegociosEnRed/mails/assets/';
//        $UrlProduct = isset($_POST['UrlProduct']) ? $_POST['UrlProduct'] : '';
//        $UrlProductShort = isset($_POST['UrlProductShort']) ? $_POST['UrlProductShort'] : '';
//        $NameProduct = isset($_POST['NameProduct']) ? $_POST['NameProduct'] : '';
//        $description = isset($_POST['description']) ? $_POST['description'] : '';
//        $idProduct = isset($_POST['idProduct']) ? $_POST['idProduct'] : '';
//        if ($UrlProductShort != '') {
//            $Product = '<tr>
//                <th align="right" valign="middle" nowrap="nowrap" bgcolor="#515050" style="color: #FFF !important;"><strong style="color: #FFF">Interesado en</strong></th>
//                <td align="left" valign="middle" nowrap="nowrap" bgcolor="#F5F5F5">
//                  <h3><a href="' . $UrlProduct . '">' . $NameProduct . '</a></h3>
//                </td>
//              </tr>';
//        }
        $Mail_ValidateRegistration = SKTPATH_CmsDev . 'Security' . DS . 'Mail_ValidateRegistration.php';
        $EmailMessagge = \file_get_contents($Mail_ValidateRegistration);
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

}
