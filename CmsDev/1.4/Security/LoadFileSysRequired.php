<?php

/**
 * Description of LoadEditorRequired
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Security;

use CmsDev\Security\loginIntent as Login;

class LoadFileSysRequired {

    function __construct() {

        if (Login::action('validateAdmin') === true) {
            $DS = DIRECTORY_SEPARATOR;
            $app = \file_get_contents(dirname(dirname(__FILE__)) . $DS . '_appjs'. $DS .'app.js');
            $appPack = new \CmsDev\JavaScriptPacker($app);
            $SKTFSys = \file_get_contents(dirname(dirname(__FILE__)) . $DS . '_appjs'. $DS .'SKTFSys.js');
            $SKTFSysPack = new \CmsDev\JavaScriptPacker($SKTFSys);
            echo '<script type="text/javascript">' . $appPack->pack() . $SKTFSysPack->pack() . '</script>';
            $MessageBox = \CmsDev\Info\Asistance::get();
            $MessageBox->Render();
        }
    }

}

?>
