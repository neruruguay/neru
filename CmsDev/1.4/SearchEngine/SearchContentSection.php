<?php

/**
 * Description of Results
 *
 * @author Martín Daguerre
 */

namespace CmsDev\SearchEngine;

class SearchContentSection {

    protected $ListTemplate = '
        <div class="product-thumb">
            <header class="product-header">
                <img src="[ProductImage]" alt="" title="" />
            </header>
            <div class="product-inner">
                <h5 class="product-title">[Title]</h5>
                <p class="product-desciption">[ProductDescription]<br>[Priority]</p>
                <div class="product-meta">
                    <ul class="product-price-list">
                        <li><span class="product-price">[Currency][Price][UnitOrAll]</span></li>
                    </ul>
                    <ul class="product-actions-list">
                        <li><a class="btn btn-sm" href="[UrlLike]"><i class="fa fa-hand-o-up"></i> Me gusta</a>
                        </li>
                        <li><a class="btn btn-sm" href="[UrlDetail]"><i class="fa fa-plus"></i> Detalle</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>';
    protected static $ProductFields = array(
        'Title' => 'text',
        'Price' => 'int',
        'ProductDescription' => 'text',
        'ProductDescriptionHTML' => 'text'
    );
    protected static $CompanyFields = array(
        'Title' => 'text',
        'Price' => 'int',
        'ProductDescription' => 'text',
        'ProductDescriptionHTML' => 'text'
    );
    protected static $ServiceFields = array(
        'Title' => 'text',
        'Price' => 'int',
        'ProductDescription' => 'text',
        'ProductDescriptionHTML' => 'text'
    );
    protected static $SectionFields = array(
        'Title' => 'text',
        'Price' => 'int',
        'ProductDescription' => 'text',
        'ProductDescriptionHTML' => 'text'
    );

    protected static function EncodeValue($value) {
        return \utf8_encode($value);
    }

    protected static function DecodeValue($value) {
        return \utf8_decode($value);
    }
    protected static function Render($Type = 'All', $SearchTxt = 'Negocios', $limit = 100) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $SearchTxt = self::DecodeValue(strtolower($SearchTxt));
        $Resultssections = $SKTDB->get_results("SELECT * FROM " . DB_PREFIX . "sections AS sections WHERE 
	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.Title like '%$SearchTxt%')
	OR 
	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.Description like '%$SearchTxt%' )
	OR 
	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.URLName like '%$SearchTxt%' )
	OR 
	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.MetaDataTitle like '%$SearchTxt%' )
	OR 
	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.MetaDataDescription like '%$SearchTxt%' )
	OR 
	( sections.RecycleBin = '0' AND sections.SectionType < '3' AND sections.MetaDataKeywords like '%$SearchTxt%' )"
                . "LIMIT " . $limit ."");

        $Resultscontent = $SKTDB->get_results(""
                . "SELECT content.*,sections.ID, sections.URLName "
                . "FROM " . DB_PREFIX . "content AS content," . DB_PREFIX . "sections AS sections 
                    WHERE 
	( content.RecycleBin = '0' AND content.Content like '%$SearchTxt%'  AND content.IDPage = sections.ID )
	OR 
	( content.RecycleBin = '0' AND content.Description like '%$SearchTxt%' AND content.IDPage = sections.ID )"
                . "LIMIT " . $limit ."");
        if (!$Resultssections && !$Resultsproducts && !$Resultscontent) {
            //echo 'No se encontraron coincidencias en contenidos para "' . $SearchTxt . '"...';
        }
        if ($Resultssections) {
            echo '<h4>Secciones</h4>';
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
    }

    public function Get_Results($Type = 'All', $SearchTxt = 'Negocios', $limit) {
        self::Render($Type, $SearchTxt, $limit);
    }

}
