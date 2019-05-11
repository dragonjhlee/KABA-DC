<?php

/**
 *	FlickrPress Public Class
 */
class FlickrPress extends FlickrPress_Base {
	
	/** 
	 *	Constructor
	 */
	function __construct() {
		// Pre-load Options
		$this->load_options();
		// Let's get started... This will hijack page requests for use of FlickrPress
		add_action('template_redirect', array(&$this,'hijack_page'));
	}
	// PHP 4 Constructor
	function FlickrPress() {
		$this->construct();
	}
	
	/**
	 *	Helper Functions
	 */
	function slideshow_url() {
		return 'http://www.flickr.com/photos/'.$this->opts['user']['ID'].'/sets/'.$this->albumID.'/show/';
	}
	function flickr_album_url() {
		return 'http://www.flickr.com/photos/'.$this->opts['user']['ID'].'/sets/'.$this->albumID.'/';	
	}
	function flickr_photo_url() {
		return 'http://www.flickr.com/photos/'.$this->opts['user']['ID'].'/'.$this->photoID.'/';	
	}
	
	function slideshow_link($anchor_text = 'View Slideshow &gt;') {
		$target = ($this->opts['new_windows']) ? ' target="_blank"' : '';
		$link = '<a href="'.apply_filters('flickr_slideshow_url', $this->slideshow_url()).'" class="slideshow"'.$target.'>'.$anchor_text.'</a>';
		return $link;
	}
	function flickr_album_link($anchor_text = 'View album on Flickr') {
		$target = ($this->opts['new_windows']) ? ' target="_blank"' : '';
		$link = '<a href="'.apply_filters('flickr_album_url', $this->flickr_album_url()).'" class="flickr_album"'.$target.'>'.$anchor_text.'</a>';
		return $link;
	}
	function flickr_photo_link($anchor_text = 'View this photo on Flickr') {
		$target = ($this->opts['new_windows']) ? ' target="_blank"' : '';
		$link = '<a href="'.apply_filters('flickr_album_url', $this->flickr_photo_url()).'" class="flickr_photo_link"'.$target.'>'.$anchor_text.'</a>';
		return $link;
	}
	
	function encode_url($url) {
		return strtolower(urlencode(sanitize_title_with_dashes($url)));
	}
	
	function get_photo_of_size($size='Square', $photos) {
		foreach ($photos as $image) {
			if (strtolower($image['label']) == strtolower($size)) break;
		}
		return $image;
	}
	
	/**
	 *	Response Headers
	 */
	function headers($is_404=false) {
		global $wp_query;
		if ($is_404) {
			$wp_query->is_404 = true;
			status_header(404);
		} else {
			$wp_query->is_404 = false;
			status_header(200);
		}
	}
	
	
	/**
	 *	Hijack page content
	 */
	function hijack_page() {
		// Check that we're on a Flickr page
		if (empty($this->opts['flickr_page'])) return;
		$permalink = get_permalink($this->opts['flickr_page']);
		$request_uri = (($_SERVER['HTTPS'] != 'on') ? 'http://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if (substr($request_uri, 0, strlen($permalink)) !== $permalink)	return;
		// Load flickr object - only if we're on a FlickrPress page
		if (empty($this->opts['user']['token'])) return;
		$this->load_flickr();
		// Enqueue scripts and styles
		wp_enqueue_script('flickrpress', FLICKR_PLUGIN_URL.'/custom.js', array('jquery') );
		wp_enqueue_style('flickrpress', FLICKR_PLUGIN_URL.'/custom.css');
		//echo '<h1>Marker: Running Flickr Hijack</h1>';
		
		// Load data from request uri
		$args = explode('/',$_SERVER['REQUEST_URI']);
		$this->albumID = $args[array_search('album', $args) + 1];
		$this->photoID = $args[array_search('photo', $args) + 1];
		
		// Which page, if any, are we showing.
		if (strpos($_SERVER['REQUEST_URI'],'/album/')!==false && strpos($_SERVER['REQUEST_URI'],'/photo/')!==false) {
			$this->load_view_photo();
		} else if (strpos($_SERVER['REQUEST_URI'],'/album/')!==false) {
			$this->load_view_album();
		} else {
			$this->load_list_albums();
		}
	}
	
	
	/**
	 *	Loader functions
	 */
	function load_list_albums() {
		// Response headers
		$this->headers(false);
		// Keep <title> and page heading, only set the_content
		add_filter('the_content', array(&$this,'view_list_photosets'));
	}
	function load_view_album() {
		// Response headers
		$this->headers(false);
		// Load our usual Flickr page
		global $wp_query;
		$wp_query->query(array('page_id'=>$this->opts['flickr_page']));
		$this->headers(false);
		// Prepare Album Info
		$result = $this->flickr->photosets_getInfo($this->albumID);
		$this->album = array(
			'ID'			=> $result['id'],
			'title'			=> $result['title'],
			'description'	=> $result['description'],
			'count'			=> $result['photos'],
			'primary'		=> $result['primary'],
		);
		$wp_query->post->post_title = $this->view_photoset_heading();
		$wp_query->post->post_content = $this->view_photoset_content();
		$wp_query->post->comment_status = 'closed';
		// Add or remove relevant filters
		remove_filter('the_content', 'wpautop');
	}
	function load_view_photo() {
		// Response headers
		$this->headers(false);
		// Load our usual Flickr page
		global $wp_query;
		$wp_query->query(array('page_id'=>$this->opts['flickr_page']));
		$this->headers(false);
		// Prepare Album Info
		$result = $this->flickr->photosets_getInfo($this->albumID);
		$this->album = array(
			'ID'			=> $result['id'],
			'title'			=> $result['title'],
			'description'	=> $result['description'],
			'count'			=> $result['photos'],
			'primary'		=> $result['primary'],
		);
		// Prepare Photo Info
		$size = $this->get_photo_of_size('Medium', $this->flickr->photos_getSizes($this->photoID));
		$photo = $this->flickr->photos_getInfo($this->photoID);
		$this->photo = array(
			'ID'			=> $photo['id'],
			'date'			=> $photo['dateuploaded'],
			'title'			=> $photo['title'],
			'description'	=> $photo['description'],
			'flickr_url'	=> $photo['urls']['url'][0]['_content'],
			'src'			=> $size['source'],
			'width'			=> $size['width'],
			'height'		=> $size['height'],
			'album'			=> $album['title'],
		);
		$wp_query->post->post_title = $this->view_photo_heading();
		$wp_query->post->post_content = $this->view_photo_content();
		$wp_query->post->comment_status = 'closed';
		// Add or remove relevant filters
		remove_filter('the_content', 'wpautop');
	}


	
	/**
	 *	Display: List all photosets
	 */
	function view_list_photosets($content = '') {
		ob_start();
		$result = $this->flickr->photosets_getList($this->opts['user']['ID']);
		echo '<div id="flickr_photosets">'."\n";
		foreach ($result['photoset'] as $set) {
			// Check if we're hiding this album
			if (in_array($set['id'], $this->opts['hide_albums'])) continue;
			// Prepare album data
			$this->albumID = $set['id'];
			$photosetURL = 'album/'.$set['id'].'/'.$this->encode_url($set['title']).'/';
			// Fetch thumbnail (photo size = 'Square'
			$image = $this->get_photo_of_size('Square', $this->flickr->photos_getSizes($set['primary']));
			// Output photoset
			echo '<div class="photoset">'."\n";
			echo '<a href="'.$photosetURL.'"><img class="photoset_thumb" src="'.$image['source'].'" width="'.$image['width'].'" height="'.$image['height'].'" /></a>';
			echo '<h3><a href="'.$photosetURL.'">'.$set['title'].'</a></h3>'."\n";
			if (!empty($set['description']))	echo '<p>'.$set['description'].'&nbsp;</p>'."\n";
			echo '<p><a href="'.$photosetURL.'">'.$set['photos'].' Photos</a> | '.$this->slideshow_link().'</p>'."\n";
			echo '<div class="clear"></div>'."\n";
			echo '</div>'."\n";
		}
		echo '</div><!-- flickr_photosets -->'."\n";
		$output = ob_get_clean();
		// Append or Prepend content?
		if ($this->opts['flickr_position'] == 'below')	$content = $content.$output;
		else											$content = $output.$content;
		// Return content
		return $content;
	}
	
	/**
	 *	Display: Show single photoset
	 */
	function view_photoset_heading($heading='') {
		$heading = $this->album['title'];
		return $heading;
	}
	function view_photoset_content($content='') {
		ob_start();
		$result = $this->flickr->photosets_getPhotos($this->albumID, 'url_sq,url_t,url_s,url_m,url_o');
		$photosetURL = get_permalink($this->opts['flickr_page']).'album/'.$this->album['ID'].'/';
		
		// Load primary album image
		$image = $this->get_photo_of_size('Small', $this->flickr->photos_getSizes($this->album['primary']));
		$info = $this->flickr->photos_getInfo($this->album['primary']);
		$image['link'] = $photosetURL.'photo/'.$info['id'].'/'.$this->encode_url($info['title']).'/';
		
		echo '<div id="flickr_album">'."\n";
		// Show album information
		//echo '<h1 class="album_title">'.$this->album['title'].'</h1>'."\n";
		echo '<a href="'.$image['link'].'"><img class="primary" src="'.$image['source'].'" width="'.$image['width'].'" height="'.$image['height'].'" /></a>'."\n";
		echo '<div class="album_information">'."\n";
		echo '<p class="description">'.$this->album['description'].'</p>'."\n";
		echo '<p class="album_meta">'.$this->album['count'].' Photos<br /><a href="'.get_permalink($this->opts['flickr_page']).'">&lt;&lt; Back</a> | '.$this->slideshow_link().'</p>'."\n";
		echo '</div><!-- album_information -->'."\n";
		// List album thumbnails
		echo '<div class="thumbnails">'."\n";
		foreach ($result['photoset']['photo'] as $photo) {
			$photoURL = $photosetURL.'photo/'.$photo['id'].'/'.$this->encode_url($photo['title']).'/';
			echo '<a class="thumb" href="'.$photoURL.'"><img class="thumb" src="'.$photo['url_sq'].'" width="'.$photo['width_sq'].'" height="'.$photo['height_sq'].'" /></a>'."\n";
		}
		echo '</div><!-- thumbnails -->'."\n";
		echo '</div><!-- flickr_album -->'."\n";
		
		$output = ob_get_clean();
		return $output;
	}
	
	/**
	 *	Display: Show a photo
	 */
	function view_photo_heading($heading='') {
		$heading = $this->photo['title'];
		return $heading;
	}
	function view_photo_content($content='') {
		ob_start();
		$photosetURL = get_permalink($this->opts['flickr_page']).'album/'.$this->albumID.'/';
		// Load prev/next
		$context = $this->flickr->photosets_getContext($this->photo['ID'], $this->albumID);
		$context['prevphoto']['link'] = $photosetURL.'photo/'.$context['prevphoto']['id'].'/'.strtolower(urlencode($context['prevphoto']['title'])).'/';
		$context['nextphoto']['link'] = $photosetURL.'photo/'.$context['nextphoto']['id'].'/'.strtolower(urlencode($context['nextphoto']['title'])).'/';
		
		echo '<div id="flickr_photo">'."\n";
		// Show Photo
		//echo '<h1>'.$this->photo['title'].'</h1>'."\n";
		echo '<p class="photo"><img class="photo" src="'.$this->photo['src'].'" width="'.$this->photo['width'].'" height="'.$this->photo['height'].'" /></p>'."\n";
		echo '<p class="meta"><strong>Uploaded:</strong> '.date(get_option('date_format'), $this->photo['date']).'<br />'."\n".$this->flickr_photo_link().'</p>'."\n";
		echo '<p class="meta"><a href="'.$photosetURL.'">&lt;&lt; Back to List Photos</a> | <a href="'.get_permalink($this->opts['flickr_page']).'">Back to Albums</a></p>'."\n";
		
		
		// Show context (prev/next)
		echo '<div class="photo_context">'."\n";
		if ($context['prevphoto']['id']>0)	echo '<p class="prev"><a href="'.$context['prevphoto']['link'].'"><img src="'.$context['prevphoto']['thumb'].'" /><br />Previous Photo</a></p>'."\n";
		if ($context['nextphoto']['id']>0)	echo '<p class="next"><a href="'.$context['nextphoto']['link'].'"><img src="'.$context['nextphoto']['thumb'].'" /><br />Next Photo</a></p>'."\n";
		echo '</div><!-- photo_context -->'."\n";
		
		echo '</div><!-- flickr_photo -->'."\n";
		
		$output = ob_get_clean();
		return $output;
	}
	
}

?>