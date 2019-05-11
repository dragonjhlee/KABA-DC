
/**
 *	Modify the View Slideshow links to open in a popup
 */
jQuery(document).ready(function($) {
	$('a.slideshow').click(function(e) {
		e.preventDefault();
		var w = Math.max(screen.width-140, 750);
		var h = Math.max(screen.height-140, 400);
		var args = 'width='+w+',height='+h+',top=10,left=50,scrollbars=no,status=no,resizable=yes';
		window.open( $(this).attr('href'), 'flickr_slideshow', args);
	});
});

