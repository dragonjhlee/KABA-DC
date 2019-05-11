<?php

$data_hovercaption = ( $srz_album['hovercaption'] ) ? $srz_album['hovercaptiontype'] : '';

$data .= '<div class="collage-layout jfbalbum jfb-big"  id="' . $scroller_id . '"
	data-hovercaption="' . $data_hovercaption . '"
    data-collagepartiallast="' . $srz_album['collagepartiallast'] . '"
    data-maxheight="' . $srz_album['maxheight'] . '"
    data-collagepadding="' . $srz_album['collagepadding'] . '"
>';
foreach ( $srz_images as $image ) {
	$caption = nl2br( $image['txt'] );
	$data    .= <<<EOL
		<div class="Image_Wrapper" data-caption="{$caption}">
			<a href="javascript:;">
				<img alt="{$caption}" src="{$image['src']}" data-width="{$image['width']}" data-height="{$image['height']}" width="{$image['width']}" height="{$image['height']}" />
			</a>
		</div>
EOL;
}
$data .= '</div>';

