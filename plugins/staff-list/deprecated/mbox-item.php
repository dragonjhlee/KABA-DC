<?php
function abcfsl_mbox_item(){
    global $post;
    $postID = $post->ID;
    $itemOptns = get_post_custom( $postID );
    $lstID = $post->post_parent;
    $tplateOptns = get_post_custom( $lstID );
    $fieldOrder = abcfsl_util_field_order( $tplateOptns );

//--------------------------------------------------
    //$imgSize = isset( $itemOptns['imgS'] ) ? esc_attr( $itemOptns['imgS'][0] ) : '';

    $imgIDL = isset( $itemOptns['_imgIDL'] ) ? esc_attr( $itemOptns['_imgIDL'][0] ) : 0;
    $imgUrlL = isset( $itemOptns['_imgUrlL'] ) ? esc_attr( $itemOptns['_imgUrlL'][0] ) : '';

    abcfsl_mbox_item_img( $imgUrlL, $imgIDL );
    abcfsl_mbox_item_text( $itemOptns, $tplateOptns, $fieldOrder );

    $obj = ABCFSL_Main();
    $slug = $obj->pluginSlug;
    wp_nonce_field( $slug, $slug . '_nonce' );
}


function abcfsl_mbox_item_img( $imgUrlL, $imgIDL ){

    echo abcfl_input_hlp_lbl(abcfsl_txta(310), 'abcflMTop10', 14, 'B');
    echo abcfl_html_img_tag('', $imgUrlL, '', '', 200, '', 'abcflMTop15');

    //imgUrlL itemImgUrl
    echo abcfl_input_txt('imgUrlL', '', $imgUrlL, abcfsl_txta(312), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_hidden( 'imgIDL', 'imgIDL', $imgIDL );

    echo  abcfl_html_tag('div','','abcflPTop10');
        echo abcfl_input_btn('btnImgL', 'btnImgL', 'button', abcfsl_txta(263), 'button' );
    echo abcfl_html_tag_end('div');
    echo abcfl_input_hline('3', 15);
}

function abcfsl_mbox_item_text( $itemOptns, $tplateOptns, $fieldOrder) {

    foreach ( $fieldOrder as $F ) {
        abcfsl_mbox_item_text_line_bldr( $tplateOptns, $itemOptns, $F );
    }
}

//Render line
function abcfsl_mbox_item_text_line_bldr( $tplateOptns, $itemOptns, $F ){

    $fieldType = isset( $tplateOptns['_fieldType_' . $F] ) ? esc_attr( $tplateOptns['_fieldType_' . $F][0] ) :'N';
    $out = '';
    //-----------------------------------------------------
    switch ($fieldType){
        case 'T':
            abcfsl_mbox_item_text_T( $tplateOptns, $itemOptns, $F );
            break;
        case 'H':
            abcfsl_mbox_item_text_H( $tplateOptns, $itemOptns, $F );
            break;
        case 'EM':
            abcfsl_mbox_item_text_EM( $tplateOptns, $itemOptns, $F );
            break;
       default:
            break;
    }
    return $out;
}
//===================================================================
//Text.
function abcfsl_mbox_item_text_T( $tplateOptns, $itemOptns, $F ){

    $lineTxt = isset( $itemOptns['_txt_' . $F] ) ? esc_attr( $itemOptns['_txt_' . $F][0] ) : '';
    $inputLbl = abcfsl_mbox_item_text_line_number( $F , isset( $tplateOptns['_inputLbl_' . $F] ) ? esc_attr( $tplateOptns['_inputLbl_' . $F][0] ) : '' );

    echo abcfl_input_txt('txt_' . $F, '', $lineTxt, $inputLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
}


//Hyperlinlk.
function abcfsl_mbox_item_text_H( $tplateOptns, $itemOptns, $F ){

    $urlTxt = isset( $itemOptns['_urlTxt_' . $F] ) ? esc_attr( $itemOptns['_urlTxt_' . $F][0] ) : '';
    $url = isset( $itemOptns['_url_' . $F] ) ? esc_attr( $itemOptns['_url_' . $F][0] ) : '';

    $linkLblLbl = abcfsl_mbox_item_text_line_number( $F , isset( $tplateOptns['_lnkLblLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblLbl_' . $F][0] ) : '' );
    $linkUrlLbl = abcfsl_mbox_item_text_line_number( $F , isset( $tplateOptns['_lnkUrlLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlLbl_' . $F][0] ) : '' );

    $dataL = abcfl_input_txt('urlTxt_' . $F, '', $urlTxt, $linkLblLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    $dataR = abcfl_input_txt('url_' . $F, '', $url, $linkUrlLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    echo abcfsl_mbox_item_input_two_fields( $dataL, $dataR );
}


//Email
function abcfsl_mbox_item_text_EM( $tplateOptns, $itemOptns, $F ){

    $urlTxt = isset( $itemOptns['_urlTxt_' . $F] ) ? esc_attr( $itemOptns['_urlTxt_' . $F][0] ) : '';
    $url = isset( $itemOptns['_url_' . $F] ) ? esc_attr( $itemOptns['_url_' . $F][0] ) : '';

    $linkLblLbl = abcfsl_mbox_item_text_line_number( $F , isset( $tplateOptns['_lnkLblLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblLbl_' . $F][0] ) : '' );
    $linkUrlLbl = abcfsl_mbox_item_text_line_number( $F , isset( $tplateOptns['_lnkUrlLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlLbl_' . $F][0] ) : '' );

    $dataL = abcfl_input_txt('urlTxt_' . $F, '', $urlTxt, $linkLblLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    $dataR = abcfl_input_txt('url_' . $F, '', $url, $linkUrlLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    echo abcfsl_mbox_item_input_two_fields( $dataL, $dataR );
}

//==============================================================
function abcfsl_mbox_item_text_line_number( $F , $inputLbl, $suffix='' ){

    return '<span class="abcflFontW600 abcflFontFVS12">' . $F . '.&nbsp&nbsp' . $inputLbl . '</span><span>' . $suffix . '</span>';
}

function abcfsl_mbox_item_input_two_fields( $dataL, $dataR ){

    $fieldsCntrS = abcfl_html_tag( 'div', '', 'abcflGridRow abcflGridGroup' );
    $fieldCntrS1 = abcfl_html_tag( 'div', '', 'abcflGridCol abcflGridCol_1_of_3' );
    $fieldCntrS2 = abcfl_html_tag( 'div', '', 'abcflGridCol abcflGridCol_2_of_3 abcflPLeft20' );
    $divE = abcfl_html_tag_end( 'div');

    //$clr = abcfl_html_tag_cls( 'div',  'abcflClr', true );
    $clr = '';

    $out = $fieldsCntrS . $fieldCntrS1 . $dataL . $divE . $fieldCntrS2 . $dataR . $divE . $clr. $divE;

    return $out;
}

