<?php
function abcfsl_mbox_tplate_spg_layout( $tplateOptns ){

    echo  abcfl_html_tag('div','','inside hidden');

        $lstLayout = isset( $tplateOptns['_lstLayout'] ) ? esc_attr( $tplateOptns['_lstLayout'][0] ) : '0';
        $lstLayoutH = isset( $tplateOptns['_lstLayoutH'] ) ? esc_attr( $tplateOptns['_lstLayoutH'][0] ) : $lstLayout;
        $spgCols = isset( $tplateOptns['_spgCols'] ) ? esc_attr( $tplateOptns['_spgCols'][0] ) : '6';
        $spgMMarginT = isset( $tplateOptns['_spgMMarginT'] ) ? esc_attr( $tplateOptns['_spgMMarginT'][0] ) : 'N';

        $spgCntrW = isset( $tplateOptns['_spgCntrW'] ) ? esc_attr( $tplateOptns['_spgCntrW'][0] ) : '';
        $spgACenter = isset( $tplateOptns['_spgACenter'] ) ? esc_attr( $tplateOptns['_spgACenter'][0] ) : 'Y';
        $spgCntrCls = isset( $tplateOptns['_spgCntrCls'] ) ? esc_attr( $tplateOptns['_spgCntrCls'][0] ) : '';
        $spgCntrStyle = isset( $tplateOptns['_spgCntrStyle'] ) ? esc_attr( $tplateOptns['_spgCntrStyle'][0] ) : '';

       //-- ADD NEW Record Screen. Display only Add New Layout cbo ------------------------
        if($lstLayoutH == '0'){
            echo abcfl_html_tag_end('div');
            return;
        }
        abcfsl_mbox_tplate_spg_layout_optns_pg( $spgCntrW, $spgCntrCls, $spgCntrStyle, $spgACenter);
        abcfsl_mbox_tplate_spg_layout_optns_m( $spgCols, $spgMMarginT );

    echo abcfl_html_tag_end('div');
}

//Content Container Style
function abcfsl_mbox_tplate_spg_layout_optns_pg( $spgCntrW, $spgCntrCls, $spgCntrStyle, $spgACenter){

    abcfl_input_sec_icon_hdr_hlp( ABCFSL_ICONS_URL, 'staff-single-pg.png', abcfsl_txta(69)  . ' ' . abcfsl_txta(13), abcfsl_txta(322), abcfsl_aurl(29) );

    echo abcfl_input_txt('spgCntrW', '', $spgCntrW, abcfsl_txta(48), abcfsl_txta(260), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    abcfsl_util_center_yn( 'spgACenter', $spgACenter );

    abcfsl_autil_class_and_style( 'spgCntrCls', $spgCntrCls, 'spgCntrStyle', $spgCntrStyle, '', false, '1' );

}

function abcfsl_mbox_tplate_spg_layout_optns_m( $spgCols, $spgMMarginT ){

    $cboCols = abcfsl_cbo_list_columns();
    $cboTM = abcfsl_cbo_margin_top_social();

    echo abcfl_input_hline('2');
    abcfl_input_sec_icon_hdr_hlp( ABCFSL_ICONS_URL, 'staff-single-pg-m.png', abcfsl_txta(145), '', abcfsl_aurl(9) );

    echo abcfl_input_cbo('spgCols', '',$cboCols, $spgCols, abcfsl_txta_r(253), '', '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_cbo('spgMMarginT', '',$cboTM, $spgMMarginT, abcfsl_txta(15), '', '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
}
