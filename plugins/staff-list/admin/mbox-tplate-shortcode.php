<?php


function abcfsl_mbox_tplate_shortcode( $tplateID, $tplateOptns ) {

    //$sPageUrl = isset( $tplateOptns['_sPageUrl'] ) ? esc_attr( $tplateOptns['_sPageUrl'][0] ) : '';

    echo  abcfl_html_tag('div','','inside  hidden');

        $lstLayout = isset( $tplateOptns['_lstLayout'] ) ? esc_attr( $tplateOptns['_lstLayout'][0] ) : '0';
        $lstLayoutH = isset( $tplateOptns['_lstLayoutH'] ) ? esc_attr( $tplateOptns['_lstLayoutH'][0] ) : $lstLayout;

        if($lstLayoutH == '0'){
            echo abcfl_html_tag_end('div');
            return;
        }
        //----------------------------------
        abcfsl_mbox_tplate_field_section_hdr( 54, 170, false);

        $scode = abcfsl_scode_build_scode( 0, $tplateID );
        $scodeSP = abcfsl_scode_build_scode( 10, $tplateID );

        echo abcfl_input_txt_readonly('scode', '', $scode, abcfsl_txta(68) . ' ' . abcfsl_txta(3),'', '100%',
                'regular-text code abcflFontW700', '', 'abcflFldCntr abcflShortcode');
        echo abcfl_input_txt_readonly('scodeSP', '', $scodeSP , abcfsl_txta(69) . ' ' . abcfsl_txta(3) , '', '100%',
                'regular-text code abcflFontW700', '', 'abcflFldCntr abcflShortcode', 'abcflFldLbl');
        //----------------------------------
        echo abcfl_input_hline('2', '20');
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(242), abcfsl_aurl(54), 'abcflFontWP abcflFontS16 abcflFontW600 abcflMTop10');
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(326), abcfsl_aurl(12), 'abcflFontWP abcflFontS16 abcflFontW600 abcflMTop10');
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(187), abcfsl_aurl(56), 'abcflFontWP abcflFontS16 abcflFontW600 abcflMTop10');

    echo abcfl_html_tag_end('div');
}
