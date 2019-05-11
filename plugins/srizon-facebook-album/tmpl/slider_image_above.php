<?php
$json_data = htmlspecialchars( json_encode( $srz_images ) );
$data      .= <<<EOL
	<div class="full-size-image">
		<div class="full-size-image-container srz-clearfix">
			<div class="full-image-with-thumb" data-listid="#{$scroller_id}" id="full-{$scroller_id}"></div>
			<span class="srz-prev"></span>
			<span class="srz-next"></span>
		</div>
		<div class="loading-wrap">
			<ul class="elastislide-list"  id="{$scroller_id}"
			data-targetheight="{$srz_album['targetheight']}"
			data-maxheight="{$srz_album['maxheight']}"
	        data-animationspeed="{$srz_album['animationspeed']}"
	        data-hovercaption="{$srz_album['hovercaption']}"
	        data-jsondata = "{$json_data}"
	        data-scroll_interval="{$srz_album['autoslideinterval']}">
EOL;
$i         = 0;
foreach ( $srz_images as $image ) {
	$caption = nl2br( $image['txt'] );
	$data    .= <<<EOL
				<li>
					<a href="javascript:;" data-index="{$i}">
						<img src="{$image['thumb']}" alt="{$caption}" width="{$image['width']}" height="{$image['height']}" />
					</a>
				</li>

EOL;
	$i ++;
}
$data .= <<<EOL
			</ul>
		</div>
	</div>
EOL;

