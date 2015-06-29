<?php

require_once("JSON.php");
$json = new Services_JSON;

$conexion = mysql_connect("localhost", "usuario", "clave");
mysql_select_db("demo", $conexion);

$queEmp = "SELECT * FROM empresa ORDER BY nombre ASC";
$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);

while ($rowEmp = mysql_fetch_assoc($resEmp)) {
    $data[] = $rowEmp;
}
echo $json->encode($data);
?>