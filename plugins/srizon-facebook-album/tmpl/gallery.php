<?php
//SrizonResourceLoader::load_mag_popup();
//SrizonResourceLoader::load_collage_plus();
//SrizonResourceLoader::load_srizon_custom_css();
$url = remove_query_arg( $aid );
$url = remove_query_arg( $paging_id, $url );
if ( $srz_common_options['jumptoarea'] == 'true' ) {
	$blink = $url . '#' . $scroller_id;
} else {
	$blink = $url;
}
$extraclass = '';
if ( $srz_page['showhoverzoom'] ) {
	$extraclass .= ' zoom';
}
if ( isset( $srz_page['backtogallerytxt'] ) ) {
	$backtogallerytxt = $srz_page['backtogallerytxt'];
}
if ( empty( $backtogallerytxt ) ) {
	$backtogallerytxt = $srz_common_options['backtogallerytxt'];
}
$backlink = ' <a href="' . esc_url( $blink ) . '">' . __( $backtogallerytxt, 'srizon-facebook-album' ) . '</a>';
$dtg      = ' data-gallery="gallery"';
if ( $set ) {
	$data .= '<h2 class="fb-album-title">' . filter_fb_text( $pagetitle ) . '<span class="fb-back-link">' . $backlink . '</span></h2>';
	$dtg  = '';
}


if ( $set ) {
	$data_hovercaption = ( $srz_page['hovercaption'] ) ? $srz_page['hovercaptiontype'] : '';
} else {
	$data_hovercaption = ( $srz_page['hovercaption'] ) ? $srz_page['hovercaptiontypecover'] : '';
}

$data .= '<div class="collage-layout jfbalbum' . $extraclass . '"  id="' . $scroller_id . '" 
    data-hovercaption="' . $data_hovercaption . '"
    data-collagepartiallast="' . $srz_page['collagepartiallast'] . '"
    data-maxheight="' . $srz_page['maxheight'] . '"
    data-collagepadding="' . $srz_page['collagepadding'] . '">';

foreach ( $srz_images as $image ) {
	if ( $set ) {
		$link    = $image['src'];
		$grelval = $lightbox_attribute;
	} else {
		$u    = remove_query_arg( $paging_id );
		$link = esc_url( add_query_arg( $aid, $image['id'], $u ) );
		if ( $srz_common_options['jumptoarea'] == 'true' ) {
			$link = $link . '#' . $scroller_id;
		}
		$grelval = '';
		if ( ! empty( $srz_page['albumtxt'] ) ) {
			$image['txt'] = __( $srz_page['albumtxt'] . ': ', 'srizon-facebook-album' ) . filter_fb_text( $image['txt'] ) . "\n";
		} elseif ( ! empty( $srz_common_options['albumtxt'] ) ) {
			$image['txt'] = __( $srz_common_options['albumtxt'] . ': ', 'srizon-facebook-album' ) . filter_fb_text( $image['txt'] ) . "\n";
		} else {
			$image['txt'] = filter_fb_text( $image['txt'] ) . "\n";
		}
		if ( $srz_page['show_image_count'] ) {
			$image['txt'] = $image['txt'] . $image['count'] . __( ' Photos', 'srizon-facebook-album' );
		}
	}
	$caption = nl2br( $image['txt'] );
	$data    .= <<<EOL
		<div class="Image_Wrapper" data-caption="{$caption}">
			<a href="{$link}"  data-title="{$caption}" {$grelval}{$dtg}>
				<img alt="{$caption}" src="{$image['thumb']}" data-width="{$image['width']}" data-height="{$image['height']}" width="{$image['width']}" height="{$image['height']}" />
			</a>
		</div>
EOL;
}
$data .= '</div>';


