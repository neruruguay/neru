<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Editor
 *
 * @author usuario
 */

namespace CmsDev\CustomControl\EditorHTML;

class Editor {

    public $Width = '100%';
    public $Height = 300;
    public $Rand = 0;
    public $Type = 'Basic';
    public $Content = '';
    public $FieldName = 'EditorHTML';
    protected $RenderHTML = '<textarea id="[FieldName]" name="[FieldName]" class="htmlfield[RandName]" class="form-control rezise-y">[Content]</textarea>';
    protected $RenderScriptHtmlfield = '<script type="text/javascript">
    function HTML_Content_htmlfield[RandName]() {
        CreateContentEditor({
            "Element": ".htmlfield[RandName]",
            "width": "100%",
            "height": "300",
            "colors": "[SKT_EDITOR_COLORS]",
            "fonts": "[SKT_EDITOR_FONTS]",
            "bodyStyle": "[SKT_EDITOR_BODY]",
            "docCSSFile": "[docCSSFile]",
            "docType": "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">"
        });
    }
    $(document).ready(function () {
        if ($(".htmlfield[RandName]").length != 0) {
            setTimeout("HTML_Content_htmlfield[RandName]();", 1000);
            $(".htmlfield[RandName]").next().focusout(function () {
                alert("focusout");
                $(".htmlfield[RandName]").html($(".htmlfield[RandName]").next().find("body").html());
            });
        }
    });
    </script>';
    protected $RenderScriptRichfield = '<script type="text/javascript">
    function HTML_Content_Richfield[RandName]() {
        CreateContentEditor({
            "Element": ".htmlfield[RandName]",
            "width": "100%",
            "height": "300",
            "colors": "[SKT_EDITOR_COLORS]",
            "fonts": "[SKT_EDITOR_FONTS]",
            "bodyStyle": "[SKT_EDITOR_BODY]",
            "docCSSFile": "[docCSSFile]",
            "docType": "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">",
            "controls": "bold | removeformat | bullets numbering | undo redo"
        });
    }
    $(document).ready(function () {
        if ($(".htmlfield[RandName]").length != 0) {
            setTimeout("HTML_Content_Richfield[RandName]();", 1000);
            $(".htmlfield[RandName]").next().focusout(function () {
                alert("focusout");
                $(".htmlfield[RandName]").html($(".htmlfield[RandName]").next().find("body").html());
            });
        }
    });
    </script>';

    public function Set_Width($W) {
        $this->Width = $W;
    }

    public function Set_Height($H) {
        $this->Height = $H;
    }

    public function Set_FieldName($FieldName) {
        $this->FieldName = $FieldName;
    }

    public function Set_Content($Content) {
        $this->Content = $Content;
    }

    public function Set_Type($Type) {
        $this->Type = $Type;
    }

    public function txtsearch() {
        return array(
            '[RandName]',
            '[FieldName]',
            '[Content]',
            '[W]',
            '[H]',
            '[SKTServerURL]'
        );
    }

    public function txtreplace() {
        return array(
            \RAND_GLOBAL_INSTANCE,
            $this->FieldName,
            $this->Content,
            $this->Width,
            $this->Height,
            \SKTServerURL
        );
    }

    public function Make() {
        if ($this->FieldName == '') {
            $this->FieldName = 'HtmlEditor' . $this->Rand;
        }
        $RenderHTML = str_replace($this->txtsearch(), $this->txtreplace(), $this->RenderHTML);
        if ($this->Type === 'Basic') {
            $RenderScriptRichfield = str_replace($this->txtsearch(), $this->txtreplace(), $this->RenderScriptRichfield);
            echo $RenderHTML . $RenderScriptRichfield;
        } else {
            $RenderScriptHtmlfield = str_replace($this->txtsearch(), $this->txtreplace(), $this->RenderScriptHtmlfield);
            echo $RenderHTML . $RenderScriptHtmlfield;
        }
    }

}
