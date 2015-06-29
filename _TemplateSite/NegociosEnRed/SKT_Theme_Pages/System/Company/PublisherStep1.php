<?php
$SKTDB = \CmsDev\Sql\db_Skt::connect();
$Query = "SELECT category_name FROM " . \DB_PREFIX . "categories WHERE category_id = " . \GetSQLValueString($_GET['n'], "int");
$Query2 = "SELECT category_name FROM " . \DB_PREFIX . "categories WHERE category_id = " . \GetSQLValueString($_GET['n2'], "int");
$Name_parent = $SKTDB->get_var($Query);
$Name_Sub = $SKTDB->get_var($Query2);

$ProductImage = isset($_POST['ProductImage']) ? $_POST['ProductImage'] : '';
$Image2 = isset($_POST['Image2']) ? $_POST['Image2'] : '';
$Image3 = isset($_POST['Image3']) ? $_POST['Image3'] : '';
$Image4 = isset($_POST['Image4']) ? $_POST['Image4'] : '';
$Image5 = isset($_POST['Image5']) ? $_POST['Image5'] : '';
$Image6 = isset($_POST['Image6']) ? $_POST['Image6'] : '';

$stock = isset($_POST['stock']) ? $_POST['stock'] : 0;
$Tags = isset($_POST['Tags']) ? $_POST['Tags'] : '';
$Title = isset($_POST['Title']) ? $_POST['Title'] : '';
$ProductDescription = isset($_POST['ProductDescription']) ? $_POST['ProductDescription'] : '';
$ProductDescriptionHTML = isset($_POST['ProductDescriptionHTML']) ? $_POST['ProductDescriptionHTML'] : '';
$Currency = isset($_POST['Currency']) ? $_POST['Currency'] : '0';
$Price = isset($_POST['Price']) ? $_POST['Price'] : '0';
$Date = isset($_POST['Date']) ? $_POST['Date'] : date('Y-m-d');
$URLName = isset($_POST['URLName']) ? $_POST['URLName'] : '0';
$ProductType = isset($_POST['ProductType']) ? $_POST['ProductType'] : '1';
$Plan = isset($_POST['Plan']) ? $_POST['Plan'] : '3';
$ProductID = isset($_POST['ProductID']) ? $_POST['ProductID'] : \RAND_GLOBAL_INSTANCE;
$UnitOrAll = isset($_POST['UnitOrAll']) ? $_POST['UnitOrAll'] : 'Unit';
$stock = isset($_POST['stock']) ? $_POST['stock'] : 10;
$MinSell = isset($_POST['MinSell']) ? $_POST['MinSell'] : 1;
$SelUnit = 'selected=selected';
$SelAll = '';
if ($UnitOrAll == 'Unit') {
    $SelUnit = 'selected=selected';
}
if ($UnitOrAll == 'All') {
    $SelAll = 'selected=selected';
    $SelUnit = '';
}
?>
<h3 class="text-left text-color">
    <a href="javascript:history.back();" title="Volver" class="text-color">
        <i class="skt-icon-left-open text-color"></i></a> Publicar <?php echo $productDesc[$_GET['uValue']][1]; ?>
</h3>
<div class="clear"></div>
<ul class="breadcrumb mt20">
    <li><?php echo $productDesc[$_GET['uValue']][1]; ?></li>
    <li><?php echo $Name_parent; ?></li>
    <li class="active"><?php echo $Name_Sub; ?></li>
    <li class="float-right hidden">PID:<?php echo $ProductID ?></li>
</ul>

<form action="" method="post" id="SKTNewProductForm" enctype="multipart/form-data">
    <div class="hidden">
        <input type="text" id="ProductID" name="ProductID" value="<?php echo $ProductID ?>" />
        <input type="text" id="IDUser" name="IDUser" value="<?php echo $User->id ?>" />
        <input type="text" id="CatP" name="CatP" value="<?php echo $_GET['n'] ?>" />
        <input type="text" id="Cat" name="Cat" value="<?php echo $_GET['n2'] ?>" />
        <input type="text" id="ProductType" name="ProductType" value="<?php echo $productDesc[$_GET['uValue']][1] ?>" />
        <input type="text" id="Plan" name="Plan" value="<?php echo $Plan; ?>" />
        <input type="text" id="URLName" name="URLName" value="<?php echo $URLName; ?>" />
    </div>
    <?php
    if (isset($_POST['ProductID']) && !isset($_POST['Edit'])) {
        require 'PublisherStep2.php';
    } else {
        ?>

        <h3><strong>1.</strong> <span>Informaci&oacute;n general</span> <span class="badge" style="font-weight: 300;">Obligatoria</span></h3>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="control-group">
                <label class="control-label">
                    Tutulo de la Publicaci&oacute;n
                    <span class="form-required" title="Escriba el t&iacute;tulo que se mostrar&aacute;">* <span class="Info" style="font-weight: 300;"><span id="TitleStatus" style="font-weight:bold;text-align:right;">0</span> de 80 caract&eacute;res Max.</span> </span>
                </label>
                <div class="controls">
                    <div class="bg-warning form-alert" id="form-alert-Title">Escriba el t&iacute;tulo que se mostrar&aacute;</div>
                    <input type="text" name="Title" id="Title" class="form-control" data-output="TitleStatus" data-maxsize="80" maxlength="80" value="<?php echo $Title; ?>" required  onblur="CheckURLProduct(this.value, 'URLName');"/>
                </div>
            </div>
            <div class="control-group "> 
                <label class="control-label">
                    Breve descripci&oacute;n 
                    <span class="form-required" title="Campo requerido">* <span class="Info" style="font-weight: 300;"><span id="PDStatus" style="font-weight:bold;text-align:right;">0</span> de 128 caract&eacute;res Max.</span> </span>
                </label>
                <div class="controls">
                    <div class="bg-warning form-alert" id="form-alert-ProductDescription">Escriba la descripci&oacute;n</div>
                    <textarea name="ProductDescription" id="ProductDescription" data-maxsize="128" data-output="PDStatus" wrap="virtual" class="form-control no-rezise" required ><?php echo $ProductDescription; ?></textarea>
                </div>
            </div>
        </div>
        <div class="gap"></div>
        <div class="clear"></div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="control-group">
                <label class="control-label">
                    Moneda
                </label>
                <div class="controls">
                    <select id="Currency" name="Currency" class="form-control">
                        <option value="0">$</option>
                        <option value="1">U$S</option>
                    </select>
                </div>
            </div> 
            <div class="control-group">
                <label class="control-label">
                    Precio (Impuestos inc.)
                    <span class="form-required" title="Escriba el Precio">* <span class="Info" style="font-weight: 300;">0 o N&uacute;meros sin decimales</span> </span>
                </label>
                <div class="controls">
                    <div class="bg-warning form-alert" id="form-alert-Price">Escriba el Precio</div>
                    <input type="text" name="Price" id="Price" class="form-control numeric" value="<?php echo $Price; ?>" required />
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="control-group">
                <label class="control-label">
                    Precio por Unidad o el Lote?
                </label>
                <div class="controls">
                    <select id="UnitOrAll" name="UnitOrAll" class="form-control">
                        <option value="Unit" <?php echo $SelUnit; ?> >Unidad</option>
                        <option value="All" <?php echo $SelAll; ?> >Lote</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">
                    Stock / Lote
                </label>
                <div class="controls">
                    <input type="text" name="stock" id="stock" class="form-control" value="<?php echo $stock; ?>" />
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="control-group">
                <label class="control-label">
                    Cantidad mínima de Unidades para Comprar 
                </label>
                <div class="controls">
                    <input type="text" name="MinSell" id="MinSell" class="form-control" value="<?php echo $MinSell; ?>" />
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="control-group">
                <label class="control-label">
                    Inicia el
                    <span class="form-required" title="Escriba la fecha">*</span>
                </label>
                <div class="controls">
                    <div class="bg-warning form-alert" id="form-alert-Date">Indique la fecha de inicio</div>
                    <input type="text" name="Date" id="Date" class="form-control date datepicker" value="<?php echo $Date; ?>" required />
                </div>
            </div>
        </div>
        <div class="gap"></div>
        <div class="clear"></div>
        <div class="gap"></div>
        <h3><strong>2.</strong> <span>Imagenes del producto</span> <span class="badge" style="font-weight: 300;">Medida &oacute;ptima 800x600 pixeles</span></h3>
        <div class="clear"></div>
        <div class="gap"></div>
        <div class="col-md-4 col-xs-6 col-sm-6">
            <p>Imagen principal</p>
            <div class="bg-warning form-alert" id="form-alert-ProductImage">Seleccione una imagen para ser la imagen Principal del producto</div>
            <div class="controls">
                <?php
                if ($ProductImage != '') {
                    $Set_Picture = $ProductImage;
                } else {
                    $Set_Picture = \SKT_URL_BASE . '_FileSystems/avatar.png';
                }
                $FieldName = $User->username . '_ProductImage_' . \RAND_GLOBAL_INSTANCE;
                $Foto = new \CmsDev\CustomControl\ImageUpload\ImageUpload_Control();
                $FieldRand = $Foto->Set_Random(md5(rand(9, 999999) . microtime()));
                $Foto->Set_fileType(array('image/jpeg', 'image/jpg', 'image/png'));
                $Foto->Set_fileTypeNames('JPG o PNG sin transparencia, con fondo blanco preferentemente.');
                $Foto->Set_TextButton('Cargar imagen Principal');
                if ($ProductImage != '') {
                    $Foto->EnablePictureDefault();
                }
                $Foto->SizeW(800);
                $Foto->SizeH(600);
                $Foto->ResizeSize(true);
                $Foto->CropSize();
                $Foto->ShowDelete('Quitar imagen');
                $Foto->Set_Max_Dimension_And_FileSize(1280, 900, 2097152);
                $Foto->Set_Picture($Set_Picture);
                $Foto->Set_Directory('_FileSystems' . \DS . 'Products' . \DS);
                $Foto->Set_Name($User->username . '_' . $FieldName . md5(microtime()));
                $Foto->Set_FieldName($FieldName);
                $Foto->RealName('ProductImage');
                $Foto->Make();
                ?>
            </div>
        </div>
        <div class="col-md-2 col-xs-6 col-sm-6">
            <p>Imagen 2</p>
            <div class="controls">
                <?php
                if ($Image2 != '') {
                    $Set_Picture = $Image2;
                } else {
                    $Set_Picture = \SKT_URL_BASE . '_FileSystems/avatar.png';
                }
                $FieldName2 = $User->username . '_Image2_' . \RAND_GLOBAL_INSTANCE;
                $Foto = new \CmsDev\CustomControl\ImageUpload\ImageUpload_Control();
                $FieldRand = $Foto->Set_Random(md5(rand(9, 999999) . microtime()));
                $Foto->Set_fileType(array('image/jpeg', 'image/jpg', 'image/png'));
                $Foto->Set_fileTypeNames('JPG o PNG sin transparencia, con fondo blanco preferentemente.');
                $Foto->Set_TextButton('Cargar imagen');
                if ($Image2 != '') {
                    $Foto->EnablePictureDefault();
                }
                $Foto->SizeW(800);
                $Foto->SizeH(600);
                $Foto->ResizeSize(true);
                $Foto->CropSize();
                $Foto->ShowDelete('Quitar imagen');
                $Foto->Set_Max_Dimension_And_FileSize(1280, 900, 2097152);
                $Foto->Set_Picture($Set_Picture);
                $Foto->Set_Directory('_FileSystems' . \DS . 'Products' . \DS);
                $Foto->Set_Name($User->username . '_' . $FieldName2 . md5(microtime()));
                $Foto->Set_FieldName($FieldName2);
                $Foto->RealName('Image2');
                $Foto->Make();
                ?>
            </div>
        </div>
        <div class="col-md-2 col-xs-6 col-sm-6">
            <p>Imagen 3</p>
            <div class="controls">
                <?php
                if ($Image3 != '') {
                    $Set_Picture = $Image3;
                } else {
                    $Set_Picture = \SKT_URL_BASE . '_FileSystems/avatar.png';
                }
                $FieldName3 = $User->username . '_Image3_' . \RAND_GLOBAL_INSTANCE;
                $Foto = new \CmsDev\CustomControl\ImageUpload\ImageUpload_Control();
                $FieldRand = $Foto->Set_Random(md5(rand(9, 999999) . microtime()));
                $Foto->Set_fileType(array('image/jpeg', 'image/jpg', 'image/png'));
                $Foto->Set_fileTypeNames('JPG o PNG sin transparencia, con fondo blanco preferentemente.');
                $Foto->Set_TextButton('Cargar imagen');
                if ($Image3 != '') {
                    $Foto->EnablePictureDefault();
                }
                $Foto->SizeW(800);
                $Foto->SizeH(600);
                $Foto->ResizeSize(true);
                $Foto->CropSize();
                $Foto->ShowDelete('Quitar imagen');
                $Foto->Set_Max_Dimension_And_FileSize(1280, 900, 2097152);
                $Foto->Set_Picture($Set_Picture);
                $Foto->Set_Directory('_FileSystems' . \DS . 'Products' . \DS);
                $Foto->Set_Name($User->username . '_' . $FieldName3 . md5(microtime()));
                $Foto->Set_FieldName($FieldName3);
                $Foto->RealName('Image3');
                $Foto->Make();
                ?>
            </div>
        </div>
        <div class="col-md-2 col-xs-6 col-sm-6">
            <p>Imagen 4</p>
            <div class="controls">
                <?php
                if ($Image4 != '') {
                    $Set_Picture = $Image4;
                } else {
                    $Set_Picture = \SKT_URL_BASE . '_FileSystems/avatar.png';
                }
                $FieldName4 = $User->username . '_Image4_' . \RAND_GLOBAL_INSTANCE;
                $Foto = new \CmsDev\CustomControl\ImageUpload\ImageUpload_Control();
                $FieldRand = $Foto->Set_Random(md5(rand(9, 999999) . microtime()));
                $Foto->Set_fileType(array('image/jpeg', 'image/jpg', 'image/png'));
                $Foto->Set_fileTypeNames('JPG o PNG sin transparencia, con fondo blanco preferentemente.');
                $Foto->Set_TextButton('Cargar imagen');
                if ($Image4 != '') {
                    $Foto->EnablePictureDefault();
                }
                $Foto->SizeW(800);
                $Foto->SizeH(600);
                $Foto->ResizeSize(true);
                $Foto->CropSize();
                $Foto->ShowDelete('Quitar imagen');
                $Foto->Set_Max_Dimension_And_FileSize(1280, 900, 2097152);
                $Foto->Set_Picture($Set_Picture);
                $Foto->Set_Directory('_FileSystems' . \DS . 'Products' . \DS);
                $Foto->Set_Name($User->username . '_' . $FieldName4 . md5(microtime()));
                $Foto->Set_FieldName($FieldName4);
                $Foto->RealName('Image4');
                $Foto->Make();
                ?>
            </div>
        </div>
        <div class="col-md-2 col-xs-6 col-sm-6">
            <p>Imagen 5</p>
            <div class="controls">
                <?php
                if ($Image5 != '') {
                    $Set_Picture = $Image5;
                } else {
                    $Set_Picture = \SKT_URL_BASE . '_FileSystems/avatar.png';
                }
                $FieldName5 = $User->username . '_Image5_' . \RAND_GLOBAL_INSTANCE;
                $Foto = new \CmsDev\CustomControl\ImageUpload\ImageUpload_Control();
                $FieldRand = $Foto->Set_Random(md5(rand(9, 999999) . microtime()));
                $Foto->Set_fileType(array('image/jpeg', 'image/jpg', 'image/png'));
                $Foto->Set_fileTypeNames('JPG o PNG sin transparencia, con fondo blanco preferentemente.');
                $Foto->Set_TextButton('Cargar imagen');
                if ($Image5 != '') {
                    $Foto->EnablePictureDefault();
                }
                $Foto->SizeW(800);
                $Foto->SizeH(600);
                $Foto->ResizeSize(true);
                $Foto->CropSize();
                $Foto->ShowDelete('Quitar imagen');
                $Foto->Set_Max_Dimension_And_FileSize(1280, 900, 2097152);
                $Foto->Set_Picture($Set_Picture);
                $Foto->Set_Directory('_FileSystems' . \DS . 'Products' . \DS);
                $Foto->Set_Name($User->username . '_' . $FieldName5 . md5(microtime()));
                $Foto->Set_FieldName($FieldName5);
                $Foto->RealName('Image5');
                $Foto->Make();
                ?>
            </div>
        </div>
        <div class="clear"></div>
        <div class="gap"></div>
        <h3><strong>3.</strong> <span>Datos Opcionales</span></h3>
        <div class="col-md-12">
            <div class="control-group ">
                <label class="control-label">
                    Etiquetas(Tags): Escriba las palabras clave que crea conveniente, para que su producto se encuentre más facilmente.
                </label>
                <div class="controls">
                    <input type="text" value="<?php echo $Tags; ?>" data-role="tagsinput" name="Tags" id="Tags" />
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="control-group ">
                <label class="control-label">
                    Descripci&oacute;n extendida
                </label>
                <div class="controls">
                    <?php
                    $editor = new \CmsDev\CustomControl\EditorHTML\Editor();
                    $editor->Set_FieldName('ProductDescriptionHTML');
                    $editor->Set_Content($ProductDescriptionHTML);
                    $editor->Set_Type('Basic');
                    $editor->Make();
                    ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="gap"></div>
        <div class="col-md-9 validatemail_tips  alert" style="padding: 7px 7px 14px 18px; color: #ff3300">
            <p>Complete todos los campos.</p>
        </div>
        <div class="col-md-12 text-right">
            <h1>
                <button id="NextStepRegister" type="button" class="btn btn-large btn-primary float-right"><i class="skt-icon-right-open-1"></i> Validar publicación</button>
            </h1>
        </div>

        <script>
            $('#MinSell').blur(function () {
                var Stock = parseInt($('input#stock').val());
                var MinSell = parseInt($(this).val());
                if (MinSell >= Stock || MinSell <= 1) {
                    alert('La cantidad minima de compra no puede superar al Stock "' + Stock + '"');
                    $(this).val(1);
                }
            });
            $('#UnitOrAll').change(function () {
                var MinSell = $('#MinSell');
                $("#UnitOrAll option:selected").each(function () {
                    if ($(this).val() == 'All') {
                        MinSell.prop('disabled', true);
                    } else {
                        MinSell.prop('disabled', false);
                    }
                }
                )
            }).change();

            function CheckURLProduct(field1, field2) {
                $.post(SKTGoTo + 'Q2hlY2tVUkxOYW1l', {Title: field1, rand: Math.random()}, function (data) {
                    $('#' + field2).val(data);
                });
            }
            function CreateContentEditor(options) {
                var default_args = {
                    'Element': '.skt_HTML_Editor',
                    'width': '100%',
                    'height': '350px',
                    'colors': '' + SKT_EDITOR_COLORS + '',
                    'fonts': '' + SKT_EDITOR_FONTS + '',
                    'bodyStyle': '' + SKT_EDITOR_BODY + '',
                    'docCSSFile': '' + URL_docCSSFile + '',
                    'docType': '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
                    'controls': 'bold italic underline strikethrough subscript superscript | font size style | color highlight removeformat | bullets numbering | outdent indent | alignleft center alignright justify | undo redo | Layout2 | FileSystem | rule table | image link | unlink cut copy paste pastetext | print source'
                };
                for (var index in default_args) {
                    if (typeof options[index] === "undefined")
                        options[index] = default_args[index];
                }
                var Element = $(options['Element']);
                Element.cleditor({
                    width: options['width'],
                    height: options['height'],
                    controls: options['controls'],
                    colors:
                            "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
                            "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
                            "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
                            "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
                            "666 900 C60 C93 990 090 399 33F 60C 939 " +
                            "333 600 930 963 660 060 366 009 339 636 " +
                            "000 300 630 633 330 030 033 006 309 303 " +
                            options['colors'],
                    fonts:
                            "Arial,Georgia,Tahoma,Trebuchet MS,Verdana" + options['fonts'],
                    sizes:
                            "1,2,3,4,5,6,7",
                    styles:
                            [["Paragraph", "<p>"], ["Header 1", "<h1>"], ["Header 2", "<h2>"], ["Header 3", "<h3>"], ["Header 4", "<h4>"], ["Header 5", "<h5>"],
                                ["Header 6", "<h6>"]],
                    useCSS: false,
                    docType:
                            options['docType'],
                    docCSSFile:
                            options['docCSSFile'],
                    bodyStyle:
                            options['bodyStyle'] + 'max-width:' + options['width'] + '!important;' + 'min-width:' + options['width'] + '!important;'
                })[0].focus();
            }

            $('#SKTNewProduct').submit(function () {
                ValidateProduct();
            });
            $('#NextStepRegister').click(function () {
                ValidateProduct();
            });
            $('#FinishValidateProduct').click(function () {
                FinishValidateProduct()
            });

            function ValidateProduct() {
                var error = false;
                var Title = $('#Title').val();
                var ProductDescription = $('#ProductDescription').val();
                var Price = $('#Price').val();
                var Date = $('#Date').val();
                var ProductImage = $('input[name="ProductImage"]').val();
                var validatemail_tips = $('.validatemail_tips');
                var errorText = '';
                $("input#Tags").val($("input#Tags").tagsinput('items'));
                var alert = 'form-alert-';
                if (Title.length === 0) {
                    error = true;
                    errorText += $('#' + alert + 'Title').html() + '<br>';
                }
                if (ProductDescription.length === 0) {
                    error = true;
                    errorText += $('#' + alert + 'ProductDescription').html() + '<br>'
                }
                if (Price.length === 0) {
                    error = true;
                    errorText += $('#' + alert + 'Price').html() + '<br>'
                }
                if (Date.length === 0) {
                    error = true;
                    errorText += $('#' + alert + 'Date').html() + '<br>'
                }
                if (ProductImage.length === 0) {
                    error = true;
                    errorText += $('#' + alert + 'ProductImage').html() + '<br>'
                }

                var ProductDescriptionHTML = $('iframe', '#SKTNewProductForm')[0].contentWindow.document.body.innerHTML;
                $('#ProductDescriptionHTML').html(ProductDescriptionHTML);

                if (error == false) {
                    $('#SKTNewProductForm').submit();
                } else {
                    validatemail_tips.html(errorText).fadeIn(500).delay(10000).fadeOut(500);
                }
            }



            var thresholdcolors = [['20%', 'darkred'], ['10%', 'red']] //[chars_left_in_pct, CSS color to apply to output]
            var uncheckedkeycodes = /(8)|(13)|(16)|(17)|(18)/  //keycodes that are not checked, even when limit has been reached.

            thresholdcolors.sort(function (a, b) {
                return parseInt(a[0]) - parseInt(b[0])
            }) //sort thresholdcolors by percentage, ascending

            function setformfieldsize($fields, optsize, optoutputdiv) {
                var $ = jQuery
                $fields.each(function (i) {
                    var $field = $(this)
                    $field.data('maxsize', optsize || parseInt($field.attr('data-maxsize'))) //max character limit
                    var statusdivid = optoutputdiv || $field.attr('data-output') //id of DIV to output status
                    $field.data('$statusdiv', $('#' + statusdivid).length == 1 ? $('#' + statusdivid) : null)
                    $field.unbind('keypress.restrict').bind('keypress.restrict', function (e) {
                        setformfieldsize.restrict($field, e)
                    })
                    $field.unbind('keyup.show').bind('keyup.show', function (e) {
                        setformfieldsize.showlimit($field)
                    })
                    setformfieldsize.showlimit($field) //show status to start
                })
            }

            setformfieldsize.restrict = function ($field, e) {
                var keyunicode = e.charCode || e.keyCode
                if (!uncheckedkeycodes.test(keyunicode)) {
                    if ($field.val().length >= $field.data('maxsize')) { //if characters entered exceed allowed
                        if (e.preventDefault)
                            e.preventDefault()
                        return false
                    }
                }
            }

            setformfieldsize.showlimit = function ($field) {
                if ($field.val().length > $field.data('maxsize')) {
                    var trimmedtext = $field.val().substring(0, $field.data('maxsize'))
                    $field.val(trimmedtext)
                }
                if ($field.data('$statusdiv')) {
                    $field.data('$statusdiv').css('color', '').html($field.val().length)
                    var pctremaining = ($field.data('maxsize') - $field.val().length) / $field.data('maxsize') * 100 //calculate chars remaining in terms of percentage
                    for (var i = 0; i < thresholdcolors.length; i++) {
                        if (pctremaining <= parseInt(thresholdcolors[i][0])) {
                            $field.data('$statusdiv').css('color', thresholdcolors[i][1])
                            break
                        }
                    }
                }
            }



            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                weekHeader: 'Sm',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['es']);
            $(".datepicker").datepicker({minDate: 0, maxDate: "+1M", dateFormat: "yy-mm-dd"});
            $('#ui-datepicker-div').wrap('<div class="skt" />');

            $(".numeric").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });

            $(document).ready(function ($) { //fire on DOM ready
                var $targetfields = $("input[data-maxsize], textarea[data-maxsize]")
                setformfieldsize($targetfields);
            })

        </script>
    <?php } ?>

</form>
<div class="gap"></div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              