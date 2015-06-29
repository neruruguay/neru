<?php

require_once("JSON.php");
$json = new Services_JSON;

$data[0] = array("nombre" => "Martín", "apellido" => "Camus");
$data[1] = array("nombre" => "Ernesto", "apellido" => "Sabato");

echo $json->encode($data);
?>