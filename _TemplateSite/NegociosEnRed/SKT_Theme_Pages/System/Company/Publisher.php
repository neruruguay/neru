<?php
//echo "<pre>";
//var_dump($_GET);
//echo "</pre>";
$productDesc = array(
    '1' => array('Productos', 'Productos'),
    '2' => array('Servicios', 'Servicios'),
    '3' => array('Maquinaria', 'Maquinaria Industrial'),
    '4' => array('MateriaPrima', 'Materias primas')
//    '5' => array('Cotizacion2', 'Solicitud de Cotización'),
//    '6' => array('Oportunidades', 'Ventana de Negocios'),
);

if ($_GET['n'] != '' && $_GET['n2'] != '') {
    require (dirname(__FILE__) . DS . 'PublisherStep1.php');
} else {

    if ($_GET['uValue']) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Query = "SELECT * FROM " . \DB_PREFIX . "categories WHERE category_idx = " . \GetSQLValueString($_GET['uValue'], "int") . " Order By category_position ASC, category_name ASC";
        $query_parent = $SKTDB->get_results($Query);
        ?>
        <div  class="row">
            <div class="mt30 col-md-12 col-xs-12">
                <h1 class="text-left text-color"><a href="javascript:history.back();" title="Volver"><i class="skt-icon-left-open"></i></a> Publicar <?php echo $productDesc[$_GET['uValue']][1]; ?></h1>
            </div>
        </div>
        <hr>
        <form method="get">
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                        <h4 class="text-color"><i class="skt-icon-list"></i> Categor&iacute;as</h4>
                        <select name="parent_cat" id="parent_cat" class="LargeSelectPublisher form-control" size="15">
                            <?php foreach ($query_parent as $items) { ?>
                                <option value="<?php echo $items->category_id; ?>"><?php echo $items->category_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                        <h4 class="text-color"><i class="skt-icon-list"></i> Sub Categor&iacute;as</h4>
                        <select name="sub_cat" id="sub_cat" class="LargeSelectPublisher form-control" size="15"></select>
                    </div>
                </div>
                <div class="col-md-4 col-xs-4">
                    <div class="form-group">
                        <div class="LargeSelectPublisherSuccess" style="display: none">
                            <i class="skt-icon-acept size-4-i text-color"></i>
                            <h1>Listo!</h1>
                            <button type="button" class="btn btn-mega btn-block color">Continuar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script type="text/javascript">
            $(document).ready(function () {
                var UrlSubCategories = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Categories/loadsubcat');
                $("#parent_cat").change(function () {

                    $("#sub_cat").html('<option class="skt-icon-config"> Cargando categorias...</option>');
                    jQuery.ajax({
                        'type': 'POST',
                        'url': UrlSubCategories,
                        'cache': false,
                        'data': 'parent_cat=' + $(this).val(),
                        'success': function (data) {
                            if (data === '') {
                                $(".LargeSelectPublisherSuccess").show();
                            } else {
                                $(".LargeSelectPublisherSuccess").hide();
                            }
                            $("#sub_cat").html(data);
                            $('#loader').slideUp(200, function () {
                                $(this).remove();
                            });
                        }
                    });


                });
                $("#sub_cat").change(function () {
                    $(".LargeSelectPublisherSuccess").show();
                });
                $(".LargeSelectPublisherSuccess button").click(function () {
                    document.location.href = "<?php echo TOTAL_REQUEST; ?>" + $("#parent_cat").val() + "/" + $("#sub_cat").val() + "/";
                });
            });
        </script>
        <?php
    } else {
        ?>
        <div class="gap"></div>
        <h1 class="text-left text-color">Elige qué quieres publicar</h1>
        <h3>Asegúrate de que tu publicación cumpla con las Políticas de <a href="#">Negocios en Red</a>.</h3>
        <div  class="row row-wrap">
            <?php for ($i = 1; $i <= count($productDesc); $i++) { ?>
                <div class="col-md-3 mt30 col-xs-4">
                    <a href="<?php echo TOTAL_REQUEST . $i . '/'; ?>" class="hover-img">
                        <div class="product-banner">
                            <img alt="<?php echo $productDesc[$i][1]; ?>" class="img-responsive" src="<?php echo SKTURL_TemplateSite; ?>assets/img/Grupos/<?php echo $productDesc[$i][0]; ?>.jpg" />
                            <div class="product-banner-inner gradient_black padding">
                                <h2 class="white"><?php echo $productDesc[$i][1]; ?></h2>
                            </div>
                        </div>
                    </a>
                </div> 
            <?php } ?>
        </div>
        <?php
    }
}
?>