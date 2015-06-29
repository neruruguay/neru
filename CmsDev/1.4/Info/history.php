<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of history
 *
 * @author usuario
 */

namespace CmsDev\Info;

class history {

    function __construct($user, $SERVER, $POST, $GET) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $user = $user;
        $url = (!empty($SERVER['HTTPS'])) ? "https://" . $SERVER['SERVER_NAME'] . $SERVER['REQUEST_URI'] : "http://" . $SERVER['SERVER_NAME'] . $SERVER['REQUEST_URI'];
        $previousUrl = (isset($SERVER['HTTP_REFERER'])) ? $SERVER['HTTP_REFERER'] : '0';
        $postData = json_encode($POST);
        $now = date("Y-m-d H:i:s");
        $product = (isset($GET['DetailID'])) ? $GET['DetailID'] : '';
        $search = (isset($GET['SearchQuery'])) ? $GET['SearchQuery'] : '';
        $query = "INSERT INTO userstep"
                . "(user, previous_page, url_query_string, post_param, date_time, product, search )"
                . "VALUES ("
                . GetSQLValueString($user, 'int') . ","
                . GetSQLValueString($previousUrl, 'text') . ","
                . GetSQLValueString($url, 'text') . ","
                . GetSQLValueString($postData, 'text') . ","
                . GetSQLValueString($now, 'text') . ","
                . GetSQLValueString($product, 'int') . ","
                . GetSQLValueString($search, 'text') . ")";
        $insert = $SKTDB->query($query);
    }

}
