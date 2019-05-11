<?php
//Render Single Page content.
function abcfsl_cnt_spage( $scodeArgs ){

    $clsPfix = $scodeArgs['prefix'];
    $pversion = $scodeArgs['pversion'];
    $tplateID = $scodeArgs['id'];
    $staffMemberID = abcfsl_util_staff_member_id ( $scodeArgs );

    //Both qry args are missing. Show blank page. // TODO ADD ERROR HANDLER
    if( $staffMemberID == 0 ) {
        return abcfl_html_tag_with_content( abcfsl_txt(1) . abcfsl_txt(4), 'p', '' );
    }
    //---------------------------------

    $tplateOptns = get_post_custom( $tplateID );
    $pgLayout = isset( $tplateOptns['_singleLayout'] ) ? esc_attr( $tplateOptns['_singleLayout'][0] ) : '1';
    $spgCntrW = isset( $tplateOptns['_spgCntrW'] ) ? esc_attr( $tplateOptns['_spgCntrW'][0] ) : '';
    $spgACenter = isset( $tplateOptns['_spgACenter'] ) ? esc_attr( $tplateOptns['_spgACenter'][0] ) : 'Y';

    //$spgCntrTM = isset( $tplateOptns['_spgCntrTM'] ) ? esc_attr( $tplateOptns['_spgCntrTM'][0] ) : '';
    $spgCntrCls = isset( $tplateOptns['_spgCntrCls'] ) ? esc_attr( $tplateOptns['_spgCntrCls'][0] ) : '';
    $spgCntrStyle = isset( $tplateOptns['_spgCntrStyle'] ) ? esc_attr( $tplateOptns['_spgCntrStyle'][0] ) : '';

    $addItemCls = isset( $tplateOptns['_icls'] ) ? esc_attr( $tplateOptns['_icls'][0] ) : 'N';
    $vAid = isset( $tplateOptns['_vAid'] ) ? esc_attr( $tplateOptns['_vAid'][0] ) : 'N';

    //---------------------------------------------------------------
    // TODO
    $cntrStyle = abcfl_css_w_responsive($spgCntrW, $spgCntrW) . $spgCntrStyle;

    $vAidCls = '';
    if( $vAid == 'Y' ) { $vAidCls = ' ' . $clsPfix . 'VAidBorder'; }

    $centerCls = abcfsl_util_center_cls( $spgACenter, $clsPfix );
    //$cntCntrCustomCls = $spgCntrCls . $centerCls . $vAidCls;
    $cntCntrCustomCls = $spgCntrCls . $centerCls . ' ' . $clsPfix . '_v' . $pversion . $vAidCls;
    

    //Single Page container
    $spgCntr = abcfsl_cnt_generic_div($clsPfix, 'SPgCntr', $cntCntrCustomCls, $cntrStyle, '', '', $tplateID, 'Y', true);

    //1.Image left, text right; 2.Image top, text bottom;
    switch ($pgLayout) {
        case 1:
            $pgCnt = abcfsl_cnt_spage_cnt_1($staffMemberID, $tplateOptns, $vAid, $clsPfix, $pgLayout, $addItemCls);
            break;
        default:
            break;
    }

    //Return Grid container + all items.
    return $spgCntr['cntrS'] . $pgCnt . $spgCntr['cntrE'];
}

//Item container: List, image left, text right.
function abcfsl_cnt_spage_cnt_1( $staffMemberID, $tplateOptns, $vAid, $clsPfix, $pgLayout, $addItemCls ){

    $colL = isset( $tplateOptns['_spgCols'] ) ? esc_attr( $tplateOptns['_spgCols'][0] ) : '6';
    $colR = (12 - $colL);

    //Check if post has been published ----
    $postStatus = get_post_status( $staffMemberID );
    if( $postStatus != 'publish' ) {
        return '';
    }

    $itemOptns = get_post_custom( $staffMemberID );
    if( empty($itemOptns) ) {
        //Why single page is blank.
        return abcfl_html_tag_with_content( abcfsl_txt(1) . abcfsl_txt(3), 'p', '' );
    }


    $hideSMember = isset( $itemOptns['_hideSMember'] ) ? esc_attr( $itemOptns['_hideSMember'][0] ) : '0';
    if($hideSMember == 1) { return '';}
    //-----------------------------------------------
    $imgCntr = abcfsl_cnt_spage_img_cntr( $staffMemberID, $tplateOptns, $itemOptns, $colL, $clsPfix, $pgLayout, $vAid );

    //abcfsl_cnt_list_txt_section( $itemID, $itemOptns, $tplateOptns, $sPageUrl, $colSize, $clsPfix, $vAid, $isSingle )
    $txtHTML = abcfsl_cnt_spage_txt_section( $staffMemberID, $itemOptns, $tplateOptns, $colR, $clsPfix, $vAid );

    $spgCntrT = abcfsl_cnt_generic_div($clsPfix, '', '', '', '', '', '', 'N', true);
    //$spgCntrM = abcfsl_cnt_generic_div($clsPfix, 'SPgCntrM abcfClrFix', '', '', '', '', '', 'N', true);
    $spgCntrB = abcfsl_cnt_generic_div($clsPfix, '', '', '', '', '', '', 'N', true);


    if( !empty( $txtHTML['T'] ) ) { $txtHTML['T'] =  $spgCntrT['cntrS'] . $txtHTML['T'] . $spgCntrT['cntrE']; }
    
    //if( !empty( $txtHTML['M'] ) ) {
    //-- Middle section. Fix for no text section. Image only.
    if( !empty( $txtHTML['M'] ) || !empty( $imgCntr ) ) {
        $spgMMarginT = isset( $tplateOptns['_spgMMarginT'] ) ? esc_attr( $tplateOptns['_spgMMarginT'][0] ) : 'N';
        $spgCntrM = abcfsl_cnt_spage_txt_cntr_m( $spgMMarginT, '', '', $clsPfix );

        $txtHTML['M'] =  $spgCntrM['cntrS'] . $imgCntr . $txtHTML['M'] . $spgCntrM['cntrE'];
    }

    if( !empty( $txtHTML['B'] ) ) { $txtHTML['B'] =  $spgCntrB['cntrS'] . $txtHTML['B'] . $spgCntrB['cntrE']; }

    return $txtHTML['T'] . $txtHTML['M'] . $txtHTML['B'];
}

function abcfsl_cnt_spage_txt_cntr_m( $spgMMarginT, $customCls, $cntrStyle, $clsPfix ){

    $clsTM = abcfsl_util_cls_name_ncd_bldr( $spgMMarginT, 'MT', $clsPfix );
    $baseCls = trim ( 'SPgCntrM abcfClrFix '  . $clsTM);
    return abcfsl_cnt_generic_div( $clsPfix, $baseCls, $customCls, $cntrStyle, '', '', '', 'N', true);
}

function abcfsl_cnt_social_cntr_cls_TEMP( $socialTM, $customCls, $cntrStyle, $clsPfix, $isSingle ){

    $clsTM = abcfsl_util_cls_name_ncd_bldr( $socialTM, 'MT', $clsPfix );
    $baseCls = trim ( 'SocialIconsA '  . $clsTM);
    return abcfsl_cnt_generic_div( $clsPfix, $baseCls, $customCls, $cntrStyle, '', '', '', 'N', $isSingle);
}


function abcfsl_cnt_spage_img_cntr( $staffMemberID, $tplateOptns, $itemOptns, $colL, $clsPfix, $pgLayout, $vAid ){

    $vAidClsImgCntr = '';
    if( $vAid == 'Y' ) { $vAidClsImgCntr = ' ' . $clsPfix . 'VAidBorderR'; }
    $itemOptns['_imgLnkL'] = array('');

    $imgUrlS = isset( $itemOptns['_imgUrlS'] ) ? esc_attr( $itemOptns['_imgUrlS'][0] ) : '';
    if($imgUrlS != 'SP'){
        $itemOptns['_imgUrlL'] = array( $imgUrlS );

        $imgIDS = isset( $itemOptns['_imgIDS'] ) ? esc_attr( $itemOptns['_imgIDS'][0] ) : 0;
        $itemOptns['_imgIDL'] = array( $imgIDS );
    }
    //-------------------------------------------------
    return abcfsl_cnt_image_cntr( $pgLayout, $staffMemberID, $tplateOptns, $itemOptns, $colL, $clsPfix, $vAidClsImgCntr, '', true  );
}

//Container + text fields.
function abcfsl_cnt_spage_txt_section( $itemID, $itemOptns, $tplateOptns, $colSize, $clsPfix, $vAid ){

    $outHTML['T'] = '';
    $outHTML['M'] = '';
    $outHTML['B'] = '';
    $vAidCls = '';
    if( $vAid == 'Y' ) { $vAidCls = ' ' . $clsPfix . 'VAidTxt'; }

    $lstTxtCntrCustomCls = isset( $tplateOptns['_lstTxtCntrCls'] ) ? esc_attr( $tplateOptns['_lstTxtCntrCls'][0] ) : $clsPfix . 'PadLPc5';
    $lstTxtCntrCustomStyle = isset( $tplateOptns['_lstTxtCntrStyle'] ) ? esc_attr( $tplateOptns['_lstTxtCntrStyle'][0] ) : '';

    $custCls = abcfsl_util_pg_type_cls_bldr( $lstTxtCntrCustomCls, true );
    $divMiddle = abcfsl_cnt_list_txt_cntr_div( $colSize, $clsPfix, 'Lst1Txt', $custCls, $lstTxtCntrCustomStyle, $vAidCls, true );

    //List of all fields in sort order. Get all text lines for a single record.
    $fieldOrder = abcfsl_util_field_order( $tplateOptns, true );

    $tplateOptnsFixed = abcfsl_cnt_spage_set_field_style( $tplateOptns, $fieldOrder );

    foreach ( $fieldOrder as $F ) {

        $fieldCntrSPg = isset( $tplateOptns['_fieldCntrSPg_' . $F] ) ? esc_attr( $tplateOptns['_fieldCntrSPg_' . $F][0] ) : 'M';

        switch ($fieldCntrSPg) {
            case 'M':
                $outHTML['M'] .= abcfsl_cnt_txt_field( $itemOptns, $tplateOptnsFixed, $itemID, '', $F, true, $clsPfix );
                break;
            case 'T':
                 $outHTML['T'] .= abcfsl_cnt_txt_field( $itemOptns, $tplateOptnsFixed, $itemID, '', $F, true, $clsPfix );
                break;
            case 'B':
                $outHTML['B'] .= abcfsl_cnt_txt_field( $itemOptns, $tplateOptnsFixed, $itemID, '', $F, true, $clsPfix );
                break;
            default:
                break;
        }
    }

    if( !empty( $outHTML['M'] ) ) { $outHTML['M'] =  $divMiddle['cntrS'] . $outHTML['M'] . $divMiddle['cntrE']; }

    return $outHTML;
}

function abcfsl_cnt_spage_set_field_style( $tplateOptns, $fieldOrder ){

    foreach ( $fieldOrder as $F ) {
        $tagTypeSPg = isset( $tplateOptns['_tagTypeSPg_' . $F] ) ? esc_attr( $tplateOptns['_tagTypeSPg_' . $F][0] ) : '';
        $tagFontSPg = isset( $tplateOptns['_tagFontSPg_' . $F] ) ? esc_attr( $tplateOptns['_tagFontSPg_' . $F][0] ) : '';
        $tagMarginTSPg = isset( $tplateOptns['_tagMarginTSPg_' . $F] ) ? esc_attr( $tplateOptns['_tagMarginTSPg_' . $F][0] ) : '';

        if( !empty( $tagTypeSPg ) ) { $tplateOptns['_tagType_' . $F][0] = $tagTypeSPg; }
        if( !empty( $tagFontSPg ) ) { $tplateOptns['_tagFont_' . $F][0] = $tagFontSPg; }
        if( !empty( $tagMarginTSPg ) ) { $tplateOptns['_tagMarginT_' . $F][0] = $tagMarginTSPg; }
    }

    return $tplateOptns;
}
