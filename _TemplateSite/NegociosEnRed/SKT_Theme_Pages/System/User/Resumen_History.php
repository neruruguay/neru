<h2>Mis Publicaciones</h2>
<div class="row">
    <table class="table cart-table table-striped dataTableB3" id="tableProducts">
        <thead>
            <tr>
                <th>Item</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Activo</th>
                <th>Moneda</th>
                <th>Precio</th>
                <th>Volúmen</th>
                <th class="hidden">Borrar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $TemplateItem = '<tr class="[ClassExpired]">
                <td>
                    [ProductUID]
                </td>
                    <td class="cart-item-image">
                    <a href="[UrlDetail]">
                        [ProductImage]
                    </a>
                </td>
                <td><a href="[UrlDetail]"><b>[Title]</b></a>
                <td class="text-color">
                    <b>[TextExpired]</b>
                    <br>
                    <small>[InvertDate] / <b>[Invertexpiredate]</b></small>
                </td>
                </td>
                <td>[Currency]</td>                
                <td>[Price]</td>
                <td>[UnitOrAll]</td>
                <td class="cart-item-remove hidden">
                    <a class="fa fa-times" href="#"></a>
                </td>
            </tr>';
            $InstancsParams = array(
                'TemplateItem' => $TemplateItem,
                'ProductImageSize' => array('x' => '70', 'y' => '70'),
                'CatP' => '',
                'Cat' => '',
                'Query' => '',
                'ShowExpired' => 1,
                'IDUser' => $CCParams_Products_List['id'],
                //'ExcludeID' => $CCParams['Exclude'],
                'Limit' => 150
            );
            $List = new CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes();
            echo $List->GetList($InstancsParams);
            ?>
        </tbody>
    </table>
</div>
<div class="gap-small"></div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tableProducts').dataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            stateSave: true,
            "aoColumnDefs": [{
                    "aTargets": [4],
                    "sType": "currency",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        var $currencyCell = $(nTd);
                        var commaValue = $currencyCell.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        $currencyCell.text(commaValue);
                    }
                }]
        });
    });
</script>