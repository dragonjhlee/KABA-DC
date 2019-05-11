<?php
//FREE
function abcfsl_mbox_item_img( $imgUrlL, $imgLnkL, $imgUrlS, $imgIDL, $imgIDS, $imgAlt, $overTxtI1, $overTxtI2 ){

    $imgUrlSTag = $imgUrlS;
    if( $imgUrlS == 'SP' ) {
        $imgUrlSTag = $imgUrlL;
    }

    echo  abcfl_html_tag('div','','inside hidden');

        //-- Image: Staff Page ------------------------------------------------
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(310), abcfsl_aurl(50) );
        echo abcfl_html_img_tag('', $imgUrlL, '', '', 200, '', 'abcflMTop15');

        //-- imgUrlL itemImgUrl -----------------------------------------------
        echo abcfl_html_tag_cls('div', 'abcflFloatsCntr');
        echo abcfl_input_txt('imgUrlL', '', $imgUrlL, abcfsl_txta(312), '', '100%', '', '', 'abcflFloatL abcflWidth89Pc', 'abcflFldLbl');
        echo abcfl_input_txt_dr('readonly', true, 'imgIDL', '', $imgIDL, abcfsl_txta(35), '', '100%', '', '', 'abcflFloatL abcflWidth10Pc', 'abcflFldLbl');
        echo abcfl_html_tag_cls('div', 'abcflClr', true);
        echo abcfl_html_tag_end('div');

        echo  abcfl_html_tag('div','','abcflPTop10');
            echo abcfl_input_btn('btnImgL', 'btnImgL', 'button',  abcfsl_txta(263), 'button' );
        echo abcfl_html_tag_end('div');

        $lbl = abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(186), abcfsl_aurl(49), 'abcflFontWP abcflFontS13 abcflFontW400' );
        echo abcfl_input_txt( 'imgAlt', '', $imgAlt, $lbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
        //-------------------------------------------------------------
        $lbl = abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(261), abcfsl_aurl(66), 'abcflFontWP abcflFontS13 abcflFontW400' );
        echo abcfl_input_txt('imgLnkL', '', $imgLnkL,  $lbl, abcfsl_txta(262), '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');        
        //echo abcfl_input_txt('imgLnkL', '', $imgLnkL, abcfsl_txta(261), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
        //echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(262), abcfsl_aurl(34), 'abcflFontWPHdr abcflFontS12 abcflFontW400' );

        //-- Image: Single Page ------------------------------------------------
        echo abcfl_input_hline('2');
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(311), abcfsl_aurl(67) );
        echo abcfl_html_img_tag('', $imgUrlSTag, '', '', 200, '', 'abcflMTop15');

        echo abcfl_html_tag_cls('div', 'abcflFloatsCntr');
        echo abcfl_input_txt('imgUrlS', '', $imgUrlS, abcfsl_txta(312), abcfsl_txta(284), '100%', '', '', 'abcflFloatL abcflWidth90Pc', 'abcflFldLbl');
        echo abcfl_input_txt_dr('readonly', true, 'imgIDS', '', $imgIDS, abcfsl_txta(35), '', '100%', '', '', 'abcflFloatL abcflWidth10Pc', 'abcflFldLbl');
        echo abcfl_html_tag_cls('div', 'abcflClr', true);
        echo abcfl_html_tag_end('div');

        echo  abcfl_html_tag('div','','abcflPTop10');
            echo abcfl_input_btn('btnImgS', 'btnImgS', 'button',  abcfsl_txta(263), 'button' );
        echo abcfl_html_tag_end('div');

        //echo abcfsl_mbox_item_img_overlay_txt( $overTxtI1, $overTxtI2 );

    echo abcfl_html_tag_end('div');
}

//== IMG ID ====================================================
function abcfsl_mbox_item_img_id( $imgUrl ){

    if( empty( $imgUrl ) ){ return 0; }

    $imageID = abcfsl_mbox_item_img_id_by_url( $imgUrl );
    return $imageID;
}

//Get image ID by different methods. If not found return 0.
function abcfsl_mbox_item_img_id_by_url( $imgUrl ){

    $imageID = abcfsl_mbox_item_img_id_by_guid( $imgUrl );
    if( $imageID > 0 ) { return $imageID; }

    $imageID = abcfsl_mbox_item_img_attachment_url_to_postid( $imgUrl );
    if( $imageID > 0 ) { return $imageID; }
    //return $imageID;

    $imageID = abcfsl_mbox_item_img_relative( $imgUrl );
    //if( $imageID > 0 ) { return $imageID; }
    return $imageID;

    //return $imgIDLS;

}

function abcfsl_mbox_item_img_id_by_guid( $imgUrl ){

    global $wpdb;

    //Full size image.
    $imageID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $imgUrl ));
    if( $imageID > 0 ) { return $imageID; }

    // If the URL is auto-generated thumbnail, remove the sizes and get the URL of the original image
    $url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $imgUrl );
    $imageID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));

    return $imageID;
}

function abcfsl_mbox_item_img_attachment_url_to_postid( $imgUrl ) {

    //Return (int). The found post ID, or 0 on failure.
    $imageID = attachment_url_to_postid( $imgUrl );
    if( $imageID > 0 ) { return $imageID; }

    $url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $imgUrl );
    return attachment_url_to_postid( $url );
}

function abcfsl_mbox_item_img_relative( $imgUrl ) {

    //http://localhost:8080/blog
    $siteURL = get_site_url();

    $url = ltrim( $imgUrl, '/\\' );

    $fullURL = trailingslashit( $siteURL ) . $url;

    $imageID = abcfsl_mbox_item_img_attachment_url_to_postid( $fullURL );
    return $imageID;
}

//=========================================
function abcfsl_mbox_item_img_overlay_txt( $overTxtI1, $overTxtI2){

    echo abcfl_input_hline('2');
    echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(273) . ' ' . abcfsl_txta(9), abcfsl_aurl(51) );

    echo abcfl_input_txt( 'overTxtI1', '', $overTxtI1, abcfsl_txta(43)  . ' 1', '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
    echo abcfl_input_txt( 'overTxtI2', '', $overTxtI2,  abcfsl_txta(43) . ' 2', '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
}


//###########################################################
function abcfsl_mbox_item_img_OLD( $imgUrlL, $imgLnkL, $imgUrlS, $imgIDL, $imgIDS ){

    $imgUrlSTag = $imgUrlS;
    if( $imgUrlS == 'SP' ) {
        $imgUrlSTag = $imgUrlL;
        $imgIDS = 0;
    }
    else{
        if( empty($imgUrlL) ){
            $imgIDL = 0;
        }
        else {
             $imgIDS = abcfsl_mbox_item_img_img_by_url( $imgUrlS );
        }
    }

    if( empty($imgUrlL) ){
        $imgIDL = 0;
    }
    else {
        $imgIDL = abcfsl_mbox_item_img_img_by_url( $imgUrlL );
    }

    echo  abcfl_html_tag('div','','inside hidden');

        //-- Image: Staff Page ------------------------------------------------
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(310), abcfsl_aurl(0) );
        echo abcfl_html_img_tag('', $imgUrlL, '', '', 200, '', 'abcflMTop15');

        //-- imgUrlL itemImgUrl -----------------------------------------------
        echo abcfl_html_tag_cls('div', 'abcflFloatsCntr');
        echo abcfl_input_txt('imgUrlL', '', $imgUrlL, abcfsl_txta(312), '', '100%', '', '', 'abcflFloatL abcflWidth89Pc', 'abcflFldLbl');
        echo abcfl_input_txt_dr('readonly', true, 'imgIDL', '', $imgIDL, abcfsl_txta(35), '', '100%', '', '', 'abcflFloatL abcflWidth10Pc', 'abcflFldLbl');
        echo abcfl_html_tag_cls('div', 'abcflClr', true);
        echo abcfl_html_tag_end('div');

        echo  abcfl_html_tag('div','','abcflPTop10');
            echo abcfl_input_btn('btnImgL', 'btnImgL', 'button',  abcfsl_txta(263), 'button' );
        echo abcfl_html_tag_end('div');
        //-------------------------------------------------------------
        echo abcfl_input_txt('imgLnkL', '', $imgLnkL, abcfsl_txta(261), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(262), abcfsl_aurl(34), 'abcflFontWPHdr abcflFontS12 abcflFontW400' );

        //-- Image: Single Page ------------------------------------------------
        echo abcfl_input_hline('2');
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(311), abcfsl_aurl(0) );
        echo abcfl_html_img_tag('', $imgUrlSTag, '', '', 200, '', 'abcflMTop15');

        echo abcfl_html_tag_cls('div', 'abcflFloatsCntr');
        echo abcfl_input_txt('imgUrlS', '', $imgUrlS, abcfsl_txta(312), abcfsl_txta(284), '100%', '', '', 'abcflFloatL abcflWidth90Pc', 'abcflFldLbl');
        echo abcfl_input_txt_dr('readonly', true, 'imgIDS', '', $imgIDS, abcfsl_txta(35), '', '100%', '', '', 'abcflFloatL abcflWidth10Pc', 'abcflFldLbl');
        echo abcfl_html_tag_cls('div', 'abcflClr', true);
        echo abcfl_html_tag_end('div');

        echo  abcfl_html_tag('div','','abcflPTop10');
            echo abcfl_input_btn('btnImgS', 'btnImgS', 'button',  abcfsl_txta(263), 'button' );
        echo abcfl_html_tag_end('div');

    echo abcfl_html_tag_end('div');
}

function abcfsl_mbox_item_img_img_by_url_OLD( $url ){

    global $wpdb;
    $imageID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));
    if( !empty( $imageID ) ) { return $imageID; }

    // If the URL is auto-generated thumbnail, remove the sizes and get the URL of the original image
    $url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url );
    $imageID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));
    if( !empty( $imageID ) ) { return $imageID; }

    return 0;
}

