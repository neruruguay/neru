<?php

$UserTheme = isset($_GET['usr']) ? $_GET['usr'] : null;
$DetailID = isset($_GET['DetailID']) ? $_GET['DetailID'] : null;

if ($UserTheme != null || $DetailID != null) {
    $Users = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes;
    
    if($DetailID != null){
        $TestUser =  new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes;
        $UserTheme = $TestUser->GetPUserID($DetailID);
    }
    
    $GetTheme = $Users->GetUseTheme($UserTheme);
    if ($GetTheme) {
        $WideBoxedScript = $BackgroundScript = $PatternScript = '';
        if ($GetTheme->WideBoxed != '') {
            $WideBoxedScript = '$("body").addClass("' . $GetTheme->WideBoxed . '");';
        }
        if ($GetTheme->Pattern != '') {
            $PatternScript = '$("body").css(\'background-image\', \'url("' . $GetTheme->Pattern . '")\');';
        }
        if ($GetTheme->Background != '') {
            $BackgroundScript = '$("body").addClass("bg-cover").css(\'background-image\', \'url("' . $GetTheme->Background . '")\');';
        }
        $SKT_Header->custom(''
                . '<link rel="stylesheet" id="UserColorStylesheet" href="{fromTemplate}assets/css/schemes/' . $GetTheme->ColorTheme . '.css">'
                . '<script>'
                . '$(document).ready(function(){'
                . $WideBoxedScript
                . $BackgroundScript
                . $PatternScript
                . '});'
                . '</script>', false);
    }
}