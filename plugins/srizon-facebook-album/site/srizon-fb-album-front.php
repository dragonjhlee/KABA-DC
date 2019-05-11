<?php
function srz_fb_album_shortcode( $atts ) {
	if ( class_exists( 'Jetpack_Photon' ) ) {
		remove_filter( 'image_downsize', array( Jetpack_Photon::instance(), 'filter_image_downsize' ) );
	}
	if ( ! isset( $atts['id'] ) ) {
		return 'Invalid shortcode... ID missing';
	}
	$srz_albumid = $atts['id'];
	$srz_album   = SrizonFBDB::GetAlbum( $srz_albumid );
	if ( ! $srz_album ) {
		return 'Album Not found';
	}
	if ( ! $srz_album['access_token'] ) {
		return __( 'Access Token not set. You can generate Access Tokens for your Page or Profile on <a href="https://fb.srizon.com" target="_blank">fb.srizon.com</a>. After generating the access token, insert it on the backend', 'srizon-facebook-album' );
	}
	$srz_album = stripslashes_deep( $srz_album );
	srz_fb_set_debug_msg( 'Album Details:', $srz_album );
	if ( ! isset( $GLOBALS['imggroup'] ) ) {
		$GLOBALS['imggroup'] = 1;
	} else {
		$GLOBALS['imggroup'] ++;
	}
	$paging_id   = 'jfb' . $GLOBALS['imggroup'];
	$scroller_id = 'jfbalbum' . $GLOBALS['imggroup'];

	$srzfbalbum     = new SrizonFBAlbum( $srz_album['updatefeed'] * 60, $srz_album['access_token'] );
	$srz_images_all = $srzfbalbum->get_facebook_albums_images( $srz_album['albumid'], $srz_album['image_sorting'] );
	srz_fb_set_debug_msg( 'Images', $srz_images_all );
	$srz_images_all = array_slice( $srz_images_all, 0, $srz_album['totalimg'] );

	$srz_common_options = SrizonFBDB::GetCommonOpt();
	$srz_common_options = stripslashes_deep( $srz_common_options );
	if ( $srz_common_options['loadlightbox'] == 'mp' ) {
		$lightbox_attribute = 'class="aimg"';
	} else {
		$lightbox_attribute = stripslashes( $srz_common_options['lightboxattrib'] );
	}

	$srz_totalimgall = count( $srz_images_all );
	$srz_cur_page    = isset( $_REQUEST[ $paging_id ] ) ? ( $_REQUEST[ $paging_id ] - 1 ) : 0;
	$srz_images      = array_slice( $srz_images_all, $srz_cur_page * $srz_album['paginatenum'], $srz_album['paginatenum'] );
	$data            = '';
	include( dirname( __FILE__ ) . '/../tmpl/' . $srz_album['layout'] . '.php' );
	$data .= srizon_show_pagination( $srz_album['paginatenum'], $srz_totalimgall, $scroller_id, $paging_id, $srz_common_options['jumptoarea'] );

	return $data;
}

add_shortcode( 'srizonfbalbum', 'srz_fb_album_shortcode' );
