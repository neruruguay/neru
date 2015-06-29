<?php

/**
 * Description of Curl
 *
 * @author Martín Daguerre
 */
class Curl {

    public function getCurl($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/2008111317  Firefox/3.0.4');
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}

?>
