<?php

function ListField($field) {
    $fieldtrue = explode('|', $field);
    $count = count($fieldtrue)-1;
    if($count>=1){
    return utf8_encode($fieldtrue[1]);
    }
}

function ListFieldType($field) {
    $fieldtrue = explode('|', $field);
    return $fieldtrue[0];
}

function showListType($a, $select = '') {
    $formatedarray = '';
    foreach ($a as $k => $v) {
        if ($select == $v) {
            $formatedarray.= "$k";
        } else {
            
        }
    }
    return $formatedarray;
}

function ListType($name, $id, $passarray, $select = '') {
    $optionarray = showListType($passarray, $select);
    return $optionarray;
}

function enumCreate($x, $Fields) {
    $ListEnum = explode(',', ListField($Fields));
    //echo count($ListEnum);
    $i = 0;
    foreach ($ListEnum as $value) {
        $value = str_replace('\'', '', $value);
        if ($i == 0) {
            $check = 'checked';
        } else {
            $check = '';
        }
        echo '<label for="' . $x . '_' . $i . '" class="labelradio"><span><input name="' . $x . '" type="radio" ' . $check . ' value="' . $value . '" id="' . $x . '_' . $i . '">' . $value . '</span></label>';
        $i++;
    }
}
