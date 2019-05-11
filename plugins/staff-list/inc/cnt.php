<?php
/*
 * Content builders. Used by all layouts
 * Returns single text field container + content.
 */
//TEXT FIELD BUILDER. Renders single text fiel, dcontainer + content.
function abcfsl_cnt_txt_field( $itemOptns, $tplateOptns, $itemID, $sPageUrl, $F, $isSingle, $pfix ){

    $showFieldOn = '';
    $showField = true;
    $fieldType = 'N';

     //Quit if field is not selected or hidden.
    switch ( $F ){
        case 'SL':
            $showSocial = isset( $tplateOptns['_showSocial'] ) ? esc_attr( $tplateOptns['_showSocial'][0] ) : 'N';
            if( $showSocial != 'Y' ) { return ''; }

            $showFieldOn = isset( $tplateOptns['_showSocialOn'] ) ? esc_attr( $tplateOptns['_showSocialOn'][0] ) : 'Y';
            $fieldType = 'SL';
            break;
        case 'SPTL':
            $sPgLnkShow = isset( $tplateOptns['_sPgLnkShow'] ) ? $tplateOptns['_sPgLnkShow'][0] : 'N';
            if( $sPgLnkShow != 'Y' ) { return ''; }
            $showFieldOn = 'L';
            $fieldType = 'SPTL';
            break;
       default:
            $fieldType = isset( $tplateOptns['_fieldType_' . $F] ) ? esc_attr( $tplateOptns['_fieldType_' . $F][0] ) :'N';
            $hideField = isset( $tplateOptns['_hideDelete_' . $F] ) ? esc_attr( $tplateOptns['_hideDelete_' . $F][0] ) : 'N';
            if( $fieldType == 'N' || $hideField != 'N' ) { return ''; }

            $showFieldOn = isset( $tplateOptns['_showField_' . $F] ) ? esc_attr( $tplateOptns['_showField_' . $F][0] ) : 'L';
            break;
    }

    //Quit if field is not selected or hidden.
    //if( !$showField ){ return ''; }

    switch ( $showFieldOn ){
        case 'L': //List only
            if( $isSingle ){ $showField = false; }
            break;
        case 'S': //Single page only
            if( !$isSingle ){ $showField = false; }
            break;
       default:
            break;
    }
    if( !$showField ){ return ''; }

    //------------------------------------------------------------
    $tagCls = '';
    $marginT = '';
    $tagFont = '';
    $tagType = '';
    $tagStyle = '';
    $newTab = '';

    $href['hrefUrl'] = '';
    $href['hrefTxt'] = '';
    $href['target'] = '';

    switch ($F){
        case 'SPTL':
            $tagType = isset( $tplateOptns['_sPgLnkTag'] ) ? $tplateOptns['_sPgLnkTag'][0] : 'div';
            $tagCls = isset( $tplateOptns['_sPgLnkCls'] ) ? esc_attr( $tplateOptns['_sPgLnkCls'][0] ) : '';
            $tagStyle = isset( $tplateOptns['_sPgLnkStyle'] ) ? esc_attr( $tplateOptns['_sPgLnkStyle'][0] ) : '';
            $marginT = isset( $tplateOptns['_sPgLnkMarginT'] ) ? $tplateOptns['_sPgLnkMarginT'][0] : 'N';
            $tagFont = isset( $tplateOptns['_sPgLnkFont'] ) ? $tplateOptns['_sPgLnkFont'][0] : 'D';

            $newTab = isset( $tplateOptns['_sPgLnkNT'] ) ? $tplateOptns['_sPgLnkNT'][0] : '0';
            if( $newTab == '0' ) { $newTab = 'N';} else { $newTab = 'Y';}

            $lineTxt = isset( $tplateOptns['_sPgLnkTxt'] ) ? esc_attr( $tplateOptns['_sPgLnkTxt'][0] ) : '';
            break;

       default:
            $tagType = isset( $tplateOptns['_tagType_' . $F] ) ? esc_attr( $tplateOptns['_tagType_' . $F][0] ) : 'div';
            $tagCls = isset( $tplateOptns['_tagCls_' . $F] ) ? esc_attr( $tplateOptns['_tagCls_' . $F][0] ) : '';
            $tagStyle = isset( $tplateOptns['_tagStyle_' . $F] ) ? esc_attr( $tplateOptns['_tagStyle_' . $F][0] ) : '';
            $marginT = isset( $tplateOptns['_tagMarginT_' . $F] ) ? esc_attr( $tplateOptns['_tagMarginT_' . $F][0] ) : 'N';
            $tagFont = isset( $tplateOptns['_tagFont_' . $F] ) ? esc_attr( $tplateOptns['_tagFont_' . $F][0] ) : 'D';
            $newTab = isset( $tplateOptns['_newTab_' . $F] ) ? esc_attr( $tplateOptns['_newTab_' . $F][0] ) : 'N';

            $href = abcfsl_util_href_bldr( $itemOptns, $itemID, $sPageUrl, $F );

            // HTML
            $lineTxt = isset( $itemOptns['_txt_' . $F] ) ? $itemOptns['_txt_' . $F][0]  : '';
            break;
    }

    //Field container custom class.
    $tagCustCls = abcfsl_util_pg_type_cls_bldr( $tagCls, $isSingle );

    //Top margin. Class name or empty string if Default or Custom selected.
    $tagMarginT = abcfsl_util_cls_name_nc_bldr( $marginT, 'MT', $pfix );

    //Font Size. Class name or empty string if Default or Custom selected.
    $tagFont = abcfsl_util_cls_name_nc_bldr( $tagFont, 'F', $pfix );

    //Tag, all classes.
    $tagClss = ltrim ( $tagMarginT . ' ' . $tagFont . ' ' . $tagCustCls );

    //------------------------------------------------------------

    $par = array(
        'tagType' => $tagType,
        'tagCls' => $tagClss,
        'tagStyle' => $tagStyle,
        'lnkCls' => isset( $tplateOptns['_lnkCls _' . $F] ) ? esc_attr( $tplateOptns['_lnkCls_' . $F][0] ) : '',
        'lnkStyle' => isset( $tplateOptns['_lnkStyle_' . $F] ) ? esc_attr( $tplateOptns['_lnkStyle_' . $F][0] ) : '',
        'lblTxt' => isset( $tplateOptns['_lblTxt_' . $F] ) ? esc_attr( $tplateOptns['_lblTxt_' . $F][0] ) : '',
        'lblCls' => isset( $tplateOptns['_lblCls_' . $F] ) ? esc_attr( $tplateOptns['_lblCls_' . $F][0] ) : '',
        'lblStyle' => isset( $tplateOptns['_lblStyle_' . $F] ) ? esc_attr( $tplateOptns['_lblStyle_' . $F][0] ) : '',
        'txtCls' => isset( $tplateOptns['_txtCls_' . $F] ) ? esc_attr( $tplateOptns['_txtCls_' . $F][0] ) : '',
        'txtStyle' => isset( $tplateOptns['_txtStyle_' . $F] ) ? esc_attr( $tplateOptns['_txtStyle_' . $F][0] ) : '',
        'newTab' => $newTab,
        'lineTxt'  => $lineTxt,
        'editorCnt'  => isset( $itemOptns['_editorCnt_' . $F] ) ? esc_attr( $itemOptns['_editorCnt_' . $F][0] ) : '',
        'hrefUrl' => $href['hrefUrl'],
        'hrefTxt' => $href['hrefTxt'],
        'target' => $href['target'],
        'F' => $F,
        'sPageUrl' => $sPageUrl,
        'itemID'  => $itemID,
        'isSingle'  => $isSingle,
        'clsPfix'  => $pfix
    );

    $out = '';
    switch ($fieldType){
        case 'T': //Text
        case 'PT': //Paragraph Text
            $out = abcfsl_cnt_txt_field_T( $par );
            break;
        case 'LT': //Lsbel + Text
            $out = abcfsl_cnt_txt_field_LT( $par );
            break;
        case 'H': //Hyperlink
            $out = abcfsl_cnt_txt_field_H( $par );
            break;
        case 'TH': //Static Text + Hyperlink
            $out = abcfsl_cnt_txt_field_TH( $par, $itemOptns );
            break;
        case 'EM': //Email
            $out = abcfsl_cnt_txt_field_EM( $par );
            break;
         case 'MP': //Multipart
            $out = abcfsl_cnt_txt_field_MP( $tplateOptns, $par, $itemOptns, $F );
            break;
        case 'CE': //HTML
            $out = abcfsl_cnt_txt_field_WPE( $par );
            break;
        case 'HL': //PRO --- Horizontal Line
            $out = abcfsl_cnt_txt_field_HL( $par['tagCls'], $par['tagStyle'], $pfix );
            break;            
        case 'SPTL':  //Single Page Text Link
            $out = abcfsl_cnt_txt_field_SPTL( $par, $itemOptns );
            break;
       default:
            break;
    }
    return $out;
}

//==SINGLE PAGE LINK ===========================================================
function abcfsl_cnt_txt_field_SPTL( $par, $itemOptns ){

    $url = 'SP';
    if( $par['newTab'] == 'Y' ) { $url = 'NT SP'; }

    $pretty = isset( $itemOptns['_pretty'] ) ? esc_attr( $itemOptns['_pretty'][0] ) : '';
    $href = abcfsl_util_href_bldr_SPTL( $url, $par['lineTxt'], $pretty, $par['itemID'], $par['sPageUrl'] );
    $link = abcfl_html_a_tag( $href['hrefUrl'], $href['hrefTxt'], $href['target'], $par['lnkCls'], $par['lnkStyle'], '', false);

    return abcfl_html_tag( $par['tagType'], '', $par['tagCls'], $par['tagStyle'] ) . $link . abcfl_html_tag_end( $par['tagType']);
}

//---MP builder START -------------------------------------------------------------
function abcfsl_cnt_txt_field_MP( $tplateOptns, $par, $itemOptns, $F ){

    $name = abcfsl_cnt_txt_field_MP_string_bldr( $tplateOptns, $itemOptns, $F, $par['isSingle'] );
    if( abcfl_html_isblank( $name ) ) { return ''; }

    $cntrS = abcfl_html_tag( $par['tagType'], '', $par['tagCls'], $par['tagStyle'] );
    $cntrE = abcfl_html_tag_end( $par['tagType']);

    return $cntrS . $name . $cntrE;
}

function abcfsl_cnt_txt_field_MP_string_bldr( $tplateOptns, $itemOptns, $F, $isSingle ){

    $mp1 = isset( $itemOptns['_mp1_' . $F] ) ? esc_attr( $itemOptns['_mp1_' . $F][0] ) : '';
    $mp2 = isset( $itemOptns['_mp2_' . $F] ) ? esc_attr( $itemOptns['_mp2_' . $F][0] ) : '';
    $mp3 = isset( $itemOptns['_mp3_' . $F] ) ? esc_attr( $itemOptns['_mp3_' . $F][0] ) : '';
    $mp4 = isset( $itemOptns['_mp4_' . $F] ) ? esc_attr( $itemOptns['_mp4_' . $F][0] ) : '';

    if( abcfl_html_isblank( $mp1 ) && abcfl_html_isblank( $mp2 ) && abcfl_html_isblank( $mp3 ) && abcfl_html_isblank( $mp4 ) ) { return ''; }

    $orderP1 = '';
    $orderP2 = '';
    $orderP3 = '';
    $orderP4 = '';
    $sfixP1 = '';
    $sfixP2 = '';
    $sfixP3 = '';
    $sfixP4 = '';

    if( !$isSingle ){
        $orderP1 = isset( $tplateOptns['_orderLP1_' . $F] ) ? $tplateOptns['_orderLP1_' . $F][0] : '0';
        $orderP2 = isset( $tplateOptns['_orderLP2_' . $F] ) ? esc_attr( $tplateOptns['_orderLP2_' . $F][0] ) : '0';
        $orderP3 = isset( $tplateOptns['_orderLP3_' . $F] ) ? esc_attr( $tplateOptns['_orderLP3_' . $F][0] ) : '0';
        $orderP4 = isset( $tplateOptns['_orderLP4_' . $F] ) ? esc_attr( $tplateOptns['_orderLP4_' . $F][0] ) : '0';

        $sfixP1 = isset( $tplateOptns['_sfixLP1_' . $F] ) ? esc_attr( $tplateOptns['_sfixLP1_' . $F][0] ) : '';
        $sfixP2 = isset( $tplateOptns['_sfixLP2_' . $F] ) ? esc_attr( $tplateOptns['_sfixLP2_' . $F][0] ) : '';
        $sfixP3 = isset( $tplateOptns['_sfixLP3_' . $F] ) ? esc_attr( $tplateOptns['_sfixLP3_' . $F][0] ) : '';
        $sfixP4 = isset( $tplateOptns['_sfixLP4_' . $F] ) ? esc_attr( $tplateOptns['_sfixLP4_' . $F][0] ) : '';
    }
    else {
        $orderP1 = isset( $tplateOptns['_orderSP1_' . $F] ) ? esc_attr( $tplateOptns['_orderSP1_' . $F][0] ) : '0';
        $orderP2 = isset( $tplateOptns['_orderSP2_' . $F] ) ? esc_attr( $tplateOptns['_orderSP2_' . $F][0] ) : '0';
        $orderP3 = isset( $tplateOptns['_orderSP3_' . $F] ) ? esc_attr( $tplateOptns['_orderSP3_' . $F][0] ) : '0';
        $orderP4 = isset( $tplateOptns['_orderSP4_' . $F] ) ? esc_attr( $tplateOptns['_orderSP4_' . $F][0] ) : '0';

        $sfixP1 = isset( $tplateOptns['_sfixSP1_' . $F] ) ? esc_attr( $tplateOptns['_sfixSP1_' . $F][0] ) : '';
        $sfixP2 = isset( $tplateOptns['_sfixSP2_' . $F] ) ? esc_attr( $tplateOptns['_sfixSP2_' . $F][0] ) : '';
        $sfixP3 = isset( $tplateOptns['_sfixSP3_' . $F] ) ? esc_attr( $tplateOptns['_sfixSP3_' . $F][0] ) : '';
        $sfixP4 = isset( $tplateOptns['_sfixSP4_' . $F] ) ? esc_attr( $tplateOptns['_sfixSP4_' . $F][0] ) : '';
    }

    $parts = array();
    if( abcfsl_cnt_MP_field_not_empty( $orderP1, $mp1 ) ) { $parts[1] = abcfsl_cnt_MP_field_array( $orderP1, $mp1, $sfixP1 ); }
    if( abcfsl_cnt_MP_field_not_empty( $orderP2, $mp2 ) ) { $parts[2] = abcfsl_cnt_MP_field_array( $orderP2, $mp2, $sfixP2 ); }
    if( abcfsl_cnt_MP_field_not_empty( $orderP3, $mp3 ) ) { $parts[3] = abcfsl_cnt_MP_field_array( $orderP3, $mp3, $sfixP3 ); }
    if( abcfsl_cnt_MP_field_not_empty( $orderP4, $mp4 ) ) { $parts[4] = abcfsl_cnt_MP_field_array( $orderP4, $mp4, $sfixP4 ); }

    usort( $parts, 'abcfsl_cnt_MP_fields_fix_sort' );

    $name = '';
    foreach ($parts as $values) {
        foreach ($values as $key => $value) {
            switch ( $key ){
                case 'mp':
                    $name .= $value;
                    break;
                case 'sfix':
                    $name .= $value . ' ';
                    break;
                default:
                    break;
            }
        }
    }
    return trim( $name );
}

function abcfsl_cnt_MP_field_not_empty( $order, $mp ){

    if( $order != 0 && !abcfl_html_isblank( $mp ) ){
        return true;
    }
    return false;
}

function abcfsl_cnt_MP_field_array( $order, $mp, $sfix ){
    return array('order' => $order, 'mp' => $mp, 'sfix' => $sfix);
}

function abcfsl_cnt_MP_fields_fix_sort( $a, $b ){
    return $a['order'] - $b['order'];
}
//---MP builder END -----------------------------------------------------

//Text
function abcfsl_cnt_txt_field_T( $par ){

    $txt = $par['lineTxt'];
    if(abcfl_html_isblank($txt)) { return ''; }

    $cntrS = abcfl_html_tag( $par['tagType'], '', $par['tagCls'], $par['tagStyle'] );
    $cntrE = abcfl_html_tag_end( $par['tagType']);

    return $cntrS . $txt . $cntrE;
}

//Label & Text (span)
function abcfsl_cnt_txt_field_LT( $par ){

    $lineTxt = $par['lineTxt'];
    if( abcfl_html_isblank( $lineTxt ) ) { return ''; }

    if(abcfl_html_isblank($par['lblTxt'])) { return abcfsl_cnt_txt_field_T($par); }

    $tagCls = abcfsl_util_pg_type_cls_bldr( $par['tagCls'], $par['isSingle'] );
    $lblCls = abcfsl_util_pg_type_cls_bldr( $par['lblCls'], $par['isSingle'] );
    $txtCls = abcfsl_util_pg_type_cls_bldr( $par['txtCls'], $par['isSingle'] );

    $cntrS = abcfl_html_tag( $par['tagType'], '', $tagCls, $par['tagStyle'] );
    $cntrE = abcfl_html_tag_end( $par['tagType']);

    $spanLblS = abcfl_html_tag( 'span', '', $lblCls, $par['lblStyle']  );
    $spanTxtS = abcfl_html_tag( 'span', '', $txtCls, $par['txtStyle'] );

    $spanE = abcfl_html_tag_end('span');

    return $cntrS . $spanLblS . html_entity_decode( $par['lblTxt'] ) . '&nbsp;' . $spanE . $spanTxtS . html_entity_decode($lineTxt) . $spanE . $cntrE;
}



//Hyperlink
function abcfsl_cnt_txt_field_H( $par ){

    if( empty( $par['hrefUrl'] ) ){ return ''; }

    $cntrS = abcfl_html_tag( $par['tagType'], '', $par['tagCls'], $par['tagStyle'] );
    $cntrE = abcfl_html_tag_end( $par['tagType']);

    //$url = abcfsl_util_url_selector( $par['itemID'], $par['hrefUrl'], $par['sPageUrl'] );
    //if( empty( $url ) ){ return ''; }

    //abcfl_html_a_tag($href, $inputLinkLbl, $target='', $cls='', $style='', $spanStyle='', $blankTag=true, $onclickJS='', $args='')
    $link = abcfl_html_a_tag( $par['hrefUrl'], $par['hrefTxt'], $par['target'], $par['lnkCls'], $par['lnkStyle'], '', false);

    return $cntrS . $link . $cntrE;
}


//Static Text + Hyperlink
function abcfsl_cnt_txt_field_TH( $par ){

    if( empty( $par['hrefUrl'] ) ){ return ''; }

    $cntrS = abcfl_html_tag( $par['tagType'], '', $par['tagCls'], $par['tagStyle'] );
    $cntrE = abcfl_html_tag_end( $par['tagType']);

    //$url = abcfsl_util_url_selector( $par['itemID'], $par['hrefUrl'], $par['sPageUrl'] );
    //if( empty( $url ) ){ return ''; }

    $link = abcfl_html_a_tag( $par['hrefUrl'], $par['lblTxt'], $par['target'], $par['lnkCls'], $par['lnkStyle'], '', false);
    return $cntrS . $link . $cntrE;
}

//Horizontal Line
function abcfsl_cnt_txt_field_HL($tagCls, $tagStyle, $pfix){

    //if(empty($tagCls)) { $tagCls = 'abcfslBB12 abcfsWidth100'; }
    if(empty($tagCls)) { $tagCls = $pfix . 'BB12 ' . $pfix . 'Width100'; }
    return abcfl_html_tag( 'div', '', $tagCls, $tagStyle ) . abcfl_html_tag_end( 'div');
}

// Email
function abcfsl_cnt_txt_field_EM( $par ){

    $cntrS = abcfl_html_tag( $par['tagType'], '', $par['tagCls'], $par['tagStyle'] );
    $cntrE = abcfl_html_tag_end( $par['tagType']);
    $url = $par['hrefUrl'];
    $urlTxt = $par['hrefTxt'];
    if(empty($url)){ return ''; }
    if(empty($urlTxt)){ return $urlTxt = $url; }
    $url = 'mailto:' . $url;

    //abcfl_html_a_tag($href, $inputLinkLbl, $target='', $cls='', $style='', $spanStyle='', $blankTag=true, $onclickJS='', $args='')
    $link = abcfl_html_a_tag($url, $urlTxt, '0', $par['lnkCls'], $par['lnkStyle'], '', false);

    return $cntrS . $link . $cntrE;
}

//Text editor
function abcfsl_cnt_txt_field_WPE($par){

    $editorCnt = $par['editorCnt'];
    if(abcfl_html_isblank($editorCnt)) { return ''; }
    $cnt = html_entity_decode($editorCnt);

    $cntrS = abcfl_html_tag( $par['tagType'], '', $par['tagCls'], $par['tagStyle'] );
    $cntrE = abcfl_html_tag_end( $par['tagType']);

    return $cntrS . apply_filters('the_content', $cnt) . $cntrE;
}
//== TEXT FIELDS END ===========================================================

//IMAGE container.
// 1. abcfsl_cnt_list_item_cntr; abcfsl_cnt_spage_img_cntr
// 3. abcfsl_cnt_grid_item
function abcfsl_cnt_image_cntr( $lstLayout, $itemID, $tplateOptns, $itemOptns, $colL, $pfix, $vAidCls, $sPageUrl, $isSingle ){

    $imgUrl = isset( $itemOptns['_imgUrlL'] ) ? esc_attr( $itemOptns['_imgUrlL'][0] ) : '';
    if(empty($imgUrl)){ return ''; }

    //Get image border class
    $imgBorderCls = abcfsl_util_cls_name_nc_bldr( isset( $tplateOptns['_imgBorder'] ) ? esc_attr( $tplateOptns['_imgBorder'][0] ) : 'D', 'ImgBorder', $pfix );

    //Grid always has images centered including single page.
    $imgCenterCls = abcfsl_util_img_center_cls( 'Y', $pfix );
    if ( $lstLayout != 3 ){
        $imgCenterCls = abcfsl_util_img_center_cls( isset( $tplateOptns['_imgCenter'] ) ? esc_attr( $tplateOptns['_imgCenter'][0] ) : 'Y', $pfix );
    }

    $imgCustomCls = abcfsl_util_pg_type_cls_bldr( isset( $tplateOptns['_lstImgCls'] ) ? esc_attr( $tplateOptns['_lstImgCls'][0] ) : '', $isSingle );
    $imgClasses = ltrim( $imgBorderCls . $imgCenterCls . ' ' . $imgCustomCls );
    $lstImgStyle = isset( $tplateOptns['_lstImgStyle'] ) ? esc_attr( $tplateOptns['_lstImgStyle'][0] ) : '';
    //-------------------------

    //List img ID for getting ALT.
    $imgIDL = isset( $itemOptns['_imgIDL'] ) ? esc_attr( $itemOptns['_imgIDL'][0] ) : 0;
    $imgAlt = isset( $itemOptns['_imgAlt'] ) ? esc_attr( $itemOptns['_imgAlt'][0] ) : '';

    $alt = abcfsl_img_alt( $imgIDL, $imgUrl, $imgAlt );
    $imgTag = abcfl_html_img_tag('', $imgUrl, $alt, '', '', '', $imgClasses, $lstImgStyle);

    //Get Single page Url or Url entered in text field.
    $imgLnkL = isset( $itemOptns['_imgLnkL'] ) ? esc_attr( $itemOptns['_imgLnkL'][0] ) : '';
    $pretty = isset( $itemOptns['_pretty'] ) ? esc_attr( $itemOptns['_pretty'][0] ) : '';

    //URL and target
    $imgHref = abcfsl_util_url_selector( $itemID, $imgLnkL, $sPageUrl, $pretty );
    $imgATag = abcfl_html_a_tag( $imgHref['hrefUrl'], $imgTag, $imgHref['target'],'', '', '', false);

    $div['cntrS'] = '';
    $div['cntrE'] = '';
    switch ($lstLayout) {
        case 1:
        case 2:
            $div = abcfsl_cnt_list_img_cntr_div( $colL, $pfix, 'LstImg', '', '', $vAidCls );
            break;
        case 3:
            $div = abcfsl_cnt_generic_div($pfix, 'GridImgCntr', '', '', '', '', $itemID, 'N', $isSingle);
            break;
        default:
            break;
    }
    return $div['cntrS'] . $imgATag . $div['cntrE'];
}

//List, Grid B. Image container div.
function abcfsl_cnt_list_img_cntr_div( $colSize, $pfix, $colBaseCls, $customCls, $customStyle, $vAidCls ){

    $colCls = ' ' . $pfix . $colBaseCls . 'Col';
    if(!empty($customCls)){ $customCls = ' ' . $customCls; }

    //if( empty( $cls ) ) { $cls = 'LstCol'; }
    $cls = 'LstCol';
    $colCls = $pfix . $cls . ' ' . $pfix . $cls . '-' . $colSize . $colCls . $vAidCls;

    $colS = abcfl_html_tag( 'div', '', $colCls, '' );
    $cntrS = abcfl_html_tag( 'div', '', $pfix . $colBaseCls . 'Cntr' . $customCls, $customStyle );

    $div['cntrS'] = $colS . $cntrS;
    $div['cntrE'] = abcfl_html_tag_ends( 'div,div');

    return $div;
}

//=== Text section: List, Grid B, Single. START ====================================
//Container + text fields.
function abcfsl_cnt_list_txt_section( $itemID, $itemOptns, $tplateOptns, $sPageUrl, $colSize, $pfix, $vAid, $isSingle ){

    $txtFieldsHTML  = '';
    $vAidCls = '';
    if( $vAid == 'Y' ) { $vAidCls = ' ' . $pfix . 'VAidTxt'; }

    $lstTxtCntrCustomCls = isset( $tplateOptns['_lstTxtCntrCls'] ) ? esc_attr( $tplateOptns['_lstTxtCntrCls'][0] ) : $pfix . 'PadLPc5';
    $lstTxtCntrCustomStyle = isset( $tplateOptns['_lstTxtCntrStyle'] ) ? esc_attr( $tplateOptns['_lstTxtCntrStyle'][0] ) : '';

    $custCls = abcfsl_util_pg_type_cls_bldr( $lstTxtCntrCustomCls, $isSingle );

    $div = abcfsl_cnt_list_txt_cntr_div( $colSize, $pfix, 'Lst1Txt', $custCls, $lstTxtCntrCustomStyle, $vAidCls, $isSingle );

    //List of all fields in sort order. Get all text lines for a single record.
    $fieldOrder = abcfsl_util_field_order( $tplateOptns, $isSingle );

    foreach ( $fieldOrder as $F ) {
        $txtFieldsHTML .= abcfsl_cnt_txt_field($itemOptns, $tplateOptns, $itemID, $sPageUrl, $F, $isSingle, $pfix );
    }
    return $div['cntrS'] . $txtFieldsHTML . $div['cntrE'];
}

//Text section div.
function abcfsl_cnt_list_txt_cntr_div( $colSize, $pfix, $colBaseCls, $customCls, $customStyle, $vAidCls, $isSingle ){

    $colCls = ' ' . $pfix . $colBaseCls . 'Col';

    $cls = $pfix . 'PadLRPc0767';
    if( !$isSingle ){ $cls = $pfix . 'TxtCenter767 ' . $pfix . 'PadLRPc0767'; }
    if( !empty( $customCls ) ){ $customCls = ' ' . $customCls; }
    $customCls = $customCls . ' ' . $cls;

    //if( empty( $cntrCls ) ) { $cntrCls = 'LstCol'; }
    $cntrCls = 'LstCol';
    $colCls = $pfix . $cntrCls . ' ' . $pfix . $cntrCls . '-' . $colSize . $colCls . $vAidCls;

    $colS = abcfl_html_tag( 'div', '', $colCls, '' );
    $cntrS = abcfl_html_tag( 'div', '', $pfix . $colBaseCls . 'Cntr' . $customCls, $customStyle );

    $div['cntrS'] = $colS . $cntrS;
    $div['cntrE'] = abcfl_html_tag_ends( 'div,div');

    return $div;
}
//=== Text section: List, Grid B, Single. END ====================================

function abcfsl_cnt_generic_div( $pfix, $baseCls, $customCls, $customStyle, $vAidCls, $divID, $itemID, $addItemCls, $isSingle ){

    $cntrCls = abcfsl_cnt_class_bldr( $pfix, $baseCls, $customCls, $isSingle, $vAidCls, $addItemCls, $itemID );

    $div['cntrS'] = abcfl_html_tag( 'div', $divID, $cntrCls, $customStyle );
    $div['cntrE'] = abcfl_html_tag_end( 'div');

    return $div;
}

//------------------------------------------------------------------------------------------
//Returns classes
function abcfsl_cnt_class_bldr( $pfix, $baseCls, $customCls, $isSingle=false, $vAidCls='', $addItemCls='N', $itemID='0' ){

    $cntrBaseCls = '';
    if( !empty( $baseCls ) ){ $cntrBaseCls = $pfix . $baseCls; }
    if( !empty( $vAidCls ) ){ $vAidCls = ' ' . $pfix . $vAidCls; }
    $custCls = abcfsl_util_pg_type_cls_bldr( $customCls, $isSingle );

    $itemCls = '';
    if($addItemCls == 'Y'){ $itemCls = ' ' . $cntrBaseCls . '_' . $itemID; }

    return  trim( $cntrBaseCls . ' ' . $custCls . $vAidCls . $itemCls );
}



