<?php
function abcfsl_v_tabs_manager_div_s( $mgrID ){

    //---Manager START
    echo abcfl_html_tag( 'div', 'abcfsl_VTabsMgr_' . $mgrID, 'abcflVTabsMgr' );
    //abcfl_html_tag_cls('div', 'abcflClr', true);
}

function abcfsl_v_tabs_render_nav_tab( $cls, $lbl1, $lbl2='', $url='#'){

    $lbl1 = abcfl_html_tag_with_content( $lbl1, 'span', '');
    $lbl2 = abcfl_html_tag_with_content( $lbl2, 'span', '');

    $lbl = trim( $lbl1 . ' ' . $lbl2 );

    $out = abcfl_html_tag( 'li', '', $cls );
        $out .= abcfl_html_a_tag($url, $lbl, '', '');
    $out .= abcfl_html_tag_end( 'li' );

    return $out;
}
