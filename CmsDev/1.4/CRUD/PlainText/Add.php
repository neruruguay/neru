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
if (\CmsDev\Security\loginIntent::action('validate', 'PlainText','Add') === true) {
    echo str_replace('[title]', \SKT_ADMIN_EditPlainText, \SKT_ADMIN_AdminWraperOpen);
    ?>
    <form action="" method="post" id="FormCreateContent">
        <div class="skts_content">
            <div id="server_response_CreateContentHtml"></div>
            <div class="SKTrow row">
                <div class="col-md-8 first">
                    <fieldset>
                        <label>
                            <span>Recortes de c&oacute;digo, Ejemplos:</span>
                            <select name="CodeSnippets" id="CodeSnippets">
                                <option value="">Reemplazar&aacute; su c&oacute;digo!</option>
                                <option value="YouTube">Video de YouTube</option>
                                <option value="GoogleMap">Mapa de Google</option>
                                <option value="Twitter">Twitter</option>
                                <option value="Facebook">Facebook</option>
                            </select>
                        </label>
                        <textarea id="CreateContentEditor" name="CreateContentEditor" style="width: 100%; height: 280px;"><?php echo \SKT_ADMIN_PLAIN_DefaultEditorText; ?></textarea>
                    </fieldset>
                </div>
                <div class="col-md-4 last">
                    <fieldset>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_TitleContent ?></span>
                            <input name="Title" type="text" value="" />
                            <input name="Date" type="hidden" value="<?php echo date('Y-m-d') ?>" />
                            <input name="IDPage" readonly="readonly" type="hidden" value="<?php echo $_POST['IDPage'] ?>" />
                            <input name="Custom" readonly="readonly" type="hidden" value="" />
                            <input name="Type" type="hidden" value="script" />
                        </label>
                        <div class="clear"></div>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_View_AllPagesTitle ?>: </span>
                            <?php
                            echo \CmsDev\CRUD\Xtras\List_ThisOrAll_Page::ThisOrAll();
                            ?>
                        </label>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_IDZoneContent ?>:</span>
                            <div id="ZoneNewContent"></div>  
                        </label>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_ZoneOrder ?>:</span>
                            <?php
                            echo \CmsDev\CRUD\Xtras\List_Position_Zone::set(0, \SKT_SECTION_ID, 0);
                            ?>
                        </label>
                    </fieldset>
                    <?php echo \CmsDev\CRUD\Xtras\Radio_RecycleBin::OptionGroup(0, 0); ?>
                </div>
            </div>
        </div>
    </form>
    <div class="clear"></div>
    <div id="CodeSnippetsResourse" style="display:none">
        <textarea id="CodeSnippets_YouTube"><iframe title="YouTube video player" width="100%" height="200" src="http://www.youtube.com/embed/tBU27wdkEZk?rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe></textarea>
        <textarea id="CodeSnippets_GoogleMap"><iframe width="100%" height="200" src="http://maps.google.es/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Enrique+Foster+Norte+118,+Santiago,+Chile&amp;aq=0&amp;sll=-34.908599,-56.205379&amp;sspn=0.005094,0.013078&amp;ie=UTF8&amp;hq=&amp;hnear=Enrique+Foster+Norte+118,+Las+Condes,+Santiago,+Chile&amp;ll=-33.413066,-70.595484&amp;spn=0.016478,0.031714&amp;t=p&amp;z=15&amp;iwloc=A&amp;output=embed" frameborder="0" allowfullscreen></iframe></textarea>
        <textarea id="CodeSnippets_Twitter">
                <script src="http://widgets.twimg.com/j/2/widget.js"></script>
                    <script>
                        var Twitter_User = 'daguerremartin';
                        var oTweet = new TWTR.Widget({
                            version: 2,
                            type: 'profile',
                            rpp: 4,
                            interval: 10000,
                            width: '100%',
                            height: 250,
                            theme: {
                                shell: {
                                    background: '#333333',
                                    color: '#ffffff'
                                },
                                tweets: {
                                    background: '#ffffff',
                                    color: '#333333',
                                    links: '#885555'
                                }
                            },
                            features: {
                                scrollbar: false,
                                loop: true,
                                live: false,
                                hashtags: true,
                                timestamp: true,
                                avatars: true,
                                behavior: 'default'
                            }
                        });
                        jQuery(document).ready(function () {
                            oTweet.render().setUser(Twitter_User).start();
                        });
    </script>
        </textarea>
        <textarea id="CodeSnippets_Facebook">
                
        </textarea>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#ZoneNewContent").append($('#ListZoneColector').html());
            $("#ZoneNewContent select:eq(1)").remove();
            $(".validateTips").remove();
            $("select#CodeSnippets").change(function () {
                var str = $("select#CodeSnippets option:selected").val();
                $("#CreateContentEditor").val($('#CodeSnippets_' + str).val());
            })
        });

        $("#dialog").dialog("destroy");
        $("#dialog-form-Administrator").dialog({
            autoOpen: true,
            width: 990,
            maxWidth: 990,
            position: ['3%', 55],
            modal: true,
            buttons: {
                'Agregar el Contenido': function () {
                    var validating = '<label><div class="ui-state-highlight ui-corner-all"><p>' + SKT_ADMIN_Message_Validating + '<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-refresh"></span></p></div></label>';
                    $("#server_response_CreateContentHtml").html(validating);
                    jQuery.ajax({
                        'type': 'POST',
                        'url': 'SKTGoTo/' + admd2('/Query/CreateContent'),
                        'cache': false,
                        'data': $("#FormCreateContent").serialize(),
                        'success': function (data) {
                            if (data.indexOf('okay') != -1) {
                                var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p>' + SKT_ADMIN_Message_Update_OK + '<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';
                                $("#server_response_CreateContentHtml").html(ROK);
                                AppSKT.ReloadPage(document.URL);
                            } else {
                                var RKO = '<label><div class="ui-state-error ui-corner-all"><p>' + SKT_ADMIN_Message_Update_Error + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                                $("#server_response_CreateContentHtml").html(RKO);
                            }
                        }
                    });
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

    </script> 
    <?php
    echo \SKT_ADMIN_AdminWraperClose;
}
?> 
