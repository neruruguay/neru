<?php 
var_dump($_GET);
$searchtxt = str_replace('+', ' ', REQUEST_URI('N', 'q')); 
$searchtxt = $_GET['q'];
?>

<h4><i class="skt-icon-search"></i> Resultados de b&uacute;squeda de: <b><?php echo $searchtxt; ?></b></h4>
<div id="ResultSearch">   
<script>
  (function() {
    var cx = '007283243822476871912:rqrlsz8k5sa';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:searchresults-only></gcse:searchresults-only>
</div>
<?php
$SKTDB = \CmsDev\Sql\db_Skt::connect();
$Resultssections = $SKTDB->get_results("SELECT * FROM " . DB_PREFIX . "sections AS sections WHERE 



	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.Language = '" .\SKT_ThisLaguage."'  AND sections.Title like '%$searchtxt%')

	OR 

	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.Language = '" .\SKT_ThisLaguage."'  AND sections.Description like '%$searchtxt%' )

	OR 

	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.Language = '" .\SKT_ThisLaguage."'  AND sections.URLName like '%$searchtxt%' )

	OR 

	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.Language = '" .\SKT_ThisLaguage."'  AND sections.MetaDataTitle like '%$searchtxt%' )

	OR 

	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.Language = '" .\SKT_ThisLaguage."'  AND sections.MetaDataDescription like '%$searchtxt%' )

	OR 

	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.Language = '" .\SKT_ThisLaguage."'  AND sections.MetaDataKeywords like '%$searchtxt%' )

	

");

$Resultsproducts = $SKTDB->get_results("SELECT products.*,sections.* FROM " . DB_PREFIX . "products AS products," . DB_PREFIX . "sections AS sections  WHERE 

	( products.ProductDescriptionHTML like '%$searchtxt%' AND products.ProductID = sections.PID )

	OR 

	( sections.URLName like '%$searchtxt%' AND products.ProductID = sections.PID )
	
	OR 

	( sections.SectionImage like '%$searchtxt%' AND products.ProductID = sections.PID )
	
	OR 

	( products.Reference1 like '%$searchtxt%' AND products.ProductID = sections.PID )
	
	OR 
	
	( products.Reference1 like '%$searchtxt%' AND products.ProductID = sections.PID )
	
	OR 

	( products.Reference2 like '%$searchtxt%' AND products.ProductID = sections.PID )
	
	OR 

	( products.Reference3 like '%$searchtxt%' AND products.ProductID = sections.PID )
	
	OR 

	( products.Reference4 like '%$searchtxt%' AND products.ProductID = sections.PID )
	
	OR 

	( products.Reference5 like '%$searchtxt%' AND products.ProductID = sections.PID )

	

");

$Resultscontent = $SKTDB->get_results("SELECT content.*,sections.ID, sections.URLName FROM " . DB_PREFIX . "content AS content," . DB_PREFIX . "sections AS sections WHERE 

	( content.RecycleBin = '0' AND content.Content like '%$searchtxt%'  AND content.IDPage = sections.ID )

	OR 

	( content.RecycleBin = '0' AND content.Description like '%$searchtxt%' AND content.IDPage = sections.ID )

");



/* ------------------------------------------------------ */

$PrefixURL = \SKTURL;

/* ------------------------------------------------------ */
?>
<style type="text/css">


    #SearchResults {
        list-style: none outside none;
        margin: 0 2% 2%;
        width: 96%;
    }

    #SearchResults li {

        background: none repeat scroll 0 0 transparent;

        border: 1px solid white;

        list-style: none outside none;

        margin: 0 0 5px;

        padding: 0;

        position: relative;

        box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.50);

        -moz-box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.50);

        -webkit-box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.50);

    }

    #SearchResults li.even { background: none repeat scroll 0 0 #FDFDFD; }

    #SearchResults li.odd { background: none repeat scroll 0 0 #F9F9F9; }

    #SearchResults li a { display: block; padding: 4px; font-size:12px; color:#1898D5; font-weight:bold; }


    #SearchResults li img {
        display: inline;
        vertical-align: middle;
        width: 100px;
    }

    #SearchResults li.title { padding: 10px; }

    #SearchResults li.title h4 {

        font-weight: bold;

        padding: 0; margin: 0;

    }
    .gs-no-results-result, #cse iframe{display:none !important;}
    #SearchResults li span {

        display: inline-block;

        font-size: 10px;

        font-style: normal;

        line-height: 11px;

        padding: 4px 0 4px 4px;

        color:#000;

    }

    #SearchResults a:hover { background-color:#1898D5; text-decoration:none; color:#FFF; }

    #SearchResults a:hover span{ color:#FFF; }


    .page_navigation {
        display: table;
        float: none;
        margin: 15px auto;
        text-align: center;
    }
    .page_navigation a, .alt_page_navigation a{
        padding:3px 5px;
        margin:2px;
        color:white;
        text-decoration:none;
        float: left;
        font-family: Tahoma;
        font-size: 12px;
        background-color:#1898D5;
    } 
</style>
<script type="text/javascript">

        $(document).ready(function() {



            $("#SearchResults li:odd").addClass('odd');

            $("#SearchResults li:even").addClass('even');



            $('#paging').pajinate({
                items_per_page: 12,
                item_container_id: '#SearchResults',
                nav_panel_id: '.page_navigation',
                nav_label_first: '<<',
                nav_label_last: '>>',
                nav_label_prev: '<',
                nav_label_next: '>',
                abort_on_small_lists: true

            });



        });

</script>
<div id="paging">
    <div id="info"></div>
    <ul id="SearchResults">
        <?php
        if (!$Resultssections && !$Resultsproducts && !$Resultscontent) { //echo 'No se encontraron coincidencias para "'.$searchtxt.'"...'; 
        }
        if ($Resultssections) {

            echo '<li><h4>Secciones</h4></li>';

            foreach ($Resultssections as $ResultItem) {

                if ($ResultItem->SectionType == 1) {

                    echo '<li id="listItem_' . $ResultItem->ID . '" class="ui-corner-all">

			<a href="' . \SKTURL . $ResultItem->URLName . '" class="ui-corner-all" style="vertical-align:middle;">
				<img src="_FileSystems/images/' . $ResultItem->SectionImage . '" alt="" style="vertical-align:middle;" />
				' . $ResultItem->Title . '

				<span>' . $ResultItem->Description . '</span>

			</a>

		</li>';
                }
            }
        }
        if ($Resultsproducts) {

            echo '<li><h4>Productos</h4></li>';

            foreach ($Resultsproducts as $ResultItem) {

                $ParentURLThisProd = '';

                $PSID1 = $SKTDB->get_row("SELECT SID, URLName FROM " . DB_PREFIX . "sections WHERE PID = '$ResultItem->ProductID'");
                if (isset($PSID1->SID) && $PSID1->SID != '') {
                    //$ParentURLThisProd = $PSID1->URLName.'/';
                    $PSID2 = $SKTDB->get_row("SELECT SID, URLName FROM " . DB_PREFIX . "sections WHERE ID = '$PSID1->SID'");
                    if (isset($PSID2->SID) && $PSID2->SID != '') {
                        $ParentURLThisProd = $PSID2->URLName;
                        $PSID3 = $SKTDB->get_row("SELECT SID, URLName FROM " . DB_PREFIX . "sections WHERE ID = '$PSID2->SID'");
                        if (isset($PSID3->SID) && $PSID3->SID != '') {
                            $ParentURLThisProd = $PSID3->URLName . '/' . $PSID2->URLName;
                            $PSID4 = $SKTDB->get_row("SELECT SID, URLName FROM " . DB_PREFIX . "sections WHERE ID = '$PSID3->SID'");
                            if (isset($PSID4->SID) && $PSID4->SID != '') {
                                $ParentURLThisProd = $PSID4->URLName . '/' . $PSID3->URLName . '/' . $PSID2->URLName;
                            }
                        }
                    }
                }


                echo '<li id="listItem_' . $ResultItem->ProductID . '" class="ui-corner-all">

			<a href="' . '/' . $Language . '/productos/' . $ParentURLThisProd . '/' . $ResultItem->URLName . '" class="ui-corner-all">

				<img src="/_FileSystems/images/' . $ResultItem->ProductImage . '" alt="" />

				' . $ResultItem->Title . '

			</a>

		</li>';
            }
        }
        ?>
    </ul>
    <div class="page_navigation"></div>
</div>
