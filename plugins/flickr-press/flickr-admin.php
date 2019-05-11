<?php

/**
 *	FlickrPress Admin Class
 */
class FlickrPress extends FlickrPress_Base {
	
	function __construct() {
		// Pre-load Options
		$this->load_options();
		// Admin Menu
		add_action('admin_menu', array(&$this,'admin_menu'));
		add_filter('plugin_action_links', array(&$this,'plugin_action_links'), 10, 2);
		// Save Settings
		add_action('admin_init', array(&$this,'settings_page_save'), 12);
		// Activation hook
		register_activation_hook( FLICKR_PLUGIN_DIR.'/flickr.php', array( &$this, 'activation_hook' ) );
		// Only want to load our Flickr wrapper if we have the key set.
		if (!empty($this->opts['api']['key']) && !empty($this->opts['api']['secret'])) {
			add_action('admin_init', array(&$this,'load_flickr'));
		}
		// Warnings for admin area
		add_action('admin_notices', array(&$this,'admin_warning_pretty_permalinks'));
		add_action('admin_notices', array(&$this,'admin_warning_settings'));
		
	}
	// PHP 4 Constructor
	function FlickrPress() {
		$this->construct();
	}
	
	function admin_warning_pretty_permalinks() {
		if ('' != get_option( 'permalink_structure'))	return;
		echo '<div id="message" class="updated fade"><p><strong>Warning:</strong> FlickrPress will not work properly until you 
				<a href="'.admin_url('options-permalink.php').'">set up your Permalinks</a>.</div>'."\n";
	}
	
	function admin_warning_settings() {
		if (empty($this->opts['api']['key']) || empty($this->opts['api']['secret'])) {
			echo '<div id="message" class="updated fade"><p><strong>Warning:</strong> FlickrPress will not work until you 
					<a href="'.admin_url('options-general.php?page=flickr').'">enter your Flickr API Settings</a>.</div>'."\n";
		} else 
		if (empty($this->opts['user']['token'])) {
			echo '<div id="message" class="updated fade"><p><strong>Warning:</strong> FlickrPress will not work until you 
					<a href="'.admin_url('options-general.php?page=flickr').'">authorize with your Flickr account</a>.</div>'."\n";
		} else
		if (empty($this->opts['flickr_page'])) {
			echo '<div id="message" class="updated fade"><p><strong>Warning:</strong> FlickrPress will not work until you 
					<a href="'.admin_url('options-general.php?page=flickr').'">choose a page to show your albumns on</a>.</div>'."\n";
		}
	}
	
	
	function admin_menu() {
		$hooks[] = add_submenu_page('options-general.php', 'FlickrPress Settings', 'Flickr Settings', 'administrator', 'flickr', array(&$this,'settings_page'));
		foreach ($hooks as $hook) {		add_action("load-$hook", array(&$this,'enqueue'));	}
	}
	
	function enqueue() {
		wp_enqueue_script('flickr', FLICKR_PLUGIN_URL.'/admin.js', array('jquery', 'jquery-ui-tabs') );
		wp_enqueue_style('flickr', FLICKR_PLUGIN_URL.'/admin.css');
	}
	
	function plugin_action_links($links, $file) {
		if ($file != 'flickr-press/flickr.php') return $links;
		array_unshift($links, '<a href="options-general.php?page=flickr">Configure</a>');
		return $links;
	}
	
	
	function settings_page_save() {
		// Make sure we're supposed to run...
		if (empty($_POST))											return;
		if (!wp_verify_nonce($_POST['_wpnonce'], $this->nonce))		return;
		// Clean & Secure all POST data
		$_POST = $this->slash_array($_POST);
		// Clear API Details?
		if (isset($_POST['ClearAPI'])) {
			$this->opts['api'] = array();
			$this->opts['user'] = array();
			$this->flickr = false;
			$this->save_options();
			$this->update_message = '<div id="message" class="updated fade"><p><strong>Your API settings have been cleared.  You may now re-enter your details.</strong></p></div>';
		}
		// Save general options
		if (isset($_POST['SaveGeneral'])) {
			$this->opts['flickr_page']		= $_POST['sel_flickr_page'];
			$this->opts['flickr_position']	= $_POST['flickrSelPosition'];
			$this->opts['new_windows']		= $_POST['flickrOpenWindow'];
			$this->opts['hide_private']		= $_POST['flickrHidePrivate'];
			$this->save_options();
			$this->update_message = '<div id="message" class="updated fade"><p><strong>General settings saved.</strong></p></div>';
		}
		// Save API Key and Secret
		if (isset($_POST['SaveAPI'])) {
			$this->opts['api'] = array( 'key'=>$_POST['apiKey'], 'secret'=>$_POST['apiSecret']);
			$this->save_options();
			$this->load_flickr();
			$this->update_message = '<div id="message" class="updated fade"><p><strong>Your Flickr API Key has been saved.</strong></p></div>';
		}
		// Save our Flickr FROB token (authenticate with Flickr)
		if (isset($_POST['SaveFlickrToken'])) {
			$token = $this->flickr->auth_getToken($_POST['frob']);
			$this->opts['user'] = array(
				'ID'	=> $token['user']['nsid'],
				'login'	=> $token['user']['username'],
				'name'	=> $token['user']['fullname'],
				'token'	=> $token['token'],
				'frob'	=> $frob,
			);
			$this->save_options();
			$this->update_message = '<div id="message" class="updated fade"><p><strong>Flickr Authorised.</strong></p></div>';
		}
		// Save Album Settings
		if (isset($_POST['SaveAlbumSettings'])) {
			$this->opts['hide_albums'] = (is_array($_POST['hide_album'])) ? array_values($_POST['hide_album']) : array();
			$this->save_options();
			$this->update_message = '<div id="message" class="updated fade"><p><strong>Album Settings Saved.</strong></p></div>';
		}
		// Force a refresh - clear cached data
		if (isset($_POST['ClearFlickrCache'])) {
			global $wpdb;
			$sql = "DELETE FROM `{$this->flickr->cache_table}`;";
			$wpdb->query($sql);
			$this->update_message = '<div id="message" class="updated fade"><p><strong>Flickr cache has been cleared.</strong></p></div>';
		}
		
	}
	
	function settings_page() {
		echo '<div class="wrap">'."\n";
		echo '<h2>Flickr Settings</h2>'."\n";
		
		//echo '<pre>'; print_r($_POST); echo '</pre>';
		if ($this->update_message)	echo $this->update_message;
		
		// Tickbox
		$sel_window = ($this->opts['new_windows']==true) ? ' checked="checked"' : '';
		$sel_private = ($this->opts['hide_private']==true) ? ' checked="checked"' : '';
		
		?>
<div id="tabContainer" class="ui_tabs">
<ul id="tabMenu">
	<li><a href="#tabSettings"><span>General</span></a></li>
    <li><a href="#tabFlickrAPI"><span>API Settings</span></a></li>
<?php	if (is_object($this->flickr) && !empty($this->opts['user']['token'])) {	?>
	<li><a href="#tabFlickrAlbums"><span>Albums</span></a></li>
<?php	} // flickr object														?>
</ul><!-- tcTabMenu -->
<div id="tabSettings">
  <form class="flickr" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
	<?php wp_nonce_field($this->nonce); ?>
	<p><label for="sel_flickr_page">Flickr Page</label>
		<?php  echo wp_dropdown_pages(array(
					'name' => 'sel_flickr_page', 
					'echo' => 0, 
					'show_option_none' => __( '&mdash; Select &mdash;' ), 
					'option_none_value' => '0', 
					'selected' => $this->opts['flickr_page'],
				 )); 
		?></p>
	<p><label for="flickrSelPosition">Auto-add Position:</label>
			<select name="flickrSelPosition" id="flickrSelPosition">
			<?php
			$poss_positions = array(
				'below'	=> 'After existing page content',
				'above'	=> 'Before existing page content',
			);
			foreach ($poss_positions as $pos => $label) {
				$sel = ($this->opts['flickr_position'] == $pos) ? ' selected="selected"' : '';
				echo '<option value="'.$pos.'"'.$sel.'>'.$label.'</option>';
			}
			?>
			</select></p>
	<p class="tick"><label><input type="checkbox" name="flickrOpenWindow" id="flickrOpenWindow" value="Yes" <?php echo $sel_window; ?>/>
		Open links to Flickr in a new window?</label></p>
	<p class="tick"><label><input type="checkbox" name="flickrHidePrivate" id="flickrHidePrivate" value="Yes" <?php echo $sel_private; ?>/>
		Hide photos marked as <em>private</em>?</label></p>
	<p><label>&nbsp;</label>
    	<input type="submit" name="SaveGeneral" value="Save Changes" class="button-primary save" /></p>
  </form>
</div>
<div id="tabFlickrAPI">
        <?php
		if (!is_object($this->flickr)) {
			// Ask for Flickr Key + Secret
			?>
			<form class="flickr" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>#tabFlickrAPI">
	            <?php wp_nonce_field($this->nonce); ?>
                <p><label for="apiKey">Flickr API Key</label>
	                <input type="text" name="apiKey" id="apiKey" value="<?php echo $this->opts['api']['key']; ?>" /></p>
                <p><label for="apiSecret">Shared Secret</label>
    	            <input type="text" name="apiSecret" id="apiSecret" value="<?php echo $this->opts['api']['secret']; ?>" /></p>
                <p><label>&nbsp;</label>
        	        <input type="submit" name="SaveAPI" value="Save Changes" class="button-primary save" /></p>
                <p>Sign into Flickr and <a href="http://www.flickr.com/services/apps/" target="_blank">get your API key here</a>.</p>
			</form>
			<?php
		} else
		if ($this->flickr !== false && empty($this->opts['user']['token'])) {
			// We have the key, but not yet authorized
			$frob = $this->flickr->auth_getFrob();
			$api_sig = md5( $this->flickr->secret.'api_key'.$this->flickr->api_key.'frob'.$frob.'perms'.$this->perms);
			?>
            <form id="FlickrClearAuth" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>#tabFlickrAPI">
				<?php wp_nonce_field($this->nonce); ?>
                <input type="submit" name="ClearAPI" value="Clear these details" class="button-secondary" />
            </form>
            <p><strong>Flickr API Key:</strong> <?php echo $this->opts['api']['key']; ?></p>
            <p><strong>Shared Secret:</strong> <?php echo $this->opts['api']['secret']; ?></p>
            <p>You must now link your flickr account to this site.</p>
            <form id="FlickrGetAuth" method="get" action="http://flickr.com/services/auth/" target="_blank">
                <input type="hidden" name="api_key" value="<?php echo $this->flickr->api_key; ?>" />
                <input type="hidden" name="frob" value="<?php echo $frob; ?>" />
                <input type="hidden" name="perms" value="<?php echo $this->perms; ?>" />
                <input type="hidden" name="api_sig" value="<?php echo $api_sig; ?>" />
                <p>Step 1: <input type="submit" class="button-secondary" value="Authorize Flickr" /></p>
            </form>
            <form id="FlickrGetToken" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
				<?php wp_nonce_field($this->nonce); ?>
                <input type="hidden" name="frob" value="<?php echo $frob; ?>" />
                <p>Step 2: <input type="submit" name="SaveFlickrToken" value="Save Changes" class="button-secondary" /></p>
            </form>
            <?php
		} else {
			?>
          <form id="FlickrClearAuth" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>#tabFlickrAPI">
          	 <?php wp_nonce_field($this->nonce); ?>
             <input type="submit" name="ClearAPI" value="Clear these details" class="button-secondary" />
          </form>
		  <p><strong>Flickr API Key:</strong> <?php echo $this->opts['api']['key']; ?></p>
          <p><strong>Shared Secret:</strong> <?php echo $this->opts['api']['secret']; ?></p>
          <p>Your are now linked to your Flickr account, and can display photos on your site.</p>
            <?php
		}
		?>
</div>
<?php	if (is_object($this->flickr) && !empty($this->opts['user']['token'])) {	?>
<div id="tabFlickrAlbums">
  <form id="ClearFlickrCache" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>#tabFlickrAlbums">
     <?php wp_nonce_field($this->nonce); ?>
     <input type="submit" name="ClearFlickrCache" value="Clear the Flickr Cache" class="button-secondary" />
  </form>
  <form class="flickr" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>#tabFlickrAlbums">
	<?php wp_nonce_field($this->nonce); ?>
	<?php
	$result = $this->flickr->photosets_getList($this->opts['user']['ID']);
	//echo '<pre>'; print_r($result); echo '</pre>';
	foreach ($result['photoset'] as $set) {
		$photosetURL = get_permalink($this->opts['flickr_page']).'album/'.$set['id'].'/'.strtolower(urlencode($set['title'])).'/';
		$primary_sizes = $this->flickr->photos_getSizes($set['primary']);
		// Find the thumbnail (Square) image
		foreach ($primary_sizes as $image) {	if ($image['label'] == 'Square') break;	}
//		echo '<pre>'; print_r($set); echo '</pre>';
//		echo '<pre>'; print_r($image); echo '</pre>';
		$sel_hide = (in_array($set['id'], $this->opts['hide_albums'])) ? ' checked="checked"' : '';
		?>
		<div class="album">
            	<img src="<?php echo $image['source']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
            <p class="name"><a href="<?php echo $photosetURL; ?>"><?php echo $set['title']; ?></a></p>
            <p class="tick"><label><input type="checkbox" name="hide_album[]" value="<?php echo $set['id']; ?>"<?php echo $sel_hide; ?> />
				Hide album?</label></p>
			<div class="cb"></div>
        </div><!-- album -->
        <?php
	}
	?>
    <div class="cb"></div>
    <p><label>&nbsp;</label>
	    <input type="submit" name="SaveAlbumSettings" value="Save Changes" class="button-primary save" /></p>
  </form>
</div>
<?php	}	// if $flickr token set		?>
</div><!-- tabContainer -->


        <?php
//		echo '<pre>'; print_r($this->opts); echo '</pre>';
//		echo '<pre>'; print_r($this->flickr); echo '</pre>';
		echo '</div>'."\n";
	}
	
}



?>