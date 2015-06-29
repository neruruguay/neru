<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../../Core.php');
}
$SKTDB = \CmsDev\sql\db_Skt::connect();
if (\CmsDev\Security\loginIntent::action('validate', 'Product', 'Add') === true) {
    $USER = new \CmsDev\Query\UserProfile();
    $USER->GetDataSet();
    $Section_AutoID = $Products_AutoID = CmsDev\Dataset\Section::new_auto_increment_ID();
    $getAutoID = $Section_AutoID . '_' . date('Y-m-d');
    $AdminWraperOpen = str_replace('[title]', $CMSText_CreateProduct . ': <em>' . $MetaDataTitle . '</em>.', \SKT_ADMIN_AdminWraperOpen);
    $AdminWraperOpen = str_replace('validateTips', 'validateTipsProduct', $AdminWraperOpen);
    echo $AdminWraperOpen;
    ?>
    <style media="all">
        #dialog-form-Administrator label input { font-size: 13px; font-weight: bold; padding: 3px 6px !important; width: 92%; }
    </style>
    <div class="container_16" >
        <div class="CreateContentHtml" id="AddProductBox" style="display:none;">
            <form action="" method="post" id="FormCreateContent">
                <input name="ProductAutoID" id="ProductAutoID" type="hidden" value="<?php echo $Products_AutoID ?>" />
                <input name="SectionAutoID" id="SectionAutoID" type="hidden" value="<?php echo $Section_AutoID ?>" />
                <input name="File" id="File" type="hidden" value="" />
                <input name="RelatedDocument" id="RelatedDocument" type="hidden" value="" />
                <input name="iva_perc" type="hidden" value="22" />
                <input name="SearchURLName" id="SearchURLName"  type="hidden" value="" />
                <input name="RenderURL" readonly type="hidden" value="<?php echo CorrectURL($_POST['RenderURL']) ?>" />
                <input name="RenderSubDir" readonly type="hidden" value="<?php echo CorrectURL($_POST['RenderSubDir']) ?>" />
                <input name="Language" type="hidden" value="<?php echo $Language ?>" />
                <input name="SystemRequired" type="hidden" value="0" />
                <input name="SectionType" type="hidden" value="2" />
                <input name="Template" type="hidden" value="<?php echo $ProductTemplate ?>" />
                <input name="SID" type="hidden" value="<?php echo $Section_AutoID ?>" />
                <input name="IDPage" readonly type="hidden" value="<?php echo $_POST['IDPage']; ?>" />
                <script>
                    var URL = window.location.pathname;
                    $('#SearchURLName').val(URL);
                    //alert(URL);
                </script>
                <div id="CmsDevTabs">
                    <ul>
                        <li><a href="#tabs-1">Caracter&iacute;sticas del Producto</a></li>
                        <li><a href="#tabs-2">Carga de Im&aacute;genes y Referencias</a></li>
                        <!--<li><a href="#tabs-3">Meta-Descripci&oacute;n</a></li>-->
                    </ul>
                    <div id="tabs-1"> 
                        <!--//////////////////////////////////////////////////////////////////////////////////////////////-->

                        <div class="grid_7">
                            <label><span><?php echo $CMSText_ProductDescription ?></span>
                                <textarea id="ProductDescription" name="ProductDescription"  class="text ui-corner-all LimitedComments"  maxlength="300" style="height: 60px;"></textarea>
                                <span class="LimitedCounter"><b class="number"></b> caracteres restantes</span> </label>
                            <label style="height: 267px;"><span><?php echo $CMSText_ProductDetail ?></span>
                                <textarea id="ProductDescriptionHTML" name="ProductDescriptionHTML"></textarea>
                            </label>
                            <div class="clear"></div>
                        </div>
                        <div class="grid_5">
                            <label><span><?php echo $CMSText_ProductName ?></span>
                                <input name="ProductName"  id="ProductName" type="text" value="" onBlur="AppSKT.CheckURLName(this.value, 'URLNameNewSection');
                                        $('#MetaDataTitle').val(this.value)" class="text ui-widget-content ui-corner-all" />
                            </label>
                            <label><span><?php echo $CMSText_URLSection ?>:<span id="urlNew"></span></span>
                                <input name="URLName" id="URLNameNewSection" type="text" value="" class="text ui-corner-all" />
                            </label>
                            <label>
                                <span><?php echo $CMSText_RelatedDocumentUpload ?>: .doc, .xls, .pdf, .rar, .zip <span id="RelatedDocumentUpload"  style="display:inline-block; font-weight: bold; font-size: 13px;">.</span></span>
                                <div id="RelatedDocumentUploadBtn">
                                    <noscript>
                                    <p>Lo sentimos, para cargar el archivo es necesario tener java activado en su navegador.<br />
                                        Recomendamos como navegador: IExplorer > 8, Firefox o Chrome.</p>
                                    </noscript>
                                </div>
                            </label>
                            <div class="clear"></div>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <input type="radio" name="RecycleBin" value="0" id="RecycleBin_0" checked="checked"/>
                                    </td>
                                    <td>
                                        <label class="checkbox"><span><?php echo $CMSText_ShowContentVisible ?></span></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="radio" name="RecycleBin"  value="1" id="RecycleBin_1" />
                                    </td>
                                    <td>
                                        <label class="checkbox"><span><?php echo $CMSText_ShowContentHidden ?></span></label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="grid_4">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableDialogAdmin">
                                <tr>
                                    <td style="display:none;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td>
                                                    <input name="ProductNew" type="checkbox" value="1"/>
                                                </td>
                                                <td>
                                                    <label class="checkbox"><span><?php echo $CMSText_ProductNew ?></span></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input name="ProductOffer" type="checkbox" value="1" />
                                                </td>
                                                <td>
                                                    <label class="checkbox"><span><?php echo $CMSText_ProductOffer ?></span></label>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <label><span>Empaque</span>
                                            <input name="Packing" id="Packing" type="text" value="" class="text ui-corner-all" />
                                        </label>
                                        <label><span><?php echo $CMSText_ProductType ?></span>
                                            <select name="ProductType" size="1" class="text ui-corner-all" >
                                                <option value="2" selected="selected">Con cambio de fondos</option>
                                                <option value="1">Sin cambio de fondos</option>
                                            </select>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                            <label>
                                <input name="Date"  id="Date" type="text" value="<?php echo date('Y-m-d') ?>" class="text ui-corner-all" />
                            </label>
                        <label><span><?php echo \SKT_ADMIN_TXT_OrderMenuSection ?>:</span>
                            <?php
                            $List_Position_Section = new \CmsDev\CRUD\Xtras\List_Position_Section();
                            echo $List_Position_Section->set('max', $_POST['IDSections']);
                            ?>
                        </label> 
                            <label><span>Meta <?php echo $CMSText_MetaDataTitle ?></span>
                                <input name="MetaDataTitle" id="MetaDataTitle" type="text" value="" class="text ui-corner-all" />
                            </label>
                            <label><span>Meta <?php echo $CMSText_MetaDataDescription ?></span>
                                <textarea name="MetaDataDescription" style="height: 40px;" class="text ui-corner-all" ></textarea>
                            </label>
                            <label><span>Meta <?php echo $CMSText_MetaDataKeywords ?></span>
                                <textarea name="MetaDataKeywords" style="height: 40px;"  class="text ui-corner-all" ></textarea>
                            </label>
                        </div>
                        <div class="clear"></div>

                        <!--//////////////////////////////////////////////////////////////////////////////////////////////--> 
                    </div>
                    <div id="tabs-2"> 
                        <!--//////////////////////////////////////////////////////////////////////////////////////////////-->

                        <div class="grid_4 bg-2">
                            <label> <span>Nombre/Color</span>
                                <input name="ReferenceName1" id="ReferenceName1" type="text" value="" />
                            </label>
                            <label> <span>Ref.N&deg;</span>
                                <input name="Reference1" id="Reference1" type="text" value="" />
                            </label>
                            <label>
                                <span id="ProductImageIMG" style="height: 160px;"></span>
                                <span><?php echo $CMSText_ProductImage ?></span>
                                <span id="fileUploaderBtn">
                                    <noscript>
                                    <p>Lo sentimos, para cargar el archivo es necesario tener java activado en su navegador.<br />
                                        Recomendamos como navegador: IExplorer > 8, Firefox o Chrome.</p>
                                    </noscript>
                                </span>
                                <input name="ProductImage" id="ProductImage" type="text" value="default.png" />
                            </label>
                        </div>
                        <div class="grid_3">
                            <label> <span>Nombre/Color</span>
                                <input name="ReferenceName2" id="ReferenceName2" type="text" value="" />
                            </label>
                            <label> <span>Ref.N&deg;</span>
                                <input name="Reference2" id="Reference2" type="text" value="" />
                            </label>
                            <label>
                                <div id="ProductImageIMG_Image2" style="height: 160px;"></div>
                                <span><?php echo $CMSText_ProductImage2 ?> 2</span>
                                <div id="fileUploaderBtn_Image2">
                                    <noscript>
                                    <p>Lo sentimos, para cargar el archivo es necesario tener java activado en su navegador.<br />
                                        Recomendamos como navegador: IExplorer > 8, Firefox o Chrome.</p>
                                    </noscript>
                                </div>
                                <input name="Image2" id="Image2" type="text" value="" />
                            </label>
                        </div>
                        <div class="grid_3">
                            <label> <span>Nombre/Color</span>
                                <input name="ReferenceName3" id="ReferenceName3" type="text" value="" />
                            </label>
                            <label> <span>Ref.N&deg;</span>
                                <input name="Reference3" id="Reference3" type="text" value="" />
                            </label>
                            <label>
                                <div id="ProductImageIMG_Image3" style="height: 160px;"></div>
                                <span><?php echo $CMSText_ProductImage2 ?> 3</span>
                                <div id="fileUploaderBtn_Image3">
                                    <noscript>
                                    <p>Lo sentimos, para cargar el archivo es necesario tener java activado en su navegador.<br />
                                        Recomendamos como navegador: IExplorer > 8, Firefox o Chrome.</p>
                                    </noscript>
                                </div>
                                <input name="Image3" id="Image3" type="text" value="" />
                            </label>
                        </div>
                        <div class="grid_3">
                            <label> <span>Nombre/Color</span>
                                <input name="ReferenceName4" id="ReferenceName4" type="text" value="" />
                            </label>
                            <label> <span>Ref.N&deg;</span>
                                <input name="Reference4" id="Reference4" type="text" value="" />
                            </label>
                            <label>
                                <div id="ProductImageIMG_Image4" style="height: 160px;"></div>
                                <span><?php echo $CMSText_ProductImage2 ?> 4</span>
                                <div id="fileUploaderBtn_Image4">
                                    <noscript>
                                    <p>Lo sentimos, para cargar el archivo es necesario tener java activado en su navegador.<br />
                                        Recomendamos como navegador: IExplorer > 8, Firefox o Chrome.</p>
                                    </noscript>
                                </div>
                                <input name="Image4" id="Image4" type="text" value="" />
                            </label>
                        </div>
                        <div class="grid_3">
                            <label> <span>Nombre/Color</span>
                                <input name="ReferenceName5" id="ReferenceName5" type="text" value="" />
                            </label>
                            <label> <span>Ref.N&deg;</span>
                                <input name="Reference5" id="Reference5" type="text" value="" />
                            </label>
                            <label>
                                <div id="ProductImageIMG_Image5" style="height: 160px;"></div>
                                <span><?php echo $CMSText_ProductImage2 ?> 5</span>
                                <div id="fileUploaderBt_Image5">
                                    <noscript>
                                    <p>Lo sentimos, para cargar el archivo es necesario tener java activado en su navegador.<br />
                                        Recomendamos como navegador: IExplorer > 8, Firefox o Chrome.</p>
                                    </noscript>
                                </div>
                                <input name="Image5" id="Image5" type="text" value="" />
                            </label>
                        </div>
                        <div class="clear"></div>

                        <!--//////////////////////////////////////////////////////////////////////////////////////////////--> 
                    </div>
                    <div id="tabs-3"> 
                        <!--//////////////////////////////////////////////////////////////////////////////////////////////-->

                        <div class="grid_8"> </div>
                        <div class="clear"></div>

                        <!--//////////////////////////////////////////////////////////////////////////////////////////////--> 
                    </div>
                </div>
                <!--///////////////////////////////////  END TABS  ///////////////////////////////////////////////-->

            </form>
        </div>
        <div class="clear"></div>
    </div>
    <script type="text/javascript">
        function HTML_Content_Add_Product() {
            CreateContentEditor({
                'Element': '#ProductDescriptionHTML',
                'width': '391px',
                'height': '200px',
                'colors': "<?php echo $ExtraColorsEditor; ?>",
                //'fonts'		:	"<?php echo $ExtraFontEditor ?>",
                'bodyStyle': "<?php echo $bodyStyle ?>",
                'docCSSFile': "_TemplateSite/<?php echo $TemplateSite ?>/css/style.css",
                'docType': '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
                'controls': 'bold italic underline subscript superscript | size style | color highlight removeformat | bullets numbering | outdent indent | alignleft center alignright | FileSystem | rule | link unlink | pastetext'
            });
            $('#AddProductBox').css('display', 'block');
        }


        $(function () {

            $('.LimitedComments').keyup(function () {
                var maxlength = $(this).attr("maxlength");
                var actuallength = $(this).val().length;
                var remainder = maxlength - actuallength;
                $(this).next('.LimitedCounter').find('.number').html(remainder);
                if (remainder <= 1) {
                    $(this).attr("maxlength", maxlength);
                    return false;
                }
            });

            $('.LimitedCounter .number').each(function (index) {
                var maxlength = $(this).parent().prev('.LimitedComments').attr("maxlength");
                $(this).text(maxlength);
            });

        });


        $(document).ready(function () {




            $(function () {
                $("#CmsDevTabs").tabs();
            });
            var t = setTimeout('HTML_Content_Add_Product()', 1000);
            /* ----------------------------- UPLOAD --------------------------------------------------*/
            var uploader = new qq.FileUploader({
                element: document.getElementById('fileUploaderBtn'),
                action: './_CmsDevfileuploader/ProductUpload.php',
                multiple: true,
                sizeLimit: 1024000,
                allowedExtensions: ['jpg', 'png', 'gif'],
                onComplete: function (id, fileName, responseJSON) {
                    $("#ProductImageIMG").html('');
                    $('#fileUploaderBtn .qq-upload-list').html('');
                    $("#ProductImageIMG").html('<img src="./_FileSystems/images/' + responseJSON["filename"] + '?r=' + Math.floor(Math.random() * 4) + '" alt=""/>');
                    $("#ProductImage").val(responseJSON["filename"]);
                }
            });

            /* ----------------------------- UPLOAD Image2--------------------------------------------------*/
            var uploaderImage2 = new qq.FileUploader({
                element: document.getElementById('fileUploaderBtn_Image2'),
                action: './_CmsDevfileuploader/ProductUpload2.php',
                multiple: true,
                sizeLimit: 1024000,
                allowedExtensions: ['png'],
                onComplete: function (id, fileName, responseJSON) {
                    $("#ProductImageIMG_Image2").html('');
                    $('#fileUploaderBtn_Image2 .qq-upload-list').html('');
                    $("#ProductImageIMG_Image2").html('<img src="./_FileSystems/productos/' + responseJSON["filename"] + '?r=' + Math.floor(Math.random() * 4) + '" alt=""/>');
                    $("#Image2").val(responseJSON["filename"]);
                }
            });
            /* ----------------------------- UPLOAD Image3--------------------------------------------------*/
            var uploaderImage3 = new qq.FileUploader({
                element: document.getElementById('fileUploaderBtn_Image3'),
                action: './_CmsDevfileuploader/ProductUpload2.php',
                multiple: true,
                sizeLimit: 1024000,
                allowedExtensions: ['png'],
                onComplete: function (id, fileName, responseJSON) {
                    $("#ProductImageIMG_Image3").html('');
                    $('#fileUploaderBtn_Image3 .qq-upload-list').html('');
                    $("#ProductImageIMG_Image3").html('<img src="./_FileSystems/productos/' + responseJSON["filename"] + '?r=' + Math.floor(Math.random() * 4) + '" alt=""/>');
                    $("#Image3").val(responseJSON["filename"]);
                }
            });
            /* ----------------------------- UPLOAD Image4--------------------------------------------------*/
            var uploaderImage4 = new qq.FileUploader({
                element: document.getElementById('fileUploaderBtn_Image4'),
                action: './_CmsDevfileuploader/ProductUpload2.php',
                multiple: true,
                sizeLimit: 1024000,
                allowedExtensions: ['png'],
                onComplete: function (id, fileName, responseJSON) {
                    $("#ProductImageIMG_Image4").html('');
                    $('#fileUploaderBtn_Image4 .qq-upload-list').html('');
                    $("#ProductImageIMG_Image4").html('<img src="./_FileSystems/productos/' + responseJSON["filename"] + '?r=' + Math.floor(Math.random() * 4) + '" alt=""/>');
                    $("#Image4").val(responseJSON["filename"]);
                }
            });
            /* ----------------------------- UPLOAD Image5--------------------------------------------------*/
            var uploaderImage5 = new qq.FileUploader({
                element: document.getElementById('fileUploaderBt_Image5'),
                action: './_CmsDevfileuploader/ProductUpload2.php',
                multiple: true,
                sizeLimit: 1024000,
                allowedExtensions: ['png'],
                onComplete: function (id, fileName, responseJSON) {
                    $("#ProductImageIMG_Image5").html('');
                    $('#fileUploaderBtn_Image5 .qq-upload-list').html('');
                    $("#ProductImageIMG_Image5").html('<img src="./_FileSystems/productos/' + responseJSON["filename"] + '?r=' + Math.floor(Math.random() * 4) + '" alt=""/>');
                    $("#Image5").val(responseJSON["filename"]);
                }
            });



            /* ----------------------------- UPLOAD DOC --------------------------------------------------*/
            var RelatedDocumentUpload = new qq.FileUploader({
                element: document.getElementById('RelatedDocumentUploadBtn'),
                action: './_CmsDevfileuploader/RelatedDocumentUpload.php?Language=<?php echo $Language ?>',
                multiple: true,
                sizeLimit: 1024000,
                allowedExtensions: ['doc', 'docx', 'xls', 'xlsx', 'pdf', 'rar', 'zip'],
                onComplete: function (id, fileName, responseJSON) {
                    $('#RelatedDocumentUploadBtn .qq-upload-list').html('');
                    $("#RelatedDocumentUpload").text(responseJSON["filename"]);
                    $("#RelatedDocument").val(responseJSON["filename"]);
                }
            });
    //$('#RelatedDocumentUploadBtn .qq-upload-button:contains("Cargar imagen")').html('Cargar Documento<input type="file" multiple="multiple" name="file" style="position: absolute; right: 0px; top: 0px; font-family: Arial; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;">');
            /* ----------------------------- LIST ZONE's ---------------------------------------------*/
            $("#ZoneNewContent").append($('#ListZoneColector').html());
            $("#ZoneNewContent select:eq(1)").remove();

        });


        /* ----------------------------- CREATE DIALOG --------------------------------------------------*/

        $(function () {

            $("#dialog").dialog("destroy");



            var ProductAutoID = $("#ProductAutoID"),
                    SectionAutoID = $("#SectionAutoID"),
                    ProductName = $("#ProductName"),
                    URLNameNewSection = $("#URLNameNewSection"),
                    ProductImage = $("#ProductImage"),
                    ProductDescription = $("#ProductDescription"),
                    CreateDate = $("#Date"),
                    MetaDataTitle = $("#MetaDataTitle"),
                    allFields = $([]).add(ProductAutoID).add(SectionAutoID).add(ProductName).add(URLNameNewSection).add(ProductImage).add(ProductDescription).add(CreateDate).add(MetaDataTitle),
                    tips = $(".validateTipsProduct");



            $("#dialog-form-Administrator").dialog({
                autoOpen: true,
                width: 990,
                maxWidth: 990,
                position: ['3%', 55],
                modal: true,
                buttons: {
                    'Crear Producto': function () {

                        var bValid = true;

                        allFields.removeClass('ui-state-error');



                        /* ----------------------------- VALIDATE FIELDS --------------------------------------------------*/



                        bValid = bValid && AppSKT.checkRegexp(ProductAutoID, /^([0-9a-zA-Z])+$/, "Por un error desconocido, no se puede agregar el Producto, refresque la p&aacute;gina e intente nuevamente");

                        bValid = bValid && AppSKT.checkRegexp(SectionAutoID, /^([0-9a-zA-Z])+$/, "Por un error desconocido, no se puede agregar el Producto, refresque la p&aacute;gina e intente nuevamente");

                        bValid = bValid && AppSKT.checkLength(ProductName, "Nombre del producto", 4, 255);

                        //bValid = bValid && AppSKT.checkLength(ProductImage,"Imagen del producto",4,255);

                        bValid = bValid && AppSKT.checkRegexp(ProductImage, /^([0-9a-zA-Z-.])+$/, "Seleccione una Imagen del producto");

                        bValid = bValid && AppSKT.checkLength(URLNameNewSection, "Dirección de la P&aacute;gina", 5, 300);

                        bValid = bValid && AppSKT.checkLength(ProductDescription, "Breve Resumen del producto", 6, 300);



                        /* ----------------------------- END VALIDATE FIELDS --------------------------------------------------*/



                        if (bValid) {

                            /*  -----------------------------  IF OK  --------------------------*/





                            var elHTML = $('iframe', '#FormCreateContent')[0].contentWindow.document.body.innerHTML;

                            $('#ProductDescriptionHTML').html(elHTML);

                            var validating = '<label><div class="ui-state-highlight ui-corner-all"><p><?php echo $CMSText_RefreshIn ?><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-refresh"></span></p></div></label>';

                            tips.html(validating);

                            jQuery.ajax({
                                'type': 'POST',
                                'url': '<?php echo $URL_QueryCreateSectionProduct ?>',
                                'cache': false,
                                'data': $("#FormCreateContent").serialize(),
                                'success': function (data) {

                                    if (data.indexOf('okay') != -1) {

                                        var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p><?php echo $CMSText_UpdateOK ?><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';

                                        tips.html(ROK);

                                        AppSKT.ReloadPage(document.URL);

                                    } else {

                                        var RKO = '<label><div class="ui-state-error ui-corner-all"><p><?php echo $CMSText_UpdateError ?><br />' +
                                                data + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';

                                        tips.html(RKO);

                                    }

                                }



                            });





                            /*  -----------------------------  OK  --------------------------*/



                        }

                    },
                    Cancelar: function () {

                        $('.ui-widget-overlay').remove();
                        $('body #dialog-form-Administrator').remove();
                        $('.cleditorPopup').remove();
                    }

                },
                close: function () {

                    $('.ui-widget-overlay').remove();
                    $('body #dialog-form-Administrator').remove();
                    $('.cleditorPopup').remove();
                }

            });

        });


        /* ----------------------------- END CREATE DIALOG --------------------------------------------------*/

        $(function () {
            var availableTags = [
                "Grafito",
                "Blanco",
                "Negro",
                "Marfil",
                "Cafe",
                "Rojo",
                "Amarillo",
                "Aluminio",
                "Oro",
                "Cobre",
                "Bronce",
                "Ambar",
                "1M",
                "2M",
                "1MD",
                "Ciega",
                "3M",
                "6M"
            ];
            $("#ReferenceName1, #ReferenceName2, #ReferenceName3, #ReferenceName4, #ReferenceName5").autocomplete({
                source: availableTags
            });
        });

    </script> 
    <?php
    echo \SKT_ADMIN_AdminWraperClose;
}
?> 