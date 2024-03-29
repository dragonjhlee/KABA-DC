<?php
function srz_fb_galleries() {
	SrizonFBUI::startPageWrap();
	if ( isset( $_REQUEST['srzf'] ) ) {
		switch ( $_REQUEST['srzf'] ) {
			case 'edit':
				srz_fb_galleries_edit();
				break;
			default:
				break;
		}
	} else {
		if ( isset( $_REQUEST['srzl'] ) ) {
			switch ( $_REQUEST['srzl'] ) {
				case 'save':
					srz_fb_galleries_save();
					break;
				case 'delete':
					srz_fb_galleries_delete();
					break;
				case 'sync':
					srz_fb_galleries_sync();
					break;
				default:
					break;
			}
		}
		echo '<h2 class="mb3">' . __( 'Galleries', 'srizon-facebook-album' ) . '<a href="admin.php?page=SrzFb-Galleries&srzf=edit" class="add-new-h2">' . __( 'Add New', 'srizon-facebook-album' ) . '</a></h2>';
		$galleries = stripslashes_deep( SrizonFBDB::GetAllGalleries() );
		include( 'tables/gallery-table.php' );
	}
	SrizonFBUI::endPageWrap();
}

function srz_fb_galleries_edit() {
	$optvar = stripslashes_deep( SrizonFBDB::GetCommonOpt() );
	if ( isset( $_REQUEST['id'] ) ) {
		echo '<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><h2>' . __( 'Edit Gallery', 'srizon-facebook-album' ) . '</h2>';
		$value_arr = SrizonFBDB::GetGallery( $_GET['id'] );
		$value_arr = stripslashes_deep( $value_arr );
	} else {
		echo '<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div><h2>' . __( 'Add New Gallery', 'srizon-facebook-album' ) . '</h2>';
		$value_arr = array(
			'title'                 => '',
			'excludeids'            => '',
			'include_exclude'       => 'exclude',
			'albumtxt'              => 'Album',
			'backtogallerytxt'      => '[Back To Gallery]',
			'updatefeed'            => '600',
			'image_sorting'         => 'default',
			'album_sorting'         => 'default',
			'liststyle'             => 'slidergridv',
			'totalimg'              => '1000',
			'paginatenum'           => '18',
			'collagepadding'        => '2',
			'collagepartiallast'    => '0',
			'hovercaption'          => '1',
			'hovercaptiontype'      => '0',
			'hovercaptiontypecover' => '2',
			'show_image_count'      => '1',
			'showhoverzoom'         => '1',
			'maxheight'             => '250',
			'album_source'          => 'page',
			'auth_type'             => 'settings',
		);
		$value_arr = stripslashes_deep( $value_arr );
	}
	SrizonFBUI::startOptionWrapper();
	SrizonFBUI::startRightColumn();
	SrizonFBUI::renderBoxHeader( 'box1', __( "About Gallery", 'srizon-facebook-album' ) );
	echo '<div><div class="misc-pub-section">' . __( 'Gallery is a 2 level view of your Facebook albums', 'srizon-facebook-album' ) . '</div><div class="misc-pub-section">' . __( 'First level shows the album covers. Clicking on the cover of an album will take you to the second level listing the thumbs of that album', 'srizon-facebook-album' ) . '</div>
	<div class="misc-pub-section">' . __( 'You can exclude/remove some albums by using their album IDs on the exclusion list', 'srizon-facebook-album' ) . '</div></div>';
	SrizonFBUI::renderBoxFooter();
	SrizonFBUI::endRightColumn();
	SrizonFBUI::startLeftColumn();
	include 'forms/gallery-option-form.php';
	SrizonFBUI::endLeftColumn();
	SrizonFBUI::endOptionWrapper();
}

function srz_fb_galleries_save() {
	if ( wp_verify_nonce( $_POST['srjfb_submit'], 'SrzFbGalleries' ) == false ) {
		die( 'Nice Try!' );
	}
	if ( ! isset( $_POST['id'] ) ) {
		SrizonFBDB::SaveGallery( true );
		echo "<div class=\"updated notice notice-success is-dismissible\"><h4>" . __( "New Gallery Created! Now copy the shortcode and use it in your post/page", 'srizon-facebook-album' ) . "</h4></div>";
	} else {
		SrizonFBDB::SaveGallery( false );
		SrizonFBDB::SyncGallery( $_POST['id'] );
		echo "<div class=\"updated notice notice-success is-dismissible\"><h4>" . __( "Gallery Saved!", 'srizon-facebook-album' ) . "</h4></div>";
	}
}

function srz_fb_galleries_delete() {
	if ( isset( $_GET['id'] ) ) {
		SrizonFBDB::DeleteGallery( $_GET['id'] );
	}
	echo "<div class=\"notice notice-warning is-dismissible\"><h4>" . __( "Gallery Deleted!", 'srizon-facebook-album' ) . "</h4></div>";
}

function srz_fb_galleries_sync() {
	if ( isset( $_GET['id'] ) ) {
		SrizonFBDB::SyncGallery( $_GET['id'] );
	}
	echo "<div class=\"updated notice notice-success is-dismissible\"><h4>" . __( "Cached data deleted for this gallery! It will be synced on the next load!", 'srizon-facebook-album' ) . "</h4></div>";
}
