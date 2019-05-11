<?php
$data .= '<div class="loading-wrap"><ul class="elastislide-list jfbalbum"  id="' . $scroller_id . '"
	data-targetheight="' . $srz_album['targetheight'] . '"
	data-animationspeed="' . $srz_album['animationspeed'] . '"
	data-scroll_interval="' . $srz_album['autoslideinterval'] . '"

>';
foreach ( $srz_images as $image ) {
	$caption = nl2br( $image['txt'] );
	$data    .= <<<IMGLINK
	<li>
		<a href="{$image['src']}" data-title="{$caption}" {$lightbox_attribute}>
			<img src="{$image['thumb']}" alt="{$caption}" width="{$image['width']}" height="{$image['height']}" />
		</a>
	</li>
IMGLINK;
}
$data .= '</ul></div>';

