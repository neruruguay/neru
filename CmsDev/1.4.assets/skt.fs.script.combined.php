<?php

require_once '../1.4/JavaScriptPacker.php';
$DS = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'FileUpload' . DIRECTORY_SEPARATOR;
$app = '';
$app .= \file_get_contents($DS . 'load-image.all.min.js');
$app .= \file_get_contents($DS . 'canvas-to-blob.min.js');
$app .= \file_get_contents($DS . 'jquery.iframe-transport.js');
$app .= \file_get_contents($DS . 'jquery.fileupload.js');
$app .= \file_get_contents($DS . 'jquery.fileupload-process.js');
$app .= \file_get_contents($DS . 'jquery.fileupload-image.js');
$app .= \file_get_contents($DS . 'jquery.fileupload-audio.js');
$app .= \file_get_contents($DS . 'jquery.fileupload-video.js');
$app .= \file_get_contents($DS . 'jquery.fileupload-validate.js');
$appPack = new \CmsDev\JavaScriptPacker($app);
echo $appPack->pack();
