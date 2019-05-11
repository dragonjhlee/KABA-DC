<?php
if ( ! defined( 'ABSPATH' ) ) {exit;}
class ABCFSL_MBox_Item {

    public function __construct() {
        add_action( 'add_meta_boxes_cpt_staff_lst_item', array( $this, 'add_meta_box' ) );
        add_action( 'save_post_cpt_staff_lst_item', array( $this, 'save_post' ) );
    }

    public function add_meta_box($post) {

        add_meta_box(
            'abcfsl_staff_member',
            abcfsl_txta(268),
            array( $this, 'display_staff_member' ),
            $post->post_type,
            'normal',
            'default'
        );

        add_meta_box(
            'abcfsl_staff_member_parent',
            abcfsl_txta(63),
            array( $this, 'staff_templates_cbo' ),
            $post->post_type,
            'side',
            'core'
        );

    }
//------------------------------------------------
    function remove_metabox() {
        remove_meta_box( 'wpseo_meta', 'cpt_img_txt_list', 'normal' );
    }

    public function display_staff_member() {
        abcfsl_mbox_item_tabs();
    }

    //meta box Select Template
    public function staff_templates_cbo( $post ) {

        $tplateID = $post->post_parent;
        if( $tplateID == 0 ) { $tplateID = get_option( 'sl_default_tplate_id', 0 ); }

        $cboTplates = abcfsl_dba_cbo_tplates( abcfsl_txta(244) );
        echo abcfl_input_cbo('parent_id', 'parent_id', $cboTplates, $tplateID, '', abcfsl_txta(267), '100%', true, 'widefat');
    }

    public function save_post( $postID ) {

        $obj = ABCFSL_Main();
        $slug = $obj->pluginSlug;

 //echo"<pre>", print_r($_POST), "</pre>"; die;
        //Exit if user doesn't have permission to save
        if (!$this->user_can_save( $postID, $slug ) ) { return; }

//        $imgUrlS = ( isset( $_POST['imgUrlS']) ? esc_attr( $_POST['imgUrlS' ] ) : '' );
//        if( empty( $imgUrlS  )){
//            abcfl_mbsave_save_txt($postID, '', '_imgIDS');
//        }
//        else{
//            abcfl_mbsave_save_txt($postID, 'imgIDS', '_imgIDS');
//        }
//        abcfl_mbsave_save_txt($postID, 'imgUrlS', '_imgUrlS');

        //-----------------------------
        abcfl_mbsave_save_chekbox($postID, 'hideSMember', '_hideSMember');
        abcfl_mbsave_save_txt($postID, 'sortTxt', '_sortTxt');
        //abcfl_mbsave_save_txt_sanitize_title($postID, 'pretty', '_pretty');
        abcfl_mbsave_save_txt($postID, 'pretty', '_pretty');
        abcfl_mbsave_save_txt($postID, 'sPgTitle', '_sPgTitle');
        //------------------------------------------------

        //------------------------------------------------
        $this->save_img_L( $postID );
        $this->save_img_S( $postID );
        abcfl_mbsave_save_txt($postID, 'imgLnkL', '_imgLnkL');

//        abcfl_mbsave_save_txt($postID, 'imgIDL', '_imgIDL');
//        abcfl_mbsave_save_txt($postID, 'imgUrlL', '_imgUrlL');

        for ( $i = 1; $i < 21; $i++ ) {
            $this->save_item( $postID, 'F' . $i );
        }
        $this->update_menu_order();
    }

    //======================================
        private function save_img_alt( $postID, $imgID, $imgAlt ) {

        if( !empty( $imgAlt ) ) {
            abcfl_mbsave_save_txt($postID, 'imgAlt', '_imgAlt');
            return;
        }

        if( $imgID == 0 ){
            abcfl_mbsave_save_txt($postID, 'imgAlt', '_imgAlt');
            return;
        }

        $metaImgAlt = get_post_meta( $imgID, '_wp_attachment_image_alt', true);
        abcfl_mbsave_save_txt_value( $postID, '_imgAlt', $metaImgAlt,  '');
    }

    private function save_img_L( $postID ) {

        $imgUrlL = isset( $_POST['imgUrlL']) ? esc_attr( $_POST['imgUrlL' ] ) : '';
        $imgIDL = isset( $_POST['imgIDL']) ? $_POST['imgIDL' ] : 0 ;
        $imgAlt = isset( $_POST['imgAlt'] ) ? esc_attr( $_POST['imgAlt'][0] ) : '';

        $imgID = abcfsl_mbox_item_img_id( $imgUrlL );

        abcfl_mbsave_save_txt_value( $postID, '_imgUrlL', $imgUrlL,  '');
        abcfl_mbsave_save_txt_value( $postID, '_imgIDL', $imgID,  '');

        $this->save_img_alt( $postID, $imgID, $imgAlt );
    }

    private function save_img_S( $postID ) {

        $imgUrlS = isset( $_POST['imgUrlS']) ? esc_attr( $_POST['imgUrlS' ] ) : '';
        $imgIDS = isset( $_POST['imgIDS']) ? $_POST['imgIDS' ] : 0;

        if( $imgUrlS == 'SP' ){
            abcfl_mbsave_save_txt_value( $postID, '_imgUrlS', 'SP',  '');
            abcfl_mbsave_save_txt_value( $postID, '_imgIDS', 0,  '');
            return;
        }

        $imgID = abcfsl_mbox_item_img_id( $imgUrlS );

        abcfl_mbsave_save_txt_value( $postID, '_imgUrlS', $imgUrlS,  '');
        abcfl_mbsave_save_txt_value( $postID, '_imgIDS', $imgID,  '');
    }
    //======================================

    private function save_item( $postID, $F ) {

        // To save Text and Paragraph
        abcfl_mbsave_save_txt_html($postID, 'txt_' . $F, '_txt_' . $F);
        abcfl_mbsave_save_txt($postID, 'url_' . $F, '_url_' . $F);
        abcfl_mbsave_save_txt($postID, 'urlTxt_' . $F, '_urlTxt_' . $F);

        //abcfl_mbsave_save_txt_editor($postID, 'editorCnt_' . $F, '_editorCnt_' . $F);
        abcfl_mbsave_save_tinymce( $postID, 'editorCnt_' . $F, '_editorCnt_' . $F );

        //Multipart field
        abcfl_mbsave_save_txt($postID, 'mp1_' . $F, '_mp1_' . $F);
        abcfl_mbsave_save_txt($postID, 'mp2_' . $F, '_mp2_' . $F);
        abcfl_mbsave_save_txt($postID, 'mp3_' . $F, '_mp3_' . $F);
        abcfl_mbsave_save_txt($postID, 'mp4_' . $F, '_mp4_' . $F);
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

    //Update sort order for list items if sort by TEXT (sortType=T). $parentID = List ID.
    private function update_menu_order() {

        $parentID = ( isset( $_POST['post_parent'] ) ? esc_attr( $_POST['post_parent'] ) : 0 );
        if($parentID == 0){ return; }

        $sortType = get_post_meta ( $parentID, '_sortType', true );

        abcfsl_autil_update_menu_order( $parentID, $sortType );
    }

}
