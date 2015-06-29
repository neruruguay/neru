<?php

/**
 * Description of LoadEditorRequired
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Security;

use CmsDev\Security\loginIntent as Login;

class LoadEditorRequired {

    function __construct() {
        $MessageBox = \CmsDev\Info\Asistance::get();
        if (Login::action('validateAdmin') === true) {
            require_once (dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '/SKTEditor.php');
            require(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '/Layout/EditorLayouts.php');
            require_once (dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '/CRUD/Xtras/ColectorData.php');
        }
    }

}
