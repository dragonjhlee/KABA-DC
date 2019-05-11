<?php
function abcfsl_mbox_item_optns( $itemOptns ){

    $hideSMember = isset( $itemOptns['_hideSMember'] ) ? esc_attr( $itemOptns['_hideSMember'][0] ) : '0';
    //$sortTxt = isset( $itemOptns['_sortTxt'] ) ? esc_attr( $itemOptns['_sortTxt'][0] ) : '';
    $pretty = isset( $itemOptns['_pretty'] ) ? esc_attr( $itemOptns['_pretty'][0] ) : '';
    $sPgTitle = isset( $itemOptns['_sPgTitle'] ) ? esc_attr( $itemOptns['_sPgTitle'][0] ) : '';

    echo  abcfl_html_tag('div','','inside hidden');
        echo abcfl_input_checkbox('hideSMember',  '', $hideSMember,  abcfsl_txta(153), '', '', '', '', '', '', '' );
        echo abcfl_input_hline('1', '10');
        //----------------------------------------------------
        //echo abcfl_input_info_lbl(abcfsl_txta(303), 'abcflMTop15', '14', 'SB');
        echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(303), abcfsl_aurl(60) );

        //echo abcfl_input_info_lbl(abcfl_html_a_tag('http://abcfolio.com/staff-list-single-page-pretty-permalinks/#permalink-spg-name', abcfsl_txta(11) ), 'abcflMTop5', 13, 'N');
        echo abcfl_input_txt('pretty', '', $pretty,  abcfsl_txta(231), abcfsl_txta(270) . ' ' . abcfsl_txta(232), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
        //Html Head Title
        echo abcfl_input_txt('sPgTitle', '', $sPgTitle,  abcfsl_txta(77), abcfsl_txta(270), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_html_tag_end('div');
}

