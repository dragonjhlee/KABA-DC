<?php
function abcfsl_mbox_tplate_spg_optns( $tplateID, $tplateOptns ){

    $lstLayout = isset( $tplateOptns['_lstLayout'] ) ? esc_attr( $tplateOptns['_lstLayout'][0] ) : '0';
    $lstLayoutH = isset( $tplateOptns['_lstLayoutH'] ) ? esc_attr( $tplateOptns['_lstLayoutH'][0] ) : $lstLayout;

    $sPageUrl = isset( $tplateOptns['_sPageUrl'] ) ? esc_attr( $tplateOptns['_sPageUrl'][0] ) : '';
    $sPgLnkTxt = isset( $tplateOptns['_sPgLnkTxt'] ) ? esc_attr( $tplateOptns['_sPgLnkTxt'][0] ) : '';
    $sPgLnkNT = isset( $tplateOptns['_sPgLnkNT'] ) ? $tplateOptns['_sPgLnkNT'][0] : '0';
    $sPgLnkShow = isset( $tplateOptns['_sPgLnkShow'] ) ? $tplateOptns['_sPgLnkShow'][0] : 'N';
    $sPgLnkTag = isset( $tplateOptns['_sPgLnkTag'] ) ? $tplateOptns['_sPgLnkTag'][0] : 'div';
    $sPgLnkFont = isset( $tplateOptns['_sPgLnkFont'] ) ? $tplateOptns['_sPgLnkFont'][0] : 'D';
    $sPgLnkMarginT = isset( $tplateOptns['_sPgLnkMarginT'] ) ? $tplateOptns['_sPgLnkMarginT'][0] : 'N';
    $sPgLnkCls = isset( $tplateOptns['_sPgLnkCls'] ) ? esc_attr( $tplateOptns['_sPgLnkCls'][0] ) : '';
    $sPgLnkStyle = isset( $tplateOptns['_sPgLnkStyle'] ) ? esc_attr( $tplateOptns['_sPgLnkStyle'][0] ) : '';

    $scode = abcfsl_scode_build_scode( 10,$tplateID );
    $cboTag = abcfsl_cbo_tag_type();
    $cboFont = abcfsl_cbo_font_size();
    $cboMarginT  = abcfsl_cbo_txt_margin_top();
    $cboSPgLnkShow = abcfsl_cbo_yn();

    echo  abcfl_html_tag('div','','inside hidden');

        //-- ADD NEW Record Screen. Display only Add New Layout cbo ------------------------
        if($lstLayoutH == '0'){
            echo abcfl_html_tag_end('div');
            return;
        }

        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(69)  . ' ' . abcfsl_txta(9), abcfsl_aurl(29) );
        //-------------------------------------------
        echo abcfl_input_txt_readonly('scodeSP', '', $scode , abcfsl_txta(69) . ' ' . abcfsl_txta(3) , '', '100%',
                'regular-text code abcflFontW700', '', 'abcflFldCntr abcflShortcode', 'abcflFldLbl');
        echo abcfl_input_txt('sPageUrl', '', $sPageUrl, abcfsl_txta_r(271), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(326), abcfsl_aurl(12), 'abcflFontWP abcflFontS16 abcflFontW600 abcflMTop5');

        //-- Single Page Hyperlink -----------------------------------------
        echo abcfl_input_hline('4', '30');
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(74), abcfsl_aurl(23) );
        echo abcfl_input_info_lbl( abcfsl_txta(142), 'abcflMTop5', 12 );
        //---------------------------------
        echo abcfl_input_cbo('sPgLnkShow', '', $cboSPgLnkShow, $sPgLnkShow, abcfsl_txta_r(147), '', '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
        echo abcfl_input_txt( 'sPgLnkTxt', '', $sPgLnkTxt, abcfsl_txta_r(259), abcfsl_txta(127), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
        echo abcfl_input_checkbox('sPgLnkNT',  '', $sPgLnkNT, abcfsl_txta(143), '', '', '', 'abcflFldCntr', '', '', '' );
        //---------------------------------
        echo abcfl_input_hline('2', '20');
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(141), abcfsl_aurl(14) );
        echo abcfl_input_cbo( 'sPgLnkTag', '', $cboTag, $sPgLnkTag, abcfsl_txta_r(287), abcfsl_txta(279), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
        echo abcfl_input_cbo_strings( 'sPgLnkFont', '', $cboFont, $sPgLnkFont, abcfsl_txta(47), abcfsl_txta(247), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
        echo abcfl_input_cbo_strings( 'sPgLnkMarginT', '', $cboMarginT , $sPgLnkMarginT, abcfsl_txta(15), '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
        //---------------------------------
        echo abcfl_input_hline('2', '20');
        echo abcfl_input_txt( 'sPgLnkCls', '', $sPgLnkCls, abcfsl_txta(323), abcfsl_txta(223), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
        echo abcfl_input_txt( 'sPgLnkStyle', '', $sPgLnkStyle, abcfsl_txta(289), abcfsl_txta(224), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');

    echo abcfl_html_tag_end('div');
}
