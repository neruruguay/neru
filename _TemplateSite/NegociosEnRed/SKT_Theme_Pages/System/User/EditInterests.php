<?php
$categories = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "categories WHERE category_idx = '40' ORDER BY category_name ASC");
$Options = '';
foreach ($categories as $items) {
    if ($User->category === $items->category_id) {
        $category = 'selected="selected"';
    }
    $Options .= '<tr><td><label><input type="checkbox" name="Interests" value="' . $items->category_id . '" ' . $category . '>' . $items->category_name . '</label></td></tr>';
}
?>

<form method="POST" id="UpdateInterests<?php echo $User->id ?>">
    <div class="row" id="UpdateInterestsArea">
        <h4 class="text-color skt-icon-lightbulb">Seleccione hasta 5 temas de interés para su empresa</h4>
        <hr>
        <div class="form-group">
            <table id="Interests" class="table table-bordered table-condensed table-striped">
                <tbody>
                    <?php echo $Options; ?>
                </tbody>
            </table>

        </div>
    </div>
</form>
<button type="button" onclick="UpdateInterests<?php echo $User->id ?>();" id="UpdateInterests" class="right btn btn-primary btn-lg float-right" ><i class="skt-icon-lightbulb"></i> Guardar temas de Interés</button>
<script type="text/javascript">

    function UpdateInterests<?php echo $User->id ?>() {
        var UrlUpdateInterests = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Users/Interests');
        var ID = '<?php echo $User->id; ?>';
        jQuery.ajax({
            'type': 'POST',
            'url': UrlUpdateInterests,
            'cache': false,
            'data': $('#UpdateInterests<?php echo $User->id ?>').serialize() + '&ID=' + ID,
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
    jQuery(function ($) {
        $('#Interests').checkboxes('max', 5);
    });

    /*
     var config = {
     '.chosen-select': {},
     '.chosen-select-no-single': {no_results_text: '', max_selected_options: 5, disable_search_threshold: 5, width: "100%", height: "50px"},
     }
     for (var selector in config) {
     $(selector).chosen(config[selector]);
     }
     */

</script>