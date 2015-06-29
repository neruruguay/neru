
<?php

if (\is_dir(SKTPATH_TemplateSite)) {
    require_once(SKTPATH_TemplateSite . '/head.php');
    echo '<body class="'.$SKT['BODY']['CLASS'].'" style="'.$SKT['BODY']['STYLE'].'" id="'.$SKT['BODY']['ID'].'"><div class="ui-widget-overlay"></div>';
    require_once (SKTPATH_TemplateSite . '/body.php');
    echo '<div class="skt SKTNotRemove">';
    new \CmsDev\Security\LoadEditorRequired();
    $MessageBox = \CmsDev\Info\Asistance::get();
    echo $MessageBox->Render();
    echo '</div><div id="loader-wrapper" class="load_hide"><div id="loader"></div></div>';
    echo '</body>';
} else {
    require_once ('/_TemplateSite/defaultSite/head.php');
    echo '<body><div class="ui-widget-overlay"></div>';
    require_once ('/_TemplateSite/defaultSite/body.php');
    echo '<div class="skt SKTNotRemove">';
    new \CmsDev\Security\LoadEditorRequired();
    $MessageBox = \CmsDev\Info\Asistance::get();
    echo $MessageBox->Render();
    echo '</div>';
    echo '</body>';
}
//echo '<script>setTimeout(function(){var links=document.getElementsByTagName("a");if(links.length){for(var i=0;i<=links.length-1;i++){var thisLink=document.getElementsByTagName("a")[i];if(thisLink.hasAttribute("href")){var thishref=document.getElementsByTagName("a")[i].getAttribute("href");if(thishref=="#"){document.getElementsByTagName("a")[i].setAttribute("href","javascript:void(0);")}else{if(thishref.charAt(0)=="#"){document.getElementsByTagName("a")[i].setAttribute("href",document.URL+thishref)}}}}}},1000);</script>';
echo '</html>';
