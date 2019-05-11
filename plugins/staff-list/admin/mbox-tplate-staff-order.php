<?php
function abcfsl_mbox_list_order( $postID, $tplateOptns ) {
    echo  abcfl_html_tag('div','','inside  hidden');

        $lstLayout = isset( $tplateOptns['_lstLayout'] ) ? esc_attr( $tplateOptns['_lstLayout'][0] ) : '0';
        $lstLayoutH = isset( $tplateOptns['_lstLayoutH'] ) ? esc_attr( $tplateOptns['_lstLayoutH'][0] ) : $lstLayout;
        if($lstLayoutH == '0'){
            echo abcfl_html_tag_end('div');
            return;
        }

    $cboSortType = abcfsl_cbo_sort_type();
    $sortType = isset( $tplateOptns['_sortType'] ) ? esc_attr( $tplateOptns['_sortType'][0] ) : 'M';

    echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(280), abcfsl_aurl(31) );
    echo abcfl_input_cbo('sortType', '',$cboSortType, $sortType, '', abcfsl_txta(237), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_hline();

    if($sortType == 'M'){
        $dbRows = abcfsl_dba_items_for_order($postID);
        //var_dump($items);
        if ($dbRows) {
            echo abcfl_input_info_lbl( abcfsl_txta(255), 'abcflMTop15', 14, 'SB');
            abcfsl_list_items_order($dbRows);
        }
        else{
            echo abcfl_input_info_lbl( abcfsl_txta(266), 'abcflMTop15 abcflGreen', 14, 'SB');
        }
    }
    else{
        echo abcfl_input_info_lbl( abcfsl_txta(281), 'abcflMTop15 abcflGreen', 14, 'SB');
    }

    echo abcfl_html_tag_end('div');
}

function abcfsl_list_items_order($dbRows) {

    echo  abcfl_html_tag('div', '', 'wrap wrapSort');
        echo abcfl_html_tag( 'table', 'sort-items-tbl', 'wp-list-table widefat striped' );
        echo abcfl_html_tag( 'tbody', '' );
            foreach ( $dbRows as $dbRow ) { abcfsl_list_order_item($dbRow->ID, $dbRow->post_title, $dbRow->menu_order ); }
        echo abcfl_html_tag_ends( 'tbody,table' );
    echo abcfl_html_tag_end( 'div' );
}

function abcfsl_list_order_item($postID, $postTitle, $menuOrder){

    $optns = get_post_custom($postID);

    $imgUrl = isset( $optns['_imgUrlL'] ) ? esc_attr( $optns['_imgUrlL'][0] ) : '';

    echo abcfl_html_tag( 'tr', 'item_' . $postID );

    echo abcfl_html_tag( 'td', '', 'column-order', 'width: 60px;' );
    echo abcfl_html_img_tag('', ABCFSL_PLUGIN_URL . 'images/move-icon.png', 'Move Icon', '', 24, 24);
    echo abcfl_html_tag_end( 'td' );

    echo abcfl_html_tag( 'td', '', 'column-photo' );
    echo abcfl_html_img_tag('', $imgUrl, '', '', 0, 60);
    echo abcfl_html_tag_end( 'td' );

    echo abcfl_html_tag( 'td', '', 'column-name' );
    echo $postTitle;
    echo abcfl_html_tag_end( 'td' );

    echo abcfl_html_tag( 'td', '', 'menu-order' );
    echo $menuOrder;
    echo abcfl_html_tag_ends( 'td,tr' );

}


