<?php

/**
 * @example <br/><p>
 *      $MessageBox = \CmsDev\Info\Asistance::get();<br/>
  $MessageBox->TipInfo('Bienvenido a Sékito CMS!');<br/>
  $MessageBox->TipOk('Correo enviado correctamente');<br/>
  $MessageBox->TipError('Tus datos no estan actualizados',false);<br/></p>
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Info;

class Asistance {

    public $render = '';
    public $scriptClose = '';
    public $delay = 2500;
    public $delaySum = 2500;
    private static $instancia;

    public static function get() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public function Render() {
        return '<div id="InformationTipBox">' . $this->render . '</div><script type="text/javascript">$(".TipClose").click(function(){$(this).parent().remove();}); ' . $this->scriptClose . '</script>';
    }

    public function TipInfo($HTML = '', $close = true) {
        $rand = rand(5, 15);
        if ($close) {
            $delay2 = $this->delay + $this->delaySum;
            $this->scriptClose .= '$("#Tip' . $rand . '").delay(' . $this->delay . ').animate({opacity:0.3},{duration:200}).animate({opacity:1},{duration:200}).delay(' . $delay2 . ').hide(\'slow\');';
            $this->delay = $this->delay + $this->delaySum;
        }
        $this->render .= '<div class="TipInfo" id="Tip' . $rand . '"><div class="TipClose">x</div><span class="icon">Información:</span><p>' . $HTML . '</p></div>';
    }

    public function TipError($HTML = '', $close = false) {
        $rand = rand(5, 15);
        if ($close) {
            $delay2 = $this->delay + $this->delaySum;
            $this->scriptClose .= '$("#Tip' . $rand . '").delay(' . $this->delay . ').animate({opacity:0.3},{duration:200}).animate({opacity:1},{duration:200}).delay(' . $delay2 . ').hide(\'slow\');';
            $this->delay = $this->delay + $this->delaySum;
        }
        $this->render .= '<div class="TipError" id="Tip' . $rand . '"><div class="TipClose">x</div><span class="icon">Error:</span><p>' . $HTML . '</p></div>';
    }

    public function TipOk($HTML = '', $close = true) {
        $rand = rand(5, 15);
        if ($close) {
            $delay2 = $this->delay + $this->delaySum;
            $this->scriptClose .= '$("#Tip' . $rand . '").delay(' . $this->delay . ').animate({opacity:0.3},{duration:200}).animate({opacity:1},{duration:200}).delay(' . $delay2 . ').hide(\'slow\');';
            $this->delay = $this->delay + $this->delaySum;
        }
        $this->render .= '<div class="TipOk" id="Tip' . $rand . '"><div class="TipClose">x</div><span class="icon">Ok:</span><p>' . $HTML . '</p></div>';
    }

}

?>
