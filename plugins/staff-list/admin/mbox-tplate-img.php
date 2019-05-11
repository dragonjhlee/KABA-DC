<?php
function abcfsl_mbox_tplate_img( $tplateOptns ){

//echo"<pre>", print_r($tplateOptns), "</pre>";

  echo  abcfl_html_tag('div','','inside hidden');

    $lstLayout = isset( $tplateOptns['_lstLayout'] ) ? esc_attr( $tplateOptns['_lstLayout'][0] ) : '0';
    $lstLayoutH = isset( $tplateOptns['_lstLayoutH'] ) ? esc_attr( $tplateOptns['_lstLayoutH'][0] ) : $lstLayout;

    $imgBorder = isset( $tplateOptns['_imgBorder'] ) ? $tplateOptns['_imgBorder'][0] : 'D';
    $imgCenter = isset( $tplateOptns['_imgCenter'] ) ? esc_attr( $tplateOptns['_imgCenter'][0] ) : 'Y';
    $imgHover = isset( $tplateOptns['_imgHover'] ) ? esc_attr( $tplateOptns['_imgHover'][0] ) : '';
    $imgDS = isset( $tplateOptns['_imgDS'] ) ? esc_attr( $tplateOptns['_imgDS'][0] ) : '';
    $imgCircle = isset( $tplateOptns['_imgCircle'] ) ? $tplateOptns['_imgCircle'][0] : '';

    $lstImgCls = isset( $tplateOptns['_lstImgCls'] ) ? esc_attr( $tplateOptns['_lstImgCls'][0] ) : '';
    $lstImgStyle = isset( $tplateOptns['_lstImgStyle'] ) ? esc_attr( $tplateOptns['_lstImgStyle'][0] ) : '';

    //$overTxtT1, overTxtT2, $overFont1, $overFont2, $overTM
    $overTxtT1 = isset( $tplateOptns['_overTxtT1'] ) ? esc_attr( $tplateOptns['_overTxtT1'][0] ) : '';
    $overTxtT2 = isset( $tplateOptns['_overTxtT2'] ) ? esc_attr( $tplateOptns['_overTxtT2'][0] ) : '';
    $overFont1 = isset( $tplateOptns['_overFont1'] ) ? $tplateOptns['_overFont1'][0] : 'D';
    $overFont2 = isset( $tplateOptns['_overFont2'] ) ? $tplateOptns['_overFont2'][0] : 'D';
    $overTM = isset( $tplateOptns['_overTM'] ) ? $tplateOptns['_overTM'][0] : 'N';


    switch ($lstLayoutH) {
        case 1:
            abcfsl_mbox_tplate_img_img_cntr( $imgBorder, $imgCenter, 'staff-list-img-cntr.png', true,$imgHover, $imgDS, $imgCircle );
            //abcfsl_mbox_tplate_img_overlay_optns( $overTxtT1, $overTxtT2, $overFont1, $overFont2, $overTM);
            abcfsl_autil_class_and_style( 'lstImgCls', $lstImgCls, 'lstImgStyle', $lstImgStyle, '', false, '2' );
            //abcfsl_mbox_tplate_pholder( $tplateOptns );
            break;
        case 2:
            abcfsl_mbox_tplate_img_img_cntr( $imgBorder, $imgCenter, 'staff-list-img-cntr.png', true, $imgHover, $imgDS, $imgCircle );
            //abcfsl_mbox_tplate_img_overlay_optns( $overTxtT1, $overTxtT2, $overFont1, $overFont2, $overTM);
            abcfsl_autil_class_and_style( 'lstImgCls', $lstImgCls, 'lstImgStyle', $lstImgStyle, '', false, '2' );
            //abcfsl_mbox_tplate_pholder( $tplateOptns );
            break;
        case 3:
            abcfsl_mbox_tplate_img_img_cntr( $imgBorder, $imgCenter, 'image-container.png', false, $imgHover, $imgDS, $imgCircle );
            //abcfsl_mbox_tplate_img_overlay_optns( $overTxtT1, $overTxtT2, $overFont1, $overFont2, $overTM);
            abcfsl_autil_class_and_style( 'lstImgCls', $lstImgCls, 'lstImgStyle', $lstImgStyle, '', false, '2' );
            //abcfsl_mbox_tplate_pholder( $tplateOptns );
            break;
        default:
            break;
    }
    echo abcfl_html_tag_end('div');
}
//== GENERIC ==============================================================
//Image Style.
function abcfsl_mbox_tplate_img_img_cntr( $imgBorder, $imgCenter, $icon, $hasImgCenter, $imgHover, $imgDS, $imgCircle ){

    $cboImgBorder = abcfsl_cbo_img_border();
    abcfl_input_sec_icon_hdr_hlp( ABCFSL_ICONS_URL , $icon, abcfsl_txta(27), '', abcfsl_aurl(41) );

    echo abcfl_input_cbo_strings('imgBorder', '', $cboImgBorder, $imgBorder, abcfsl_txta(40), abcfsl_txta(228), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    if( $hasImgCenter ) {
        abcfsl_util_center_yn( 'imgCenter', $imgCenter, 84, 0 );
    }

    // HOVER ANIMATIONS
    //abcfsl_mbox_tplate_img_img_hover( $imgHover, $imgDS );
    //abcfsl_mbox_tplate_img_circle( $imgCircle );

    //echo abcfl_input_checkbox_hlp( 'imgCircle', $imgCircle, abcfsl_txta(175), '', abcfsl_aurl(2), ABCFSL_ICONS_URL,  'abcflFldCntr');
}

function abcfsl_mbox_tplate_img_circle( $imgCircle ){

    $lbl = abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(175), abcfsl_aurl(40), 'abcflFontWP abcflFontS13 abcflFontW400' );

    $cboCircle = abcfsl_cbo_img_circle();
    echo abcfl_input_cbo('imgCircle', '', $cboCircle, $imgCircle, $lbl, abcfsl_txta(0), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
}


function abcfsl_mbox_tplate_img_img_hover( $imgHover, $imgDS ){

    $lbl = abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(265), abcfsl_aurl(43), 'abcflFontWP abcflFontS13 abcflFontW400' );

    $cboDS = abcfsl_cbo_drop_shadow();
    $cboHover = abcfsl_cbo_hover();
    echo abcfl_input_cbo('imgDS', '', $cboDS, $imgDS, abcfsl_txta(246), abcfsl_txta(0), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_cbo('imgHover', '', $cboHover, $imgHover, $lbl, '', '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
}

function abcfsl_mbox_tplate_img_overlay_optns( $overTxtT1, $overTxtT2, $overFont1, $overFont2, $overTM){

    echo abcfl_input_hline('2');
    echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(273) . ' ' . abcfsl_txta(9), abcfsl_aurl(42) );

    $cboF = abcfsl_cbo_font_size();
    $cboTM = abcfsl_cbo_txt_overlay_padding_top();

    echo abcfl_input_txt( 'overTxtT1', '', $overTxtT1, abcfsl_txta(43)  . ' 1', '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
    echo abcfl_input_cbo_strings('overFont1', '', $cboF, $overFont1, abcfsl_txta(47), abcfsl_txta(247), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_hline('1');
    echo abcfl_input_txt( 'overTxtT2', '', $overTxtT2,  abcfsl_txta(43) . ' 2', '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
    echo abcfl_input_cbo_strings('overFont2', '', $cboF, $overFont2, abcfsl_txta(47), abcfsl_txta(247), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_cbo_strings('overTM', '', $cboTM, $overTM, abcfsl_txta(15), abcfsl_txta(0), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//== PLACEHOLDER START ===================================
function abcfsl_mbox_tplate_pholder( $tplateOptns ){

    $pImgDefault = isset( $tplateOptns['_pImgDefault'] ) ? $tplateOptns['_pImgDefault'][0] : '0';
    $pImgIDL = isset( $tplateOptns['_pImgIDL'] ) ? esc_attr( $tplateOptns['_pImgIDL'][0] ) : 0;
    $pImgIDS = isset( $tplateOptns['_pImgIDS'] ) ? esc_attr( $tplateOptns['_pImgIDS'][0] ) : 0;
    $pImgUrlL = isset( $tplateOptns['_pImgUrlL'] ) ? esc_attr( $tplateOptns['_pImgUrlL'][0] ) : '';
    $pImgUrlS = isset( $tplateOptns['_pImgUrlS'] ) ? esc_attr( $tplateOptns['_pImgUrlS'][0] ) : '';

    if( empty( $pImgUrlL ) ){ $pImgIDL = 0; }
    if( empty( $pImgUrlS ) ){ $pImgIDS = 0; }
    //======================================================

    echo abcfl_input_hline('2');
    echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(172), abcfsl_aurl(44) );

    echo abcfl_input_checkbox('pImgDefault',  '', $pImgDefault, abcfsl_txta(173), '', '', '', 'abcflFldCntr', '', '', '' );

    //-- Custom Placeholders ------------------------------------------------
    echo abcfl_input_hline('1');
    echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(177), abcfsl_aurl(0) );

    //-- Image: Staff Page ------------------------------------------------
    echo abcfl_html_img_tag('', $pImgUrlL, '', '', 100, '', 'abcflMTop15');

    //-- imgUrlL itemImgUrl -----------------------------------------------
    echo abcfl_html_tag_cls('div', 'abcflFloatsCntr');
    echo abcfl_input_txt('pImgUrlL', '', $pImgUrlL, abcfsl_txta(68) . ' ' . abcfsl_txta(312), '', '100%', '', '', 'abcflFloatL abcflWidth89Pc', 'abcflFldLbl');
    echo abcfl_input_txt_dr('readonly', true, 'pImgIDL', '', $pImgIDL, abcfsl_txta(35), '', '100%', '', '', 'abcflFloatL abcflWidth10Pc', 'abcflFldLbl');
    echo abcfl_html_tag_cls('div', 'abcflClr', true);
    echo abcfl_html_tag_end('div');

    echo  abcfl_html_tag('div','','abcflPTop10');
        echo abcfl_input_btn('btnPImgL', 'btnPImgL', 'button',  abcfsl_txta(263), 'button' );
    echo abcfl_html_tag_end('div');

    //-- Image: Single Page ------------------------------------------------
    echo abcfl_html_img_tag('', $pImgUrlS, '', '', 100, '', 'abcflMTop15');

    echo abcfl_html_tag_cls('div', 'abcflFloatsCntr');
    echo abcfl_input_txt('pImgUrlS', '', $pImgUrlS, abcfsl_txta(69) . ' ' . abcfsl_txta(312), '', '100%', '', '', 'abcflFloatL abcflWidth90Pc', 'abcflFldLbl');
    echo abcfl_input_txt_dr('readonly', true, 'pImgIDS', '', $pImgIDS, abcfsl_txta(35), '', '100%', '', '', 'abcflFloatL abcflWidth10Pc', 'abcflFldLbl');
    echo abcfl_html_tag_cls('div', 'abcflClr', true);
    echo abcfl_html_tag_end('div');

    echo  abcfl_html_tag('div','','abcflPTop10');
        echo abcfl_input_btn('btnPImgS', 'btnPImgS', 'button',  abcfsl_txta(263), 'button' );
    echo abcfl_html_tag_end('div');
}

