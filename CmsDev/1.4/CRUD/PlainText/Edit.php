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
if (\CmsDev\Security\loginIntent::action('validate', 'PlainText', 'Edit') === true) {
    $ID = $_POST['ID'];
    $content = $SKTDB->get_row("SELECT * FROM " . DB_PREFIX . "content WHERE ID = '$ID'");
    echo str_replace('[title]', \SKT_ADMIN_EditPlainText, \SKT_ADMIN_AdminWraperOpen);
    ?>
    <form action="" method="post" id="FormEditPlainText">
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
                        </label><br />
                        <textarea id="CreateContentEditor" name="editor" style="width: 100%; height: 280px;"><?php echo $content->Content ?></textarea>
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
                            echo \CmsDev\CRUD\Xtras\List_ThisOrAll_Page::ThisOrAll($content->IDPage);
                            ?>
                        </label>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_IDZoneContent ?>:</span>
                            <div id="ZoneNewContent"></div>  
                        </label>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_ZoneOrder ?>:</span>
                            <?php
                            echo \CmsDev\CRUD\Xtras\List_Position_Zone::set($content->Position, $content->IDPage, $content->IDZone);
                            ?>
                        </label>
                    </fieldset>
                    <?php echo \CmsDev\CRUD\Xtras\Radio_RecycleBin::OptionGroup($content->RecycleBin, 0); ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </form>
    <div id="CodeSnippetsResourse" style="display:none">
        <textarea id="CodeSnippets_YouTube"><iframe title="YouTube video player" width="100%" height="200" src="http://www.youtube.com/embed/tBU27wdkEZk?rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe></textarea>
        <textarea id="CodeSnippets_GoogleMap"><iframe width="100%" height="200" src="http://maps.google.es/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Enrique+Foster+Norte+118,+Santiago,+Chile&amp;aq=0&amp;sll=-34.908599,-56.205379&amp;sspn=0.005094,0.013078&amp;ie=UTF8&amp;hq=&amp;hnear=Enrique+Foster+Norte+118,+Las+Condes,+Santiago,+Chile&amp;ll=-33.413066,-70.595484&amp;spn=0.016478,0.031714&amp;t=p&amp;z=15&amp;iwloc=A&amp;output=embed" frameborder="0" allowfullscreen></iframe></textarea>
        <textarea id="CodeSnippets_Twitter">
                <script src="http://widgets.twimg.com/j/2/widget.js"></script>
                <script type="text/javascript">
                    /* REPLACE THE 'Twitter_User' */
                    var Twitter_User = 'daguerremartin';
                    /*-----------------------------*/
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
        <textarea id="CodeSnippets_Facebook"></textarea>
    </div>
    <script type="text/javascript">
        $("select#CodeSnippets").change(function () {
            var str = $("select#CodeSnippets option:selected").val();
            $("#CreateContentEditor").val($('#CodeSnippets_' + str).val());
        })
        var translations = [];
        translations['Ok'] = SKT_ADMIN_Btn_Acept;
        translations['Create'] = SKT_ADMIN_Btn_Create;
        translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
        translations['Delete'] = SKT_ADMIN_Btn_Delete;
        translations['Save'] = SKT_ADMIN_Btn_Save;
        translations['Edit'] = SKT_ADMIN_Btn_Edit;
        var IDContentProp = '<?php echo $content->ID; ?> ';
        $("#dialog").dialog("destroy");
        $("#dialog-form-Administrator").dialog({
            autoOpen: true,
            width: 990,
            maxWidth: 990,
            position: ['3%', 55],
            modal: true,
            buttons: [{
                    text: translations['Cancel'],
                    click: function () {
                        AppSKT.skt_RemoveDialog();
                    }
                }, {
                    text: translations['Edit'],
                    click: function () {
                        $.ajax({
                            'type': 'POST',
                            'url': URL_QueryUpdateContent,
                            'cache': false,
                            'data': $('form#FormEditPlainText').serialize(),
                            'success': function () {
                                document.location.reload();
                            }
                        });
                    }
                }],
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