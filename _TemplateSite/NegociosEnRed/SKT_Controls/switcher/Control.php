<?php
$Company = isset($_GET['usr']) ? $_GET['usr'] : 0;
$SKTDB = \CmsDev\Sql\db_Skt::connect();
$Query = "SELECT *
FROM users as user join userprofile as profile 
ON user.id = profile.IDX
WHERE profile.level = 'Publishers' AND user.isactive = '1' AND user.id = " . GetSQLValueString($Company, "int") . "";
$User = $SKTDB->get_row($Query);

?>
<link href="<?php echo SKTURL_TemplateSite; ?>assets/css/switcher.css" rel="stylesheet">
<link media="all" title="dark" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/dark.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="apple" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/apple.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="pink" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/pink.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="teal" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/teal.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="gold" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/gold.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="downy" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/downy.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="atlantis" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/atlantis.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="violet" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/violet.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="pomegranate" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/pomegranate.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="violet-red" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/violet-red.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="mexican-red" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/mexican-red.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="victoria" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/victoria.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="orient" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/orient.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="jgger" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/jgger.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="de-york" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/de-york.css" type="text/css" rel="alternate stylesheet">
<link media="all" title="blaze-orange" href="<?php echo SKTURL_TemplateSite; ?>assets/css/schemes/blaze-orange.css" type="text/css" rel="alternate stylesheet">
<div id="demo_changer" class="demo_changer">
    <div class="form_holder row">
        <div class="col-md-2">
            <p>Color del Tema</p>
            <div id="styleswitch_area" class="predefined_styles">
                <a style="background:#333333" class="styleswitch" data-source="dark" href=""><span>Gris</span></a>
                <a style="background:#56AD48" class="styleswitch" data-source="apple" href=""><span>Verde</span></a>
                <a style="background:#8cc732" class="styleswitch" data-source="atlantis" href=""><span>Verde Manzana</span></a>
                <a style="background:#8CCA91" class="styleswitch" data-source="de-york" href=""><span>Oceano</span></a>
                <a style="background:#6dcda7" class="styleswitch" data-source="downy" href=""><span>Verde agua</span></a>
                <a style="background:#FBB829" class="styleswitch" data-source="gold" href=""><span>Oro</span></a>
                <a style="background:#FF6600" class="styleswitch" data-source="blaze-orange" href=""><span>Naranja</span></a>
                <a style="background:#F02311" class="styleswitch" data-source="pomegranate" href=""><span>Rojo</span></a>
                <a style="background:#F23A65" class="styleswitch" data-source="violet-red" href=""><span>Rosado</span></a>
                <a style="background:#FF0066" class="styleswitch" data-source="pink" href=""><span>Magenta</span></a>
                <a style="background:#D31996" class="styleswitch" data-source="violet" href=""><span>Fucsia</span></a>
                <a style="background:#9b2139" class="styleswitch" data-source="mexican-red" href=""><span>Ladrillo</span></a>
                <a style="background:#420943" class="styleswitch" data-source="jgger" href=""><span>Vino</span></a>
                <a style="background:#544AA1" class="styleswitch" data-source="victoria" href=""><span>Violeta</span></a>
                <a style="background:#025D8C" class="styleswitch" data-source="orient" href=""><span>Turquesa</span></a>
                <a style="background:#1693A5" class="styleswitch" data-source="teal" href=""><span>Oceano 2</span></a>
                <a style="background:#2A8FBD" class="styleswitch" href="?default=true"><span>Cian</span></a>
            </div>
        </div>
        <div class="col-md-3">
            <p>Patr&oacute;n de fondo</p>
            <div id="patternswitch_area" class="predefined_styles">
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/binding_light.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/binding_light.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/binding_dark.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/binding_dark.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/dark_fish_skin.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/dark_fish_skin.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/dimension.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/dimension.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/escheresque_ste.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/escheresque_ste.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/food.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/food.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/giftly.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/giftly.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/grey_wash_wall.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/grey_wash_wall.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/ps_neutral.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/ps_neutral.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/pw_maze_black.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/pw_maze_black.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/pw_pattern.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/pw_pattern.png" class="patternswitch" href="javascript:void(0);"></a>
                <a style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/simple_dashed.png')" data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/patterns/simple_dashed.png" class="patternswitch" href="javascript:void(0);"></a>
            </div>
        </div>
        <div class="col-md-2">
            <div id="bgimageswitch_area" class="predefined_styles">
                <?php
                if ($CCParams->BackgroundCustom != '') {
                    $Set_Picture = $CCParams->BackgroundCustom;
                    echo '<p>Su imagen</p><a data-source="' . $Set_Picture . '" style="background-image: url(\'' . $Set_Picture . '\')" class="bgimageswitch" href="javascript:void(0);"></a>';
                } elseif ($CCParams->Background != '') {
                    $Set_Picture = $CCParams->Background;
                    echo '<p>Su imagen</p><a data-source="' . $Set_Picture . '" style="background-image: url(\'' . $Set_Picture . '\')" class="bgimageswitch" href="javascript:void(0);"></a>';
                } else {
                    
                }
                ?>
                <p>Im&aacute;genes de fondo</p>
                <a data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/backgrounds/wood.jpg" style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/backgrounds/wood.jpg')" class="bgimageswitch" href="javascript:void(0);"></a>
                <a data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/backgrounds/videobg1.jpg" style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/backgrounds/videobg1.jpg')" class="bgimageswitch" href="javascript:void(0);"></a>
                <a data-source="<?php echo SKTURL_TemplateSite; ?>assets/img/backgrounds/Glamour.jpg" style="background-image: url('<?php echo SKTURL_TemplateSite; ?>assets/img/backgrounds/Glamour.jpg')" class="bgimageswitch" href="javascript:void(0);"></a>
            </div>
        </div>
        <div class="col-md-5 ">
            <p>Ancho de p&aacute;gina</p>
            <div class="predefined_styles mb20">
                <a id="btn-wide" class="btn btn-sm <?php
                if ($CCParams->WideBoxed == 'wide') {
                    echo 'btn-primary';
                }
                ?>" href="javascript:void(0);">Ancho completo (Sin fondo)</a>
                <a id="btn-boxed" class="btn btn-sm <?php
                if ($CCParams->WideBoxed == 'boxed') {
                    echo 'btn-primary';
                }
                ?>" href="javascript:void(0);">En caja con fondo</a>
            </div>
            <p>Cargar una imagen propia para el fondo</p>
            <div class="controls" id="BackgroundCustom">
                <?php
                if ($CCParams->BackgroundCustom != '') {
                    $Set_Picture = $CCParams->BackgroundCustom;
                } elseif ($CCParams->Background != '') {
                    $Set_Picture = $CCParams->Background;
                } else {
                    $Set_Picture = \SKT_URL_BASE . '_FileSystems/transparent.png';
                }

                $FieldName = $User->username.'_BackgroundCustom';
                $Foto = new \CmsDev\CustomControl\ImageUpload\ImageUpload_Control();
                $FieldRand = $Foto->Set_Random(md5(rand(9, 999999) . microtime()));
                $Foto->Set_fileType(array('image/jpeg', 'image/jpg', 'image/png'));
                $Foto->Set_fileTypeNames('JPG o PNG sin transparencia, con fondo blanco preferentemente.');
                $Foto->Set_TextButton('Cargar imagen de fondo');
                //$Foto->SizeW(1280);
                //$Foto->SizeH(900);
                $Foto->ResizeSize(false);
                $Foto->Set_Max_Dimension_And_FileSize(1280, 900, 2097152);
                $Foto->Set_Picture($Set_Picture);
                $Foto->Set_FieldName($FieldName);
                $Foto->Set_Directory('_FileSystems' . \DS . 'users' . \DS);
                $Foto->Make();
                ?>
                <button id="SKT_SetNewImageUpload" onclick="BackgroundCustom<?php echo $Foto->Get_OutputField() ?>('<?php echo $FieldName; ?>');" class="btn btn-success btn-block mt20" style="display: none">Aplicar cambio de imagen</button>
            </div>
            <script type="text/javascript">
                function BackgroundCustom<?php echo $Foto->Get_OutputField() ?>(Image) {
                    $('#switcher_BackgroundCustom, #switcher_Background').val($('#' + Image).val());
                    $('#demo_changer #btn-boxed').trigger('click');
                    $('body').addClass('bg-cover');
                    $('body').css('background-image', 'url("' + $('#' + Image).val() + '?r=' + Math.floor((Math.random() * 9999999999)) + '")');
                    $('#switcher_Pattern').val('');
                }
            </script>
        </div>
    </div>
</div>
