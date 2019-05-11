<?php
/*
 */
add_filter( 'wp_insert_post_data','abcfsl_autil_untrash_tplate', 10, 2 );

//Don't delete a template it has Staff Members.
function abcfsl_autil_untrash_tplate($data, $postarr ){

    $out = abcfsl_autil_post_type ( $data['post_type'] );
    if( $out == 1){
        switch ( $data['post_status'] ) {
        case 'trash' :
            if( abcfsl_dba_chidren_qty( $postarr['ID'] ) > 0 ){
                wp_die(abcfsl_txta(327) );
                exit;
            }
            break;
        default:
            break;
        }
    }
    return $data;
}
//==============================================================

//Called from abcfolio-staff-list.php. remove_permalink , remove_post_edit_links
function abcfsl_autil_post_type ( $postType ){
    $out = 0;

    switch ($postType) {
        case 'cpt_staff_lst':
            $out = 1;
            break;
        case 'cpt_staff_lst_item':
            $out = 2;
            break;
        default:
            break;
    }
    return $out;
}

//=======================================================================
//???????????????????????????????????????
function abcfsl_autil_show_field_for_field_order( $showFieldOn, $fieldTypeH, $isSingle ){

    $out = false;

    //Hidden field. Fileld type. N = field not selected yet.
    //For SL value of Show/Hide
    if($fieldTypeH == 'N'){ return $out; }

    switch ( $showFieldOn ) {
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

function abcfsl_autil_show_field_for_data_input( $showFieldOn, $isSingle ){

    $out = 0;

    switch ( $showFieldOn ) {
    case 'Y':
        if( $isSingle ){ $out = 2; }
        else { $out = 1; }
        break;
    case 'L':
        if( $isSingle ){ $out = 0; }
        else { $out = 1; }
        break;
    case 'S':
        if( $isSingle ){ $out = 1; }
        else { $out = 0; }
        break;
    default:
        break;
    }

    return $out;
}

//== UPDATE FIELD ORDER - START ===================================================
//Add new field to meta fields order. If field already exists exit with no updates.
//Called from save template.
function abcfsl_autil_add_new_field_to_field_order( $tplatID, $showField, $showOn, $F ){

    $show = false;
    if ( $F == 'SPTL' || $F == 'SL' ){
        //$showField N, Y, H
        switch ( $showField ) {
            case 'Y':
            case 'H':
                $show = true;
                break;
            default:
                return;
        }
    }
    else{
        //Hide/Delete N, H, D
        switch ( $showField ) {
            case 'N':
            case 'H':
                $show = true;
                break;
            default:
                return;
        }
    }

    if( !$show ) { return ; }

    //Show On Y, L, S
    switch ( $showOn ) {
        case 'Y':
            abcfsl_autil_update_field_order_wrap( $tplatID, $F, false );
            abcfsl_autil_update_field_order_wrap( $tplatID, $F, true );
            break;
        case 'L':
            abcfsl_autil_update_field_order_wrap( $tplatID, $F, false );
            break;
        case 'S':
            abcfsl_autil_update_field_order_wrap( $tplatID, $F, true );
            break;
        default:
            break;
    }
}

//Update meta field order. Add new field. If field already exists exit with no updates.
function abcfsl_autil_update_field_order_wrap( $tplatID, $F, $isSingle ){

    $tplateOptns = get_post_custom( $tplatID );
    $fieldOrderL = isset( $tplateOptns['_fieldOrder'] ) ? $tplateOptns['_fieldOrder'][0] : '';

    if( $isSingle ){
        $fieldOrderS = isset( $tplateOptns['_fieldOrderS'] ) ? $tplateOptns['_fieldOrderS'][0] : '';
        abcfsl_autil_update_field_order( $tplatID, '_fieldOrderS', $fieldOrderS, $fieldOrderL, $F );
    }
    else {
        abcfsl_autil_update_field_order( $tplatID, '_fieldOrder', $fieldOrderL, $fieldOrderL, $F );
    }
}

//Add new field to meta: fields order. If field already exists exit with no updates.
function abcfsl_autil_update_field_order( $postID, $metaFieldName, $dataToUpdate, $fieldOrderL, $F ){

    $metaToUpdateExists = true;

    //Check if new meta field exists. Empty or populated.
    if( empty( $dataToUpdate ) ){
        $metaToUpdateExists = false;
    }

    //There is already metadata. Update it
    if( $metaToUpdateExists ){
        abcfsl_autil_update_meta_field_order( $postID, $metaFieldName, $dataToUpdate, $F );
        return;
    }

    //Check if L meta exists.
    if( empty( $fieldOrderL ) ){ $metaToUpdateExists = false; }

    //No meta exists. Add a new meta + new field. Exit.
    if( !$metaToUpdateExists ){
        abcfsl_autil_add_meta_field_order( $postID, $metaFieldName, $F );
        return;
    }


    //No new meta but there is a legacy data. Copy legacy meta to new meta. Add new field to new meta.
    abcfsl_autil_add_meta_field_order_from_legacy( $postID, $metaFieldName, $fieldOrderL, $F );

}

//No legacy and no new. Add new option with a single field (first one)
function abcfsl_autil_add_meta_field_order( $postID, $metaFieldName, $F ){

    $metaValue[1] = $F;
    update_post_meta( $postID, $metaFieldName, $metaValue );
}


//Meta field exists.
function abcfsl_autil_update_meta_field_order( $postID, $metaFieldName, $metaData, $F ){

    //meta field exists.
    //Check if field is already present in an array if so exit. Otherwise add a new field and exit.

        $metaDataArray = unserialize( $metaData );

        //Check if field is already in an array. If so exit.
        if (in_array($F, $metaDataArray)) {
            return;
        }

        for ( $i = 1; $i <= 11; $i++ ) {

            //Add new field to first available key and exit.
            if(!isset($metaDataArray[$i])){
               $metaDataArray[$i] = $F;
               update_post_meta( $postID, $metaFieldName, $metaDataArray );
               return;
            }
        }
}

//No new but we got legacy.
function abcfsl_autil_add_meta_field_order_from_legacy( $postID, $metaFieldName, $fieldOrderL, $F ){

    //------------------------------------------------------------
    //If we are still not done it means that legacy field order exists and no new field order has been created.
    //Copy legacy to new meta
    //Update new meta.

    $metaDataArray = unserialize( $fieldOrderL );

    //Copy legacy to new meta
    update_post_meta( $postID, $metaFieldName, $metaDataArray );

    abcfsl_autil_update_meta_field_order( $postID, $metaFieldName, $fieldOrderL, $F );
}
//== UPDATE FIELD ORDER - END ===================================================

function abcfsl_autil_update_menu_order( $parentID, $sortType ) {

    if(empty($sortType)){ return; }
    if($sortType != 'T'){ return; }

    $postIDs = abcfsl_dba_get_post_children_ids($parentID);
    $orderBy = array();

    if ( $postIDs ) {
        foreach ( $postIDs as $itemID ) {
            $sortTxt = get_post_meta ( $itemID, '_sortTxt', true );
            $orderBy[$itemID] = $sortTxt;
        }
    }

    if(empty($orderBy)) { return; }
    asort($orderBy);
    $menuOrder = 0;

    foreach( $orderBy as $postID => $value ) {
        $menuOrder++;
        abcfsl_dba_update_menu_order( $postID, $parentID, $menuOrder );
    }
}

//== UPDATE FIELD ORDER - END ===================================================

//Generic class + style  section.
function abcfsl_autil_class_and_style( $clsName, $clsValue, $styleName, $styleValue, $F,
        $addHdr, $hline='', $clsLbl='', $styleLbl='', $clsHelp='',
        $styleHelp='', $aurl=2, $customHdrID='' ){

    //$hdr = true; Generic header is added to CSS section.
    //$customHdrID=''; Custom header is added to CSS section.
    //$aurl = 0; No ? icon.
    //If field label or text parameter is blank, defaults are shown.

    //Default labels and descriptions
    if ( empty( $clsLbl ) ) { $clsLbl = 323; }
    if ( empty( $styleLbl ) ) { $styleLbl = 289; }
    if ( empty( $clsHelp ) ) { $clsHelp = 223; }
    if ( empty( $styleHelp ) ) { $styleHelp = 224; }

    //Default text of a header.
    $hdrTxt = 202;
    if( !empty( $customHdrID ) ) {
        $addHdr = true;
        $hdrTxt = $customHdrID;
    }

    if( !empty( $hline ) ) { echo abcfl_input_hline( $hline ); }

    //? Icon is added to Header label or Class label.
    $lbl = abcfsl_txta( $clsLbl );
    if( $addHdr ) {
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta( $hdrTxt ), abcfsl_aurl( $aurl ) );
    }
    else{
        $lbl = abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta( $clsLbl ), abcfsl_aurl( $aurl ), 'abcflFontWP abcflFontS13 abcflFontW400' );
    }

    echo abcfl_input_txt( $clsName . $F, '', $clsValue, $lbl, abcfsl_txta( $clsHelp ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
    echo abcfl_input_txt( $styleName . $F, '', $styleValue, abcfsl_txta( $styleLbl ), abcfsl_txta( $styleHelp ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
}

