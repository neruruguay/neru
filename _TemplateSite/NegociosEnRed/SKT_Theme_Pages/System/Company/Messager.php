<h2 class=" mt30 mb20 text-color"><i class="skt-icon-icon-email"></i> Mensajes</h2>
<ul class="comments-list  ml30 mr30">
    <?php
    $Messager = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Messenger\_classes();
    $MessagerCountNum = $Messager->MessagerCount($User->id);
    if ($MessagerCountNum >= 1) {
        $query = $Messager->MessageRead($User->id);
        $BeforeChild = '<ul>';
        $AfterChild = '</ul>';
        $Counter = 1;
        $Owner = 'readTo';
        $TemplateMessageChild = '';
        $Avatar = '_FileSystems/anonimo.png';
        $TemplateItem = '<li [CheckRead] data-id="[id]">
                <div class="toggleMessage"></div>
                <article class="comment comment-line">
                    <div class="comment-author">
                        <img title="[NameFrom]" alt="[NameFrom]" src="[Avatar]" style="width: 35px;">
                    </div>
                    <div class="comment-inner">
                        <a href="javascript:RemoveFromList([id],\'[Owner]\');" class="comment-delete float-right" title="Borrar permanentemente" style="display:block;"> <i class="fa fa-trash-o"></i> </a>
                        <a href="javascript:SetReadUnread([id],\'\',\'[Owner]\');" class="comment-read float-right" title=" Marcar como no leído" style="display:block;"><i class="fa fa-archive"></i> Leído</a>
                        <span class="comment-author-name">
                            <b class="badge">[Counter]</b> <span>Iniciado por: </span><i class="fa fa-user"></i> [NameFrom] <a href="mailto:[EmailFrom]">[EmailFrom]</a>
                            <span>[Messageshort]</span>
                        </span>
                        <span class="comment-time float-right"><i class="fa fa-calendar"></i> [datePost]</span>
                    </div>
                </article>
                <article class="comment">
                    <div class="comment-author">
                        <img title="[NameFrom]" alt="[NameFrom]" src="[Avatar]" style="width: 80px;">
                    </div>
                    <div class="comment-inner">
                        <a href="javascript:RemoveFromList([id],\'[Owner]\');" class="comment-delete float-right" title="Borrar permanentemente" style="display:block;"> <i class="fa fa-trash-o"></i> </a>
                        <a href="javascript:SetReadUnread([id],\'1\',\'[Owner]\');" class="comment-read float-right" title="Archivar"><i class="fa fa-archive"></i> Marcar como leído</a>
                        <span class="comment-author-name">
                            <b class="badge">[Counter]</b> <i class="fa fa-user"></i> [NameFrom] <a href="mailto:[EmailFrom]">[EmailFrom]</a>
                        </span>
                        <p class="comment-content">[Message]</p>
                        <span class="comment-time"><i class="fa fa-calendar"></i> [datePost]</span>
                    </div>
                </article>
                    [MessageChild]
                <article class="comment SendComment">
                    <a href="javascript:void(0);" class="btn btn-primary float-right comment-reply"><i class="fa fa-reply"></i> Responder</a>
                    <div id="Messenger[id]" style="display:none;" class=" ml30 mt40 alert alert-info">
                    <form id="FormResponseComment[id]">
                        <h4>Continuar cadena</b></h4>
                        <input type="hidden" name="Parent" value="[Parent]" />
                        <input type="hidden" name="IDFrom" value="[IDFrom]" />
                        <input type="hidden" name="IDTo" value="[IDTo]" />
                        <input type="hidden" name="EmailFrom" value="[EmailFrom]" />
                        <input type="hidden" name="NameFrom" value="[NameFrom]" />
                        <input type="hidden" name="EmailTo" value="[EmailTo]" />
                        <input type="hidden" name="NameTo" value="[NameTo]" />
                        <div class="form-group">
                            <textarea placeholder="Escriba aqu&iacute; la respuesta..." class="form-control rezise-y" name="Message" id="MessageResponse"></textarea>
                        </div>
                        <input type="buttom" class="btn btn-primary" value="Enviar Mensaje" id="Comment[id]" onclick="sendmessage([id]);">
                        <hr>
                    </div>
                </article>
              </li>';
        $TemplateItemChild = '<li>
                        <article class="comment">
                            <div class="comment-author">
                                <img title="[NameFrom]" alt="[NameFrom]" src="[Avatar]" style="width: 80px;">
                            </div>
                            <div class="comment-inner">
                                <span class="comment-author-name">
                                    <i class="fa fa-user"></i> [NameFrom] <a href="mailto:[EmailFrom]">[EmailFrom]</a>
                                </span>
                                <p class="comment-content">[Message]</p>
                                <span class="comment-time"><i class="fa fa-calendar"></i> [datePost]</span>
                            </div>
                        </article>
                    </li>';
        foreach ($query as $itemId) {
            if ($itemId->Parent == '' || $itemId->Parent == NULL) {
                $user_Avatar = $SKTDB->get_var("SELECT ClientAuth_picture FROM userprofile WHERE IDX = " . GetSQLValueString($itemId->IDFrom, "int") . "");
                if ($user_Avatar) {
                    $Avatar = $user_Avatar;
                }

                if ($itemId->IDFrom === $User->id) {
                    $Owner = 'readFrom';
                } else {
                    $Owner = 'readTo';
                }

                if (($itemId->readFrom == '1' && $itemId->IDFrom == $User->id) || ($itemId->readTo == '1' && $itemId->IDTo == $User->id)) {
                    $CheckRead = $User->IDFrom;
                    $CheckReadSet = 'class="Message MessageRead Closed"';
                } else {
                    $CheckRead = $itemId->IDTo;
                    $CheckReadSet = 'class="Message MessageUnread Open"';
                }

                $find = array(
                    '[datePost]',
                    '[id]',
                    '[IDFrom]',
                    '[IDTo]',
                    '[NameFrom]',
                    '[EmailFrom]',
                    '[NameTo]',
                    '[EmailTo]',
                    '[Message]',
                    '[readFrom]',
                    '[readTo]',
                    '[Type]',
                    '[Parent]',
                    '[Avatar]',
                    '[CheckRead]',
                    '[Messageshort]',
                    '[Owner]'
                );
                $replace = array(
                    invertirFecha($itemId->datePost),
                    $itemId->id,
                    $itemId->IDFrom,
                    $itemId->IDTo,
                    $itemId->NameFrom,
                    $itemId->EmailFrom,
                    $itemId->NameTo,
                    $itemId->EmailTo,
                    $itemId->Message,
                    $itemId->readFrom,
                    $itemId->readTo,
                    $itemId->Type,
                    $itemId->Parent,
                    $Avatar,
                    $CheckReadSet,
                    cut_string($itemId->Message, 100),
                    $Owner
                );
                $Thisitem = str_replace($find, $replace, $TemplateItem);
                //echo $itemId->id;
                $queryChild = $Messager->MessageReadChild($itemId->id);
                //var_dump($queryChild);
                /* ---------------------------------------MessageReadChild------------------------------------------- */
                if ($queryChild) {
                    $TemplateMessageChild.=$BeforeChild;
                    foreach ($queryChild as $itemId2) {
                        $Counter++;
                        $user_Avatar = $SKTDB->get_var("SELECT ClientAuth_picture FROM userprofile WHERE IDX = " . GetSQLValueString($itemId2->IDFrom, "int") . "");
                        if ($user_Avatar) {
                            $Avatar = $user_Avatar;
                        }
                        $replace2 = array(
                            invertirFecha($itemId2->datePost),
                            $itemId2->id,
                            $itemId2->IDFrom,
                            $itemId2->IDTo,
                            $itemId2->NameFrom,
                            $itemId2->EmailFrom,
                            $itemId2->NameTo,
                            $itemId2->EmailTo,
                            $itemId2->Message,
                            $itemId2->readFrom,
                            $itemId2->readTo,
                            $itemId2->Type,
                            $itemId2->Parent,
                            $Avatar
                        );
                        $TemplateMessageChild.= str_replace($find, $replace2, $TemplateItemChild);
                    }
                    $queryChild = false;
                    $TemplateMessageChild.=$AfterChild;
                }
                $Thisitem = str_replace(array('[MessageChild]', '[Counter]'), array($TemplateMessageChild, $Counter), $Thisitem);
                $TemplateMessageChild = '';
                /* -----------[MessageChild]----------------------------MessageReadChild------------------------------------------- */

                echo $Thisitem;
                $Thisitem = '';
                $Counter = 1;
            }
        }
    }
    ?>
</ul>
<div class="gap"></div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.comment-read').click(function () {
            $(this).closest('li').removeClass('MessageUnread').toggleClass('MessageRead');
        });
        $('.SendComment .comment-reply').click(function () {
            $(this).next().toggle();
        });
        $('.toggleMessage').click(function () {
            $(this).closest('li').toggleClass('MessageRead').toggleClass('MessageUnread');
        });
    });
    function SetReadUnread(ID, Set, Owner) {
        var UrlSetReadUnread = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Messenger/SetReadUnread');
        var UserID = '<?php echo $User->id; ?>';
        jQuery.ajax({
            'type': 'POST',
            'url': UrlSetReadUnread,
            'cache': false,
            'data': 'UserID=' + UserID + '&ID=' + ID + '&Owner=' + Owner + '&Set=' + Set,
            'success': function (data) {
                $('#SKT_UpdateDataInfo').html(data).show();
                if (Set == '1') {
                    $(this).closest('li').removeClass('MessageUnread').addClass('MessageRead');
                } else {
                    $(this).closest('li').addClass('MessageUnread').removeClass('MessageRead');
                }
                setTimeout(function () {
                    $('#SKT_UpdateDataInfo').hide();
                    $('#SKT_UpdateDataInfo').html('');
                }, 3500);
            }
        });
    }
    function RemoveFromList(ID, Owner) {
        var UrlSetReadUnread = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Messenger/Delete');
        var UserID = '<?php echo $User->id; ?>';
        jQuery.ajax({
            'type': 'POST',
            'url': UrlSetReadUnread,
            'cache': false,
            'data': 'UserID=' + UserID + '&ID=' + ID + '&Owner=' + Owner + '&Set=Delete',
            'success': function (data) {
                $('#SKT_UpdateDataInfo').html(data).show();
                $('li[data-id="' + ID + '"]').remove();
            }
        });
    }

    function sendmessage(id) {
        var Urlsendmessage = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Messenger/_Response');
        var form = $('#FormResponseComment' + id);
        var error = false;
        var message = $('#MessageResponse', '#FormResponseComment' + id);
        if (message.val().length <= 15) {
            var error = true;
            alert('Escriba un mensaje con más de 15 caracteres...');
        }
        if (error == false) {
            jQuery.ajax({
                'type': 'POST',
                'url': Urlsendmessage,
                'cache': false,
                'data': form.serialize() + '&id=' + id,
                'success': function (data) {
                    if ($.trim(data) == 'ok') {
                        message.val('');
                        alert('Mensaje enviado!');
                    } else {
                        alert('Parece que tenemos un problema.<br>Intente nuevamente mas tarde.');
                    }
                }
            });
        }
    }

</script>