<?php

/**
 * Description of Breadcrumb
 *
 * @author Martin Daguerre
 */

namespace CmsDev\AdminFilesystem;

use \CmsDev\skt_Code as Code;

class Breadcrumb {

    public static function Render($subfolder) {
        $Breadcrumb = '<a href="javascript:window.parent.SKTFSys.ViewFolderList(\'/\');"><span>Root</span><i class="skt-icon-right-open"></i></a>';
        $Element = '';
        $subfolder = Code::RemoveLocalFS(Code::Decode($subfolder));
        $e = \explode("/", $subfolder);
        $c = \count($e);
        $Elementparents = '';
        for ($i = 0; $i < $c; $i++) {
            $Element = $e[$i];
            if ($Element != '/' && $Element != '') {
                $Elementparents = $Elementparents . '/' . $Element;
                $Elementparents = \str_replace('//', '/', $Elementparents);
                $Breadcrumb.= '<a href="' . SUBSITE . 'SKTFiles/' . Code::Encode(Code::AddLocalFS($Elementparents)) . '/"><span>' . $Element . '</span><i class="skt-icon-right-open"></i></a>';
            }
        }
        return \str_replace('//', '/', $Breadcrumb);
    }
}
?>
