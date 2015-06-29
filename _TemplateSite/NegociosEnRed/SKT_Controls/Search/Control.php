<?php
$randSub = rand(456, 132456789);
$SearchQuery = utf8_decode(isset($_GET['SearchQuery']) && $_GET['SearchQuery'] !== '' ? $_GET['SearchQuery'] : '');
?>
<form class="form-group" id="Submit<?php echo $randSub; ?>">
    <div class="row">
        <div class="col-xs-9 col-sm-8 col-md-9">
            <div class="search-area-division search-area-division-input">
                <input type="text" class="form-control search-query" id="search-term" value="<?php echo $SearchQuery; ?>" name="q" placeholder="Escribe tu b&uacute;squeda...">
                <select class="search-area-division-select form-control" name="search_area" id="search_area">
                    <option value="All">Todo</option>
                    <option value="Company">Empresa</option>
                    <option value="Service">Servicios</option>
                    <option value="Product">Producto</option>
                    <option value="Business">Oportunidades de negocios</option>
                </select>
            </div>
        </div>
        <div class="col-xs-3 col-sm-4 col-md-3">
            <button class="btn btn-block btn-white searchSubmit search-btn fontweb" type="submit"><?php echo \SKT_ADMIN_TXT_SearchSubmit; ?> Buscar</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    var URLSearch = '<?php echo \SKTURL; ?>Search/';
    var URLSearchQuery = '';
    var URLSearchType = 'All/';

    $("#Submit<?php echo $randSub; ?> #search_area").on('change', function () {
        URLSearchType = $(this).val() + '/';
    }).change();

    $('#Submit<?php echo $randSub; ?> .searchSubmit').on('click', function () {
        URLSearchQuery = $('#Submit<?php echo $randSub; ?> #search-term').val();
        if (URLSearchQuery == '') {
            alert('Escriba una palabra o palabras a buscar.');
        } else {
            document.location.href = '' + URLSearch + URLSearchType + URLSearchQuery + '/';
        }
    });
    $('#Submit<?php echo $randSub; ?>').submit(function () {
        return false;
        URLSearchQuery = $('#Submit<?php echo $randSub; ?> #search-term').val();
        if (URLSearchQuery == '') {
            alert('Escriba una palabra o palabras a buscar.');
        } else {
            document.location.href = '' + URLSearch + URLSearchType + URLSearchQuery + '/';
        }
    });
</script>