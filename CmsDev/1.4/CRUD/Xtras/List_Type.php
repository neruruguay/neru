<?php

namespace CmsDev\CRUD\Xtras;

class List_Type {

    private $HTML = '';
    private $ListsTypes = array(
        'Photo' => \SKT_ADMIN_TypeContentPhoto,
        'Note' => \SKT_ADMIN_TypeContentNote,
        'html' => \SKT_ADMIN_TypeContentHtml,
        'Product' => \SKT_ADMIN_TypeContentProduct,
        'script' => \SKT_ADMIN_TypeContentScript,
        'SKT_Controls' => \SKT_ADMIN_TypeContentSKT_Controls,
        'SKTList' => \SKT_ADMIN_TypeContentSKTList
    );

    public function Render($ThisType) {
        $this->HTML = '<select name="Type" id="Type">';
        foreach ($this->ListsTypes as $Type => $NameType) {
            if ($ThisType === $Type) {
                $this->HTML .= '<option value="' . $Type . '" selected="selected">' . $NameType . '</option>';
            } else {
                $this->HTML .= '<option value="' . $Type . '">' . $NameType . '</option>';
            }
        }
        $this->HTML .= '</select>';
        return $this->HTML;
    }

    public function NameType($ThisType) {
        $NameTypeRes = 'HTML';
        foreach ($this->ListsTypes as $Type => $NameType) {
            if ($ThisType === $Type) {
                $NameTypeRes = $NameType;
            }
        }
        return $NameTypeRes;
    }

}

?>
