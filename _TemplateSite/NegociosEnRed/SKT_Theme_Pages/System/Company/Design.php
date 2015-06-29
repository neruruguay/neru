<?php
$theme = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes;
$user_theme = $theme->GetUseTheme($User->id);
?>
<h2 class="mb20  mt30 text-color"><i class="skt-icon-image"></i> Cambiar el estilo y color de sus p&aacute;ginas <input type="button" onclick="UpdateTheme<?php echo $User->id; ?>();" class="btn btn-primary float-right" value="Guardar Cambios" /></h2>
<form id="UrlUpdateTheme<?php echo $User->id ?>">
    <input name="ColorTheme" id="switcher_ColorTheme" type="hidden" value="<?php echo $user_theme->ColorTheme; ?>" />
    <input name="WideBoxed" id="switcher_WideBoxed" type="hidden" value="<?php echo $user_theme->WideBoxed; ?>" />
    <input name="Pattern" id="switcher_Pattern" type="hidden" value="<?php echo $user_theme->Pattern; ?>" />
    <input name="Background" id="switcher_Background" type="hidden" value="<?php echo $user_theme->Background; ?>" />
    <input name="BackgroundCustom" id="switcher_BackgroundCustom" type="hidden" value="<?php echo $user_theme->BackgroundCustom; ?>" />
</form>
<?php $SKT_CC->Render('switcher', $user_theme); ?>
<div class="gap"></div>

<script type="text/javascript">
    $('#styleswitch_area .styleswitch').click(function () {
        $('#UserColorStylesheet').remove();
    });
    function UpdateTheme<?php echo $User->id; ?>() {
        var UrlUpdateTheme = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Users/UpdateTheme');
        var ID = '<?php echo $User->id; ?>';
        jQuery.ajax({
            'type': 'POST',
            'url': UrlUpdateTheme,
            'cache': false,
            'data': $('#UrlUpdateTheme<?php echo $User->id ?>').serialize() + '&ID=' + ID,
            'success': function (data) {
                $('#SKT_UpdateDataInfo').html(data).show();
                $('.mfp-close').trigger('click');
                setTimeout(function () {
                    $('#SKT_UpdateDataInfo').hide();
                    $('#SKT_UpdateDataInfo').html('');
                }, 3500);
            }
        });
    }

</script>