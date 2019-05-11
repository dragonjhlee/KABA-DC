<?php
if ( ! defined( 'ABSPATH' ) ) {exit;}
class ABCFSL_MBox_List {

    public function __construct() {
        add_action( 'add_meta_boxes_cpt_staff_lst', array( $this, 'add_meta_box' ) );
        add_action( 'save_post_cpt_staff_lst', array( $this, 'save_post' ) );
    }

    public function add_meta_box() {
        add_meta_box(
            'abcfsl_mbox_staff_lst',
            abcfsl_txta(19),
            array( $this, 'display_mbox_lst_optns' ),
            'cpt_staff_lst',
            'normal',
            'high'
        );
        add_meta_box(
            'abcfsl_mbox_staff_lst_fields',
            abcfsl_txta(217),
            array( $this, 'display_mbox' ),
            'cpt_staff_lst',
            'normal',
            'default'
        );
    }

    public function display_mbox_lst_optns() {
        abcfsl_mbox_tplate_tabs();
    }

    public function display_mbox() {
	abcfsl_mbox_tplate_fields();
    }

    public function save_post( $postID ) {

        $obj = ABCFSL_Main();
        $slug = $obj->pluginSlug;

//echo"<pre>", print_r($_POST), "</pre>";  die;

        //Exit if user doesn't have permission to save
        if (!$this->user_can_save( $postID, $slug ) ) { return; }

        //Save data.---------------------------------------------
        //New record.
        $lstLayoutH = ( isset( $_POST['lstLayoutH']) ? esc_attr( $_POST['lstLayoutH'] ) : '0' );
        $lstLayout = ( isset( $_POST['lstLayout' ]) ? esc_attr( $_POST['lstLayout' ] ) : $lstLayoutH );

        if ($lstLayout == '0' ){ return; }
        if ($lstLayoutH == '0'){
            abcfl_mbsave_save_cbo( $postID, 'lstLayout', '_lstLayout', '0');
            abcfl_mbsave_save_field( $postID, '_lstLayoutH', $lstLayout);
            return;
        }

        abcfl_mbsave_save_chekbox($postID, 'showAllStaff', '_showAllStaff');
        abcfl_mbsave_save_cbo( $postID, 'lstCols', '_lstCols', '6');
        abcfl_mbsave_save_cbo( $postID, 'gridCols', '_gridCols', '2');
        abcfl_mbsave_save_cbo( $postID, 'gridColsLG', '_gridColsLG', '0');
        abcfl_mbsave_save_cbo( $postID, 'gridColsMD', '_gridColsMD', '0');

        // ????????? -----------------------------------------
        //Legacy grid margins and padding. Delete data on save. Data is copied to custom CSS when form opens  and saved as CSS. ?????????
        abcfl_mbsave_save_txt( $postID, 'itemMarginL', '_itemMarginL');
        abcfl_mbsave_save_txt( $postID, 'itemMarginB', '_itemMarginB');

        //New version of grid margins and padding
        abcfl_mbsave_save_cbo( $postID, 'itemPadLR', '_itemPadLR' , 'Pc1');
        abcfl_mbsave_save_cbo( $postID, 'itemMarginBN', '_itemMarginBN' , '40');
        //-----------------------------------------

        abcfl_mbsave_save_cbo( $postID, 'lstVAid', '_vAid', 'N');

        abcfl_mbsave_save_txt($postID, 'lstItemCls', '_lstItemCls');
        abcfl_mbsave_save_txt($postID, 'lstItemStyle', '_lstItemStyle');
//        abcfl_mbsave_save_txt($postID, 'innerCntrCls', '_innerCntrCls');
//        abcfl_mbsave_save_txt($postID, 'innerCntrStyle', '_innerCntrStyle');

        // -- Image ------------------------
        $this->save_img( $postID );
        //$this->save_pholder_imgs( $_POST, $postID );
        //$this->save_social( $postID );
        //$this->save_pagination( $postID );

//        abcfl_mbsave_save_cbo( $postID, 'imgBorder', '_imgBorder', 'D');
//        abcfl_mbsave_save_cbo( $postID, 'imgCenter', '_imgCenter', 'Y');
//        abcfl_mbsave_save_txt($postID, 'lstImgCls', '_lstImgCls');
//        abcfl_mbsave_save_txt($postID, 'lstImgStyle', '_lstImgStyle');

        abcfl_mbsave_save_txt($postID, 'lstTxtCntrCls', '_lstTxtCntrCls');
        abcfl_mbsave_save_txt($postID, 'lstTxtCntrStyle', '_lstTxtCntrStyle');
        abcfl_mbsave_save_cbo( $postID, 'addMaxW', '_addMaxW', 'N');

        abcfl_mbsave_save_txt($postID, 'lstCntrW', '_lstCntrW');
        abcfl_mbsave_save_cbo( $postID, 'lstACenter', '_lstACenter', 'Y');

        abcfl_mbsave_save_txt($postID, 'lstCntrTM', '_lstCntrTM');
        abcfl_mbsave_save_txt($postID, 'lstCntrCls', '_lstCntrCls');
        abcfl_mbsave_save_txt($postID, 'lstCntrStyle', '_lstCntrStyle');

        abcfl_mbsave_save_txt($postID, 'sPageUrl', '_sPageUrl');
        abcfl_mbsave_save_cbo($postID, 'sortType', '_sortType', 'M');

        // -- Single Page text Link ------------------------
        abcfl_mbsave_save_cbo( $postID,'sPgLnkShow', '_sPgLnkShow', 'N');
        abcfl_mbsave_save_txt($postID, 'sPageUrl', '_sPageUrl');
        abcfl_mbsave_save_txt($postID, 'sPgLnkTxt', '_sPgLnkTxt');
        abcfl_mbsave_save_chekbox($postID, 'sPgLnkNT', '_sPgLnkNT');
        abcfl_mbsave_save_cbo( $postID, 'sPgLnkTag', '_sPgLnkTag', 'div');
        abcfl_mbsave_save_cbo( $postID, 'sPgLnkFont', '_sPgLnkFont', 'D');
        abcfl_mbsave_save_cbo( $postID, 'sPgLnkMarginT', '_sPgLnkMarginT', 'N');
        abcfl_mbsave_save_txt($postID, 'sPgLnkCls', '_sPgLnkCls');
        abcfl_mbsave_save_txt($postID, 'sPgLnkStyle', '_sPgLnkStyle');

        abcfl_mbsave_save_cbo( $postID,'tplateMenuID', '_tplateMenuID', '0');

        //$showPgLnk = isset( $_POST['sPgLnkShow'] ) ? esc_attr( $_POST['sPgLnkShow'][0] ) : 'N';
        $showPgLnk = isset( $_POST['sPgLnkShow'] ) ? $_POST['sPgLnkShow'] : 'N';
        abcfsl_autil_add_new_field_to_field_order( $postID, $showPgLnk, 'L', 'SPTL' );

        // -- Single Layout ------------------------
        abcfl_mbsave_save_cbo( $postID, 'spgCols', '_spgCols', '1');
        abcfl_mbsave_save_cbo( $postID, 'spgMMarginT', '_spgMMarginT', '');

        abcfl_mbsave_save_cbo( $postID, 'spgVAid', '_spgVAid', 'N');
        abcfl_mbsave_save_txt($postID, 'spgCntrW', '_spgCntrW');
        abcfl_mbsave_save_cbo( $postID, 'spgACenter', '_spgACenter', 'Y');
        abcfl_mbsave_save_txt($postID, 'spgCntrTM', '_spgCntrTM');
        abcfl_mbsave_save_txt($postID, 'spgCntrCls', '_spgCntrCls');
        abcfl_mbsave_save_txt($postID, 'spgCntrStyle', '_spgCntrStyle');

        for ( $i = 1; $i <= 10; $i++ ) {
            $this->save_line_option( $postID, 'F' . $i );
        }
    }
    //===============================================
    private function save_img( $postID ) {

        abcfl_mbsave_save_cbo( $postID, 'imgBorder', '_imgBorder', 'D');
        abcfl_mbsave_save_cbo( $postID, 'imgCenter', '_imgCenter', 'Y');
        //abcfl_mbsave_save_cbo( $postID, 'imgCircle', '_imgCircle', '');
        //abcfl_mbsave_save_cbo( $postID, 'imgHover', '_imgHover', '');
        //abcfl_mbsave_save_cbo( $postID, 'imgDS', '_imgDS', '');
//        abcfl_mbsave_save_txt($postID, 'overTxtT1', '_overTxtT1');
//        abcfl_mbsave_save_txt($postID, 'overTxtT2', '_overTxtT2');
//        abcfl_mbsave_save_cbo( $postID, 'overFont1', '_overFont1', 'D');
//        abcfl_mbsave_save_cbo( $postID, 'overFont2', '_overFont2', 'D');
//        abcfl_mbsave_save_cbo( $postID, 'overTM', '_overTM', 'N');

        abcfl_mbsave_save_txt($postID, 'lstImgCls', '_lstImgCls');
        abcfl_mbsave_save_txt($postID, 'lstImgStyle', '_lstImgStyle');

        //abcfl_mbsave_save_chekbox($postID, 'pImgDefault', '_pImgDefault');
    }

    private function save_line_option( $postID, $F ) {

        //New field type not selected.
        $fieldTypeH = ( isset( $_POST['fieldTypeH_' . $F ]) ? esc_attr( $_POST['fieldTypeH_' . $F ] ) : 'N' );
        $fieldType = ( isset( $_POST['fieldType_' . $F ]) ? esc_attr( $_POST['fieldType_' . $F ] ) : $fieldTypeH );

        if ( $fieldType == 'N' ){ return 0; }

        //Add new field. Hidden field type not set. Field type is selected.
        if ($fieldTypeH == 'N'){
            //Add new field.
            abcfl_mbsave_save_cbo( $postID, 'fieldType_' . $F, '_fieldType_' . $F, 'N');
            abcfl_mbsave_save_field( $postID, '_fieldTypeH_' . $F, $fieldType);
            return 0;
        }

        //Checkbox Locked
        if (isset( $_POST['lineLocked_' . $F ])){
            abcfl_mbsave_save_chekbox($postID, 'lineLocked_' . $F, '_fieldLocked_' . $F);
        }

        //Delete field
        $hideDelete = ( isset( $_POST['hideDelete_' . $F ]) ? esc_attr( $_POST['hideDelete_' . $F ] ) : 'L' );
        if($hideDelete == 'D'){
            $this->delete_fields( $postID, $F );
            return 0;
        }

        //Add a new field to the sort fields array.
        $showField = ( isset( $_POST['showField_' . $F ]) ? esc_attr( $_POST['showField_' . $F ] ) : 'L' );
        abcfsl_autil_add_new_field_to_field_order( $postID, $hideDelete, $showField, $F );

        abcfl_mbsave_save_cbo( $postID, 'showField_' . $F, '_showField_' . $F, 'L');
        abcfl_mbsave_save_cbo( $postID, 'hideDelete_' . $F, '_hideDelete_' . $F, 'N');
        abcfl_mbsave_save_chekbox($postID, 'lineLocked_' . $F, '_fieldLocked_' . $F);

        abcfl_mbsave_save_cbo( $postID,'fieldCntrSPg_' . $F, '_fieldCntrSPg_' . $F, 'M');
        //-----------------------------------------------------
        abcfl_mbsave_save_cbo( $postID,'tagType_' . $F, '_tagType_' . $F, 'div');
        abcfl_mbsave_save_cbo( $postID,'tagFont_' . $F, '_tagFont_' . $F, 'D');
        abcfl_mbsave_save_cbo( $postID,'tagMarginT_' . $F, '_tagMarginT_' . $F, 'D');

        abcfl_mbsave_save_cbo( $postID,'tagTypeSPg_' . $F, '_tagTypeSPg_' . $F, '');
        abcfl_mbsave_save_cbo( $postID,'tagFontSPg_' . $F, '_tagFontSPg_' . $F, '');
        abcfl_mbsave_save_cbo( $postID,'tagMarginTSPg_' . $F, '_tagMarginTSPg_' . $F, '');

        abcfl_mbsave_save_txt($postID, 'tagCls_' . $F, '_tagCls_' . $F);
        abcfl_mbsave_save_txt($postID, 'tagStyle_' . $F, '_tagStyle_' . $F);
        //-----------------------------------------------------
        abcfl_mbsave_save_txt($postID, 'lblTxt_' . $F, '_lblTxt_' . $F);
        abcfl_mbsave_save_txt($postID, 'lblTag_' . $F, '_lblTag_' . $F);
        abcfl_mbsave_save_txt($postID, 'lblCls_' . $F, '_lblCls_' . $F);
        abcfl_mbsave_save_txt($postID, 'lblStyle_' . $F, '_lblStyle_' . $F);
        //-----------------------------------------------------
        abcfl_mbsave_save_txt($postID, 'txtCls_' . $F, '_txtCls_' . $F);
        abcfl_mbsave_save_txt($postID, 'txtStyle_' . $F, '_txtStyle_' . $F);
        //-----------------------------------------------------
        abcfl_mbsave_save_txt($postID, 'lnkCls_' . $F, '_lnkCls_' . $F);
        abcfl_mbsave_save_txt($postID, 'lnkStyle_' . $F, '_lnkStyle_' . $F);
        //-----------------------------------------------------
        abcfl_mbsave_save_cbo( $postID,'orderLP1_' . $F, '_orderLP1_' . $F, '0');
        abcfl_mbsave_save_txt($postID, 'sfixLP1_' . $F, '_sfixLP1_' . $F);
        abcfl_mbsave_save_cbo( $postID,'orderLP2_' . $F, '_orderLP2_' . $F, '0');
        abcfl_mbsave_save_txt($postID, 'sfixLP2_' . $F, '_sfixLP2_' . $F);
        abcfl_mbsave_save_cbo( $postID,'orderLP3_' . $F, '_orderLP3_' . $F, '0');
        abcfl_mbsave_save_txt($postID, 'sfixLP3_' . $F, '_sfixLP3_' . $F);
        abcfl_mbsave_save_cbo( $postID,'orderLP4_' . $F, '_orderLP4_' . $F, '0');
        abcfl_mbsave_save_txt($postID, 'sfixLP4_' . $F, '_sfixLP4_' . $F);

        abcfl_mbsave_save_cbo( $postID,'orderSP1_' . $F, '_orderSP1_' . $F, '0');
        abcfl_mbsave_save_txt($postID, 'sfixSP1_' . $F, '_sfixSP1_' . $F);
        abcfl_mbsave_save_cbo( $postID,'orderSP2_' . $F, '_orderSP2_' . $F, '0');
        abcfl_mbsave_save_txt($postID, 'sfixSP2_' . $F, '_sfixSP2_' . $F);
        abcfl_mbsave_save_cbo( $postID,'orderSP3_' . $F, '_orderSP3_' . $F, '0');
        abcfl_mbsave_save_txt($postID, 'sfixSP3_' . $F, '_sfixSP3_' . $F);
        abcfl_mbsave_save_cbo( $postID,'orderSP4_' . $F, '_orderSP4_' . $F, '0');
        abcfl_mbsave_save_txt($postID, 'sfixSP4_' . $F, '_sfixSP4_' . $F);

        //-- Input field labels -------------------------------
        abcfl_mbsave_save_txt($postID, 'inputLbl_' . $F, '_inputLbl_' . $F);
        abcfl_mbsave_save_txt($postID, 'inputHlp_' . $F, '_inputHlp_' . $F);

        abcfl_mbsave_save_txt($postID, 'inputLblP1_' . $F, '_inputLblP1_' . $F);
        abcfl_mbsave_save_txt($postID, 'inputLblP2_' . $F, '_inputLblP2_' . $F);
        abcfl_mbsave_save_txt($postID, 'inputLblP3_' . $F, '_inputLblP3_' . $F);
        abcfl_mbsave_save_txt($postID, 'inputLblP4_' . $F, '_inputLblP4_' . $F);

        abcfl_mbsave_save_txt($postID, 'lnkLblLbl_' . $F, '_lnkLblLbl_' . $F);
        abcfl_mbsave_save_txt($postID, 'lnkLblHlp_' . $F, '_lnkLblHlp_' . $F);
        abcfl_mbsave_save_txt($postID, 'lnkUrlLbl_' . $F, '_lnkUrlLbl_' . $F);
        abcfl_mbsave_save_txt($postID, 'lnkUrlHlp_' . $F, '_lnkUrlHlp_' . $F);
    }

    private function delete_fields( $postID, $F ) {

        delete_post_meta( $postID, '_fieldType_' . $F );
        delete_post_meta( $postID, '_fieldTypeH_' . $F );
        delete_post_meta( $postID, '_showField_' . $F );
        delete_post_meta( $postID, 'hideDelete_' . $F );
        delete_post_meta( $postID, '_fieldLocked_' . $F );
        delete_post_meta( $postID, '_fieldCntrSPg_' . $F );

        delete_post_meta( $postID, '_showAll_' . $F );
        delete_post_meta( $postID, '_tagTypeL_' . $F );
        delete_post_meta( $postID, '_tagType_' . $F );
        delete_post_meta( $postID, '_tagFont_' . $F );
        delete_post_meta( $postID, '_tagMarginT_' . $F );

        delete_post_meta( $postID, '_tagTypeSPg_' . $F );
        delete_post_meta( $postID, '_tagFontSPg_' . $F );
        delete_post_meta( $postID, '_tagMarginTSPg_' . $F );

        delete_post_meta( $postID, '_tagCls_' . $F );
        delete_post_meta( $postID, '_lblTxt_' . $F );
        delete_post_meta( $postID, '_lblTag_' . $F );

        delete_post_meta( $postID, '_lblCls_' . $F );
        delete_post_meta( $postID, '_lblStyle_' . $F );
        delete_post_meta( $postID, '_txtCls_' . $F );
        delete_post_meta( $postID, '_txtStyle_' . $F );

        delete_post_meta( $postID, '_lnkCls_' . $F );
        delete_post_meta( $postID, '_lnkStyle_' . $F );

        delete_post_meta( $postID, '_inputLbl_' . $F );
        delete_post_meta( $postID, '_inputHlp_' . $F );
        delete_post_meta( $postID, '_lnkLblLbl_' . $F );
        delete_post_meta( $postID, '_lnkLblHlp_' . $F );
        delete_post_meta( $postID, '_lnkUrlLbl_' . $F );
        delete_post_meta( $postID, '_lnkUrlHlp_' . $F );

        delete_post_meta( $postID, '_inputLblP1_' . $F );
        delete_post_meta( $postID, '_inputLblP2_' . $F );
        delete_post_meta( $postID, '_inputLblP3_' . $F );
        delete_post_meta( $postID, '_inputLblP4_' . $F );

        delete_post_meta( $postID, '_orderLP1_' . $F );
        delete_post_meta( $postID, '_sfixLP1_' . $F );
        delete_post_meta( $postID, '_orderLP2_' . $F );
        delete_post_meta( $postID, '_sfixLP2_' . $F );
        delete_post_meta( $postID, '_orderLP3_' . $F );
        delete_post_meta( $postID, '_sfixLP3_' . $F );
        delete_post_meta( $postID, '_orderLP4_' . $F );
        delete_post_meta( $postID, '_sfixLP4_' . $F );

        delete_post_meta( $postID, '_orderSP1_' . $F );
        delete_post_meta( $postID, '_sfixSP1_' . $F );
        delete_post_meta( $postID, '_orderSP2_' . $F );
        delete_post_meta( $postID, '_sfixSP2_' . $F );
        delete_post_meta( $postID, '_orderSP3_' . $F );
        delete_post_meta( $postID, '_sfixSP3_' . $F );
        delete_post_meta( $postID, '_orderSP4_' . $F );
        delete_post_meta( $postID, '_sfixSP4_' . $F );
    }

    private function user_can_save( $postID, $slug ) {

        $nonce = isset( $_POST[$slug .'_nonce'] ) ? $_POST[$slug .'_nonce'] : '';
        if(empty($nonce)){ return false; }

        $validNonce = wp_verify_nonce( $nonce, $slug );
        if(!$validNonce) { wp_die('Security check fail. VN'); }

        $is_autosave = wp_is_post_autosave( $postID );
        $is_revision = wp_is_post_revision( $postID );
        return !( $is_autosave || $is_revision );
    }

}