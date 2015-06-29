<?php

$DSLayouts = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Layouts' . DIRECTORY_SEPARATOR;
$HTML .= \file_get_contents($DSLayouts . '0_Before.html');
$HTML .= '<tr><td align="center" valign="top" class="container" style="background-color: #333333;">';
$HTML .= \file_get_contents($DSLayouts . '0_header.html');
$HTML .= '</td></tr>';
$HTML .= '<tr><td align="center" valign="top" class="container" style="background-color: #fb9610;">';
$HTML .= \file_get_contents($DSLayouts . '4_Product_Purchase_ThankYou.html');
$HTML .= '</td></tr>';
$HTML .= '<tr><td align="center" valign="top" class="container" style="background-color: #a0a0a0;">';
$HTML .= \file_get_contents($DSLayouts . '4_Product_Sold.html');
$HTML .= '</td></tr>';
$HTML .= '<tr><td align="center" valign="top" class="container" style="background-color: #a0a0a0;">';
$HTML .= \file_get_contents($DSLayouts . '4_Product_Purchase_Price.html');
$HTML .= '</td></tr>';
$HTML .= '<tr><td align="center" valign="top" class="container" style="background-color: #56a746;">';
$HTML .= \file_get_contents($DSLayouts . '4_Product_Purchase_InfoNext.html');
$HTML .= '</td></tr>';
$HTML .= '<tr><td align="center" valign="top" class="container" style="background-color: #333333;">';
$HTML .= \file_get_contents($DSLayouts . '10_Seller_Card.html');
$HTML .= '</td></tr>';
$HTML .= '<tr><td align="center" valign="top" class="container" style="background-color: #434343; padding-bottom: 40px;">';
$HTML .= \file_get_contents($DSLayouts . '0_Footer.html');
$HTML .= '</td></tr>';
$HTML .= '<tr><td align="center" valign="top" class="container" style="background-color: #dce0e1;">';
$HTML .= \file_get_contents($DSLayouts . '0_After.html');
return $HTML;
