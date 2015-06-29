<?php

/**
 * Description of ImageUpload
 *
 * @author Mart?n Daguerre
 */

namespace CmsDev\CustomControl\ImageUpload;

class ImageUpload_Control {

    public $maxUpload = 5120000;
    public $maxWidth;
    public $maxHeight;
    public $SizeW;
    public $SizeH;
    public $Rand = 0;
    public $FieldName = '';
    public $ResizeSize = 1;
    public $RealName = '[FieldName]';
    public $CropSize = false;
    public $ShowDelete = false;
    public $EnablePictureDefault = false;
    public $BtnDelete = '';
    public $uploadURL = '[SKTServerURL]_FileSystems/images/';
    public $fileType = array('image/jpeg', 'image/jpg', 'image/png');
    public $fileTypeNames = 'JPG y PNG';
    public $pasaImgSize = false;
    public $respuestaFile = false;
    public $Dimentions = '';
    public $TextButton = '';
    public $Picture = '[SKTServerURL]_FileSystems/images/avatar.png';
    public $Message = array(
        'InfoTypes' => 'Los tipos de imagen permitidos son [fileTypeNames]',
        'InfoSize' => 'Solo puede cargar imagenes que no excedan los [W] x [H]',
        'InfoWeight' => 'El archivo supera el peso permitido de carga: ',
        'InfoWeight2' => 'y el tama&ntilde;o no puede superar los',
        'TextButton' => 'Cargar Imagen',
        'InfoLoading' => 'Publicando la imagen...',
        'Unspected' => 'Error al publicar la imagen',
        'UnspectedMove' => 'Error al publicar la imagen en la carpeta seleccionada.',
        'InfoWait' => 'Espere por favor',
        'Ok' => 'Listo, imagen cargada...'
    );
    protected $RenderHTML = '<div id="SKT_ImageUpload_Wrapper[RandName]" class="SKT_ImageUpload" style="width:[W];"><div id="SKT_ImageUpload[RandName]" class="SKT_ImageUpload"><div id="SKT_ImageUpload_MessageError[RandName]" class="SKT_ImageUpload_MessageError"></div>
	    		<img id="SKT_ImageUpload_Image[RandName]" class="SKT_ImageUpload_Image img-thumbnail img-responsive" src="[Picture]">
	    	</div>
	    	<div class="btn btn-primary btn-block skt-icon-image" id="SKT_ImageUpload_addImage[RandName]"> [TextButton]</div>
                [BTNDelete]
                <div class="SKT_ImageUpload_Information bg-info">
                    <i class="skt-icon-info"></i><b>Info</b>
                    <span>[Information]</span>
                </div>
                <input type="hidden" value="[Default]" name="[RealName]" id="[FieldName]" />
                </div>';
    protected $RenderScript = '<script>
            ;(function($) {
                $(function() {
                $("input[type=file]").addClass("inputUpload");
                var SKT_ImageUpload_btn[RandName] = $("#SKT_ImageUpload_addImage[RandName]"), interval;
                new AjaxUpload("#SKT_ImageUpload_addImage[RandName]", {
                    action: "[SKTServerURL]SKTGoTo/Q3VzdG9tQ29udHJvbC9JbWFnZVVwbG9hZC9JbWFnZVVwbG9hZF9IYW5kbGVy/[RandName]/[params]",
                    name: "SKT_ImageUpload_file[RandName]",
                    onSubmit: function(file, ext) {
                        if (!(ext && /^(jpg|png)$/.test(ext))) {
                            $("#SKT_ImageUpload_MessageError[RandName]").removeClass("ok").html("[InfoTypes]").fadeIn();
                            setTimeout(function() {
                                $("#SKT_ImageUpload_MessageError[RandName]").fadeOut();
                            }, 5000);
                            return false;
                        } else {
                            $("#SKT_ImageUpload_addImage[RandName]").html("<i class=\"skt-icon-spin3 animate-spin\"></i>[InfoWait]");
                            this.disable();
                            $("#SKT_ImageUpload_remove[RandName]").remove();
                        }
                    },
                    onComplete: function(file, response) {
                        SKT_ImageUpload_btn[RandName].html("<i class=\"skt-icon-spin3 animate-spin\"></i>[InfoLoading]");
                        respuesta = $.parseJSON(response);
                        if (respuesta.respuesta == "done") {
                            $("#SKT_ImageUpload_Image[RandName]").removeAttr("scr");
                            $("#SKT_ImageUpload_Image[RandName]").attr("src", "[RespuestaFileName]"+ respuesta.fileName + "?rand=" + Math.floor((Math.random() * 9999999) + 1));
                            $("#SKT_ImageUpload_loaderAjax[RandName]").fadeIn();
                            $("#SKT_ImageUpload_addImage[RandName]").html("[TextButton]");
                            $("#[FieldName]").val("[RespuestaFileName]"+ respuesta.fileName);
                            $("#SKT_ImageUpload_MessageError[RandName]").addClass("ok").html(respuesta.mensaje).fadeIn();
                            $("#SKT_SetNewImageUpload").fadeIn();
                            setTimeout(function() {
                                $("#SKT_ImageUpload_MessageError[RandName]").fadeOut();
                            }, 1000);
                            $("<div class=\"btn btn-link skt-icon-cancel hidden\" id=\"SKT_ImageUpload_remove[RandName]\"> Borrar</div>").insertAfter("#SKT_ImageUpload_addImage[RandName]");
                            $("#SKT_ImageUpload_remove[RandName]").click(function(){
                                $("#SKT_ImageUpload_Image[RandName]").removeAttr("scr");
                                $("#SKT_ImageUpload_Image[RandName]").attr("src", "[Picture]");
                                $("#[FieldName]").val("");
                                $.post("[SKTServerURL]SKTGoTo/Q3VzdG9tQ29udHJvbC9JbWFnZVVwbG9hZC9yZW1vdmVGaWxlVW51c2Vk", { file:"[RespuestaFileName]"+ respuesta.fileName });
                            }).removeClass("hidden");

                        }
                        else {
                            $("#SKT_ImageUpload_MessageError[RandName]").removeClass("ok").html(respuesta.mensaje).fadeIn();
                            $("#SKT_ImageUpload_addImage[RandName]").html("[TextButton]");
                            setTimeout(function() {
                                $("#SKT_ImageUpload_MessageError[RandName]").fadeOut();
                            }, 5000);
                        }
                        this.enable();
                    }
                });
            });
            })(jQuery);
        </script>';

    public function txtsearch() {
        return array(
            '[RandName]',
            '[TextButton]',
            '[InfoLoading]',
            '[InfoSize]',
            '[InfoWait]',
            '[InfoTypes]',
            '[RespuestaFileName]',
            '[params]',
            '[FieldName]',
            '[RealName]',
            '[W]',
            '[H]',
            '[SizeW]',
            '[SizeH]',
            '[ResizeSize]',
            '[Information]',
            '[Picture]',
            '[SKTServerURL]',
            '[BTNDelete]',
            '[Default]'
        );
    }

    public function txtreplace() {
        return array(
            $this->Rand,
            $this->Get_TextButton(),
            $this->Message['InfoLoading'],
            $this->Message['InfoSize'],
            $this->Message['InfoWait'],
            $this->Message['InfoTypes'],
            $this->respuestaFile,
            $this->SetParameters(),
            $this->FieldName,
            $this->RealName,
            $this->maxWidth() . 'px',
            $this->maxHeight() . 'px',
            $this->SizeW,
            $this->SizeH,
            $this->ResizeSize,
            $this->SetInformation(),
            $this->Picture,
            \SKTServerURL,
            $this->BtnDelete,
            $this->Get_PictureDefault(),
        );
    }

    private function SetParameters() {
        $Parameters = json_encode(array(
            'maxUpload' => $this->maxUpload,
            'uploadURL' => $this->uploadURL,
            'fileType' => $this->fileType,
            'FieldName' => $this->FieldName,
            'maxWidth' => $this->maxWidth,
            'maxHeight' => $this->maxHeight,
            'SizeW' => $this->SizeW,
            'SizeH' => $this->SizeH,
            'ResizeSize' => $this->ResizeSize,
            'CropSize' => $this->CropSize,
            'RealName' => $this->RealName
        ));
        return \CmsDev\skt_Code::Encode($Parameters);
    }

    public function Set_Random($Rand) {
        $this->Rand = $Rand;
        return $this->Rand;
    }

    public function CropSize() {
        $this->CropSize = true;
    }

    public function ShowDelete($text) {
        $html = '<div class="btn btn-link skt-icon-cancel hidden" id="SKT_ImageUpload_remove' . $this->Rand . '"> ' . $text . '</div>';
        $this->ShowDelete = true;
        $this->BtnDelete = $html;
    }

    public function Set_Max_Dimension_And_FileSize($maxWidth, $maxHeight, $maxUpload) {
        $this->maxWidth = $maxWidth ? $maxWidth : 800;
        $this->maxHeight = $maxHeight ? $maxHeight : 600;
        $this->maxUpload = $maxUpload ? $maxUpload : 50000;
    }

    private function SetInformation() {
        $txtsearch = array('[W]', '[H]', '[fileTypeNames]');
        $txtreplace = array($this->maxWidth() . 'px', $this->maxHeight() . 'px', $this->fileTypeNames);
        $Information = str_replace($txtsearch, $txtreplace, $this->Message['InfoTypes']) .
                '.<br>' . str_replace($txtsearch, $txtreplace, $this->Message['InfoSize']) .
                '<br> ' . $this->Message['InfoWeight2'] .
                ' <b>' . ceil(($this->maxUpload / 1024)) . ' kb</b>';
        return $Information;
    }

    public function Set_fileType($fileType) {
        $this->fileType = $fileType;
    }

    public function RealName($RealName) {
        $this->RealName = $RealName;
    }

    public function Set_TextButton($text) {
        $this->TextButton = $text;
        $this->Message['TextButton'];
    }

    public function Get_TextButton() {
        if ($this->TextButton != '') {
            return $this->TextButton;
        } else {
            return $this->Message['TextButton'];
        }
    }

    public function Set_fileTypeNames($fileTypeNames) {
        $this->fileTypeNames = $fileTypeNames;
    }

    public function SizeW($W) {
        $this->SizeW = $W;
    }

    public function SizeH($H) {
        $this->SizeH = $H;
    }

    public function ResizeSize($R = 1) {
        $this->ResizeSize = (int) $R;
    }

    public function maxWidth() {
        return $this->maxWidth;
    }

    public function maxHeight() {
        return $this->maxHeight;
    }

    public function Set_FieldName($FieldName) {
        $this->FieldName = $FieldName;
    }

    public function Set_Directory($uploadURL) {
        $FixUploadURL = str_replace('[SKTServerURL]', \SKTServerURL, $uploadURL);
        $this->uploadURL = $FixUploadURL ? $FixUploadURL : \SKTPATH_FileSystems . 'users' . \DS;
    }

    public function Set_Picture($CustomFile) {
        $this->Picture = $CustomFile ? $CustomFile : '[SKTServerURL]_FileSystems/images/avatar.png';
    }
    public function EnablePictureDefault() {
        $this->EnablePictureDefault = true;
    }
    public function Get_PictureDefault() {
        if($this->EnablePictureDefault === true){
            return $this->Picture;
        }else{
            return '';
        }
    }
    
    public function Set_Name($FieldName) {
        $this->FieldName = $FieldName;
    }

    public function Get_OutputField() {
        $txtsearch = $this->txtsearch();
        $txtreplace = $this->txtreplace();
        $Name = str_replace($txtsearch, $txtreplace, 'SKT_ImageUpload[RandName]');
        return $this->FieldName . $this->Rand;
    }

    public function SetUpload($e, $Parameters) {
        self::ValidateUpload($e, $Parameters);
    }

    private function ValidateSize($size) {
        if ($size > 0 && $size <= $this->maxUpload) {
            return true;
        }
    }

    private function ValidateType($type) {
        if (\in_array($type, $this->fileType)) {
            return true;
        }
    }

    private static function size($FILE) {
        return $FILE['size'];
    }

    private static function type($FILE) {
        return $FILE['type'];
    }

    private static function name($FILE) {
        return $FILE['name'];
    }

    private static function extension($FILE) {
        $ext = strtolower(substr($FILE, strrpos($FILE, ".") + 1, 3));
        return $ext;
    }

    private function ValidateDimentions($getimagesize) {
        if ($getimagesize[0] <= $this->maxWidth() && $getimagesize[1] <= $this->maxHeight()) {
            $this->Dimentions = $getimagesize[0] . 'x' . $getimagesize[1];
            return true;
        } else {
            $this->Dimentions = $getimagesize[0] . 'x' . $getimagesize[1];
            return $getimagesize[0] . 'x' . $getimagesize[1];
        }
    }

    public function Make() {
        if ($this->FieldName == '') {
            $this->FieldName = 'ImageUpload_Control_' . $this->Rand;
        }
        $txtsearch = $this->txtsearch();
        $txtreplace = $this->txtreplace();
        $RenderHTML = str_replace($txtsearch, $txtreplace, $this->RenderHTML);
        $RenderScript = str_replace($txtsearch, $txtreplace, $this->RenderScript);
        echo $RenderHTML . $RenderScript;
    }

    private function ResizeImage($src, $w, $h, $CropSize) {

        $source_image = $src;
        $destination = $source_image;
        $tn_w = $w;
        $tn_h = $h;
        $quality = 85;
        $wmsource = false;

        $info = getimagesize($source_image);
        $imgtype = image_type_to_mime_type($info[2]);

        switch ($imgtype) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($source_image);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($source_image);
                break;
            case 'image/png':
                $source = imagecreatefrompng($source_image);
                break;
            default:
                die('Invalid image type.');
        }

        $src_w = imagesx($source);
        $src_h = imagesy($source);

        $x_ratio = $tn_w / $src_w;
        $y_ratio = $tn_h / $src_h;

        if ($CropSize) {
            if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
                $new_w = $src_w;
                $new_h = $src_h;
            } elseif (($x_ratio * $src_h) > $tn_h) {
                $new_h = ceil($x_ratio * $src_h);
                $new_w = $tn_w;
            } else {
                $new_w = ceil($y_ratio * $src_w);
                $new_h = $tn_h;
            }

            $newpic = imagecreatetruecolor(round($new_w), round($new_h));
            imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
            $final = imagecreatetruecolor($tn_w, $tn_h);
            $backgroundColor = imagecolorallocate($final, 255, 255, 255);
            imagefill($final, 0, 0, $backgroundColor);
            imagecopy($final, $newpic, (($tn_w - $new_w) / 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);
        } else {
            if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
                $new_w = $src_w;
                $new_h = $src_h;
            } elseif (($x_ratio * $src_h) < $tn_h) {
                $new_h = ceil($x_ratio * $src_h);
                $new_w = $tn_w;
            } else {
                $new_w = ceil($y_ratio * $src_w);
                $new_h = $tn_h;
            }

            $newpic = imagecreatetruecolor(round($new_w), round($new_h));
            imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
            $final = imagecreatetruecolor($tn_w, $tn_h);
            $backgroundColor = imagecolorallocate($final, 255, 255, 255);
            imagefill($final, 0, 0, $backgroundColor);
            imagecopy($final, $newpic, (($tn_w - $new_w) / 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);
        }
        if (imagejpeg($final, $destination, $quality)) {
            return true;
        }
        return false;
    }

    private function ValidateUpload($e, $Parameters) {
        if ($Parameters) {
            $Parameters = json_decode(\CmsDev\skt_Code::Decode($Parameters));
        } else {
            $Parameters = $this;
        }
        global $_FILES;
        $FILE = $_FILES['SKT_ImageUpload_file' . $e];
        $search = array('[W]', '[H]');
        $replace = array($Parameters->maxWidth . 'px', $Parameters->maxHeight . 'px');
        $this->Message['InfoSize'] = \str_replace($search, $replace, $this->Message['InfoSize']);
        if (isset($FILE)) {
            $size = self::size($FILE);
            if ($size <= $Parameters->maxUpload) {
                $type = self::type($FILE);
                $name = self::name($FILE);
                /* @var $extension type */
                $extension = self::extension($name);
                $uploadURL = $_SERVER["DOCUMENT_ROOT"] . \SKT_URL_SUBSITE . $Parameters->uploadURL;
                $imgFile = $Parameters->FieldName . '.' . $extension;
                $mensajeFile = $this->Message['InfoLoading'];
                if (self::ValidateType($type) == true) {
                    $getimagesize = \getimagesize($FILE['tmp_name']);
                    if (self::ValidateDimentions($getimagesize) == true) {
                        if (\is_uploaded_file($FILE['tmp_name'])) {
                            if (\move_uploaded_file($FILE['tmp_name'], $uploadURL . $imgFile)) {
                                if ($Parameters->ResizeSize == 1) {
                                    $this->ResizeImage($uploadURL . $imgFile, $Parameters->SizeW, $Parameters->SizeH, $Parameters->CropSize);
                                }
                                $this->respuestaFile = 'done';
                                $fileName = '/'.trim($imgFile, '/');
                                $mensajeFile = $this->Message['Ok'];
                            } else {
                                $mensajeFile = $this->Message['UnspectedMove'];
                            }
                        } else {
                            $mensajeFile = $this->Message['Unspected'];
                        }
                    } else {
                        $mensajeFile = $this->Message['InfoSize'] . 'Las dimensiones de tu archivo son' . self::ValidateDimentions($getimagesize);
                    }
                } else {
                    $mensajeFile = $this->Message['InfoTypes'];
                }
            } else {
                $maxUpload = ceil(($Parameters->maxUpload / 1024)) . ' kb';
                $mensajeFile = $this->Message['InfoWeight'] . ' <br>' . $maxUpload;
            }
            $salidaJson = array("respuesta" => $this->respuestaFile, "mensaje" => $mensajeFile, "fileName" => '/'.$Parameters->uploadURL . $imgFile,
                "Dimentions" => $this->Dimentions,
                "type" => $type,
                "size" => $size,
                "SizeW" => $Parameters->SizeW,
                "SizeH" => $Parameters->SizeH,
                "name" => $name,
                "Parameters" => \CmsDev\skt_Code::Decode(Parameters),
                "extension" => $extension);
            echo \json_encode($salidaJson);
        }
    }

}
