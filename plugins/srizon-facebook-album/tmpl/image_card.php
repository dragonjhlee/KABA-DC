<?php
$json_data = htmlspecialchars( json_encode( $srz_images ) );

echo <<<EOL
	<div class="full-size-card-image-container srz-clearfix" id="{$scroller_id}"
			data-maxheight="{$srz_album['maxheight']}"
	        data-hovercaption="{$srz_album['hovercaption']}"
	        data-jsondata = "{$json_data}"
	        data-scrollinterval="{$srz_album['autoslideinterval']}">
		<p class="current-caption"></p>
		<span class="srz-next"></span>
	</div>
EOL;
