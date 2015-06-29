<?php

/* INSTANCE HEADER */
$SKT_Header = \CmsDev\Header\Make::instance();
/* ADD INFO */
$SKT_Header->lang('es');
$SKT_Header->charset(\SKT_SITE_CHARSET);
$SKT_Header->title(\SKT_SECTION_METADATATITLE);
$SKT_Header->base(\SKTURL_BASE);
/* ADD METAS */
$SKT_Header->addMeta('description', \SKT_SECTION_METADATADESCRIPTION);
$SKT_Header->addMeta('Keywords', \SKT_SECTION_METADATAKEYWORDS);
$SKT_Header->addMeta('author', \SKT_SITE_AUTHOR);
$SKT_Header->addMeta('robots', 'noindex,nofollow');
$SKT_Header->addMeta('viewport', 'width=device-width, initial-scale=1');
/* ADD CUSTOM METAS */
$SKT_Header->customMeta('property', 'og:image', '{fromTemplate}assets/img/thumb.png');
$SKT_Header->customMeta('property', 'og:title', 'Negocios en Red');
$SKT_Header->customMeta('property', 'og:description', 'Negocios en Red');
$SKT_Header->customMeta('property', 'og:url', \SITE_SERVER);
$SKT_Header->customMeta('property', 'og:site_name', 'Negocios en Red');
$SKT_Header->customMeta('property', 'og:type', 'website');
$SKT_Header->customMeta('http-equiv', 'X-UA-Compatible', 'IE=edge');
/* ADD CUSTOM ELEMENTS */
$SKT_Header->custom('
<!-- CSS -->
    <!-- Google fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,100,300" rel="stylesheet" type="text/css">
    <!-- Bootstrap styles -->
    <link rel="stylesheet" href="{fromTemplate}assets/css/boostrap.css">
    <!-- Font Awesome styles (icons) -->
    <link rel="stylesheet" href="{fromTemplate}assets/css/font_awesome.css">
    <!-- Main Template styles -->
    <link rel="stylesheet" href="{fromTemplate}assets/css/styles.css">
    <!-- IE 8 Fallback -->
    <!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="{fromTemplate}css/ie.css" />
        <script src="/components/html5shiv/dist/html5shiv.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="{fromTemplate}assets/css/mystyles.css">
<script type="text/javascript">var UserTour = false;</script>
', false);
/* ADD ICON */
$SKT_Header->addIcon('/favicon.png', 'image/x-icon');
/* COMPANY THEME */
require_once 'ThemeUser.php';
/* RENDER HEADER */
echo $SKT_Header->RenderHeader(true);

?>