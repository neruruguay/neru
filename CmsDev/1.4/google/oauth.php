<?php

/**
 * Description of oauth
 *
 * @author Martín Daguerre
 */

namespace CmsDev\google;

require_once 'Google_Client.php';
require_once 'contrib/Google_Oauth2Service.php';

class oauth {

    public $setApplicationName = 'Negocios en Red';
    public $setClientId = '496144361420-f84kjcoccmo99a2pntbibhuaqkf1umt6.apps.googleusercontent.com';
    public $setClientSecret = '-MZG0o27g6S9yT8u99O5Ea5L';
    public $setRedirectUri = 'http://2015.negociosenred.uy/login_with_google/';
    public $setDeveloperKey = '496144361420-f84kjcoccmo99a2pntbibhuaqkf1umt6@developer.gserviceaccount.com';
    public $personMarkup = '';
    public $ClientAuth = '';
    public $family_name = '';
    public $name = '';
    public $locale = '';
    public $gender = '';
    public $email = '';
    public $link = '';
    public $given_name = '';
    public $id = '';
    public $verified_email = '';
    public $picture = '';
    public $Info = array();
    public $Profile;
    public $ServiceProviderImage = 'Google';
    public $createAuthUrl = '';

    public function GoogleUser() {

        $client = new \Google_Client();
        $client->setApplicationName(\SKT_GOOGLEOAUTH2_SETAPPLICATIONNAME);

        // Visit https://code.google.com/apis/console?api=plus to generate your
        // oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
        $client->setClientId(\SKT_GOOGLEOAUTH2_SETCLIENTID);
        $client->setClientSecret(\SKT_GOOGLEOAUTH2_SETCLIENTSECRET);
        $client->setRedirectUri(\SKT_GOOGLEOAUTH2_SETREDIRECTURI);
        $client->setDeveloperKey(\SKT_GOOGLEOAUTH2_SETDEVELOPERKEY);
        $oauth2 = new \Google_Oauth2Service($client);

        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            $redirect = \SITE_SERVER;
            \CmsDev\Header\refresh::refreshNow(\filter_var($redirect, FILTER_SANITIZE_URL));
            return;
        }

        if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
        }

        if (isset($_REQUEST['logout']) or \THIS_URL_REAL === 'UserLogout') {
            unset($_SESSION['token']);
            $client->revokeToken();
        }

        if ($client->getAccessToken()) {
            $user = $oauth2->userinfo->get();

// These fields are currently filtered through the PHP sanitize filters.
// See http://www.php.net/manual/en/filter.filters.sanitize.php

            $this->family_name = filter_var($user['family_name'], \FILTER_SANITIZE_STRING);
            $this->name = filter_var($user['name'], \FILTER_SANITIZE_STRING);
            $this->locale = filter_var($user['locale'], \FILTER_SANITIZE_STRING);
            $this->gender = filter_var($user['gender'], \FILTER_SANITIZE_STRING);
            $this->email = filter_var($user['email'], \FILTER_SANITIZE_EMAIL);
            $this->link = filter_var($user['link'], \FILTER_SANITIZE_URL);
            $this->given_name = filter_var($user['given_name'], \FILTER_SANITIZE_STRING);
            $this->id = filter_var($user['id'], \FILTER_SANITIZE_STRING);
            $this->verified_email = filter_var($user['verified_email'], \FILTER_SANITIZE_STRING);
            if (isset($user['picture']) && $user['picture'] != '') {
                $this->picture = filter_var($user['picture'], \FILTER_VALIDATE_URL);
            } else {
                $this->picture = \SKT_ACCESS_AVATAR;
            }
            $this->ClientAuth = 'Google';
            $_SESSION['token'] = $client->getAccessToken();
            $this->createAuthUrl = $client->createAuthUrl();
            $this->Info = array(
                'family_name' => HtmlSpecialChars($this->family_name),
                'name' => HtmlSpecialChars($this->name),
                'locale' => $this->locale,
                'gender' => $this->gender,
                'email' => $this->email,
                'link' => $this->link,
                'given_name' => HtmlSpecialChars($this->given_name),
                'id' => $this->id,
                'verified_email' => $this->verified_email,
                'picture' => $this->picture,
                'ClientAuth' => $this->ClientAuth,
                'createAuthUrl' => $this->createAuthUrl
            );
            \CmsDev\Security\UserRegister::checkAction($this->Info);
            return true;
        } else {
            $this->createAuthUrl = $client->createAuthUrl();
            new \CmsDev\Url\refer();
            return false;
        }
    }

}

?>
