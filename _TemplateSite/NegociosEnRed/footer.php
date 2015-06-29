<?php

/* INSTANCE Footer add assets */
$SKT_Footer = CmsDev\Footer\Make::instance();
/* -- CUSTOM ADD------------------ */
$CombineScripts = array(
    'countdown' => '{fromTemplate}assets/js/countdown.min.js',
    'flexnav' => '{fromTemplate}assets/js/flexnav.min.js',
    'magnific' => '{fromTemplate}assets/js/magnific.min.js',
    'icheck' => '{fromTemplate}assets/js/icheck.js',
    //'mapsapi'=>'http://maps.google.com/maps/api/js?sensor=false&amp;language=en',
    'fotorama' => '{fromTemplate}assets/js/fotorama.js',
    'owl-carousel' => '{fromTemplate}assets/js/owl-carousel.js',
    'masonry' => '{fromTemplate}assets/js/masonry.js',
    'chosen' => '{fromTemplate}assets/js/chosen.jquery.js',
    'validate' => '{fromTemplate}assets/js/jquery.validate.min.js',
    'custom' => '{fromTemplate}assets/js/custom.js',
    'switcher' => '{fromTemplate}assets/js/switcher.js'
);
$CombineScripts = array_merge($CombineScripts, $SKT['RegisterScriptsFooter']);
$SKT_Footer->RegisterScripts($CombineScripts, false);
/* -- RENDER ------------------ */
echo $SKT_Footer->RenderFooter();
?>