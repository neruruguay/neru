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
if (\CmsDev\Security\loginIntent::action('validate', 'Image', 'Add') === true) {

    echo str_replace('[title]', 'Agregar (Imagen)', \SKT_ADMIN_AdminWraperOpen);
    $FileDataRecovery = new \CmsDev\AdminFilesystem\FileDataRecovery();
    ?>
    <style media="all" type="text/css">
        body{overflow:hidden !important;}
    </style>
    <div class="row" style="margin: 15px 5px 0;">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sistema de archivos, seleccione la imagen aqu&iacute;</h3>
                </div>
                <div class="panel-body">
                    <div id="ImageSystemScroll" style="height:100%; width:100%; overflow:visible; display:block; position:relative">
                        <?php
                        $RenderIframe = '<iframe id="IframeFiles" frameborder="0" style="width:100%; height:100%;" scrolling="auto" src="';
                        $RenderIframe .= \SKT_URL_BASE . 'SKTFSys/"></iframe>';
                        echo $RenderIframe;
                        ?> 
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos de imagen</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="post" id="FormCreateContent">

                        <input name="CreateContentEditor" type="hidden" value=" " />
                        <input name="Date" type="hidden" value="<?php echo date('Y-m-d') ?>" />
                        <input name="IDPage" readonly type="hidden" value="<?php echo $_POST['IDPage']; ?>" />
                        <input name="Type" type="hidden" value="Photo" />
                        <input name="AllPage" type="hidden" value="0" />

                        <div class="SaveTags"></div>
                        <div id="TagForm"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <label><span><?php echo \SKT_ADMIN_IMAGE_IDZoneContent ?>:</span></label>
                                <div id="ZoneNewContent"></div>
                            </div>
                            <div class="col-md-6">
                                <label><span><?php echo \SKT_ADMIN_IMAGE_OrderContent ?>:</span></label>
                                <?php echo \CmsDev\CRUD\Xtras\List_Position_Zone::set(0, \SKT_SECTION_ID, 0); ?>
                            </div>
                        </div>

                        <div class="row">
                            <hr>
                            <div class="col-md-12">
                                <?php echo \CmsDev\CRUD\Xtras\Radio_RecycleBin::OptionGroup(0, 0); ?>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".FolderSystemUL").find("UL").hide();
            $("#ZoneNewContent").append($('#ListZoneColector').html());
            $("#ZoneNewContent select:eq(0)").addClass('form-control');
            $("#ZoneNewContent select:eq(1)").remove();
            $('#dialog-form-Administrator #ImageSystemScroll').css({'overflow-y': 'auto', 'overflow-x': 'hidden', 'height': ($(window).height() - 280)});
            $('#dialog-form-Administrator #IframeFiles')
                    .css({'height': ($(window).height() - 280)});
            $('#CheckClick').click(function () {
                var TheLink = $('#dialog-form-Administrator input#hiperlink');
                var CheckLink = '[CheckLink]' + TheLink.val();
                TheLink.val(CheckLink);
            });
            $('.SaveTags').click(function () {
                var File = $('#dialog-form-Administrator input#CustomProperty').val();
                if (File != '') {
                    var Title = $('#dialog-form-Administrator input#Title').val();
                    var tags = $('#dialog-form-Administrator textarea#Description').val();
                    var hiperlink = $('#dialog-form-Administrator input#hiperlink').val();
                    var FileOrder = $('#dialog-form-Administrator input#FileOrder').val();
                    jQuery.ajax({
                        'type': 'POST',
                        'url': 'SKTGoTo/' + admd2('/AdminFilesystem/File_SaveTags'),
                        'cache': false,
                        'data': 'File=' + File + '&Title=' + Title + '&tags=' + tags + '&hiperlink=' + hiperlink + '&FileOrder=' + FileOrder,
                        'success': function (data) {

                        }
                    });
                }
            });

            $("#dialog").dialog("destroy");
            $("#dialog-form-Administrator").dialog({
                autoOpen: true,
                height: ($(window).height() - 50),
                width: ($(window).width()),
                position: ['0%', '0%'],
                modal: true,
                buttons: {
                    'Actualizar Imagen': function () {
                        /*  -----------------------------  IF OK  --------------------------*/
                        var File = $('#dialog-form-Administrator input#CustomProperty').val();
                        var Title = $('#dialog-form-Administrator #Title').val();
                        var tags = $('#dialog-form-Administrator #Description').val();
                        var hiperlink = $('#dialog-form-Administrator #hiperlink').val();
                        var FileOrder = $('#dialog-form-Administrator #FileOrder').val();
                        jQuery.ajax({
                            'type': 'POST',
                            'url': 'SKTGoTo/' + admd2('/AdminFilesystem/File_SaveTags'),
                            'cache': false,
                            'data': 'File=<?php echo $_POST['RenderURL'] ?>' + File + '&Title=' + Title + '&tags=' + tags + '&hiperlink=' + hiperlink + '&FileOrder=' + FileOrder,
                            'success': function () {
                                jQuery.ajax({
                                    'type': 'POST',
                                    'url': 'SKTGoTo/' + admd2('/Query/CreateContent'),
                                    'cache': false,
                                    'data': $("#FormCreateContent").serialize(),
                                    'success': function (data) {
                                        var tips = $(".validateTips");
                                        if (data.indexOf('okay') != -1) {
                                            var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p><?php echo \SKT_ADMIN_IMAGE_UpdateOK ?><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';
                                            tips.html(ROK);
                                            AppSKT.ReloadPage(document.URL);
                                        } else {
                                            var RKO = '<label><div class="ui-state-error ui-corner-all"><p><?php echo \SKT_ADMIN_IMAGE_UpdateError ?><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                                            tips.append(RKO);
                                        }
                                    }
                                });
                            }
                        });

                    },
                    Cancelar: function () {
                        AppSKT.skt_RemoveDialog();
                    }
                },
                close: function () {
                    AAppSKT.skt_RemoveDialog();
                }
            });
            AppSKT.skt_WrapDialog();

        });
        function CustomPropertyFile(File, name, w, h) {
            $('#dialog-form-Administrator input#CustomProperty').val(File);
            $('#dialog-form-Administrator input#FileNewFileX').val(w);
            $('#dialog-form-Administrator input#FileNewFileY').val(h);
            File.replace('////g', '');
            var SRC = name;
            jQuery.ajax({
                'type': 'POST',
                'url': SKTGoTo + admd2('/AdminFilesystem/TagForm'),
                'cache': false,
                'data': 'File=' + File,
                'success': function (data) {
                    $('#TagForm').html(data);
                }
            });
        }

    </script>


    <?php
    echo \SKT_ADMIN_AdminWraperClose;
}
?>