<?php

$SKT_Header = \CmsDev\Header\Make::instance();
/* ADD INFO */
$SKT_Header->lang('es');
$SKT_Header->charset('windows-1252');
/* ADD BASE */
//$SKT_Header->base('http://localhost/CmsDev2013/');
/* ADD METAS */
$SKT_Header->addMeta('robots', 'index,follow');
$SKT_Header->addMeta('author', 'Sékito cms');
$SKT_Header->addMeta('googlebot', 'index,follow,snippet');
$SKT_Header->addCss('{internal}/_css/bootstrap.css', 'all');
$SKT_Header->addCss('{internal}/_css/styles.css', 'all');
/* ADD FONT FROM GOOGLE */
$SKT_Header->custom("<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,800,600' rel='stylesheet' type='text/css'>");
echo $SKT_Header->RenderHeader();
?>
