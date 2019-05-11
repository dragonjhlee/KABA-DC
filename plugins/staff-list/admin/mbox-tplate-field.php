<?php
//Field options for a single field F+P
function abcfsl_mbox_tplate_field( $tplateOptns, $F ){    

    if( $F == 'F1' ) {echo  abcfl_html_tag('div','','inside');}
    else { echo  abcfl_html_tag( 'div','','inside hidden' ); }

    $fieldType = isset( $tplateOptns['_fieldType_' . $F] ) ? esc_attr( $tplateOptns['_fieldType_' . $F][0] ) : 'N';
    $fieldTypeH = isset( $tplateOptns['_fieldTypeH_' . $F] ) ? esc_attr( $tplateOptns['_fieldTypeH_' . $F][0] ) : 'N';

    //-- Field type not selected. Display only Add New Field cbo ------------------------------------------------------------------------
    if($fieldType == 'N'){
        abcfsl_mbox_tplate_field_add_field_cbo( $fieldType, $F );
        echo abcfl_html_tag_end('div');
        return;
    }

    $showField = isset( $tplateOptns['_showField_' . $F] ) ? esc_attr( $tplateOptns['_showField_' . $F][0] ) : 'L';
    $hideDelete = isset( $tplateOptns['_hideDelete_' . $F] ) ? esc_attr( $tplateOptns['_hideDelete_' . $F][0] ) : 'N';
    $fieldLocked = isset( $tplateOptns['_fieldLocked_' . $F] ) ? esc_attr( $tplateOptns['_fieldLocked_' . $F][0] ) : '0';

    //Line container
    $tagType = isset( $tplateOptns['_tagType_' . $F] ) ? esc_attr( $tplateOptns['_tagType_' . $F][0] ) : 'div';
    $tagFont = isset( $tplateOptns['_tagFont_' . $F] ) ? esc_attr( $tplateOptns['_tagFont_' . $F][0] ) : 'D';
    $tagMarginT = isset( $tplateOptns['_tagMarginT_' . $F] ) ? esc_attr( $tplateOptns['_tagMarginT_' . $F][0] ) : 'N';
    $tagCls = isset( $tplateOptns['_tagCls_' . $F] ) ? esc_attr( $tplateOptns['_tagCls_' . $F][0] ) : '';
    $tagStyle = isset( $tplateOptns['_tagStyle_' . $F] ) ? esc_attr( $tplateOptns['_tagStyle_' . $F][0] ) : '';

    $fieldCntrSPg = isset( $tplateOptns['_fieldCntrSPg_' . $F] ) ? esc_attr( $tplateOptns['_fieldCntrSPg_' . $F][0] ) : 'M';
    $tagTypeSPg = isset( $tplateOptns['_tagTypeSPg_' . $F] ) ? esc_attr( $tplateOptns['_tagTypeSPg_' . $F][0] ) : '';
    $tagFontSPg = isset( $tplateOptns['_tagFontSPg_' . $F] ) ? esc_attr( $tplateOptns['_tagFontSPg_' . $F][0] ) : '';
    $tagMarginTSPg = isset( $tplateOptns['_tagMarginTSPg_' . $F] ) ? esc_attr( $tplateOptns['_tagMarginTSPg_' . $F][0] ) : '';

    //Static Label + Text. Label text
    $lblTxt = isset( $tplateOptns['_lblTxt_' . $F] ) ? esc_attr( $tplateOptns['_lblTxt_' . $F][0] ) : '';

    //Static Label + Text (span). Label section style
    //$lblTag = isset( $tplateOptns['_lblTag_' . $F] ) ? esc_attr( $tplateOptns['_lblTag_' . $F][0] ) : 'div';
    $lblCls = isset( $tplateOptns['_lblCls_' . $F] ) ? esc_attr( $tplateOptns['_lblCls_' . $F][0] ) : '';
    $lblStyle = isset( $tplateOptns['_lblStyle_' . $F] ) ? esc_attr( $tplateOptns['_lblStyle_' . $F][0] ) : '';

    //Static Label + Text (span). Text section style
    $txtCls = isset( $tplateOptns['_txtCls_' . $F] ) ? esc_attr( $tplateOptns['_txtCls_' . $F][0] ) : '';
    $txtStyle = isset( $tplateOptns['_txtStyle_' . $F] ) ? esc_attr( $tplateOptns['_txtStyle_' . $F][0] ) : '';

    //Input field label & description
    $inputLbl = isset( $tplateOptns['_inputLbl_' . $F] ) ? esc_attr( $tplateOptns['_inputLbl_' . $F][0] ) : '';
    $inputHlp = isset( $tplateOptns['_inputHlp_' . $F] ) ? esc_attr( $tplateOptns['_inputHlp_' . $F][0] ) : '';

    $inputLinkLblLbl = isset( $tplateOptns['_lnkLblLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblLbl_' . $F][0] ) : '';
    $inputLinkLblHlp = isset( $tplateOptns['_lnkLblHlp_' . $F] ) ? esc_attr( $tplateOptns['_lnkLblHlp_' . $F][0] ) : '';
    $inputLinkUrlLbl = isset( $tplateOptns['_lnkUrlLbl_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlLbl_' . $F][0] ) : '';
    $inputLinkUrlHlp = isset( $tplateOptns['_lnkUrlHlp_' . $F] ) ? esc_attr( $tplateOptns['_lnkUrlHlp_' . $F][0] ) : '';

    $newTab = isset( $tplateOptns['_newTab_' . $F] ) ? esc_attr( $tplateOptns['_newTab_' . $F][0] ) : 'N';

    //------------------------------------------------------------------------------
    //Field name & hidden Field Type
    if( $fieldTypeH != 'SH' ){
        abcfsl_mbox_tplate_field_number_and_datatype( $fieldTypeH, $F );
        abcfsl_mbox_tplate_field_lock( $showField, $fieldLocked, $F );
    }

    //Field type (hidden value).
    switch ( $fieldTypeH ){
        case 'SC':
            abcfsl_mbox_tplate_field_hide_delete( $hideDelete, $F );
            break;
        case 'MP':
            abcfsl_mbox_tplate_field_section_hdr( 1, 125);
            abcfsl_mbox_tplate_field_parts_MP( $tplateOptns, $F );
            //----------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 5, 286 );
            abcfsl_mbox_tplate_field_show_field( $showField, $hideDelete, $F );
            abcfsl_mbox_tplate_field_cntr_spg( $fieldCntrSPg, $F );
            //---------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 14, 139 );
            abcfsl_mbox_tplate_field_field_cntr_type( $tagType, $F, 'tagType_' );
            abcfsl_mbox_gallery_field_font( 'tagFont_', $tagFont, $F );
            abcfsl_mbox_gallery_field_margin_t( 'tagMarginT_', $tagMarginT, $F );
            //----------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 0, 130 );
            abcfsl_mbox_tplate_field_tag_type_spg( $tagTypeSPg, $F );
            abcfsl_mbox_gallery_field_font_spg( $tagFontSPg, $F );
            abcfsl_mbox_tplate_field_txt_margin_t_spg( $tagMarginTSPg, $F );
            //----------------------------------
            abcfsl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, false, '2' );
            break;
        case 'T':
            abcfsl_mbox_tplate_field_section_hdr( 6 );
            abcfsl_mbox_tplate_field_input_label( $inputLbl, $inputHlp, $F, 208, 282, 209, 257, 0, 'inputLbl_', 'inputHlp_' );
            //------------------------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 5, 286 );
            abcfsl_mbox_tplate_field_show_field( $showField, $hideDelete, $F );
            abcfsl_mbox_tplate_field_cntr_spg( $fieldCntrSPg, $F );
            //---------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 14, 139 );
            abcfsl_mbox_tplate_field_field_cntr_type( $tagType, $F, 'tagType_' );
            abcfsl_mbox_gallery_field_font( 'tagFont_', $tagFont, $F );
            abcfsl_mbox_gallery_field_margin_t( 'tagMarginT_', $tagMarginT, $F );
            //----------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 0, 130 );
            abcfsl_mbox_tplate_field_tag_type_spg( $tagTypeSPg, $F );
            abcfsl_mbox_gallery_field_font_spg( $tagFontSPg, $F );
            abcfsl_mbox_tplate_field_txt_margin_t_spg( $tagMarginTSPg, $F );
            //----------------------------------
            abcfsl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, false, '2' );
            break;
        case 'PT':
            abcfsl_mbox_tplate_field_section_hdr( 15 );
            abcfsl_mbox_tplate_field_input_label( $inputLbl, $inputHlp, $F, 208, 282, 209, 257, 0, 'inputLbl_', 'inputHlp_' );
            //------------------------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 5, 286 );
            abcfsl_mbox_tplate_field_show_field( $showField, $hideDelete, $F );
            abcfsl_mbox_tplate_field_cntr_spg( $fieldCntrSPg, $F );
            //---------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 14, 139 );
            abcfsl_mbox_tplate_field_field_cntr_type( $tagType, $F, 'tagType_' );
            abcfsl_mbox_gallery_field_font( 'tagFont_', $tagFont, $F );
            abcfsl_mbox_gallery_field_margin_t( 'tagMarginT_', $tagMarginT, $F );
            //----------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 0, 130 );
            abcfsl_mbox_tplate_field_tag_type_spg( $tagTypeSPg, $F );
            abcfsl_mbox_gallery_field_font_spg( $tagFontSPg, $F );
            abcfsl_mbox_tplate_field_txt_margin_t_spg( $tagMarginTSPg, $F );
            //----------------------------------
            abcfsl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, false, '2' );
            break;
        case 'LT': //Label + Text
            abcfsl_mbox_tplate_field_section_hdr( 16 );
            //Static label
            abcfsl_mbox_tplate_field_input_static_txt( $lblTxt, $F, 292, 293, '' );
            abcfsl_mbox_tplate_field_input_label( $inputLbl, $inputHlp, $F, 208, 282, 209, 257, 0, 'inputLbl_', 'inputHlp_' );
            //------------------------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 5, 286 );
            abcfsl_mbox_tplate_field_show_field( $showField, $hideDelete, $F );
            abcfsl_mbox_tplate_field_cntr_spg( $fieldCntrSPg, $F );
            //---------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 14, 139 );
            abcfsl_mbox_tplate_field_field_cntr_type( $tagType, $F, 'tagType_');
            abcfsl_mbox_gallery_field_font( 'tagFont_', $tagFont, $F );
            abcfsl_mbox_gallery_field_margin_t( 'tagMarginT_', $tagMarginT, $F );
            //----------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 0, 130 );
            abcfsl_mbox_tplate_field_tag_type_spg( $tagTypeSPg, $F );
            abcfsl_mbox_gallery_field_font_spg( $tagFontSPg, $F );
            abcfsl_mbox_tplate_field_txt_margin_t_spg( $tagMarginTSPg, $F );
            //----------------------------------
            abcfsl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, true, '2', '', '', '', '', 2, 211 );
            //------------------------------------------------
            //Static label style
            abcfsl_autil_class_and_style( 'lblCls_', $lblCls, 'lblStyle_', $lblStyle, $F, true, '2', '', '', '', '', 0, 226 );
            //Text  style
            abcfsl_autil_class_and_style( 'txtCls_', $txtCls, 'txtStyle_', $txtStyle, $F, true, '2', '', '', '', '', 0, 81 );
            break;
        case 'H': //Hyperlink
            abcfsl_mbox_tplate_field_section_hdr( 17 );
            echo abcfl_input_info_lbl(abcfsl_txta(230), 'abcflMTop5', 12);;
            abcfsl_mbox_tplate_field_input_label( $inputLinkLblLbl, $inputLinkLblHlp, $F, 205, 282, 245, 257, 0, 'lnkLblLbl_', 'lnkLblHlp_' );
            echo abcfl_input_hline('1', '20');
            abcfsl_mbox_tplate_field_input_label( $inputLinkUrlLbl, $inputLinkUrlHlp, $F, 302, 282, 317, 257, 0, 'lnkUrlLbl_', 'lnkUrlHlp_' );
            //------------------------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 5, 286 );
            abcfsl_mbox_tplate_field_show_field( $showField, $hideDelete, $F );
            abcfsl_mbox_tplate_field_cntr_spg( $fieldCntrSPg, $F );
            //---------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 14, 139 );
            abcfsl_mbox_tplate_field_field_cntr_type( $tagType, $F, 'tagType_');
            abcfsl_mbox_gallery_field_font( 'tagFont_', $tagFont, $F );
            abcfsl_mbox_gallery_field_margin_t( 'tagMarginT_', $tagMarginT, $F );
            //----------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 0, 130 );
            abcfsl_mbox_tplate_field_tag_type_spg( $tagTypeSPg, $F );
            abcfsl_mbox_gallery_field_font_spg( $tagFontSPg, $F );
            abcfsl_mbox_tplate_field_txt_margin_t_spg( $tagMarginTSPg, $F );
            //----------------------------------
            abcfsl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, false );
            break;
        case 'TH': //Static text + Hyperlink
            abcfsl_mbox_tplate_field_section_hdr( 18 );
            echo abcfl_input_info_lbl(abcfsl_txta(230), 'abcflMTop5', 12);

            //Static text
            abcfsl_mbox_tplate_field_input_static_txt( $lblTxt, $F, 259, 264, '' );
            abcfsl_mbox_tplate_field_input_label( $inputLinkUrlLbl, $inputLinkUrlHlp, $F, 302, 282, 317, 257, 0, 'lnkUrlLbl_', 'lnkUrlHlp_' );
            //----------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 5, 286 );
            abcfsl_mbox_tplate_field_show_field( $showField, $hideDelete, $F );
            abcfsl_mbox_tplate_field_cntr_spg( $fieldCntrSPg, $F );
            //---------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 14, 139 );
            abcfsl_mbox_tplate_field_field_cntr_type( $tagType, $F, 'tagType_' );
            abcfsl_mbox_gallery_field_font( 'tagFont_', $tagFont, $F );
            abcfsl_mbox_gallery_field_margin_t( 'tagMarginT_', $tagMarginT, $F );
            //----------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 0, 130 );
            abcfsl_mbox_tplate_field_tag_type_spg( $tagTypeSPg, $F );
            abcfsl_mbox_gallery_field_font_spg( $tagFontSPg, $F );
            abcfsl_mbox_tplate_field_txt_margin_t_spg( $tagMarginTSPg, $F );
            //----------------------------------
            abcfsl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, false );
            break;
        case 'SH': //Single Page Hyperlink DISCONTINUED
            abcfsl_mbox_tplate_field_number_and_datatype($fieldTypeH, $F);
            echo abcfl_input_info_lbl( abcfsl_txta(357), 'abcflRed abcflMTop15', 16, 'N' );
            echo abcfl_input_info_lbl( abcfsl_txta(358), 'abcflBlack abcflMTop10', 14 );

            abcfsl_mbox_tplate_field_lock($showField, $fieldLocked, $F );

            abcfsl_mbox_tplate_field_section_hdr( 23 );
            abcfsl_mbox_tplate_field_input_static_txt( $lblTxt, $F, 259, 127, '' );
            abcfsl_mbox_tplate_field_new_tab( $newTab, $F );
            //----------------------------------
            echo abcfl_input_hline('2', '20');
            abcfsl_mbox_tplate_field_hide_delete( $hideDelete, $F );
            //---------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 14, 139 );
            abcfsl_mbox_tplate_field_field_cntr_type( $tagType, $F, 'tagType_' );
            abcfsl_mbox_gallery_field_font( 'tagFont_', $tagFont, $F );
            abcfsl_mbox_gallery_field_margin_t( 'tagMarginT_', $tagMarginT, $F );
            //----------------------------------
            abcfsl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, false );
            break;
        case 'EM': //Email
            abcfsl_mbox_tplate_field_section_hdr( 19 );
            echo abcfl_input_info_lbl(abcfsl_txta(200), 'abcflMTop5', 13);
            abcfsl_mbox_tplate_field_input_label( $inputLinkLblLbl, $inputLinkLblHlp, $F, 205, 282, 245, 257, 0, 'lnkLblLbl_', 'lnkLblHlp_' );
            echo abcfl_input_hline('1', '20');
            abcfsl_mbox_tplate_field_input_label( $inputLinkUrlLbl, $inputLinkUrlHlp, $F, 300, 282, 318, 257, 0, 'lnkUrlLbl_', 'lnkUrlHlp_' );
            //------------------------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 5, 286 );
            abcfsl_mbox_tplate_field_show_field( $showField, $hideDelete, $F );
            abcfsl_mbox_tplate_field_cntr_spg( $fieldCntrSPg, $F );
            //---------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 14, 139 );
            abcfsl_mbox_tplate_field_field_cntr_type( $tagType, $F, 'tagType_');
            abcfsl_mbox_gallery_field_font( 'tagFont_', $tagFont, $F );
            abcfsl_mbox_gallery_field_margin_t( 'tagMarginT_', $tagMarginT, $F );
            //----------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 0, 130 );
            abcfsl_mbox_tplate_field_tag_type_spg( $tagTypeSPg, $F );
            abcfsl_mbox_gallery_field_font_spg( $tagFontSPg, $F );
            abcfsl_mbox_tplate_field_txt_margin_t_spg( $tagMarginTSPg, $F );
            //----------------------------------
            abcfsl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, false, '2' );
            break;
        case 'CE': //WP Text editor
            abcfsl_mbox_tplate_field_section_hdr( 20 );
            abcfsl_mbox_tplate_field_input_label( $inputLbl, $inputHlp, $F, 208, 282, 209, 257, 0, 'inputLbl_', 'inputHlp_' );
            //------------------------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 5, 286 );
            abcfsl_mbox_tplate_field_show_field( $showField, $hideDelete, $F );
            abcfsl_mbox_tplate_field_cntr_spg( $fieldCntrSPg, $F );
            //---------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 14, 139 );
            abcfsl_mbox_tplate_field_field_cntr_type( $tagType, $F, 'tagType_' );
            abcfsl_mbox_gallery_field_font( 'tagFont_', $tagFont, $F );
            abcfsl_mbox_gallery_field_margin_t( 'tagMarginT_', $tagMarginT, $F );
            //----------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 0, 130 );
            abcfsl_mbox_tplate_field_tag_type_spg( $tagTypeSPg, $F );
            abcfsl_mbox_gallery_field_font_spg( $tagFontSPg, $F );
            abcfsl_mbox_tplate_field_txt_margin_t_spg( $tagMarginTSPg, $F );
            //----------------------------------
            abcfsl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, false, '2' );
            break;
        case 'HL': //Horizontal Line
            abcfsl_mbox_tplate_field_section_hdr( 24 );
            abcfsl_mbox_tplate_field_input_txt_r( $inputLbl, $F, 208, 282, 'inputLbl_' );
            //------------------------------------------------
            abcfsl_mbox_tplate_field_section_hdr( 5, 286 );
            abcfsl_mbox_tplate_field_show_field( $showField, $hideDelete, $F );
            abcfsl_mbox_tplate_field_cntr_spg( $fieldCntrSPg, $F );
            //------------------------------------------------
            abcfsl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, false, '2' );
            break;    
        default:
            break;
    }
echo abcfl_html_tag_end('div');
}

//== SECTION HEADERS ==================================================
//Add new field
function abcfsl_mbox_tplate_field_add_field_cbo( $fieldType, $F ){
    echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(320), abcfsl_aurl(13) );
    $cboLineType = abcfsl_cbo_field_type();
    echo abcfl_input_cbo('fieldType_' . $F, '',$cboLineType, $fieldType, abcfsl_txta(222), abcfsl_txta(212), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Field number and datatype
function abcfsl_mbox_tplate_field_number_and_datatype( $fieldTypeH, $F ){

    $cboLineType = abcfsl_cbo_field_type_all();
    $fieldType = $cboLineType[$fieldTypeH];

    echo abcfl_input_sec_title( $F. '.&nbsp;&nbsp;' . $fieldType, 'abcflFontWP abcflFontS20 abcflFontW600 abcflMTop10 abcflBlue');
    echo abcfl_input_hidden( '', 'fieldTypeH_' . $F, $fieldTypeH );
}

//Section header + optional help link (?)
function abcfsl_mbox_tplate_field_section_hdr( $aurl, $txta=319, $hline=true){
    if( $hline ) { echo abcfl_input_hline('2', '20'); }
    echo abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta($txta), abcfsl_aurl($aurl) );
}
//===================================================================

//== FIELDS =========================================================
function abcfsl_mbox_tplate_field_lock($showField, $fieldLocked, $F ){

    if($showField == 'N'){ return;}

    $clsBoxlbl = '';
    $boxLbl = abcfsl_txta(296);
    if($fieldLocked == '1'){
        $clsBoxlbl = 'abcflBBRed';
        $boxLbl = abcfsl_txta(297);
    }
    echo abcfl_input_checkbox('lineLocked_'. $F,  '', $fieldLocked, $boxLbl, '', '', '', 'abcflFldCntr', '', '', $clsBoxlbl );
}

function abcfsl_mbox_tplate_field_show_field( $showField, $hideDelete, $F ){

    $cboShowField = abcfsl_cbo_show_field();
    echo abcfl_input_cbo('showField_' . $F, '',$cboShowField, $showField, abcfsl_txta_r(72), abcfsl_txta(233), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    abcfsl_mbox_tplate_field_hide_delete( $hideDelete, $F );
}


function abcfsl_mbox_tplate_field_hide_delete( $hideDelete, $F ){

    $cboHideDelete = abcfsl_cbo_hide_delete();
    echo abcfl_input_cbo('hideDelete_' . $F, '',$cboHideDelete, $hideDelete, abcfsl_txta_r(71), abcfsl_txta(134), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Field container type
function abcfsl_mbox_tplate_field_field_cntr_type( $tagType, $F, $typeL='tagType_'){

    $cboTxtCntr = abcfsl_cbo_tag_type();
    echo abcfl_input_cbo($typeL . $F, '',$cboTxtCntr, $tagType, abcfsl_txta_r(287), abcfsl_txta(279), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
}

function abcfsl_mbox_tplate_field_tag_type_spg( $tagType, $F ){

    $cboTxtCntr = abcfsl_cbo_tag_type_spg();
    echo abcfl_input_cbo('tagTypeSPg_' . $F, '',$cboTxtCntr, $tagType, abcfsl_txta(287), '', '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
}

function abcfsl_mbox_tplate_field_new_tab( $newTab, $F ){
    $cboYN = abcfsl_cbo_yn();
    echo abcfl_input_cbo('newTab_' . $F, '', $cboYN, $newTab, abcfsl_txta(143), '', '50%', false, '', '', 'abcflFldCntr', 'abcflFldLbl');
}
//=======================================================
//Field name and help
function abcfsl_mbox_tplate_field_input_label( $inputLbl, $inputHlp, $F, $name1, $help1, $name2, $help2, $name3, $lbl='inputLbl_', $hlp='inputHlp_'){

    echo abcfl_input_txt($lbl . $F, '', $inputLbl, abcfsl_txta_r( $name1 ), abcfsl_txta($help1), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_info_lbl( abcfsl_txta( $name3 ), '' );
    echo abcfl_input_txt($hlp . $F, '', $inputHlp, abcfsl_txta($name2), abcfsl_txta($help2), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

function abcfsl_mbox_tplate_field_input_txt_r( $inputLbl, $F, $name, $help, $lbl='inputLbl_' ){
    echo abcfl_input_txt( $lbl . $F, '', $inputLbl, abcfsl_txta_r( $name ), abcfsl_txta( $help ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

function abcfsl_mbox_tplate_field_input_txt( $inputLbl, $F, $name, $help, $lbl, $width='50%' ){
    echo abcfl_input_txt( $lbl . $F, '', $inputLbl, abcfsl_txta( $name ), abcfsl_txta( $help ), $width, '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//????????????????????????????????
function abcfsl_mbox_tplate_field_input_label_1( $inputLbl, $F, $name1, $help1, $lbl='inputLbl_' ){
    echo abcfl_input_txt($lbl . $F, '', $inputLbl, abcfsl_txta_r( $name1 ), abcfsl_txta($help1), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//==MP START ===================================================
function abcfsl_mbox_tplate_field_parts_MP( $tplateOptns, $F ){

    $inputLblP1 = isset( $tplateOptns['_inputLblP1_' . $F] ) ? esc_attr( $tplateOptns['_inputLblP1_' . $F][0] ) : '';
    $inputLblP2 = isset( $tplateOptns['_inputLblP2_' . $F] ) ? esc_attr( $tplateOptns['_inputLblP2_' . $F][0] ) : '';
    $inputLblP3 = isset( $tplateOptns['_inputLblP3_' . $F] ) ? esc_attr( $tplateOptns['_inputLblP3_' . $F][0] ) : '';
    $inputLblP4 = isset( $tplateOptns['_inputLblP4_' . $F] ) ? esc_attr( $tplateOptns['_inputLblP4_' . $F][0] ) : '';
    $inputHlp = isset( $tplateOptns['_inputHlp_' . $F] ) ? esc_attr( $tplateOptns['_inputHlp_' . $F][0] ) : '';

    $orderLP1 = isset( $tplateOptns['_orderLP1_' . $F] ) ? esc_attr( $tplateOptns['_orderLP1_' . $F][0] ) : '0';
    $orderLP2 = isset( $tplateOptns['_orderLP2_' . $F] ) ? esc_attr( $tplateOptns['_orderLP2_' . $F][0] ) : '0';
    $orderLP3 = isset( $tplateOptns['_orderLP3_' . $F] ) ? esc_attr( $tplateOptns['_orderLP3_' . $F][0] ) : '0';
    $orderLP4 = isset( $tplateOptns['_orderLP4_' . $F] ) ? esc_attr( $tplateOptns['_orderLP4_' . $F][0] ) : '0';

    $orderSP1 = isset( $tplateOptns['_orderSP1_' . $F] ) ? esc_attr( $tplateOptns['_orderSP1_' . $F][0] ) : '0';
    $orderSP2 = isset( $tplateOptns['_orderSP2_' . $F] ) ? esc_attr( $tplateOptns['_orderSP2_' . $F][0] ) : '0';
    $orderSP3 = isset( $tplateOptns['_orderSP3_' . $F] ) ? esc_attr( $tplateOptns['_orderSP3_' . $F][0] ) : '0';
    $orderSP4 = isset( $tplateOptns['_orderSP4_' . $F] ) ? esc_attr( $tplateOptns['_orderSP4_' . $F][0] ) : '0';

    $sfixLP1 = isset( $tplateOptns['_sfixLP1_' . $F] ) ? esc_attr( $tplateOptns['_sfixLP1_' . $F][0] ) : '';
    $sfixLP2 = isset( $tplateOptns['_sfixLP2_' . $F] ) ? esc_attr( $tplateOptns['_sfixLP2_' . $F][0] ) : '';
    $sfixLP3 = isset( $tplateOptns['_sfixLP3_' . $F] ) ? esc_attr( $tplateOptns['_sfixLP3_' . $F][0] ) : '';
    $sfixLP4 = isset( $tplateOptns['_sfixLP4_' . $F] ) ? esc_attr( $tplateOptns['_sfixLP4_' . $F][0] ) : '';

    $sfixSP1 = isset( $tplateOptns['_sfixSP1_' . $F] ) ? esc_attr( $tplateOptns['_sfixSP1_' . $F][0] ) : '';
    $sfixSP2 = isset( $tplateOptns['_sfixSP2_' . $F] ) ? esc_attr( $tplateOptns['_sfixSP2_' . $F][0] ) : '';
    $sfixSP3 = isset( $tplateOptns['_sfixSP3_' . $F] ) ? esc_attr( $tplateOptns['_sfixSP3_' . $F][0] ) : '';
    $sfixSP4 = isset( $tplateOptns['_sfixSP4_' . $F] ) ? esc_attr( $tplateOptns['_sfixSP4_' . $F][0] ) : '';


    $cbo123 = abcfsl_cbo_123();

    $lblP1 = abcfl_input_txt('inputLblP1_' . $F, '', $inputLblP1, abcfsl_txta(208), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    $lblP2 = abcfl_input_txt('inputLblP2_' . $F, '', $inputLblP2, '', '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    $lblP3 = abcfl_input_txt('inputLblP3_' . $F, '', $inputLblP3, '', '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    $lblP4 = abcfl_input_txt('inputLblP4_' . $F, '', $inputLblP4, '', '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');

    $oLP1 = abcfl_input_cbo('orderLP1_' . $F, '',$cbo123, $orderLP1, abcfsl_txta(122), '', '100%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    $sLP1 = abcfl_input_txt('sfixLP1_' . $F, '', $sfixLP1, abcfsl_txta(124), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    $oLP2 = abcfl_input_cbo('orderLP2_' . $F, '',$cbo123, $orderLP2, '', '', '100%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    $sLP2 = abcfl_input_txt('sfixLP2_' . $F, '', $sfixLP2, '', '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    $oLP3 = abcfl_input_cbo('orderLP3_' . $F, '',$cbo123, $orderLP3, '', '', '100%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    $sLP3 = abcfl_input_txt('sfixLP3_' . $F, '', $sfixLP3, '', '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    $oLP4 = abcfl_input_cbo('orderLP4_' . $F, '',$cbo123, $orderLP4, '', '', '100%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    $sLP4 = abcfl_input_txt('sfixLP4_' . $F, '', $sfixLP4, '', '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');

    $oSP1 = abcfl_input_cbo('orderSP1_' . $F, '',$cbo123, $orderSP1, abcfsl_txta(123), '', '100%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    $sSP1 = abcfl_input_txt('sfixSP1_' . $F, '', $sfixSP1, abcfsl_txta(124), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    $oSP2 = abcfl_input_cbo('orderSP2_' . $F, '',$cbo123, $orderSP2, '', '', '100%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    $sSP2 = abcfl_input_txt('sfixSP2_' . $F, '', $sfixSP2, '', '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    $oSP3 = abcfl_input_cbo('orderSP3_' . $F, '',$cbo123, $orderSP3, '', '', '100%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    $sSP3 = abcfl_input_txt('sfixSP3_' . $F, '', $sfixSP3, '', '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    $oSP4 = abcfl_input_cbo('orderSP4_' . $F, '',$cbo123, $orderSP4, '', '', '100%', true, '', '', 'abcflFldCntr', 'abcflFldLbl');
    $sSP4 = abcfl_input_txt('sfixSP4_' . $F, '', $sfixSP4, '', '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');

    echo abcfsl_mbox_tplate_field_MP_fields( '1', $lblP1, $oLP1, $sLP1, $oSP1, $sSP1 );
    echo abcfsl_mbox_tplate_field_MP_fields( '2', $lblP2, $oLP2, $sLP2, $oSP2, $sSP2 );
    echo abcfsl_mbox_tplate_field_MP_fields( '3', $lblP3, $oLP3, $sLP3, $oSP3, $sSP3 );
    echo abcfsl_mbox_tplate_field_MP_fields( '4', $lblP4, $oLP4, $sLP4, $oSP4, $sSP4 );

    echo abcfl_input_info_lbl(abcfsl_txta(126), 'abcflMTop10', '12', 'N');
    echo abcfl_input_txt('inputHlp_' . $F, '', $inputHlp, abcfsl_txta( 209 ), abcfsl_txta( 257 ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');

}

function  abcfsl_mbox_tplate_field_MP_fields( $partNo, $lbl, $orderP, $sfixP, $orderS, $sfixS ){

    $divE = abcfl_html_tag_end( 'div');

    $out = abcfl_html_tag( 'div', '', 'abcflMultiFieldsCntr' );
    $out .= abcfsl_mbox_tplate_field_MP_part_no( $partNo );
    $out .= abcfl_html_tag( 'div', '', 'abcflFloatL abcflMPLbl abcflPRight10' ) . $lbl . $divE;
    $out .= abcfl_html_tag( 'div', '', 'abcflFloatL abcflMPOrder abcflPRight5' ) . $orderP . $divE;
    $out .= abcfl_html_tag( 'div', '', 'abcflFloatL abcflMPSuffix abcflPRight10' ) .  $sfixP . $divE;
    $out .= abcfl_html_tag( 'div', '', 'abcflFloatL abcflMPOrder abcflPRight5' ) . $orderS . $divE;
    $out .= abcfl_html_tag( 'div', '', 'abcflFloatL abcflMPSuffix' ) . $sfixS . $divE;
    $out .= abcfl_html_tag_cls( 'div', 'abcflClr', true ) . $divE;

    return $out;
}

function  abcfsl_mbox_tplate_field_MP_part_no( $partNo ){

    $divE = abcfl_html_tag_end( 'div');

    $out = abcfl_html_tag( 'div', '', 'abcflFloatL abcflPRight5' );
    $out .= abcfl_html_tag( 'div', '', 'abcflFldCntr' );
    if( $partNo == 1 ){ $out .= abcfl_html_tag( 'div', '', 'abcflFldLbl' ) . '&nbsp;' . $divE; }
    $out .= abcfl_input_info_lbl(abcfsl_txta(121, ' ' . $partNo), '', '13', 'SB');
    $out .= $divE . $divE;
    return $out;

//<div class="abcflFloatL abcflPRight10">
//    <div class="abcflFldCntr">
//        <div class="abcflFldLbl">&nbsp;</div>
//        <div class="abcflFontWP abcflFontS16 abcflFontW600">Part 1</div>
//    </div>
//</div>

//<div class="abcflFloatL abcflPRight10">
//    <div class="abcflFldCntr">
//        <div class="abcflFontWP abcflFontS16 abcflFontW600">Part 2</div>
//    </div>
//</div>
}
//==MP END ===================================================

//Generic Text input. ??????
function abcfsl_mbox_tplate_field_input_static_txt( $lblTxt, $F, $name=292, $help=293, $suffix='' ){
    echo abcfl_input_txt('lblTxt_' . $F, '', $lblTxt, abcfsl_txta_r( $name, $suffix ), abcfsl_txta($help), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Fonts
function abcfsl_mbox_gallery_field_font( $fieldName, $fielValue, $F, $help=247, $lbl=47 ){
    $cbo = abcfsl_cbo_font_size();
    echo abcfl_input_cbo_strings($fieldName . $F, '', $cbo, $fielValue, abcfsl_txta( $lbl ), abcfsl_txta( $help ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

function abcfsl_mbox_gallery_field_font_spg( $fielValue, $F ){
    $cbo = abcfsl_cbo_font_size_spg();
    echo abcfl_input_cbo_strings('tagFontSPg_' . $F, '', $cbo, $fielValue, abcfsl_txta( 47 ), '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Top margin.
function abcfsl_mbox_gallery_field_margin_t( $fieldName, $fielValue, $F, $help=0, $lbl=15 ){
    $cbo = abcfsl_cbo_txt_margin_top();
    echo abcfl_input_cbo_strings($fieldName . $F, '', $cbo, $fielValue, abcfsl_txta( $lbl ), abcfsl_txta( $help ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

function abcfsl_mbox_tplate_field_txt_margin_t_spg( $fielValue, $F ){
    $cbo = abcfsl_cbo_txt_margin_top_spg();
    echo abcfl_input_cbo_strings('tagMarginTSPg_' . $F, '', $cbo, $fielValue, abcfsl_txta( 15 ), '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

function abcfsl_mbox_tplate_field_cntr_spg( $fielValue, $F ){
    $cbo = abcfsl_cbo_field_cntr_spg();
    $lbl = abcfl_input_sec_title_hlp( ABCFSL_ICONS_URL, abcfsl_txta(140), abcfsl_aurl(9), 'abcflFontWP abcflFontS12 abcflFontW400' );
    echo abcfl_input_cbo_strings('fieldCntrSPg_' . $F, '', $cbo, $fielValue, $lbl, abcfsl_txta(148), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}
