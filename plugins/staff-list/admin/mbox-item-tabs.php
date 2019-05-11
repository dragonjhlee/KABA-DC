<?php
function abcfsl_mbox_item_tabs(){

    $obj = ABCFSL_Main();
    $slug = $obj->pluginSlug;
    //$clsPfix = $obj->prefix;

    abcfsl_v_tabs_manager_div_s( '1' ); //---Manager START
        abcfsl_mbox_item_tabs_render_nav_tabs();
        abcfsl_mbox_item_tabs_render_cnt( );
    echo abcfl_html_tag_end( 'div' ); //---Manager END

    wp_nonce_field( $slug, $slug . '_nonce' );
}

function abcfsl_mbox_item_tabs_render_nav_tabs( ){

    echo abcfl_html_tag( 'ul', '', 'abcflVTabsNavCntr' );
        echo abcfsl_v_tabs_render_nav_tab( 'abcflVTabsTabActive', abcfsl_txta(68) );
        echo abcfsl_v_tabs_render_nav_tab( '', abcfsl_txta(69) );
        echo abcfsl_v_tabs_render_nav_tab( '', abcfsl_txta(2) );
        echo abcfsl_v_tabs_render_nav_tab( '', abcfsl_txta(9) );
    echo abcfl_html_tag_end( 'ul' );

}

function abcfsl_mbox_item_tabs_render_cnt( ){

    global $post;
    $postID = $post->ID;
    $itemOptns = get_post_custom( $postID );
    $tplateID = $post->post_parent;
    $tplateOptns = get_post_custom( $tplateID );

    echo abcfl_html_tag( 'div', 'abcfsl_VTabsCntCntr_1', 'abcflVTabsCntCntr' ); //---Content START

    $imgIDL = isset( $itemOptns['_imgIDL'] ) ? esc_attr( $itemOptns['_imgIDL'][0] ) : 0;
    $imgUrlL = isset( $itemOptns['_imgUrlL'] ) ? esc_attr( $itemOptns['_imgUrlL'][0] ) : '';
    $imgLnkL = isset( $itemOptns['_imgLnkL'] ) ? esc_attr( $itemOptns['_imgLnkL'][0] ) : '';
    $imgIDS = isset( $itemOptns['_imgIDS'] ) ? esc_attr( $itemOptns['_imgIDS'][0] ) : 0;
    $imgUrlS = isset( $itemOptns['_imgUrlS'] ) ? esc_attr( $itemOptns['_imgUrlS'][0] ) : '';
    $imgAlt = isset( $itemOptns['_imgAlt'] ) ? esc_attr( $itemOptns['_imgAlt'][0] ) : '';

    $overTxtI1 = isset( $itemOptns['_overTxtI1'] ) ? esc_attr( $itemOptns['_overTxtI1'][0] ) : '';
    $overTxtI2 = isset( $itemOptns['_overTxtI2'] ) ? esc_attr( $itemOptns['_overTxtI2'][0] ) : '';

    abcfsl_mbox_item_text($itemOptns, $tplateOptns, false);
    abcfsl_mbox_item_text($itemOptns, $tplateOptns, true);
    abcfsl_mbox_item_img( $imgUrlL, $imgLnkL, $imgUrlS, $imgIDL, $imgIDS, $imgAlt, $overTxtI1, $overTxtI2 );
    abcfsl_mbox_item_optns( $itemOptns );


    echo abcfl_html_tag_end( 'div' ); //---Content END
}