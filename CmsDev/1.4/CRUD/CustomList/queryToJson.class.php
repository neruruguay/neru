<?php

class QueryToJson {
    /*
     * Function: queryToJson : It converts the query result into a JSON string
     * with $header as the top header with column header as the header for other data values
     * Arguments : $result : mysql result returned by mysql_query(), $header : top header of the JSON object
     * Return : $data : the JSON string
     */

    function queryToJson($result, $header) {
        $resultArray = array();
        $count = 0;
        while ($i = mysql_fetch_row($result)) {
            for ($k = 0; $k < count($i); $k++) {
                $resultArray[$count][mysql_field_name($result, $k)] = $i[$k];
            }
            $count++;
        }
        $data = json_encode($resultArray);
        $data = "{\"$header\":" . $data . "}";
        return $data;
    }

}

?>