<?php

//function mbox_tplate_field_order( $postID, $tplateOptns, $isSingle ){
//
//    echo  abcfl_html_tag('div','','inside  hidden');
//        $out = abcfsl_tplate_field_order_sort_cntr( $postID, $tplateOptns, $isSingle );
//        echo $out['msg'];
//        echo $out['sortCntr'];
//    echo abcfl_html_tag_end('div');
//}

function mbox_tplate_field_order( $postID, $tplateOptns, $isSingle ){

    echo  abcfl_html_tag('div','','inside  hidden');

        $lstLayout = isset( $tplateOptns['_lstLayout'] ) ? esc_attr( $tplateOptns['_lstLayout'][0] ) : '0';
        $lstLayoutH = isset( $tplateOptns['_lstLayoutH'] ) ? esc_attr( $tplateOptns['_lstLayoutH'][0] ) : $lstLayout;
        if($lstLayoutH == '0'){
            echo abcfl_html_tag_end('div');
            return;
        }

        $out = abcfsl_tplate_field_order_sort_cntr( $postID, $tplateOptns, $isSingle );
        echo $out['msg'];
        echo $out['sortCntr'];
    echo abcfl_html_tag_end('div');
}

//-------------------------------------------------------------------------------------

//Render sort fields container
function abcfsl_tplate_field_order_sort_cntr( $postID, $tplateOptns, $isSingle ){

    $items = '';
    $fieldsQty = 0;
    $sortSuffix = 'L';
    if($isSingle) { $sortSuffix = 'S'; }

    //[1] => F1 [2] => F4 [3] => F5
    $fieldOrder = abcfsl_util_field_order( $tplateOptns, $isSingle );

    foreach ( $fieldOrder as $order => $F ) {

        $lineName = isset( $tplateOptns['_lnkUrlLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlLbl_' . $F][0] ) : '';
        $lineName = isset( $tplateOptns['_lnkLblLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblLbl_' . $F][0] ) : $lineName;
        $lineName = isset( $tplateOptns['_inputLbl_' . $F] ) ? esc_attr( $tplateOptns['_inputLbl_' . $F][0] ) : $lineName;
        $lineName = isset( $tplateOptns['_lblTxt_' . $F] ) ? esc_attr( $tplateOptns['_lblTxt_' . $F][0] ) : $lineName;

        if( empty( $lineName )){
            $lineName = isset( $tplateOptns['_inputLblP1_' . $F] ) ? esc_attr( $tplateOptns['_inputLblP1_' . $F][0] ) : '';
            $lineName = trim($lineName . ' ' . (isset( $tplateOptns['_inputLblP2_' . $F] ) ? esc_attr( $tplateOptns['_inputLblP2_' . $F][0] ) : ''));
        }

        // TODO SL
        //Hidden field. Fileld type. N = field not selected yet.
        $fieldTypeH = isset( $tplateOptns['_fieldTypeH_' . $F] ) ? esc_attr( $tplateOptns['_fieldTypeH_' . $F][0] ) : 'N';
        $fieldType = $fieldTypeH; //????????????
        $showField = $fieldTypeH;
        $showOn = isset( $tplateOptns['_showField_' . $F] ) ? esc_attr( $tplateOptns['_showField_' . $F][0] ) : 'L';

        if( $F == 'SL' ){
            $showField = isset( $tplateOptns['_showSocial'] ) ? esc_attr( $tplateOptns['_showSocial'][0] ) : 'N';
            $fieldType = 'SL';
            $showOn = isset( $tplateOptns['_showSocialOn'] ) ? esc_attr( $tplateOptns['_showSocialOn'][0] ) : 'Y';
        }

        if( $F == 'SPTL' ){
            $showField = isset( $tplateOptns['_sPgLnkShow'] ) ? $tplateOptns['_sPgLnkShow'][0] : 'N';
            $fieldType = 'SPTL';
            $fieldTypeH = 'SPTL';
            $showOn = 'L';
        }

        $addToList = abcfsl_tplate_field_order_show_field( $showOn, $showField, $isSingle );
        if( $addToList ){
            //$lineName = $inputLbl;
            $items .= abcfsl_tplate_field_order_li( $F, $order, $fieldTypeH, $fieldType, $lineName );
            $fieldsQty++;
        }
    }

    $out['msg'] = abcfl_input_info_lbl(abcfsl_txta(214), 'abcflMTop15 abcflMBottom15', 16, 'SB');
    $out['sortCntr'] = '';

    if( $fieldsQty > 0 ){
        $out['msg'] = abcfl_input_info_lbl(abcfsl_txta(255), 'abcflMTop15 abcflMBottom15', 14, 'SB');
        $out['sortCntr'] = abcfsl_tplate_field_order_cntr($postID, $sortSuffix, $items);
    }
    return $out;
}

//Check if field should be included in sort fields container
function abcfsl_tplate_field_order_show_field( $showOn, $showField, $isSingle ){

    //$showField: N = field is not selected.
    //$showField: N = showSocial, sPgLnkSho
    //Hidden fields are added to sort fields container.
    if( $showField == 'N' ){ return false; }

    $out = false;
    switch ( $showOn ) {
    case 'Y':
        $out = true;
        break;
    case 'L':
        if( !$isSingle ){ $out = true; }
        break;
    case 'S':
        if($isSingle ){ $out = true; }
        break;
    default:
        break;
    }

    return $out;
}

//LI buider.
function abcfsl_tplate_field_order_li( $F, $order, $fieldTypeH, $selectedFieldType, $lineName ){

        $clsLi = 'sortable-item';
        $idLi = $F;

        $clsSort = 'abcflFontFVS12';
        if( $fieldTypeH != 'N' ){ $clsSort = 'abcflFontFVS12 abcflFontW700'; }

        $clsName = 'abcflPLeft15 abcflFontFVS12';

        $lineNumber = $order . ' - '. $idLi . '&nbsp;';
        $fieldType = abcfsl_tplate_field_order_field_type( $selectedFieldType );

        $liS = abcfl_html_tag('li',  $idLi, $clsLi );
        $spanSort = abcfl_html_tag( 'span', '', $clsSort) .$lineNumber . '</span>';
        $spanName = abcfl_html_tag( 'span', '', $clsName) . $lineName . '</span>';
        $spanFieldType = abcfl_html_tag( 'span', '', 'abcflPLeft10') . $fieldType . '</span>';

        return $liS . $spanSort . $spanName . $spanFieldType. '</li>';
}

function abcfsl_tplate_field_order_cntr( $postID, $sortSuffix, $items ){

    $divID = 'fieldsSortCntr' . $sortSuffix;
    $divCls = 'abcflWidth60Pc';
    $divS = abcfl_html_tag( 'div', $divID, $divCls );
    $divE = '</div>';

    $ulCls = 'sortable-list ui-sortable';
    $ulID = 'ul' . $sortSuffix . '_' . $postID;
    $ulS = abcfl_html_tag( 'ul', $ulID, $ulCls );

    return $divS . $ulS . $items . '</ul>' . $divE;
}

//Labels displayed next to field names on sort screen
function abcfsl_tplate_field_order_field_type( $selectedFieldType ){

    $out = '';
    $fieldType = '';
    if( $selectedFieldType != 'N '){

        switch ($selectedFieldType) {
            case 'T':
                $fieldType = 'Txt';
                break;
            case 'MP':
                $fieldType = 'Name - Multipart';
                break;
             case 'LT':
                $fieldType = 'Lbl+Txt';
                break;
             case 'STXT':
                $fieldType = 'Static Txt';
                break;
            case 'H':
                $fieldType = 'Link';
                break;
            case 'TH':
                $fieldType = 'Static Txt + Link';
                break;
            case 'SH':
                $fieldType = 'Single Page Link';
                break;
            case 'CE':
                $fieldType = 'Txt Editor';
                break;
            case 'EM':
                $fieldType = 'Email';
                break;
            case 'PT':
                $fieldType = 'Paragraph';
                break;
            case 'SC':
                $fieldType = 'Shortcode';
                break;
            case 'CBO':
                $fieldType = 'Drop-down';
                break;
            case 'LBLCBO':
                $fieldType = 'Static Lbl + Drop-down';
                break;                          
            case 'SL':
                $fieldType = 'Social Icons';
                break;
            case 'SPTL':
                $fieldType = 'Single Page Text Link';
                break;
            case 'HL':
                $fieldType = 'Horizontal Line';
                break;
            default:
                break;
        }
        $out = '[ ' . $fieldType . ' ]';
    }
    return $out;
}





