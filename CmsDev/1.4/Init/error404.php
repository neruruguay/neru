<?php
if (\is_dir(SKTPATH_TemplateSite)) {
    require_once(SKTPATH_TemplateSite . '/head.php');
    require_once (SKTPATH_TemplateSite . '/body.php');
} else {
    require_once ('/_TemplateSite/defaultSite/head.php');
    require_once ('/_TemplateSite/defaultSite/body.php');
}
echo '<script>setTimeout(function(){var links=document.getElementsByTagName("a");if(links.length){for(var i=0;i<=links.length-1;i++){var thisLink=document.getElementsByTagName("a")[i];if(thisLink.hasAttribute("href")){var thishref=document.getElementsByTagName("a")[i].getAttribute("href");if(thishref=="#"){document.getElementsByTagName("a")[i].setAttribute("href","javascript:void(0);")}else{if(thishref.charAt(0)=="#"){document.getElementsByTagName("a")[i].setAttribute("href",document.URL+thishref)}}}}}},1000);</script>';

