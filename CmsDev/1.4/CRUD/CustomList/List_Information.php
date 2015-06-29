<?php

/**
 * Description of List_Information
 * 
 * /_Service_/p/Lists/GetArray/Inmuebles|ASC|datePost|5|null|0
 * 
 * /_Service_/d/Lists/getJSON/Inmuebles|ASC|datePost|5|null|0
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\CustomList;

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../../Core.php');
}

class List_Information {

    public static function getJSON($PD = 'p', $list = '', $listSort = 'DESC', $listOrder = 'Position', $listLimit = 500, $listQuery = '', $ID = '') {
        if ($PD === 'd') {
            self::debug($list, $listSort, $listOrder, $listLimit, $listQuery, $ID);
        } else {

            $SKTDB = \CmsDev\Sql\db_Skt::connect();
            $IDList = $SKTDB->get_var("SELECT ID FROM lists WHERE ListName = '$list'");
            if ($IDList != '') {
                //$Query_Lists_Values = $SKTDB->get_results("SELECT Value FROM lists_values WHERE IDList = " . GetSQLValueString($IDList, "int"));
                $Query_Lists_Values = $SKTDB->get_results("SELECT Value FROM lists_values WHERE IDList = " . GetSQLValueString($IDList, 'int') . " ORDER BY " . GetSQLValueString($listOrder, 'text') . " LIMIT " . GetSQLValueString($listLimit, 'int'));
                $data = '';
                if ($Query_Lists_Values) {
                    foreach ($Query_Lists_Values as $Values) {
                        $data.= $Values->Value . ',';
                    }
                }

                $datatrim = \trim($data, '"');
                $datartrim = \rtrim($datatrim, ',');
                \header('Content-type: text/json');
                \header('Content-type: application/json');
                echo '[' . utf8_decode($datartrim) . ']';
            }
        }
    }

    public static function GetTableHTML($PD = 'p', $list = '', $listSort = 'DESC', $listOrder = 'Position', $listLimit = 500, $ItemTemplate = '', $ID = '') {
        
    }

    public static function GetArray($PD = 'p', $list = '', $listSort = 'DESC', $listOrder = 'Position', $listLimit = 500, $listQuery = '', $ID = '') {
        if ($PD === 'd') {
            self::debug($list, $listSort, $listOrder, $listLimit, $listQuery, $ID);
        } else {
            $SKTDB = \CmsDev\Sql\db_Skt::connect();
            $IDList = $SKTDB->get_var("SELECT ID FROM lists WHERE ListName = '$list'");
            $Query_Lists_Values = $SKTDB->get_results("SELECT Value FROM lists_values WHERE IDList = " . GetSQLValueString($IDList, 'int') . " ORDER BY " . GetSQLValueString($listOrder, 'text') . " LIMIT " . GetSQLValueString($listLimit, 'int'));

            if ($Query_Lists_Values) {
                foreach ($Query_Lists_Values as $item) {
                    $obj = json_decode($item->Value);
                    echo $obj->{'Titulo'};
                }
            }
            $Query_Lists_ValuesA = $SKTDB->get_results("SELECT Value FROM lists_values WHERE IDList = " . GetSQLValueString($IDList, 'int') . " ORDER BY " . GetSQLValueString($listOrder, 'text') . " LIMIT " . GetSQLValueString($listLimit, 'int'), ARRAY_A);

            if ($Query_Lists_ValuesA) {
                return \var_dump($Query_Lists_ValuesA);
            }
        }
    }

    public static function GetObject($PD = 'p', $list = '', $listSort = 'DESC', $listOrder = 'Position', $listLimit = 500, $listQuery = '', $ID = '') {
        if ($PD === 'd') {
            self::debug($list, $listSort, $listOrder, $listLimit, $listQuery, $ID);
        } else {
            
        }
    }

    private static function debug($list = '', $listSort = 'DESC', $listOrder = 'Position', $listLimit = 500, $listQuery = '', $ID = '') {
        global $SKT;
        echo '<!DOCTYPE html><html lang="es"><head><meta charset="windows-1252">
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,800,600" rel="stylesheet" type="text/css">
            <link rel="stylesheet" type="text/css" media="all" href="/CmsDev/' . \SKT_VERSION . '/_css/styles.css" />
            <link rel="stylesheet" type="text/css" media="all" href="/CmsDev/' . \SKT_VERSION . '/_css/grid.css" />    
                <head><body class="skt"><div class="container_12"><div class="grid_4">';

        echo '<table class="table table-striped">
            <caption>Los parametros recibidos son:</caption>
            <thead>
                    <tr>
                        <th scope="col">Parametro</th>
                        <th scope="col">Valor</th>
                    </tr>
                </thead>
                <tbody>';
        echo '<tr class="even"><td>Lista</td><td>(' . $list . ')</td><tr>';
        echo '<tr class="odd"><td>Sort</td><td>(' . $listSort . ')</td><tr>';
        echo '<tr class="even"><td>Order</td><td>(' . $listOrder . ')</td><tr>';
        echo '<tr class="odd"><td>Limit</td><td>(' . $listLimit . ')</td><tr>';
        echo '<tr class="even"><td>Query</td><td>(' . $listQuery . ')</td><tr>';
        echo '<tr class="odd"><td>ID</td><td>(' . $ID . ')</td><tr>';
        echo '</tbody></table></div>';

        $SKTDB = \CmsDev\Sql\db_Skt::connect();

        $IDList = $SKTDB->get_var("SELECT ID FROM lists WHERE ListName = " . GetSQLValueString($IDList, 'int') . " ORDER BY " . GetSQLValueString($listOrder, 'text') . " LIMIT " . GetSQLValueString($listLimit, 'int'));

        if ($IDList) {

            $Query_Lists_Values_Count = $SKTDB->get_var("SELECT count(ID) FROM lists_values WHERE IDList = " . GetSQLValueString($IDList, 'int') . " ORDER BY " . GetSQLValueString($listOrder, 'text') . " LIMIT " . GetSQLValueString($listLimit, 'int'));

            $Query_Lists_Fields = $SKTDB->get_row("SELECT * FROM lists_fields WHERE IDLists = " . GetSQLValueString($IDList, 'int') . " ORDER BY " . GetSQLValueString($listOrder, 'text') . " LIMIT " . GetSQLValueString($listLimit, 'int'));

            echo '<div class="grid_8"><table class="table table-striped">
                    <caption>La Lista <b>"' . $list . '"</b> existe y se encontraron <b>' . $Query_Lists_Values_Count . '</b> elementos.<br>Contiene los siguientes campos:</caption>
                    <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                    </tr>
                </thead>
                <tbody>';
            if ($Query_Lists_Fields) {
                $even = true;
                foreach ($Query_Lists_Fields as $Values) {
                    if (strstr($Values, '|')) {
                        $Params = explode("|", $Values);
                        switch ($Params[0]) {
                            case 0: $Type = 'Int';
                                break;
                            case 1: $Type = 'Varchar';
                                break;
                            case 2: $Type = 'Text';
                                break;
                            case 3: $Type = 'Link';
                                break;
                            case 4: $Type = 'Enum';
                                break;
                            case 5: $Type = 'HTML';
                                break;
                            case 6: $Type = 'Date';
                                break;
                            case 7: $Type = 'Basic HTML';
                                break;
                            default :$Type = '';
                                break;
                        }
                        if ($even) {
                            $evenst = 'even';
                        } else {
                            $evenst = 'odd';
                        }
                        echo '<tr class="' . $evenst . '"><td>' . $Params[1] . '</td><td>(' . $Type . ')</td></tr>';
                        if ($even) {
                            $even = false;
                        } else {
                            $even = true;
                        }
                    }
                }
            }
            echo '</tbody></table></div></div></body></html>';
        } else {

            echo 'No se encuentra una Lista con el nombre <b>"' . $list . '"</b>.<br>';
        }
    }

    public static function GetHowUse($IDList = '') {
        global $SKT;

        echo '<div class="container_16" style="max-width: none; width: 100%;">';

        $SKTDB = \CmsDev\Sql\db_Skt::connect();

        $NameList = $SKTDB->get_var("SELECT ListName FROM lists WHERE ID = '$IDList'");

        if ($NameList) {

            $Query_Lists_Values_Count = $SKTDB->get_var("SELECT count(ID) FROM lists_values WHERE IDList = '$IDList'");

            $Query_Lists_Fields = $SKTDB->get_row("SELECT * FROM lists_fields WHERE IDLists = '$IDList'");

            echo '<div class="grid_4"><table class="table table-striped">
                    <caption>La Lista <b>"' . $NameList . '"</b> contiene <b>' . $Query_Lists_Values_Count . '</b> elementos ingresados con los siguientes campos:</caption>
                    <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                    </tr>
                </thead>
                <tbody>';
            $even = true;
            if ($Query_Lists_Fields) {
                foreach ($Query_Lists_Fields as $Values) {

                    if (strstr($Values, '|')) {
                        $Params = explode("|", $Values);
                        switch ($Params[0]) {
                            case 0: $Type = 'Int';
                                break;
                            case 1: $Type = 'Varchar';
                                break;
                            case 2: $Type = 'Text';
                                break;
                            case 3: $Type = 'Link';
                                break;
                            case 4: $Type = 'Enum';
                                break;
                            case 5: $Type = 'HTML';
                                break;
                            case 6: $Type = 'Date';
                                break;
                            case 7: $Type = 'Basic HTML';
                                break;
                            default :$Type = '';
                                break;
                        }
                        if ($even) {
                            $evenst = 'even';
                        } else {
                            $evenst = 'odd';
                        }
                        echo '<tr class="' . $evenst . '"><td>' . $Params[1] . '</td><td>(' . $Type . ')</td></tr>';
                        if ($even) {
                            $even = false;
                        } else {
                            $even = true;
                        }
                    }
                }
            }
            echo '<tr><td colspan="2" style=" font-size: 14px; color: #FF1263;">+ Campos Auto-generados</td></tr>';
            echo '<tr class="even"><td>ID</td><td>(int)</td></tr>';
            echo '<tr class="odd"><td>IDLists</td><td>(int)</td></tr>';
            echo '<tr class="even"><td>RecycleBin</td><td>(enum = \'0\',\'1\')</td></tr>';
            echo '<tr class="odd"><td>Position</td><td>(int)</td></tr>';
            echo '<tr class="odd"><td>datePost</td><td>(date) Patr&oacute;n: <b>' . date('Y-m-d') . '</b></td></tr>';
            echo '</tbody></table></div>';
            echo '<div class="grid_12">';

            echo '<h1 style="font-size: 14px; color: #FF1263; line-height: normal; margin: 0 0 10px;">Para obtener los resultados de esta lista cuenta con las siguientes opciones:</h1>';


            echo '<h2 style="font-size: 16px; color: #06A7EA; line-height: normal; margin: 0 0 10px;">Mediante Servicio Web:</h2>
                <h3 style="font-size: 14px; color: #06A7EA; line-height: normal; margin: 0 0 10px;">Template HTML (Ej.: List Servicios)</h3>';
            echo '<pre><code class="php">
                &lt;?php
                    $json = \'_Service_/p/Lists/getJSON/Servicios|ASC|ID|3|null|null\';
                    $data = file_get_contents($json);
                    $array = json_decode($data);
                ?&gt;

                    &lt;div class=&quot;container&quot;&gt;
                        &lt;div class=&quot;row&quot;&gt;
                            &lt;?php
                            foreach ($array as $obj) {
                                $Titulo = $obj-&gt;Titulo;
                                $Descripcion = $obj-&gt;Descripcion;
                                $icono = $obj-&gt;icono;
                                $Link = $obj-&gt;Link;
                                echo \'&lt;div class=&quot;col-md-4&quot;&gt;
                                        &lt;span class=&quot;fa-stack fa-4x&quot;&gt;
                                            \' . $icono . \'
                                        &lt;/span&gt;
                                        &lt;h4 class=&quot;service-heading&quot;&gt;\' . $Titulo . \'&lt;/h4&gt;
                                        &lt;p class=&quot;text-muted&quot;&gt;\' . $Descripcion . \'&lt;/p&gt;
                                        &lt;a href=&quot;\' . $Link . \'&quot;&gt;Ver m&amp;aacute;s+&lt;/a&gt;
                                    &lt;/div&gt;\';
                            }
                            ?&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;

                </code></pre>';

            $json = 'http://localhost:5665/_Service_/p/Lists/getJSON/Demo|ASC|ID|3|null|null';
            $data = file_get_contents($json);
            $array = json_decode($data);


            echo '<div class="container">
                        <div class="row">';

            foreach ($array as $obj) {
                $Titulo = $obj->Titulo;
                $Descripcion = $obj->Descripcion;
                $icono = $obj->icono;
                $Link = $obj->Link;
                echo '<div class="col-md-4">
                                        <span class="fa-stack fa-4x">
                                            ' . $icono . '
                                        </span>
                                        <h4 class="service-heading">' . $Titulo . '</h4>
                                        <p class="text-muted">' . $Descripcion . '</p>
                                        <a href="' . $Link . '">Ver m&aacute;s+</a>
                                    </div>';
            }

            echo '</div>
                    </div>';

            echo '<h2 style="font-size: 16px; color: #06A7EA; line-height: normal; margin: 0 0 10px;">Mediante JQuery (Cliente-Asincr&oacute;nico):</h2>
                <h3 style="font-size: 14px; color: #06A7EA; line-height: normal; margin: 0 0 10px;">Template HTML (Ej.: List Demo)</h3>';
            echo '<pre><code class="xml">
                &lt;!-- HTML del item --&gt;
                &lt;div id="DemoListTemplate" class="display-none"&gt;
                    &lt;div class="Demo"&gt;
                        &lt;div class="Imagen left"&gt;
                            &lt;a href="[URL]"&gt;
                                &lt;img src="[Imagen]" title=""/&gt;
                            &lt;/a&gt;
                        &lt;/div&gt;
                        &lt;div class="Contenido"&gt;
                            &lt;h3&gt;[Titulo]&lt;/h3&gt;
                            &lt;span&gt;[datePost] - ID: [ID]&lt;/span&gt;
                            &lt;p&gt;[Contenido]&lt;/p&gt;
                            &lt;a class="Email" href="mailto:[Email]" title="Contactenos"&gt;[Email]&lt;/a&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;!-- END: HTML del item --&gt;
                
                &lt;div id="DemoList"&gt;&lt;/div&gt;   &lt;!-- Contenedor #DemoList --&gt;
                </code></pre>';
            echo '<h3 style="font-size: 14px; color: #06A7EA; line-height: normal; margin: 0 0 10px;">Script de obtenci&oacute;n de datos</h3>';
            echo '<pre><code data-language="javascript">

    $.ajax({
        dataType: "json",
        /*
        La URL para servicios de listas est&aacute; formada por:
        /_Service_/[PRODUCTION or DEBUG (p,d)]/Lists/[METHOD]/[NAMELIST]|[SORT(ASC,DESC,null)]|[ORDER BY (FIELDNAME,null)]|[LIMIT(int,null)]|[QUERY(WHERE...,null)]|[ID(int,null)]
        */
        url: "/_Service_/p/Lists/getJSON/' . $NameList . '|ASC|datePost|2|null|null",
        cache: true
    }).done(function(data) {
        $.map(data, function(item, index) {
            /* Listamos los valores a reemplazar */
            var reps = {
                "[ID]": item.ID,
                "[IDLists]": item.IDLists,
                "[RecycleBin]": item.RecycleBin,
                "[Position]": item.Position,
                "[datePost]": item.datePost,
                "[Titulo]": item.Titulo,
                "[Contenido]": item.Contenido,
                "[Imagen]": item.Imagen,
                "[URL]": item.Url,
                "[Email]": item.Email
            };
            var itemhtml = $("#DemoListTemplate").html();

            for (var val in reps) {
                itemhtml = itemhtml.split(val).join(reps[val]);
            }
             /* Agregamos los Items al contenedor */
            $("#DemoList").append(itemhtml);

        });

    });

</code></pre>';
            echo '<h3 style="font-size: 14px; color: #06A7EA; line-height: normal; margin: 0 0 10px;">Resultado:</h3>';
            include('DemoList.php');
            echo '</div><div class="clear"></div>';
            echo '</div>';
        } else {

            echo 'No se encuentra una Lista con el nombre <b>"' . $NameList . '"</b>.<br>';
        }
    }

}

?>
