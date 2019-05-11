<?php
//Render  content.
//After removal of legacy code and rename 1
function abcfsl_cnt_list($scodeArgs){

    $clsPfix = $scodeArgs['prefix'];
    $pversion = $scodeArgs['pversion'];
    $tplateID = $scodeArgs['id'];
    $scodeMaster = 0;
    $random = $scodeArgs['random'];
    $staffID = $scodeArgs['staff-id'];
    //------------------------------------------------
    $tplateOptns = get_post_custom( $tplateID );
    $parentID = $tplateID;
    if( $scodeMaster > 0 ){ $parentID = $scodeMaster; }

    $sPageUrl = isset( $tplateOptns['_sPageUrl'] ) ? esc_attr( $tplateOptns['_sPageUrl'][0] ) : '';
    $lstLayout = isset( $tplateOptns['_lstLayout'] ) ? esc_attr( $tplateOptns['_lstLayout'][0] ) : '1';
    $lstCntrW = isset( $tplateOptns['_lstCntrW'] ) ? esc_attr( $tplateOptns['_lstCntrW'][0] ) : '';
    $lstACenter = isset( $tplateOptns['_lstACenter'] ) ? esc_attr( $tplateOptns['_lstACenter'][0] ) : 'Y';
    //$lstCntrTM = isset( $tplateOptns['_lstCntrTM'] ) ? esc_attr( $tplateOptns['_lstCntrTM'][0] ) : '';
    $lstCntrCls = isset( $tplateOptns['_lstCntrCls'] ) ? esc_attr( $tplateOptns['_lstCntrCls'][0] ) : $clsPfix . 'LstCntrBB';
    $lstCntrStyle = isset( $tplateOptns['_lstCntrStyle'] ) ? esc_attr( $tplateOptns['_lstCntrStyle'][0] ) : '';
    $lstImgCls = isset( $tplateOptns['_lstImgCls'] ) ? esc_attr( $tplateOptns['_lstImgCls'][0] ) : $clsPfix . 'ImgCenter';
    $tplateOptns['_lstImgCls'] = array($lstImgCls);

    //$vAid = isset( $tplateOptns['_vAid'] ) ? esc_attr( $tplateOptns['_vAid'][0] ) : 'N';

    if($lstLayout > 2){
         $errMsg1 = 'Shortcode used on this page doesn\'t match the list shortcode.';
         $errMsg2 = 'Go to the list screen an copy shortcode from there.';
         abcfl_util_div_err_msg($errMsg1, $errMsg2);
         return;
    }

    //Plugin container
    //$cntCntrStyle = abcfl_css_w_responsive($lstCntrW, $lstCntrW) . abcfl_css_mt($lstCntrTM) . $lstCntrStyle;
    $cntCntrStyle = abcfl_css_w_responsive($lstCntrW, $lstCntrW) . $lstCntrStyle;
    $centerCls = abcfsl_util_center_cls( $lstACenter, $clsPfix );
    $cntCntrCustomCls = $lstCntrCls . $centerCls . ' ' . $clsPfix . '_v' . $pversion;
    $lstCntr = abcfsl_cnt_generic_div($clsPfix, 'LstCntr', $cntCntrCustomCls, $cntCntrStyle, '', '', $tplateID, 'Y', false);

    //-- Get menu -------------------------------------
    $qryOptns = '';
    //----------------------------------------------------

    //Returns grid items. Takes menu options. Filters grid based on menu options.
    $gridItems = abcfsl_cnt_list_items_html( $parentID, $tplateOptns, $qryOptns, $sPageUrl, $clsPfix, $random, $staffID );

    //Grid Items.
    return $lstCntr['cntrS'] . $gridItems . $lstCntr['cntrE'];
}

//List Items builder.
function abcfsl_cnt_list_items_html( $parentID, $tplateOptns, $qryOptns, $sPageUrl, $clsPfix, $random, $staffID ){

    $listItems  = '';
    $lstItemDefaultCls = $clsPfix . 'PadBMB30';

    $colL = isset( $tplateOptns['_lstCols'] ) ? esc_attr( $tplateOptns['_lstCols'][0] ) : '6';
    $colR = (12 - $colL);
    $vAid = isset( $tplateOptns['_vAid'] ) ? esc_attr( $tplateOptns['_vAid'][0] ) : 'N';

    $lstItemCustomCls = isset( $tplateOptns['_lstItemCls'] ) ? esc_attr( $tplateOptns['_lstItemCls'][0] ) : $lstItemDefaultCls;
    $lstItemStyle = isset( $tplateOptns['_lstItemStyle'] ) ? esc_attr( $tplateOptns['_lstItemStyle'][0] ) : '';

    if( $staffID > 0 ){
        $postIDs = abcfsl_db_staff_member( $staffID );
    }
    else {
        $postIDs = abcfsl_db_staff_member_ids( $parentID, $qryOptns  );
    }

    //$postIDs = abcfsl_db_staff_member_ids( $parentID, $qryOptns  );
    if( $random ){ shuffle($postIDs); }

    //1.Image left, text right; 2.Image top, text bottom;
    if ( $postIDs ) {
        foreach ( $postIDs as $itemID ) {
            $listItems .= abcfsl_cnt_list_item_cntr($itemID, $tplateOptns, $colL, $colR, $vAid, $lstItemCustomCls, $lstItemStyle, $sPageUrl, $clsPfix, '' );
        }
   }
   return $listItems;
}

//-- LIST ITEM ---------------------------------------------------------------------------------------
//List Item container: image left, text right.
function abcfsl_cnt_list_item_cntr( $itemID, $tplateOptns, $colL, $colR, $vAid, $lstItemCustomCls, $lstItemStyle, $sPageUrl, $clsPfix ){

    $vAidCls = '';
    $vAidClsImgCntr = '';
    if( $vAid == 'Y' ) {
        $vAidCls = ' ' . $clsPfix . 'VAidBorder';
        $vAidClsImgCntr = ' ' . $clsPfix . 'VAidBorderR';
    }

    $div = abcfsl_cnt_list_item_cntr_div( $lstItemCustomCls . $vAidCls, $lstItemStyle, $clsPfix );
    $itemOptns = get_post_custom( $itemID );

    $hideSMember = isset( $itemOptns['_hideSMember'] ) ? esc_attr( $itemOptns['_hideSMember'][0] ) : '0';
    if($hideSMember == 1) { return '';}

    $imgCntr = abcfsl_cnt_image_cntr( 1, $itemID, $tplateOptns, $itemOptns, $colL, $clsPfix, $vAidClsImgCntr, $sPageUrl, false );
    $txtSection = abcfsl_cnt_list_txt_section( $itemID, $itemOptns, $tplateOptns, $sPageUrl, $colR, $clsPfix, $vAid, false );

    return $div['itemCntrS'] . $imgCntr . $txtSection . $div['itemCntrE'];
}

function abcfsl_cnt_list_item_cntr_div( $customCls, $lstItemStyle, $clsPfix ){

    $itemCls = '';
    if(!empty($customCls)){ $customCls = ' ' . $customCls; }

    //Item container DIV
    $div['itemCntrS'] = abcfl_html_tag( 'div', '', $clsPfix . 'LstRowCntr' . $customCls . ' abcfClrFix' . $itemCls, $lstItemStyle );
    $div['itemCntrE'] = abcfl_html_tag_end( 'div');

    return $div;
}
