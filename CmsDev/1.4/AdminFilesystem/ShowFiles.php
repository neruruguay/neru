<?php
$glob = \CmsDev\util\globals::init();
$SKT = $glob->getVar('SKT');
if (\CmsDev\Security\loginIntent::action('validate') === true) {
    echo \CmsDev\Security\LoadHeader::loadOnFileSystem(FALSE);
    $FolderEncode = trim(\CmsDev\skt_Code::Encode(\LOCAL_FILESYSTEM), '%3D');
    $FolderDecode = \LOCAL_FILESYSTEM;
    $allowed2 = $SKT['allowedExtentions'];
    $Folder = '';
    $MAX_FILE_SIZE = 5120000;
    $LocalDirOrder = '';
    if (isset($_GET['Folder']) && $_GET['Folder'] !== '') {
        $FolderEncode = $_GET['Folder'];
        $FolderDecode = trim(\CmsDev\skt_Code::Decode($_GET['Folder']), '%3D');
    }
    $Folder = explode('_FileSystems', $FolderDecode);
    $Folder = $Folder[count($Folder) - 1];
    $find = array('\/', '\\/', '//', '\//', '\\', '//');
    $replace = array('/', '/', '/', '/', '/', '/');
    $Folder = str_replace($find, $replace, $Folder) . '/';
    ?>
    <style media="all" type="text/css">
        body {
            margin: 0 !important;
            min-width: 150px;
        }
    </style>
    <body class="skt" style="margin: 0 !important; padding-top:45px !important;">
        <div class="ActionCreateFileSystems">
            <ul>
                <li><a href="javascript:void(0);" id="MakeFolderShow"><i class="skt-icon-folder-add"></i><span>Nueva Carpeta</span></a></li>
                <li><a href="javascript:void(0);" id="UpDocumentShow"><i class="skt-icon-upload"></i><span>Cargar Archivo</span></a></li>
            </ul>
            <div class="ActionWidowFileSystems" style="float: right; position: fixed; right: 0px;">
                <div id="SliderSize"></div>
                <a href="javascript:history.back();"><i class="skt-icon-left-open"></i></a>
                <a href="javascript:location.reload();"><i class="skt-icon-folder"></i></a>
                <a href="javascript:history.go(1);"><i class="skt-icon-right-open"></i></a>
            </div>
            <div class="MakeFolderDiv">
                <form method="post" enctype="multipart/form-data" action="" name="MakeFolder_Form" id="MakeFolder_Form" class="row margin margin-v margin-h">
                    <input name="foldercontainer" type="hidden" value="">
                    <input name="NewFolderChecked" id="NewFolderChecked" type="hidden" value="">
                    <div class="col-md-6" style="margin: 30px;">
                        <div class="input-group">

                            <input class="form-control" placeholder="Escriba el nombre sin espacios ni caracteres especiales" name="NewFolder" id="NewFolder" type="text" maxlength="50" onKeyUp="javascript:CheckURLName(this.value, 'NewFolderChecked');" onBlur="javascript:CheckURLName($('#NewFolderChecked').val(), 'NewFolder');">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" name="NewFolderCreate" id="NewFolderCreate" onMouseOver="javascript:CheckURLName($('#NewFolderChecked').val(), 'NewFolder');"><i class="skt-icon-folder-add" style="margin: -11px 10px -8px 0px; vertical-align: middle; font-size: 25px ! important;"></i>Crear Carpeta</button>
                            </span>

                        </div>
                    </div>
                </form>
            </div>
            <div class="UpDocumentDiv">
                <div class="row" style="margin:30px 15px 15px 15px !important;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="cursor: pointer">
                                <h3 class="panel-title">Carga individual de imagenes y documentos. <b>(Recomendado)</b></h3>
                            </div>
                            <div class="panel-body">
                                <form method="post" enctype="multipart/form-data" action="" name="UpDocument_Form" id="UpDocument_Form" class="row margin margin-v margin-h">
                                    <h5 class="alert alert-warning">Carga Individual de archivos, aqu&iacute; podr&aacute; elegir el nombre del mismo asi como redimensionar imagenes acorde al uso que se le dar&aacute; mediante las medidas preestablecidas para el sistema.</h5>
                                    <br><br>
                                    <input name="foldercontainer" type="hidden" value="">
                                    <input name="NewDocumentChecked" id="NewDocumentChecked" type="hidden" value="" >
                                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo \SKT_ADMIN_MAX_FILE_SIZE ?>" />
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><span><?php echo \SKT_ADMIN_FileSystems_NewFile ?></span></label><br>
                                                <span class="btn btn-success fileinput-button" style="width: 100%; text-align: left;">
                                                    <i class="glyphicon glyphicon-plus"></i>
                                                    <span>Seleccione un archivo para cargar...</span>
                                                    <input name="userfile" type="file" onChange="javascript:CheckFileName(this.value, 'FileNewFileName');"/>
                                                </span>
                                            </div>
                                            <div class="col-md-6">
                                                <label><span><?php echo \SKT_ADMIN_FileSystems_NewFileName ?></span></label>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input name="FileNewFileName"  id="FileNewFileName"  type="text" value="" class="form-control text-right" style="width: 100%"/>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="ExtensionFile" value="" id="ExtensionFile" type="text" maxlength="4" class="form-control text-left"  style="text-align: left ! important; display: block; line-height: normal; float: left; padding: 0px; margin: 0px 0px 0px -16px; height: 31px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="filesizechange" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label> <span>Medidas predefinidas:</span></label><br>
                                                    <?php
                                                    echo select_field('imagesizeDim', 'imagesizeDim', $SKT['MEDIA']['SIZE']);
                                                    ?><i id="MoreOptionFileXY" title="Custom Size" class="skt-iconlist-add" style="font-size: 20px; vertical-align: middle;"></i>
                                                </div>
                                            </div>

                                            <div id="OptionFileXY" class="row">
                                                <div class="col-md-6">
                                                    <label> <span><?php echo \SKT_ADMIN_FileSystems_FileX ?></span></label><br>
                                                    <input name="FileNewFileX" id="FileNewFileX" type="text" value="" class="form-control"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <label> <span><?php echo \SKT_ADMIN_FileSystems_FileY ?></span></label> <br>
                                                    <input name="FileNewFileY" id="FileNewFileY" type="text" value="" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label> <span>&nbsp;</span></label><br>
                                                <button name="NewDocumentCreate" id="NewDocumentCreate" class="btn btn-success floatRight" type="submit" ><i class="skt-icon-upload" style="margin: -11px 10px -8px 0px; vertical-align: middle; font-size: 25px ! important;"></i><?php echo \SKT_ADMIN_FileSystems_NewFile ?></button>  
                                                <br><br><br><br><br>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="cursor: pointer">
                                <h3 class="panel-title">Carga r&aacute;pida de im&aacute;genes</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class=" alert alert-warning">Para la carga r&aacute;pida de im&aacute;genes tome en cueta que los nombres de los espacios ni archivos <b>NO contengan caracteres especiales antes de seleccionarlos</b>, ya que en caso contrario no podemos asegurarle el acceso a los mismos de forma correcta.<br> El m&aacute;ximo permitido para la carga es de <b>5 mb.</b><br>Los formatos permitidos son <b>JPG, GIF, PNG.</b> </h5>
                                        <br><br><br>
                                        <span class="btn btn-success fileinput-button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Carga r&aacute;pida de im&aacute;genes...</span>
                                            <!-- The file input field used as target for the file upload widget -->
                                            <input id="fileupload" type="file" name="files[]" multiple>
                                        </span>
                                        <br>
                                        <br>
                                        <!-- The global progress bar -->
                                        <div id="progress" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <!-- The container for the uploaded files -->
                                        <div id="files" class="files"></div>
                                        <br>
                                    </div>
                                </div>
                                <a class="floatRight" href="javascript:location.reload();">Refrescar la p�gina cuando est� lista la carga <i class="skt-icon-link"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="TitleFolder breadcrumb">
            Est�s en: <?php echo \CmsDev\AdminFilesystem\Breadcrumb::Render($FolderEncode); ?>
        </h3>
        <br>
        <div class="row" style="margin:15px 0 !important;">
            <div class="col-md-6 col-md-offset-3 text-center margin-b">
                <?php
                if (isset($_FILES['userfile']['name']) && $_FILES['userfile']['name'] != '') {
                    require 'UploadFile.php';
                }
                ?>
            </div>
        </div>
        <?php
        echo \CmsDev\AdminFilesystem\List_Files::Directory($FolderDecode, "javascript:window.parent.SKTFSys.CustomPropertyFile('[this]','[name]','[w]','[h]');", $SKT['allowedExtentions']);
        ?>  
        <div style="display:none;">
            <div id="dialog-confirm-file-delete" title="Borrar archivo?">
                <p> <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span> <span id="text-dialog-confirm"> <?php echo \SKT_ADMIN_Message_Confirm_Delete_Text; ?> </span> </p>
            </div>
            <div id="dialog-confirm-folder-delete" title="Borrar Carpeta?">
                <p> <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span> <span id="text-dialog-confirm"> <?php echo \SKT_ADMIN_Message_Confirm_Delete_Text; ?> </span> </p>
            </div>
            <div id="dialog-confirm-folder-rename" title="Renombrar Carpeta">
                <label> <span>Cambiar nombre<br>
                    </span>
                    <input type="text"  value="" id="NewfolderName" name="NewfolderName"  onblur="javascript:CheckURLName(this.value, 'NewfolderName');"  maxlength="50" style="width: 98%; font-size: 1.3em;">
                </label>
                <div class="block col-md-12" id="info-folder-rename"></div>
            </div>
            <div id="dialog-confirm-file-rename" title="Renombrar archivo">
                <label> <span>Cambiar nombre<br>
                    </span>
                    <input type="text"  value="" id="NewFileReName" name="NewFileReName"  onblur="javascript:CheckURLName(this.value, 'NewFileReName');"  maxlength="150" style="width: 98%; font-size: 1.3em;">
                    <span style="float: right;" id="NewFileReNameEXT"></span>
                </label>
                <div class="block col-md-12" id="info-file-rename"></div>
            </div>
            <div id="PopUpEditorTags" title="Editando">
                <div class="containerPopUpTags">
                    <form action="" method="post" id="containerPopUpTags">
                    </form>
                </div>
            </div>
        </div>
        <div class="block col-md-12" id="infoOrder"></div>

    </body>
    <script type="text/javascript">
        var GET_Folder = '<?php echo $FolderEncode; ?>';

        function CustomPropertyFile(dir, name, w, h) {
            $('#FolderSystemBreadcrumb #NameFileSelected').text(name);
            if (parent.frames.length > 0) {
                parent.frames.SKTFSys.CustomPropertyFile(dir, name, w, h);
            }
        }
        function CheckFileName(field1, field2) {
            $.post(SKTGoTo + 'Q2hlY2tGaWxlTmFtZQ', {Title: field1, rand: Math.random()}, function (data) {
                var dataf = data.split('|');
                var name = dataf[0];
                var ext = dataf[1];
                $('#' + field2).val(name);
                $('#ExtensionFile').val(ext);
                if (ext === 'jpg' || ext === 'gif' || ext === 'png') {
                    $('.filesizechange').show();
                } else {
                    $('.filesizechange').hide();
                    $('.filesizechange input:text').val('');
                }
            });
        }
        function CheckURLName(field1, field2) {
            $.post(SKTGoTo + 'Q2hlY2tVUkxOYW1l', {Title: field1, rand: Math.random()}, function (data) {
                $('#' + field2).val(data);
            });
        }
        function NewFolderCreate() {
            $.post(SKTGoTo + admd2('/AdminFilesystem/FileSystems_mkdir'), {MakeFolder: GET_Folder + '/' + $('#NewFolderChecked').val()}, function (data) {
                if ($.trim(data) === "Yes") {
                    alert('La carpeta "' + $('#NewFolderChecked').val() + '" se creo correctamente.');
                    location.reload();
                } else {
                    alert('No se pudo crear la carpeta "' + $('#NewFolderChecked').val() + '" compruebe el nombre, que no exista ya y vuelva a intentarlo.');
                }
            });
        }
        function FolderRename(Oldfolder, Newfolder) {
            jQuery.ajax({
                'type': 'POST',
                'url': SKTGoTo + admd2('/AdminFilesystem/Folder_Rename'),
                'cache': false,
                'data': 'folder=' + $.trim(Oldfolder) + '&folderN=' + $.trim(Newfolder),
                'success': function (data) {
                    var info = data;
                    if ($.trim(data) === "Yes") {
                        info += 'La carpeta fue renombrada correctamente.';
                        //setTimeout("location.reload();",1000);
                    } else {
                        info += 'No se pudo Renombrar la carpeta "' + Oldfolder + '" compruebe el nombre, que no exista ya y vuelva a intentarlo.';
                    }
                    $('#info-folder-rename').html('<p>' + info + '</p>');
                }
            });
        }
        function fileRename(OldFile, NewFile, NameEXT) {
            /*alert(OldFile);
             alert(NewFile);
             alert(NameEXT);*/
            jQuery.ajax({
                'type': 'POST',
                'url': SKTGoTo + admd2('/AdminFilesystem/File_Rename'),
                'cache': false,
                'data': 'File=' + $.trim(OldFile).replace(/''/g, "%3D") + '&FileN=' + $.trim(NewFile).replace(/''/g, "%3D") + '&NameEXT=' + $.trim(NameEXT).replace(/''/g, "%3D"),
                'success': function (data) {
                    var info = '';
                    if ($.trim(data) === "Yes") {
                        info += 'El archivo fue renombrado correctamente.';
                        setTimeout("location.reload();", 1000);
                    } else {
                        info += 'No se pudo Renombrar el archivo "' + OldFile + '" compruebe el nombre, que no exista ya y vuelva a intentarlo.';
                    }
                    $('#info-file-rename').html('<p>' + info + '</p>');
                }
            });
        }

        $(document).ready(function () {
            $("#imagesizeDim").change(function () {
                var W = '';
                var H = '';
                var str = $("#imagesizeDim option:selected").val();
                var sizeExist = str.indexOf('_');
                if (sizeExist !== -1) {
                    var strsize = str.split('_');
                    var W = strsize[0];
                    var H = strsize[1];
                } else if (str === 'null') {
                    var W = '';
                    var H = '';
                }
                $('#FileNewFileX').val(W);
                $('#FileNewFileY').val(H);
            });
            $('.UpDocumentDiv .panel-body').hide();
            $('.UpDocumentDiv .panel-heading').each(function () {
                $(this).click(function () {
                    $(this).next().toggle();
                });
            });

            $('#MakeFolderShow').click(function () {
                $(".UpDocumentDiv").hide();
                $(".MakeFolderDiv").toggle();
                $('#MakeFolderShow').addClass('active');
                $('#UpDocumentShow').removeClass('active');
            });
            $("#UpDocumentShow").click(function () {
                $(".UpDocumentDiv").toggle();
                $(".MakeFolderDiv").hide();
                $('#UpDocumentShow').addClass('active');
                $('#MakeFolderShow').removeClass('active');
            });

            $('#NewFolderCreate').click(function () {
                NewFolderCreate();
            });
            $("#MakeFolder_Form").submit(function () {
                NewFolderCreate();
            });
            $('a[rel^=prettyPhoto]').prettyPhoto({animation_speed: 'normal', theme: 'facebook', slideshow: 3000, autoplay_slideshow: false, social_tools: false});
            $('#LOADING', window.parent.document).hide();
            $('#DisplayCreateFolder .ui-dialog-titlebar-close, #DisplayUploadFile .ui-dialog-titlebar-close').click(function () {
                $(this).parent().hide();
            });
            $('#BtnCreateFolder').click(function () {
                $('#DisplayCreateFolder').toggle();
            });
            $('#MoreOptionFileXY').click(function () {
                $('#OptionFileXY').toggle();
            });
            $('#BtnUploadFile').click(function () {
                $('#DisplayUploadFile').toggle();
            });
            $(".PopUp_System").sortable({
                handle: '.skt-icon-move',
                placeholder: "ui-state-highlight",
                items: 'li.fileItem',
                cursor: 'move',
                update: function () {
                    var order = $('.PopUp_System').sortable('serialize');
                    jQuery.ajax({
                        'type': 'POST',
                        'url': SKTGoTo + admd2('/AdminFilesystem/UpdateFileOrder'),
                        'cache': false,
                        'data': 'Dir=' + GET_Folder + '&' + order,
                        'success': function (e) {
                            $('#infoOrder').html('<p>' + e + '</p>');
                            var i = 0;
                            $('.ui-sortable li .tip .FileOrder').each(function (i) {

                                $(this).html(i);
                                i++;
                            });
                        }
                    });
                }

            }).disableSelection().sortable("refreshPositions");

            $('.RenameFolder').click(function () {
                var ParentFolderName = GET_Folder;
                var OldfolderName = $(this).find('.folder-rename').attr('rel');
                var NameOnly = OldfolderName.replace(ParentFolderName, '').replace('/', '');
                $('input#NewfolderName').val($.trim((SKTDecode(NameOnly))).replace('/', ''));
                $("#dialog-confirm-folder-rename").dialog({
                    resizable: false,
                    height: 'auto',
                    width: 400,
                    modal: true,
                    buttons: {
                        "Rename": function () {
                            var NewfolderName = ParentFolderName + SKTEncode('/' + $('input#NewfolderName').val());
                            alert(OldfolderName);
                            alert(NewfolderName);
                            if (NewfolderName !== OldfolderName && NewfolderName !== '') {
                                FolderRename(OldfolderName, NewfolderName);
                            } else {
                                alert('El nombre no ha cambiado');
                            }
                        },
                        Close: function () {
                            $("#dialog-confirm-folder-rename").dialog("close");
                        }
                    }

                });
            });
            /***********************************************************************/

            $('.RenameFile').click(function () {
                var ParentFolderName = GET_Folder;
                var OldfileName = admd($(this).find('.Rename-file').attr('rel'));
                var NameOnly = $.trim((OldfileName.substring(OldfileName.lastIndexOf("\/"))).toLowerCase()).replace("\/", "");
                var NameEXT = (NameOnly.substring(NameOnly.lastIndexOf("."))).toLowerCase();
                NameOnly = NameOnly.replace(NameEXT, '');
                $('#NewFileReNameEXT').text(NameEXT);
                $('input#NewFileReName').val(NameOnly);
                $("#dialog-confirm-file-rename").dialog({
                    resizable: false,
                    height: 'auto',
                    width: 400,
                    modal: true,
                    buttons: {
                        "Rename": function () {
                            var NewFileName = $('input#NewFileReName').val();
                            NewFileName = SKTDecode(ParentFolderName) + '/' + NewFileName;
                            if (NewFileName !== OldfileName && NewFileName !== '' && NewFileName !== ParentFolderName) {
                                /*alert(ParentFolderName);
                                 alert(OldfolderName);
                                 alert(NewfolderName);*/
                                fileRename(SKTEncode(OldfileName), SKTEncode(NewFileName), NameEXT);
                                //location.reload();
                            }
                        },
                        Close: function () {
                            $("#dialog-confirm-file-rename").dialog("close");
                            //location.reload();
                        }

                    }

                });
            });

            /***********************************************************************/

            $('.folder-delete').click(function () {

                var folder = $(this).attr('rel');
                var li = $(this).parents('li');
                $("#dialog-confirm-folder-delete").dialog({
                    resizable: false,
                    height: 'auto',
                    width: 400,
                    modal: true,
                    buttons: {
                        "Delete": function () {
                            jQuery.ajax({
                                'type': 'POST',
                                'url': SKTGoTo + admd2('/AdminFilesystem/Folder_Delete'),
                                'cache': false,
                                'data': 'folder=' + folder,
                                'success': function (htmlReturn) {
                                    $("#dialog-confirm-folder-delete #text-dialog-confirm").html(htmlReturn);
                                    $("#dialog-confirm-folder-delete").next('.ui-dialog-buttonpane').hide();
                                    li.remove();
                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);
                                }
                            });
                        },
                        Cancel: function () {
                            $("#dialog-confirm-folder-delete").dialog("close");
                        }

                    }

                });
            });
            /***********************************************************************/



            $('.OptionsNav .Delete').click(function () {
                var file = $(this).find('.file-delete').attr('rel');
                var li = $(this).parents('li');
                $("#dialog-confirm-file-delete").dialog({
                    resizable: false,
                    height: 'auto',
                    modal: true,
                    buttons: {
                        "<?php echo \SKT_ADMIN_Btn_Delete ?>": function () {
                            jQuery.ajax({
                                'type': 'POST',
                                'url': SKTGoTo + admd2('/AdminFilesystem/File_Delete'),
                                'cache': false,
                                'data': 'file=' + file,
                                'success': function (htmlReturn) {
                                    if ($.trim(htmlReturn) === "ok") {
                                        $("#dialog-confirm-file-delete").dialog("close");
                                        li.remove();
                                        setTimeout(function () {
                                            location.reload();
                                        }, 500);
                                    }
                                }
                            });
                        },
                        Cancel: function () {
                            $("#dialog-confirm-file-delete").dialog("close");
                        }
                    }
                });
            });
            /***********************************************************************/


            $("#PopUpEditorTags").dialog({
                autoOpen: false,
                height: 'auto',
                width: 500,
                modal: true,
                buttons: {
                    "Guardar": function () {
                        jQuery.ajax({
                            'type': 'POST',
                            'url': SKTGoTo + admd2('/AdminFilesystem/File_SaveTags'),
                            'cache': false,
                            'data': $("form", "#PopUpEditorTags").serialize(),
                            'success': function (html) {
                                $("#server_response_FolderSystem").html(html);
                                var fileRel = $('#File', "#PopUpEditorTags").attr('value');
                                $('.file-tags[rel="' + fileRel + '"]').next('span.file-title').text($('#Title', "#PopUpEditorTags").attr('value'));
                                $("#dialog:ui-dialog").dialog("destroy");
                                $("#dialog:ui-dialog").dialog("close");
                            }
                        });
                        $(this).dialog("close");
                        return false;
                    },
                    "Cerrar": function () {
                        $(this).dialog("close");
                    }

                }

            });
            $('.file-tags').click(function () {
                var File = $(this).attr('rel');
                jQuery.ajax({
                    'type': 'POST',
                    'url': SKTGoTo + admd2('/AdminFilesystem/TagForm'),
                    'cache': false,
                    'data': 'File=' + File,
                    'success': function (data) {
                        $('#PopUpEditorTags #containerPopUpTags').html(data);
                        $("#PopUpEditorTags").dialog("open");
                    }

                });
            });

        });

        // Change this to the location of your server-side upload handler:
        var url = SKTServerURL + '_FileSystems/UploadHandler.php?Folder=<?php echo $Folder ?>',
                uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Procesando...')
                .on('click', function () {
                    var $this = $(this),
                            data = $this.data();
                    $this
                            .off('click')
                            .text('Abortar')
                            .on('click', function () {
                                $this.remove();
                                data.abort();
                            });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });
        $('#fileupload').fileupload({
            url: SKTServerURL + '_FileSystems/UploadHandler.php?Folder=<?php echo $Folder ?>',
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000, // 5 MB
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: false
        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
            if (file.preview) {
                node
                        .prepend('<br>')
                        .prepend(file.preview);
            }
            if (file.error) {
                node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');





        function refreshSize() {
            var size = $("#SliderSize").slider("value");
            $(".PopUp_System").css("font-size", size);
            $.cookie('SetSize', size, {expires: 7, path: '/'});
        }
        $(function () {
            $("#SliderSize").slider({
                orientation: "horizontal",
                range: "min",
                min: 10,
                max: 30,
                //slide: refreshSize,
                change: refreshSize
            });
            var InitialSize = 15;
            var SetSize = $.cookie('SetSize');
            if (SetSize === undefined || SetSize === 'undefined') {
                SetSize = InitialSize;
                $.cookie('SetSize', InitialSize, {expires: 7, path: '/'});
            }
            $("#SliderSize").slider("value", SetSize);
        });

    </script>
<?php } ?>