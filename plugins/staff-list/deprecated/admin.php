<?php
function abcfsl_txta_reqired( $id, $suffix='' ) {
    $txt = abcfsl_txta( $id, $suffix );
    return $txt . '<b class="abcflRed abcflFontS14"> *</b>';
}

//Image Style.
function abcfsl_mbox_tplate_css_img_cntr( $imgBorder, $imgCenter, $lstImgCls, $lstImgStyle, $icon, $hasImgCenter ){

    $cboImgBorder = abcfsl_cbo_img_border();

    echo abcfl_input_hline('2');
    abcfl_input_sec_icon_hdr_hlp( ABCFSL_ICONS_URL, $icon, abcfsl_txta(27), '', '' );
    echo abcfl_input_cbo_strings('imgBorder', '', $cboImgBorder, $imgBorder, abcfsl_txta(40), abcfsl_txta(228), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    if( $hasImgCenter ) {
        abcfsl_util_center_yn( 'imgCenter', $imgCenter, 84, 0 );
    }
    abcfsl_autil_class_and_style( 'lstImgCls', $lstImgCls, 'lstImgStyle', $lstImgStyle, '', false );
}

//Section header
//function abcfsl_mbox_tplate_css_section_hdr( $iconName, $lblID, $helpID, $hline = true, $hlineH = '2' ){
//
//    $src = ABCFSL_PLUGIN_URL . 'images/' . $iconName;
//
//    if( $hline ){ echo abcfl_input_hline($hlineH); }
//
//    echo abcfl_html_tag_cls(  'div', 'abcflPosRel', false );
//    echo abcfl_html_tag( 'div', '', 'abcflFloatL abcflPTop2 abcflLineH1' );
//        echo abcfl_html_img_tag('', $src, '', '');
//    echo abcfl_html_tag_end('div');
//
//    echo abcfl_html_tag( 'div', '', 'abcflFloatL abcflPLeft20' );
//        echo abcfl_input_info_lbl(abcfsl_txta($lblID), 'abcflMTop10', 16, 'SB');
//        echo abcfl_input_info_lbl(abcfsl_txta($helpID), 'abcflMTop5', 12, 'SB');
//    echo abcfl_html_tag_end('div');
//
//    echo abcfl_html_tag_cls(  'div', 'abcflClr', true );
//    echo abcfl_html_tag_end('div');
//}