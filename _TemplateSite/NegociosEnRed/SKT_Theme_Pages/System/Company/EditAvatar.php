<div class="controls" id="FotoPerfil">
    <?php
    $FieldName = $User->username.'_Logo';
    $Foto = new \CmsDev\CustomControl\ImageUpload\ImageUpload_Control();
    $FieldRand = $Foto->Set_Random(md5(rand(9, 999999) . microtime()));
    $Foto->Set_fileType(array('image/jpeg', 'image/jpg', 'image/png'));
    $Foto->Set_fileTypeNames('JPG o PNG sin transparencia, con fondo blanco preferentemente.');
    $Foto->Set_TextButton('Cargar Logotipo');
    $Foto->SizeW(300);
    $Foto->SizeH(300);
    $Foto->Set_Max_Dimension_And_FileSize(1000, 1000, 512000);
    $Foto->Set_Picture(\SKT_URL_BASE . $User->ClientAuth_picture);
    $Foto->Set_Directory('_FileSystems' . \DS . 'users' . \DS);
    $Foto->Set_FieldName($FieldName);
    $Foto->Make();
    ?>
    <div class="clear" id="DumySetNewImageUpload">
        <button id="SKT_SetNewImageUpload" onclick="NewLogo<?php echo $Foto->Get_OutputField() ?>('<?php echo $FieldName; ?>');" class="btn btn-success btn-block mt20" style="display: none">Aplicar cambio de imagen</button>
    </div>
</div>
<script type="text/javascript">
    function NewLogo<?php echo $Foto->Get_OutputField() ?>(Image) {
        var UrlUpdateAvatar = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Users/UpdateAvatar');
        var ID = '<?php echo $User->id; ?>';
        jQuery.ajax({
            'type': 'POST',
            'url': UrlUpdateAvatar,
            'cache': false,
            'data': 'Image=' + $('#' + Image).val() + '&ID=' + ID,
            'success': function (data) {
                $('#SKT_SetNewImageUpload').text(data);
                setTimeout(function () {
                    $('#SKT_SetNewImageUpload').hide();
                    $('#SKT_SetNewImageUpload').text('Aplicar cambio de imagen');
                }, 2500);
            }
        });
    }
</script>