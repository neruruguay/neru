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
if (\CmsDev\Security\loginIntent::action('validate', 'Note', 'Add') === true) {
    echo \SKT_ADMIN_AdminWraperOpen;
    ?>
    <form action="" method="post" id="FormCreateContent"> 
        <input name="Date" type="hidden" value="<?php echo date('Y-m-d') ?>" />
        <input name="Type" type="hidden" value="Note" />
        <input name="Custom" readonly type="hidden" value="" />
        <input name="IDPage" readonly type="hidden" value="<?php echo $_POST['IDPage'] ?>"/>
        <input name="Description" type="hidden" value="" />
        <div class="skts_content">
            <div class="SKTrow">
                <div class="col first">
                    <fieldset>
                        <textarea id="EditorAddNote" name="CreateContentEditor"></textarea>
                    </fieldset>
                </div>
                <div class="col">
                    <fieldset>
                        <label class="half-control-group half-control-group-left">
                            <span><?php echo \SKT_ADMIN_Select_Note_Theme ?>:</span>
                            <?php echo \CmsDev\CRUD\Xtras\Themes_Note::ThemeList(); ?>
                        </label>
                        <label class="half-control-group">
                            <span><?php echo \SKT_ADMIN_TXT_View_AllPagesTitle ?>:</span>
                            <?php echo \CmsDev\CRUD\Xtras\List_ThisOrAll_Page::ThisOrAll(0); ?>
                        </label>
                        <label class="half-control-group half-control-group-left">
                            <span><?php echo \SKT_ADMIN_TXT_ConfigContentTitle ?></span>
                            <input name="Title" type="text" value=""/>
                        </label>
                        <label class="half-control-group">
                            <span>Autor:</span>
                            <input name="Autor" type="text" value=""/>
                        </label>
                        <label class="half-control-group half-control-group-left">
                            <span><?php echo \SKT_ADMIN_TXT_Zone ?>:</span>
                            <div id="ZoneNewContent"></div>
                        </label>
                        <label class="half-control-group">
                            <span><?php echo \SKT_ADMIN_TXT_ZoneOrder ?>:</span>
                            <?php echo \CmsDev\CRUD\Xtras\List_Position_Zone::set(0, \SKT_SECTION_ID, 0); ?>
                        </label>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_Section_CSS; ?></span>
                            <input name="css_class" type="text" value=""/>
                        </label>
                    </fieldset>
                    <?php echo \CmsDev\CRUD\Xtras\Radio_RecycleBin::OptionGroup(0, 0); ?>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">

        $(document).ready(function () {
            setTimeout('DescriptionHTML()', 1000);
            $("#ZoneNewContent").append($('#ListZoneColector').html());
            $("#ZoneNewContent select:eq(1)").remove();
        });

        function DescriptionHTML() {
            AppSKT.CreateContentEditor({
                'Element': '#EditorAddNote',
                'width': '100%',
                'height': '365px',
                'controls': 'bold italic underline strikethrough subscript superscript | font size style | color highlight removeformat | bullets numbering | outdent indent | alignleft center alignright justify | undo redo | rule | image link | unlink cut copy paste pastetext | source'
            });
        }
        /* ----------------------------- CREATE DIALOG --------------------------------------------------*/
        $("#dialog").dialog("destroy");
        var tips = $(".validateTips");
        var allFields = '';
        /*var ProductAutoID = $("#ProductAutoID"),
         SectionAutoID = $("#SectionAutoID"),
         allFields = $([]).add(ProductAutoID).add(SectionAutoID);
         */
        $("#dialog-form-Administrator").dialog({
            autoOpen: true,
            width: 990,
            maxWidth: 990,
            position: ['3%', 55],
            title: '<i class="skt-icon-feather"></i> <?php echo \SKT_ADMIN_CreateContentTitleNote ?>',
            modal: true,
            buttons: {
                'Agregar Nota': function () {
                    var bValid = true;
                    //allFields.removeClass('ui-state-error');
                    /* ----------------------------- VALIDATE FIELDS --------------------------------------------------*/
                    /*
                     bValid = bValid && AppSKT.checkRegexp(ProductAutoID,/^([0-9a-zA-Z])+$/,"Por un error desconocido, no se puede agregar el Producto, refresque la p&aacute;gina e intente nuevamente");
                     bValid = bValid && AppSKT.checkRegexp(SectionAutoID,/^([0-9a-zA-Z])+$/,"Por un error desconocido, no se puede agregar el Producto, refresque la p&aacute;gina e intente nuevamente");
                     bValid = bValid && AppSKT.checkLength(ProductName,"Nombre del producto",6,100);					
                     */
                    /* ----------------------------- END VALIDATE FIELDS --------------------------------------------------*/
                    if (bValid) {
                        /*  -----------------------------  IF OK  --------------------------*/
                        var elHTML = $('iframe', '#FormCreateContent')[0].contentWindow.document.body.innerHTML;
                        $('#EditorAddNote').html(elHTML);
                        var validating = '<i class="skt-iconspin1 animate-spin"></i>';
                        tips.html(validating);
                        jQuery.ajax({
                            'type': 'POST',
                            'url': 'SKTGoTo/' + admd2('/Query/CreateContent'),
                            'cache': false,
                            'data': $("#FormCreateContent").serialize(),
                            'success': function (htmlReturn) {
                                if ($.trim(htmlReturn) == "okay") {
                                    var ROK = '<i class="skt-icon-success"></i><span>' + SKT_ADMIN_Message_Update_OK + '</span>';
                                    tips.html(ROK);
                                    AppSKT.ReloadPage(document.URL);
                                } else {
                                    var RKO = '<i class="skt-icon-frown"></i><span>' + SKT_ADMIN_Message_Update_Error + '</span>';
                                    tips.html(RKO);
                                }
                            }
                        });
                        /*  -----------------------------  OK  --------------------------*/
                    }
                },
                Cancelar: function () {
                    AppSKT.skt_RemoveDialog();
                }
            },
            close: function () {
                AppSKT.skt_RemoveDialog();
            }
        });
        AppSKT.skt_WrapDialog();
        /* ----------------------------- END CREATE DIALOG --------------------------------------------------*/
    </script>
    <?php
    echo \SKT_ADMIN_AdminWraperClose;
}
?> 