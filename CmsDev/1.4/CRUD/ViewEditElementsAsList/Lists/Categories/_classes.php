<?php

/**
 * category_Description of Categories
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\ViewEditElementsAsList\Lists\Categories;

class Categories {

    protected static $Root = array();

    protected static function ItemsGen($parent, $categories, $html, $category_urlNameParent, $htmltemplateRoot = '', $htmltemplate = '') {
        $PrefixURL = SUBSITE;
        if (!isset($parent)) {
            $parent = 0;
        }
        $Thisitem = '';
        $TemplateItem0 = '<li class="listItem" data-id="[category_id]" data-idx="[category_idx]">
                        <div>
                            <span class="CategoryActions" data-id="[category_id]" data-idx="[category_idx]">
                                <i class="skt-icon-edit sktToolTip" title="Editar"></i>
                                <i class="skt-icon-cancel sktToolTip" title="Borrar"></i>
                                <span class="divider"></span>
                                <div class="InfoRemove" style="display:none;">
                                    <div class="Info">
                                        <b>Categoria:</b><br>
                                        <p>[category_name]</p>
                                    </div>
                                </div>
                            </span>
                            <span class="CategoryName">
                                <a class="more" data-id="[category_id]" data-idx="[category_idx]" href="#[category_id]">[category_image]<i class="[category_icon]" style="cursor: default; border:0 none;"></i> <span style="white-space: nowrap;">[level] - <b>[category_name]</b></span></a>
                            </span>
                    </div>
                </li>';
        $TemplateItem = '<li class="listItem" data-id="[category_id]" data-idx="[category_idx]">
                        <div>
                            <span class="CategoryActions" data-id="[category_id]" data-idx="[category_idx]">
                                <i class="skt-icon-edit sktToolTip" title="Editar"></i>
                                <i class="skt-icon-cancel sktToolTip" title="Borrar"></i>
                                <span class="divider"></span>
                                <div class="InfoRemove" style="display:none;">
                                    <div class="Info">
                                        <b>Categoria:</b><br>
                                        <p>[category_name]</p>
                                    </div>
                                </div>
                            </span>
                            <span class="CategoryName">
                                <a class="more" data-id="[category_id]" data-idx="[category_idx]" href="#[category_id]">[category_image]<i class="[category_icon]" style="cursor: default; border:0 none;"></i> <span style="white-space: nowrap;">[level] - <b>[category_name]</b></span></a>
                            </span>
                    </div>
                </li>';
        if ($htmltemplateRoot != '') {
            $TemplateItem0 = $htmltemplateRoot;
        }
        if ($htmltemplate != '') {
            $templateItem = $htmltemplate;
        }
        if (isset($categories['parents'][$parent])) {
            foreach ($categories['parents'][$parent] as $itemId) {
                if (!isset($categories['parents'][$itemId])) {
                    if ($categories['items'][$itemId]['category_idx'] === '0') {
                        $Template = $TemplateItem0;
                    } else {
                        $Template = $TemplateItem;
                    }
                    $Thisitem = str_replace('[category_icon]', $categories['items'][$itemId]['category_icon'], $Template);
                    $Thisitem = str_replace('[level]', $categories['items'][$itemId]['level'], $Template);
                    if ($categories['items'][$itemId]['category_image'] != '') {
                        $Thisitem = str_replace('[category_image]', '<img src="' . $categories['items'][$itemId]['category_image'] . '" class="img-responsive" />', $Thisitem);
                    } else {
                        $Thisitem = str_replace('[category_image]', '', $Thisitem);
                    }
                    $Thisitem = str_replace('[category_name]', $categories['items'][$itemId]['category_name'], $Thisitem);
                    $Thisitem = str_replace('[category_Description]', $categories['items'][$itemId]['category_Description'], $Thisitem);
                    $Thisitem = str_replace('[category_id]', $categories['items'][$itemId]['category_id'], $Thisitem);
                    $Thisitem = str_replace('[category_idx]', $categories['items'][$itemId]['category_idx'], $Thisitem);
                    $Thisitem = str_replace('[category_idxName]', $categories['items'][$categories['items'][$itemId]['category_idx']]['category_name'], $Thisitem);
                    $Thisitem = str_replace('[category_url]', $Prefixcategory_url . $category_urlNameParent . $categories['items'][$itemId]['category_url'] . '/', $Thisitem);
                    $html .= $Thisitem;
                    echo utf8_encode($html);
                } else {
                    $Thisitem = str_replace('[category_icon]', $categories['items'][$itemId]['category_icon'], $Template);
                    if ($categories['items'][$itemId]['category_image'] != '') {
                        $Thisitem = str_replace('[category_image]', '<img src="' . $categories['items'][$itemId]['category_image'] . '" class="img-responsive" />', $Thisitem);
                    } else {
                        $Thisitem = str_replace('[category_image]', '', $Thisitem);
                    }
                    $Thisitem = str_replace('[category_name]', $categories['items'][$itemId]['category_name'], $Thisitem);
                    $Thisitem = str_replace('[category_Description]', $categories['items'][$itemId]['category_Description'], $Thisitem);
                    $Thisitem = str_replace('[category_id]', $categories['items'][$itemId]['category_id'], $Thisitem);
                    $Thisitem = str_replace('[category_idx]', $categories['items'][$itemId]['category_idx'], $Thisitem);
                    $Thisitem = str_replace('[category_idxName]', $categories['items'][$categories['items'][$itemId]['category_idx']]['category_name'], $Thisitem);
                    $Thisitem = str_replace('[category_url]', $Prefixcategory_url . $category_urlNameParent . $categories['items'][$itemId]['category_url'] . '/', $Thisitem);
                    $html .= $Thisitem;
                    $html .= self::ItemsGen($itemId, $categories, $html, $category_urlNameParent . $categories['items'][$itemId]['category_url'] . '/');
                }

                $html = '';
            }
        }
    }

    protected static function QueryListRoot($Root = '') {
        $WHERE = ' WHERE category_idx = 0';
        if ($Root != '') {
            $WHERE = ' WHERE category_idx = ' . \GetSQLValueString($Root, "int");
        }
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $categories = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "categories" . $WHERE);
        foreach ($categories as $Category) {
            $ListNames[$Category->category_id] = $Category->category_name;
        }
        return $ListNames;
    }

    protected static function Render($category_idx) {
        $WHERE = ' WHERE category_idx = 0';
        if ($category_idx != '') {
            $WHERE = ' WHERE category_idx = ' . \GetSQLValueString($category_idx, "int");
        } else {
            $category_idx = 0;
        }
        $html = '';
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $querySQL = "SELECT * FROM " . \DB_PREFIX . "categories " . $WHERE . " AND category_id !=0  ORDER BY category_idx ASC, category_position ASC, category_name ASC ";

        $query = $SKTDB->get_results($querySQL, ARRAY_A);
        $categories = array(
            'items' => array(),
            'parents' => array()
        );
        foreach ($query as $items) {
            $categories['items'][$items['category_id']] = $items;
            $categories['parents'][$items['category_idx']][] = $items['category_id'];
        }
        $html .= '<div class="CustomList TableListElementsSKT row">';
        $html .= '<div class="col-md-3 Level">'
                . '<div id="idx_' . $category_idx . '" class="idxgroup" data-group-idx="' . $category_idx . '">'
                . '<div class="clean"></div>'
                . '<ul class="nav nav-pills nav-stacked">';
        echo $html;
        self::EncodeValue(self::ItemsGen($category_idx, $categories, '', ''));
        echo '</ul>'
        . '<div class="btn skt-btn-list-add size-3-i"><i class="skt-icon-tags"></i><span>Agregar</span></div>'
        . '</div></div>'
        . '<div class="col-md-3 Level" id="sub1"></div>'
        . '<div class="col-md-3 Level" id="sub2"></div>'
        . '<div class="col-md-3 Level" id="sub3"></div>'
        . '</div>'
        . '<script type="text/javascript">var IDXCat = "' . $category_idx . '";</script>';
        include 'scripts.php';
    }

    protected static function RenderSub($category_idx) {
        $WHERE = ' WHERE category_idx = 0';
        if ($category_idx != '') {
            $WHERE = ' WHERE category_idx = ' . \GetSQLValueString($category_idx, "int");
        }
        $html = '';
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $querySQL = "SELECT * FROM " . \DB_PREFIX . "categories " . $WHERE . " AND category_id !=0 ORDER BY category_idx ASC, category_position ASC, category_name ASC ";

        $query = $SKTDB->get_results($querySQL, ARRAY_A);
        $categories = array(
            'items' => array(),
            'parents' => array()
        );
        foreach ($query as $items) {
            $categories['items'][$items['category_id']] = $items;
            $categories['parents'][$items['category_idx']][] = $items['category_id'];
        }
        $html .= '<div id="idx_' . $category_idx . '" class="idxgroup" data-group-idx="' . $category_idx . '">'
                . '<div class="clean"></div>'
                . '<ul class="nav nav-pills nav-stacked">';
        echo $html;
        self::EncodeValue(self::ItemsGen($category_idx, $categories, '', ''));
        echo '</ul>'
        . '<div class="btn skt-btn-list-add size-3-i"><i class="skt-icon-tags"></i><span>Agregar</span></div>'
        . '</div>'
        . '<script type="text/javascript">var IDXCat = "' . $category_idx . '";</script>';
        include 'scripts.php';
    }

    protected static function Add($category_name = '', $category_Description = '', $category_url = '', $category_icon = '', $category_idx = '0', $category_level = '0', $category_image = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $category_name = self::DecodeValue(isset($category_name) ? $category_name : '');
        $category_Description = self::DecodeValue(isset($category_Description) ? $category_Description : '');
        $Query = "INSERT INTO " . \DB_PREFIX . "categories (category_name, category_Description, category_url, category_icon, category_idx, level, category_image) 
		VALUES (" .
                \GetSQLValueString($category_name, "text") . "," .
                \GetSQLValueString($category_Description, "text") . "," .
                \GetSQLValueString($category_url, "text") . "," .
                \GetSQLValueString($category_icon, "text") . "," .
                \GetSQLValueString($category_idx, "int") . "," .
                \GetSQLValueString($category_level, "int") . "," .
                \GetSQLValueString($category_image, "text") . ")";
        
        $insert = $SKTDB->query($Query);
        if ($insert) {
            echo 'okay';
        } else {
            echo "error: <br>"; // . $Query;
        }
    }

    protected static function Edit($category_id = '', $category_name = '', $category_Description = '', $category_url = '', $category_icon = '', $category_idx = '0', $category_level = '0', $category_image = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $category_name = self::DecodeValue(isset($category_name) ? $category_name : '');
        $category_Description = self::DecodeValue(isset($category_Description) ? $category_Description : '');
        $update = $SKTDB->query(sprintf("UPDATE " . \DB_PREFIX . "categories Set 
            category_name = %s,
            category_Description = %s, 
            category_url = %s,
            category_icon = %s,
            level = %s,
            category_image = %s,
            category_idx = %s
            WHERE category_id = %s", 
                \GetSQLValueString($category_name, "text"), 
                \GetSQLValueString($category_Description, "text"), 
                \GetSQLValueString($category_url, "text"), 
                \GetSQLValueString($category_icon, "text"), 
                \GetSQLValueString($category_level, "int"), 
                \GetSQLValueString($category_image, "text"), 
                \GetSQLValueString($category_idx, "int"), 
                \GetSQLValueString($category_id, "int")
        ));
        if ($update) {
            echo 'okay';
        } else {
            echo "error";
        }
    }

    protected static function Remove($category_id = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $DeleteQuery = $SKTDB->query("DELETE FROM " . \DB_PREFIX . "categories WHERE category_id = '" . \GetSQLValueString($category_id, "int") . "' AND category_id !=0 LIMIT 1");
        if ($DeleteQuery) {
            echo 'ok';
        } else {
            echo \SKT_ADMIN_Message_Update_Error;
        }
    }

    protected static function EncodeValue($value) {
        return \utf8_encode($value);
    }

    protected static function DecodeValue($value) {
        return \utf8_decode($value);
    }

}

class _classes extends Categories {

    public function RenderList($category_idx) {
        return static::Render($category_idx);
    }

    public function RenderListSub($category_idx) {
        return static::RenderSub($category_idx);
    }

    public function QueryList($Root) {
        return static::QueryListRoot($Root);
    }

    public function AddToList($category_name, $category_Description, $category_url, $category_icon, $category_idx, $category_level, $category_image) {
        return static::Add($category_name, $category_Description, $category_url, $category_icon, $category_idx, $category_level, $category_image);
    }

    public function RemoveFromList($category_id) {
        return static::Remove($category_id);
    }

    public function EditItemList($category_id, $category_name, $category_Description, $category_url, $category_icon, $category_idx,$category_level, $category_image) {
        return static::Edit($category_id, $category_name, $category_Description, $category_url, $category_icon, $category_idx,$category_level, $category_image);
    }

}

?>
