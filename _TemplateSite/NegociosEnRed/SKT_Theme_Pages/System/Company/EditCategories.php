<?php
$categories = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "categories WHERE category_idx = 7 Order By category_position ASC");
$Options1 = $Options2 = $Options3 = $Options4 = $Options5 = '<option value="">Seleccione una</option>';
foreach ($categories as $items) {
    $category1 = $category2 = $category3 = $category4 = $category5 = '';
    if ($User->category1 === $items->category_id) {
        $category1 = 'selected="selected"';
    }
    if ($User->category2 === $items->category_id) {
        $category2 = 'selected="selected"';
    }
    if ($User->category3 === $items->category_id) {
        $category3 = 'selected="selected"';
    }
    if ($User->category4 === $items->category_id) {
        $category4 = 'selected="selected"';
    }
    if ($User->category5 === $items->category_id) {
        $category5 = 'selected="selected"';
    }
    $Options1 .= '<option value="' . $items->category_id . '" ' . $category1 . '>' . $items->category_name . '</option>';
    $Options2 .= '<option value="' . $items->category_id . '" ' . $category2 . '>' . $items->category_name . '</option>';
    $Options3 .= '<option value="' . $items->category_id . '" ' . $category3 . '>' . $items->category_name . '</option>';
    $Options4 .= '<option value="' . $items->category_id . '" ' . $category4 . '>' . $items->category_name . '</option>';
    $Options5 .= '<option value="' . $items->category_id . '" ' . $category5 . '>' . $items->category_name . '</option>';
}
?>

<form method="POST" id="UpdateCategories<?php echo $User->id ?>">
    <div class="row" id="UpdateCategoriesArea">
        <h4 class="text-color skt-icon-tags">Círculos Empresariales en los que aparecer&aacute; su empresa</h4>
        <hr>
        <div class="col-md-6">
            <div class="form-group">
                <label>Categor&iacute;a 1</label>
                <select name="category1" id="category1" class="form-control">
                    <?php echo $Options1; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Categor&iacute;a 2</label>
                <select name="category2" id="category2" class="form-control">
                    <?php echo $Options2; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Categor&iacute;a 3</label>
                <select name="category3" id="category3" class="form-control">
                    <?php echo $Options3; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Categor&iacute;a 4</label>
                <select name="category4" id="category4" class="form-control">
                    <?php echo $Options4; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Categor&iacute;a 5</label>
                <select name="category5" id="category5" class="form-control">
                    <?php echo $Options5; ?>
                </select>
            </div>
        </div>
    </div>
</form>
<button type="button" onclick="UpdateCategories<?php echo $User->id ?>();" id="UpdateCategories" class="right btn btn-primary btn-lg float-right" ><i class="skt-icon-tags"></i> Guardar Categorías</button>
<script type="text/javascript">
    $(document).ready(function () {
        $('#UpdateCategoriesArea select').change(function () {
            SelectCircles($(this));
        });
    });
    function SelectCircles(Selector) {
        var SelOption = Selector.find('option:selected').val();
        //alert(SelOption);
        $("#UpdateCategoriesArea select").not(Selector).find('option').each(function () {
            var EachOption = $(this).val();
            if (EachOption == SelOption) {
                $(this).attr('disabled', 'disabled').removeAttr('selected').addClass('disabled hidden');
                //$(this).text($(this).text() + ' - d');
            } else {
                $(this).removeAttr('disabled').removeClass('disabled hidden');
            }
        })
    }
    function UpdateCategories<?php echo $User->id ?>() {
        var UrlUpdateCategories = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Users/UpdateData');
        var ID = '<?php echo $User->id; ?>';
        jQuery.ajax({
            'type': 'POST',
            'url': UrlUpdateCategories,
            'cache': false,
            'data': $('#UpdateCategories<?php echo $User->id ?>').serialize() + '&ID=' + ID,
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