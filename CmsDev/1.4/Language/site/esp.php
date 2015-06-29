<?php

/* * ****************     FECHAS    ************** */
$SKT['dateFormat'] = 'Y-m-d';
$SKT['date_def_from'] = \date($SKT['dateFormat'], \time());
$SKT['date_def_to'] = \date($SKT['dateFormat'], \time());
$SKT['date_Hours'] = utf8_encode("horas");
$SKT['date_Minutes'] = utf8_encode("minutos");
$SKT['dayNames'] = utf8_encode("'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'");
$SKT['dayNamesMin'] = utf8_encode("'Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'");
$SKT['dayNamesShortGraph'] = utf8_encode("'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'");
$SKT['dayNamesShort'] = utf8_encode("'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'");
$SKT['monthNames'] = utf8_encode("'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'");
$SKT['monthNamesShort'] = utf8_encode("'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'");
/* * ************************************************* */

$SKT['PAGINATION'] = array(
    "Prev" => utf8_encode('Anterior'),
    "Next" => utf8_encode('Siguiente'),
    "First" => utf8_encode('Primero'),
    "Last" => utf8_encode('Último'),
    "Enlarge" => utf8_encode('Ampliar'),
    "Minimize" => utf8_encode('Cerrar'),
    "Page" => utf8_encode('Página'),
    "Image" => utf8_encode('Imagen'),
    "Of" => utf8_encode('de')
);
?>
