<?php

//Get fieldOrder meta. Convert saved meta to array.
function abcfsl_util_field_order( $tplateOptns, $isSingle=false ){

    $fieldOrder = array();;
    $fieldOrderA = array();

    if( $isSingle ){
        $fieldOrder = isset( $tplateOptns['_fieldOrderS'] ) ? $tplateOptns['_fieldOrderS'][0] : array();;
        if(empty($fieldOrder)){
            $fieldOrder = isset( $tplateOptns['_fieldOrder'] ) ? $tplateOptns['_fieldOrder'][0] : array();;
        }
    }
    else {
        $fieldOrder = isset( $tplateOptns['_fieldOrder'] ) ? $tplateOptns['_fieldOrder'][0] : array();;
    }

    if(empty($fieldOrder)){
        for ( $i = 1; $i <= 10; $i++ ) { 
            $fieldOrderA[$i] = 'F' . $i; 
        }
    }
    else{
        $fieldOrderA = unserialize( $fieldOrder );

        // Array has duplicates
        if(count(array_unique($fieldOrderA)) < count($fieldOrderA)){
            $fieldOrderU = array_unique($fieldOrderA);
            $fieldOrderA = array_combine(range(1, count($fieldOrderU)), array_values($fieldOrderU));
        }
    }

    //[1] => F1 [2] => F4 [3] => F5
    return $fieldOrderA;
}

//Parse custom class string. Returns string of classes: List, Single Page, Both. lst_ spg_
function abcfsl_util_pg_type_cls_bldr( $input, $isSingle ){

    //List only class starts with: 'lst_'
    //Single Page only class starts with: 'spg_'
    $pgType = 'L';
    if( $isSingle ){$pgType = 'S';}

    $cls['clsLst'] = '';
    $cls['clsSpg'] = '';
    $cls['clsBoth'] = '';
    if(empty($input)){ return '';}

    $hasLstCls = false;
    $hasSpgCls = false;

    if (strpos($input,'lst_') !== false) { $hasLstCls = true; }
    if (strpos($input,'spg_') !== false) { $hasSpgCls = true; }
    if(!$hasLstCls && !$hasSpgCls) { return $input; }

    $inputFixed = preg_replace('/\s+/', ' ', $input);
    $clsLst = '';
    $clsSpg = '';
    $clsBoth = '';

    $pieces = explode(' ', $inputFixed);

    foreach($pieces as $value){
        $prefix = substr($value, 0, 4);
        switch ($prefix){
        case 'lst_':
            $clsLst .= substr($value, 4) . ' ';
            break;
        case 'spg_':
            $clsSpg .= substr($value, 4) . ' ';
            break;
        default:
            $clsBoth .= $value . ' ';
            break;
        }
    }

    $out = '';
    switch ($pgType){
        case 'L':
            $out = trim($clsBoth . $clsLst);
            break;
        case 'S':
            $out = trim($clsBoth . $clsSpg);
            break;
        default:
            break;
    }

    return $out;

}
//---------------------------------------------------------------
//Get href parts: url + link text + target for Sinle Page link.
function abcfsl_util_href_bldr_SPTL( $itemUrl, $itemTxt, $pretty, $itemID, $sPageUrl ){

    $out = abcfsl_util_url_selector( $itemID, $itemUrl, $sPageUrl, $pretty );
    if( abcfl_html_isblank( $itemTxt ) ) { $itemTxt = $out['hrefUrl']; }

    $aTag['hrefUrl'] = $out['hrefUrl'];
    $aTag['hrefTxt'] = $itemTxt;
    $aTag['target'] = $out['target'];
    return $aTag;
}

//Get href parts: url + link text. abcfsl_util_a_tag_parts
function abcfsl_util_href_bldr( $itemOptns, $itemID, $sPageUrl, $F ){

    $itemUrl = isset( $itemOptns['_url_' . $F] ) ? esc_attr( $itemOptns['_url_' . $F][0] ) : '';
    $pretty = isset( $itemOptns['_pretty'] ) ? esc_attr( $itemOptns['_pretty'][0] ) : '';

    $out = abcfsl_util_url_selector( $itemID, $itemUrl, $sPageUrl, $pretty );
    $itemTxt = isset( $itemOptns['_urlTxt_' . $F] ) ? esc_attr( $itemOptns['_urlTxt_' . $F][0] ) : '';
    if( abcfl_html_isblank( $itemTxt ) ) { $itemTxt = $out['hrefUrl']; }

    $aTag['hrefUrl'] = $out['hrefUrl'];
    $aTag['hrefTxt'] = $itemTxt;
    $aTag['target'] = $out['target'];
    return $aTag;
}

//Get Single page Url if 'SP' used as url. Otherwise return URL as entered.
function abcfsl_util_url_selector( $itemID, $lnkUrl, $sPageUrl, $pretty ){

    $out['hrefUrl'] = '';
    $out['target'] = '';
    if( abcfl_html_isblank( $lnkUrl ) ) { return $out;}

    if($lnkUrl == 'NT SP') {
        $lnkUrl = 'SP';
        $out['target'] = '_blank';
    }

    if($lnkUrl == 'SP') {
        //If single page url is blank return empty sting.
        if( abcfl_html_isblank( $sPageUrl ) ) { return $out; }

        if( abcfsl_util_is_single_pretty( $sPageUrl, $pretty ) ) {
            $out['hrefUrl'] = trailingslashit( trailingslashit( $sPageUrl ) . $pretty ) ;
            return $out;
        }
        else {
            //Add staff member ID single page url.
            $out['hrefUrl'] = abcfl_html_url( array('smid' => $itemID), $sPageUrl );
            return $out;
        }
    }

    $out = abcfsl_util_get_target( $lnkUrl );
    return $out;
}


//URL builder for staff page. Check if single page URL is ready for pretty permalink
function abcfsl_util_is_single_pretty( $sPageUrl, $pretty ){

    if( empty( $pretty ) ) { return false; }

    if( strlen( $sPageUrl ) < 10 ) { return false; }
    $sPageUrl = rtrim( $sPageUrl, '/' );

    if( substr($sPageUrl, -3) == 'bio' ) { return true; }
    if( substr($sPageUrl, -7) == 'profile' ) { return true; }
    if( substr($sPageUrl, -6) == 'profil' ) { return true; }
    if( substr($sPageUrl, -7) == 'profilo' ) { return true; }
    if( substr($sPageUrl, -6) == 'perfil' ) { return true; }

    $out = false;
    if( function_exists( 'abcfslcp_is_single_pretty' )){
       $out = abcfslcp_is_single_pretty( $sPageUrl );
    }

    return $out;
}

//Get staffMemberID when rewrite is implemented
function abcfsl_util_staff_member_id ( $scodeArgs ){

    $staffID = (int)$scodeArgs['staff-id'];
    if( $staffID > 0 ){ return $staffID; }

    $smid = (int)$scodeArgs['smid'];
    $staffName= $scodeArgs['staff-name'];
    $staffMemberID = 0;

    if( $smid > 0) { return $smid; }
    if( empty( $staffName ) ) { return 0; }

    //?smid=63561
    if( !empty( $staffName ) & strlen( $staffName ) > 6 ){
        if ( substr($staffName, 0, 6) == '?smid=' ){ return (int) substr( $staffName, 6 ); }
        $staffMemberID = abcfsl_db_post_id_by_pretty( $staffName );
    }
    return $staffMemberID;
}

//--------------------------------------------------------
//Check for NT-new tab.
function abcfsl_util_get_target( $url ){

    $out['hrefUrl'] = $url;
    $out['target'] = '';
    if( abcfl_html_isblank( $url ) ) { return $out; }

    if(strlen($url) < 4) { return $out; }

    $targetNT = substr( $url, 0, 2 );
    if( $targetNT == 'NT' ) {
        $out['hrefUrl'] = trim( substr( $url, 2 ) );
        $out['target'] = '_blank';
    }
    return $out;
}

//----------------------------------------------
//Return class name or empty string. Used for cbos Class: None, Custom or Selected.
function abcfsl_util_cls_name_ncd_bldr( $optnValue, $clsBaseName, $clsPfix, $default='' ){

    if( $optnValue == 'N' || $optnValue == 'C'|| $optnValue == 'D' ){ return ''; }
    if( empty( $optnValue ) ) { $optnValue = $default; }
    if( empty( $optnValue) ) { return ''; }
    return $clsPfix . $clsBaseName . $optnValue;
}

//Return empty if N or C.
function abcfsl_util_cls_name_nc_bldr( $optnValue, $clsBaseName, $clsPfix, $default='' ){

    if( $optnValue == 'N' || $optnValue == 'C' ){ return ''; }
    if( $optnValue == 'D' ) { $optnValue = $default; }
    if( empty( $optnValue ) ) { $optnValue = $default; }
    if( empty( $optnValue) ) { return ''; }
    return ' ' . $clsPfix . $clsBaseName . $optnValue;
}

function abcfsl_util_center_yn( $fieldName, $aCenter, $lbl=83, $hlp=295 ){

    $cboYN = abcfsl_cbo_yn();
    echo abcfl_input_cbo( $fieldName, '',$cboYN, $aCenter, abcfsl_txta($lbl), abcfsl_txta($hlp), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl' );
}

function abcfsl_util_center_cls( $centerYN, $clsPfix ){
    $out = '';
    if( $centerYN == 'Y' ) { $out = ' ' . $clsPfix . 'MLRAuto'; }
    return $out;
}

function abcfsl_util_img_center_cls( $centerYN, $clsPfix ){
    $out = '';
    if( $centerYN == 'Y' ) { $out = ' ' . $clsPfix . 'ImgCenter'; }
    return $out;
}