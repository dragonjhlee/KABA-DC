<?php

//Data entry screen builder
function abcfsl_mbox_item_text( $itemOptns, $tplateOptns, $isSingle) {

    //echo"<pre>", print_r($tplateOptns, true), "</pre>"; 

    //Single is a second tab. Set it to hidden.
    if( $isSingle ){
        echo  abcfl_html_tag('div', '', 'inside  hidden');
    }
    else {
        echo  abcfl_html_tag('div', '', 'inside');
        abcfsl_mbox_item_text_sort_txt( $itemOptns );
    }

    //New rwcord. Template not selected yet.
    if( empty( $tplateOptns ) ){ 
        echo abcfl_input_info_lbl( abcfsl_txta(244), 'abcflMTop15', '16', 'SB'); 
        echo abcfl_html_tag_end('div');
        return;
    }

    //Get template fields in field order.
    $fieldOrder = abcfsl_util_field_order( $tplateOptns, $isSingle );

    $fieldsQty = 0;
    foreach ( $fieldOrder as $order => $F ) {
        $showField = abcfsl_mbox_item_text_line_bldr( $tplateOptns, $itemOptns, $F, $isSingle);
        $fieldsQty = $fieldsQty + $showField;
    }

    //Message: Template has no fields
    if( $fieldsQty == 0 ){ echo abcfl_input_info_lbl( abcfsl_txta(214), 'abcflMTop15', '16', 'SB'); }

    echo abcfl_html_tag_end('div');
}

function abcfsl_mbox_item_text_sort_txt( $itemOptns ){

    $sortTxt = isset( $itemOptns['_sortTxt'] ) ? esc_attr( $itemOptns['_sortTxt'][0] ) : '';

    $lblST = abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(61), abcfsl_aurl(31), 'abcflFontWP abcflFontS12 abcflFontW400' );

    echo abcfl_input_txt('sortTxt', '', $sortTxt,  $lblST, '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_hline('1', '10');
}

//Render a single input field
function abcfsl_mbox_item_text_line_bldr( $tplateOptns, $itemOptns, $F, $isSingle ){

    $fieldType = isset( $tplateOptns['_fieldType_' . $F] ) ? esc_attr( $tplateOptns['_fieldType_' . $F][0] ) :'N';
    $showFieldOn = isset( $tplateOptns['_showField_' . $F] ) ? esc_attr( $tplateOptns['_showField_' . $F][0] ) : 'L';

    if( $F == 'SPTL' ) {
        $fieldType = 'SPTL';
        $showFieldOn = 'L';
    }

    $showField = abcfsl_autil_show_field_for_data_input( $showFieldOn, $isSingle );

    //-----------------------------------------------------
    switch ($fieldType){
        case 'T':
        //case 'SC':
            abcfsl_mbox_item_text_T( $tplateOptns, $itemOptns, $F, $showField );
            break;
        case 'MP':
            abcfsl_mbox_item_text_MP( $tplateOptns, $itemOptns, $F, $showField );
            break;
        case 'PT':
            abcfsl_mbox_item_text_PT( $tplateOptns, $itemOptns, $F, $showField );
            break;
        case 'LT':
            abcfsl_mbox_item_text_LT( $tplateOptns, $itemOptns, $F, $showField );
            break;
        case 'H':
            abcfsl_mbox_item_text_H( $tplateOptns, $itemOptns, $F, $showField);
            break;
        case 'TH':
            abcfsl_mbox_item_text_TH( $tplateOptns, $itemOptns, $F, $showField);
            break;
        case 'EM':
            abcfsl_mbox_item_text_EM( $tplateOptns, $itemOptns, $F, $showField);
            break;
        case 'CE':
            abcfsl_mbox_item_text_WPE( $tplateOptns, $itemOptns, $F, $showField);
            break;
        case 'HL': 
            abcfsl_mbox_item_text_HL( $tplateOptns, $F, $showField );
            break;            
        case 'SPTL': //Single Page Text Link
            abcfsl_mbox_item_text_SPTL( $tplateOptns );
            break;
       default:
            break;
    }
    return $showField;
}


function abcfsl_mbox_item_text_SPTL( $tplateOptns ){

    $sPgLnkShow = isset( $tplateOptns['_sPgLnkShow'] ) ? $tplateOptns['_sPgLnkShow'][0] : 'N';
    if($sPgLnkShow == 'N') { return ''; }

    $sPgLnkTxt = isset( $tplateOptns['_sPgLnkTxt'] ) ? esc_attr( $tplateOptns['_sPgLnkTxt'][0] ) : '';
    $lbl = abcfsl_mbox_item_text_line_number( abcfsl_txta(74), '');
    echo abcfl_input_txt_readonly('ro_txt_sPgLnkTxt', '', $sPgLnkTxt, $lbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
}
//===================================================================
//Multipart.
function abcfsl_mbox_item_text_MP( $tplateOptns, $itemOptns, $F, $showField ){

    if($showField == 0) { return ''; }

    //All data is entered on Staff Page screen. Fields are disabled on Single Page. ??????????????????????

    $inputHlp = isset( $tplateOptns['_inputHlp_' . $F] ) ? esc_attr( $tplateOptns['_inputHlp_' . $F][0] ) : '';

    $mp1 = isset( $itemOptns['_mp1_' . $F] ) ? esc_attr( $itemOptns['_mp1_' . $F][0] ) : '';
    $mp2 = isset( $itemOptns['_mp2_' . $F] ) ? esc_attr( $itemOptns['_mp2_' . $F][0] ) : '';
    $mp3 = isset( $itemOptns['_mp3_' . $F] ) ? esc_attr( $itemOptns['_mp3_' . $F][0] ) : '';
    $mp4 = isset( $itemOptns['_mp4_' . $F] ) ? esc_attr( $itemOptns['_mp4_' . $F][0] ) : '';

    $inputLblP1 = abcfsl_mbox_item_text_line_number( $F , isset( $tplateOptns['_inputLblP1_' . $F] ) ? esc_attr( $tplateOptns['_inputLblP1_' . $F][0] ) : '' );
    $inputLblP2 = abcfsl_mbox_item_text_line_number( $F , isset( $tplateOptns['_inputLblP2_' . $F] ) ? esc_attr( $tplateOptns['_inputLblP2_' . $F][0] ) : '' );
    $inputLblP3 = abcfsl_mbox_item_text_line_number( $F , isset( $tplateOptns['_inputLblP3_' . $F] ) ? esc_attr( $tplateOptns['_inputLblP3_' . $F][0] ) : '' );
    $inputLblP4 = abcfsl_mbox_item_text_line_number( $F , isset( $tplateOptns['_inputLblP4_' . $F] ) ? esc_attr( $tplateOptns['_inputLblP4_' . $F][0] ) : '' );

    $orderLP1 = isset( $tplateOptns['_orderLP1_' . $F] ) ? esc_attr( $tplateOptns['_orderLP1_' . $F][0] ) : '0';
    $orderLP2 = isset( $tplateOptns['_orderLP2_' . $F] ) ? esc_attr( $tplateOptns['_orderLP2_' . $F][0] ) : '0';
    $orderLP3 = isset( $tplateOptns['_orderLP3_' . $F] ) ? esc_attr( $tplateOptns['_orderLP3_' . $F][0] ) : '0';
    $orderLP4 = isset( $tplateOptns['_orderLP4_' . $F] ) ? esc_attr( $tplateOptns['_orderLP4_' . $F][0] ) : '0';

    $orderSP1 = isset( $tplateOptns['_orderSP1_' . $F] ) ? esc_attr( $tplateOptns['_orderSP1_' . $F][0] ) : '0';
    $orderSP2 = isset( $tplateOptns['_orderSP2_' . $F] ) ? esc_attr( $tplateOptns['_orderSP2_' . $F][0] ) : '0';
    $orderSP3 = isset( $tplateOptns['_orderSP3_' . $F] ) ? esc_attr( $tplateOptns['_orderSP3_' . $F][0] ) : '0';
    $orderSP4 = isset( $tplateOptns['_orderSP4_' . $F] ) ? esc_attr( $tplateOptns['_orderSP4_' . $F][0] ) : '0';

    if( $orderSP1 != 0 ) { $orderLP1 = 1; }
    if( $orderSP2 != 0 ) { $orderLP2 = 1; }
    if( $orderSP3 != 0 ) { $orderLP3 = 1; }
    if( $orderSP4 != 0 ) { $orderLP4 = 1; }

    $f1 = '';
    $f2 = '';
    $f3 = '';
    $f4 = '';

    if($showField == 2) {
        $f1 = abcfsl_mbox_item_multi_field_section( 0, '1', $mp1, $inputLblP1, $F);
        $f2 = abcfsl_mbox_item_multi_field_section( 0, '2', $mp2, $inputLblP2, $F);
        $f3 = abcfsl_mbox_item_multi_field_section( 0, '3', $mp3, $inputLblP3, $F);
        $f4 = abcfsl_mbox_item_multi_field_section( 0, '4', $mp4, $inputLblP4, $F);
    }
    else{
        $f1 = abcfsl_mbox_item_multi_field_section( $orderLP1, '1', $mp1, $inputLblP1, $F);
        $f2 = abcfsl_mbox_item_multi_field_section( $orderLP2, '2', $mp2, $inputLblP2, $F);
        $f3 = abcfsl_mbox_item_multi_field_section( $orderLP3, '3', $mp3, $inputLblP3, $F);
        $f4 = abcfsl_mbox_item_multi_field_section( $orderLP4, '4', $mp4, $inputLblP4, $F);
    }

    echo abcfsl_mbox_item_input_four_fields( $f1, $f2, $f3, $f4 );

    if($showField != 2) {
        echo abcfl_input_hlp_lbl( $inputHlp , 'abcflMTop5');
    }
}

function abcfsl_mbox_item_multi_field_section( $order, $p, $mp, $inputLbl, $F){

    if( $order == 0 ){
        return  abcfl_input_txt_readonly('ro_mp' . $p . '_' . $F, '', $mp, $inputLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
    else{
        return  abcfl_input_txt('mp' . $p . '_' . $F, '', $mp, $inputLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
}

function abcfsl_mbox_item_text_HL( $tplateOptns, $F, $showField){

    if($showField == 0) { return ''; }

    $inputLbl = isset( $tplateOptns['_inputLbl_' . $F] ) ? esc_attr( $tplateOptns['_inputLbl_' . $F][0] ) : 'Horizontal Line';
    echo abcfl_input_info_lbl( abcfsl_mbox_item_text_line_number( $F , $inputLbl ) , 'abcflMTop15');
    echo abcfl_input_hline('2', 5);
}


//Text.
function abcfsl_mbox_item_text_T( $tplateOptns, $itemOptns, $F, $showField ){

    if($showField == 0) { return ''; }

    $lineTxt = isset( $itemOptns['_txt_' . $F] ) ? esc_attr( $itemOptns['_txt_' . $F][0] ) : '';
    $inputLbl = isset( $tplateOptns['_inputLbl_' . $F] ) ? esc_attr( $tplateOptns['_inputLbl_' . $F][0] ) : '';
    $inputHlp = isset( $tplateOptns['_inputHlp_' . $F] ) ? esc_attr( $tplateOptns['_inputHlp_' . $F][0] ) : '';
    //if(empty($inputLbl)){ $inputLbl = 'Line ' . $order; }

    $inputLbl = abcfsl_mbox_item_text_line_number( $F , $inputLbl );

    if($showField == 2) {
        echo abcfl_input_txt_readonly('ro_txt_' . $F, '', $lineTxt, $inputLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
    else{
        echo abcfl_input_txt('txt_' . $F, '', $lineTxt, $inputLbl, $inputHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
}

//Paragraph Text.
function abcfsl_mbox_item_text_PT( $tplateOptns, $itemOptns, $F, $showField ){

    if($showField == 0) { return ''; }

    // HTML
    $lineTxt = isset( $itemOptns['_txt_' . $F] ) ? esc_textarea( $itemOptns['_txt_' . $F][0] ) : '';
    //$lineTxt = isset( $itemOptns['_txt_' . $F] ) ? esc_attr( $itemOptns['_txt_' . $F][0] ) : '';

    $inputLbl = isset( $tplateOptns['_inputLbl_' . $F] ) ? esc_attr( $tplateOptns['_inputLbl_' . $F][0] ) : '';
    $inputHlp = isset( $tplateOptns['_inputHlp_' . $F] ) ? esc_attr( $tplateOptns['_inputHlp_' . $F][0] ) : '';

    $inputLbl = abcfsl_mbox_item_text_line_number( $F , $inputLbl );
    $inputHlp = $inputHlp . abcfsl_txta(221);

    if($showField == 2) {
        echo abcfl_input_txtarea_readonly('ro_txt_' . $F, '', $lineTxt, $inputLbl, '', '100%', '8', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
    else{
        echo abcfl_input_txtarea('txt_' . $F, '', $lineTxt, $inputLbl, $inputHlp, '100%', '10', '', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
}

//Static label + Text. ?????????????
function abcfsl_mbox_item_text_LT( $tplateOptns, $itemOptns, $F, $showField ){

    if($showField == 0) { return ''; }

    $lblTx = isset( $tplateOptns['_lblTxt_' . $F] ) ? esc_attr( $tplateOptns['_lblTxt_' . $F][0] ) : '';
    $lineTxt = isset( $itemOptns['_txt_' . $F] ) ? esc_attr( $itemOptns['_txt_' . $F][0] ) : '';
    $inputLbl = isset( $tplateOptns['_inputLbl_' . $F] ) ? esc_attr( $tplateOptns['_inputLbl_' . $F][0] ) : '';
    $inputHlp = isset( $tplateOptns['_inputHlp_' . $F] ) ? esc_attr( $tplateOptns['_inputHlp_' . $F][0] ) : '';

    $inputLbl = abcfsl_mbox_item_text_line_number( $F , $inputLbl );
    $staticLbl = abcfsl_mbox_item_text_line_number( $F , '' );

    //echo abcfl_input_txt('txt_' . $F, '', $lineTxt, $inputLbl, $inputHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl abcflFontW700');

    $dataL = '';
    $dataR = '';
    if($showField == 2) {
        $dataL = abcfl_input_txt_readonly('ro_staticTxt_' . $F, '', $lblTx, $staticLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
        $dataR = abcfl_input_txt_readonly('ro_txt_' . $F, '', $lineTxt, $inputLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl abcflFontW700');
    }
    else{
        $dataL = abcfl_input_txt_readonly('staticTxt_' . $F, '', $lblTx, $staticLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
        $dataR = abcfl_input_txt('txt_' . $F, '', $lineTxt, $inputLbl, $inputHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl abcflFontW700');
    }
    echo abcfsl_mbox_item_input_two_fields( $dataL, $dataR );

}

//Hyperlinlk.
function abcfsl_mbox_item_text_H( $tplateOptns, $itemOptns, $F, $showField ){

    if($showField == 0) { return ''; }

    $linkLblLbl = isset( $tplateOptns['_lnkLblLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblLbl_' . $F][0] ) : '';
    $linkLblHlp = isset( $tplateOptns['_lnkLblHlp_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblHlp_' . $F][0] ) : '';
    $linkUrlLbl = isset( $tplateOptns['_lnkUrlLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlLbl_' . $F][0] ) : '';
    $linkUrlHlp = isset( $tplateOptns['_lnkUrlHlp_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlHlp_' . $F][0] ) : '';

    $urlTxt = isset( $itemOptns['_urlTxt_' . $F] ) ? esc_attr( $itemOptns['_urlTxt_' . $F][0] ) : '';
    $url = isset( $itemOptns['_url_' . $F] ) ? esc_attr( $itemOptns['_url_' . $F][0] ) : '';
    //$txtLnkTarget = isset( $tplateOptns['_txtLnkTarget_' . $F] ) ? esc_attr( $tplateOptns['_txtLnkTarget_' . $F][0] ) : '';

    $linkLblLbl = abcfsl_mbox_item_text_line_number( $F , $linkLblLbl );
    $linkUrlLbl = abcfsl_mbox_item_text_line_number( $F , $linkUrlLbl );


    $dataL = '';
    $dataR = '';
    if($showField == 2) {
        $dataL = abcfl_input_txt_readonly('ro_urlTxt_' . $F, '', $urlTxt, $linkLblLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
        $dataR = abcfl_input_txt_readonly('ro_url_' . $F, '', $url, $linkUrlLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
    else{
        $dataL = abcfl_input_txt('urlTxt_' . $F, '', $urlTxt, $linkLblLbl, $linkLblHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
        $dataR = abcfl_input_txt('url_' . $F, '', $url, $linkUrlLbl, $linkUrlHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
    echo abcfsl_mbox_item_input_two_fields( $dataL, $dataR );
}

//Static link text + Hyperlinlk.
function abcfsl_mbox_item_text_TH( $tplateOptns, $itemOptns, $F, $showField ){

    if($showField == 0) { return ''; }

    $linkUrlLbl = isset( $tplateOptns['_lnkUrlLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlLbl_' . $F][0] ) : '';
    $linkUrlHlp = isset( $tplateOptns['_lnkUrlHlp_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlHlp_' . $F][0] ) : '';
    $lblTx = isset( $tplateOptns['_lblTxt_' . $F] ) ? esc_attr( $tplateOptns['_lblTxt_' . $F][0] ) : '';
    $url = isset( $itemOptns['_url_' . $F] ) ? esc_attr( $itemOptns['_url_' . $F][0] ) : '';

    $linkUrlLbl = abcfsl_mbox_item_text_line_number( $F , $linkUrlLbl );
    $staticLbl = abcfsl_mbox_item_text_line_number( $F , '' );

    $dataL = '';
    $dataR = '';
    if($showField == 2) {
        $dataL = abcfl_input_txt_readonly('ro_staticTxt_' . $F, '', $lblTx, $staticLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
        $dataR = abcfl_input_txt_readonly('ro_url_' . $F, '', $url, $linkUrlLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    }
    else{
        $dataL = abcfl_input_txt_readonly('staticTxt_' . $F, '', $lblTx, $staticLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
        $dataR = abcfl_input_txt('url_' . $F, '', $url, $linkUrlLbl, $linkUrlHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    }
    echo abcfsl_mbox_item_input_two_fields( $dataL, $dataR );

}

//Static label + Hyperlinlk.
function abcfsl_mbox_item_text_LH( $tplateOptns, $itemOptns, $F, $showField){

    if($showField == 0) { return ''; }

    $linkLblLbl = isset( $tplateOptns['_lnkLblLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblLbl_' . $F][0] ) : '';
    $linkLblHlp = isset( $tplateOptns['_lnkLblHlp_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblHlp_' . $F][0] ) : '';
    $linkUrlLbl = isset( $tplateOptns['_lnkUrlLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlLbl_' . $F][0] ) : '';
    $linkUrlHlp = isset( $tplateOptns['_lnkUrlHlp_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlHlp_' . $F][0] ) : '';

    $urlTxt = isset( $itemOptns['_urlTxt_' . $F] ) ? esc_attr( $itemOptns['_urlTxt_' . $F][0] ) : '';
    $url = isset( $itemOptns['_url_' . $F] ) ? esc_attr( $itemOptns['_url_' . $F][0] ) : '';

    $linkLblLbl = abcfsl_mbox_item_text_line_number( $F , $linkLblLbl );
    $linkUrlLbl = abcfsl_mbox_item_text_line_number( $F , $linkUrlLbl );

    //echo abcfl_input_txt('urlTxt_' . $F, '', $urlTxt, $linkLblLbl, $linkLblHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    //echo abcfl_input_txt('url_' . $F, '', $url, $linkUrlLbl, $linkUrlHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');

    $dataL = '';
    $dataR = '';
    if($showField == 2) {
        $dataL = abcfl_input_txt_readonly('ro_urlTxt_' . $F, '', $urlTxt, $linkLblLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
        $dataR = abcfl_input_txt_readonly('ro_url_' . $F, '', $url, $linkUrlLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
    else{
        $dataL = abcfl_input_txt('urlTxt_' . $F, '', $urlTxt, $linkLblLbl, $linkLblHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
        $dataR = abcfl_input_txt('url_' . $F, '', $url, $linkUrlLbl, $linkUrlHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
    echo abcfsl_mbox_item_input_two_fields( $dataL, $dataR );

}

//Email
function abcfsl_mbox_item_text_EM( $tplateOptns, $itemOptns, $F, $showField){

    if($showField == 0) { return ''; }

    $linkLblLbl = isset( $tplateOptns['_lnkLblLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblLbl_' . $F][0] ) : '';
    $linkLblHlp = isset( $tplateOptns['_lnkLblHlp_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblHlp_' . $F][0] ) : '';
    $linkUrlLbl = isset( $tplateOptns['_lnkUrlLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlLbl_' . $F][0] ) : '';
    $linkUrlHlp = isset( $tplateOptns['_lnkUrlHlp_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlHlp_' . $F][0] ) : '';

    $urlTxt = isset( $itemOptns['_urlTxt_' . $F] ) ? esc_attr( $itemOptns['_urlTxt_' . $F][0] ) : '';
    $url = isset( $itemOptns['_url_' . $F] ) ? esc_attr( $itemOptns['_url_' . $F][0] ) : '';

    $linkLblLbl = abcfsl_mbox_item_text_line_number( $F , $linkLblLbl );
    $linkUrlLbl = abcfsl_mbox_item_text_line_number( $F , $linkUrlLbl );

    $dataL = '';
    $dataR = '';
    if($showField == 2) {
        $dataL = abcfl_input_txt_readonly('ro_urlTxt_' . $F, '', $urlTxt, $linkLblLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
        $dataR = abcfl_input_txt_readonly('ro_url_' . $F, '', $url, $linkUrlLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
    else{
        $dataL = abcfl_input_txt('urlTxt_' . $F, '', $urlTxt, $linkLblLbl, $linkLblHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
        $dataR = abcfl_input_txt('url_' . $F, '', $url, $linkUrlLbl, $linkUrlHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
    echo abcfsl_mbox_item_input_two_fields( $dataL, $dataR );
}


//WordPress Text Editor.
function abcfsl_mbox_item_text_WPE( $tplateOptns, $itemOptns, $F, $showField){

    if($showField == 0) { return ''; }

    $inputLbl = isset( $tplateOptns['_inputLbl_' . $F] ) ? esc_attr( $tplateOptns['_inputLbl_' . $F][0] ) : '';
    $inputHlp = isset( $tplateOptns['_inputHlp_' . $F] ) ? esc_attr( $tplateOptns['_inputHlp_' . $F][0] ) : '';

    $inputLbl = abcfsl_mbox_item_text_line_number( $F , $inputLbl );


    $content = isset( $itemOptns['_editorCnt_' . $F] ) ? ( $itemOptns['_editorCnt_' . $F][0] ) : '';

    if($showField == 2) {

        $txt = substr(esc_attr( $content ), 0, 120) . ' ...';
        echo abcfl_input_txt_readonly('ro_txt_' . $F, '', $txt, $inputLbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
    }
    else{
        echo abcfl_input_hlp_lbl($inputLbl, 'abcflMTop15 abcflFontW700', 12);
        echo abcfl_input_hlp_lbl($inputHlp);

        $editorName = 'editorCnt_' . $F;

        // Add WP Editor (free)
        wp_editor( $content, $editorName, array(
            'wpautop'       => true,
            'media_buttons' => false,
            'textarea_name' => $editorName,
            'textarea_rows' => 10,
            'teeny' => false,
            'quicktags' => true,
            'tinymce' => true
        ) );
    }
}

//===================================================================================
function abcfsl_mbox_item_text_line_number( $F , $inputLbl, $suffix='' ){
    return '<span class="abcflFontWPSB abcflFontS13">' . $F . '.&nbsp&nbsp' . $inputLbl . '</span><span>' . $suffix . '</span>';
}

function abcfsl_mbox_item_input_four_fields( $f1, $f2, $f3, $f4 ){

    $cntrS = abcfl_html_tag( 'div', '', 'abcflGridRow abcflGridGroup' );
    $cntrS1 = abcfl_html_tag( 'div', '', 'abcflGridCol abcflGridCol_1_of_4' );
    $cntrS2 = abcfl_html_tag( 'div', '', 'abcflGridCol abcflGridCol_1_of_4 abcflPLeft10' );
    $divE = abcfl_html_tag_end( 'div');

    //$clr = abcfl_html_tag_cls( 'div',  'abcflClr', true );
    $clr = '';

    $out = $cntrS .
           $cntrS1 . $f1 . $divE .
           $cntrS2 . $f2 . $divE .
           $cntrS2 . $f3 . $divE .
           $cntrS2 . $f4 . $divE .
           $clr. $divE;

    return $out;
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

function abcfsl_mbox_item_text_link_fields( $linkTxt, $linkURL, $linkTarget ){

    $fieldsCntrS = abcfl_html_tag( 'div', '', 'abcflGridRow abcflGridGroup' );
    $fieldCntrS1 = abcfl_html_tag( 'div', '', 'abcflGridCol abcflGridCol_1_of_3' );
    $fieldCntrS2 = abcfl_html_tag( 'div', '', 'abcflGridCol abcflGridCol_2_of_3 abcflPLeft20' );
    $divE = abcfl_html_tag_end( 'div');

    //$clr = abcfl_html_tag_cls( 'div',  'abcflClr', true );
    $clr = '';

    $out = $fieldsCntrS . $fieldCntrS1 . $dataL . $divE . $fieldCntrS2 . $dataR . $divE . $clr. $divE;

    return $out;
}